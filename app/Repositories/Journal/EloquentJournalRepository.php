<?php
namespace App\Repositories\Journal;

use App\Jobs\SendReviewerInvitationJob;
use App\Jobs\UserManuscriptJob;
use App\Mail\JournalStatusChangeNotificationMail;
use App\Mail\ManuscriptSubmissionNotification;
use App\Notifications\ManuscriptStatusChangedNotification;
use App\Notifications\ReviewAssignedNotification;
use App\Notifications\ReviewSubmittedNotification;
use App\Notifications\RevisionUploadedNotification;
use App\Repositories\Journal\JournalContract;
use App\Models\Journal;
use App\Models\JournalComment;
use App\Models\ManuscriptVersion;
use App\Models\Reviewer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class EloquentJournalRepository implements JournalContract {
    public function create($request) {
        // dd($request->all());
        $journal = new Journal();
        return $this->extracted($request, $journal);
    }

    public function submitManuscript($request) {
        $journal = new Journal();
        $savedJournal = $this->extracted($request, $journal);

        // Only send notifications for actual submissions (not drafts)
        if ($request->submit == 'submit') {
            $this->sendManuscriptSubmissionNotifications($savedJournal);
        }

        return $savedJournal;
    }

    public function update($request, $id) {
        $journal = $this->findByUUID($id);
        return $this->extracted($request, $journal);
    }

    public function destroy($id) {
        $journal = $this->findByUUID($id);
        $journal->delete();
        return $journal;
    }

    public function findById($id) {
        return Journal::findOrFail($id);
    }

    public function getAll() {
        return Journal::where('approval_status', 'approved')->where('is_draft', false)->get();
    }

    public function findByUUID($uuid) {
        return Journal::where('uuid', $uuid)->first();
    }

    public function getUserSubmissions($user_id) {
        return Journal::where('user_id', $user_id)->get();
    }

    public function getUserDraftSubmissions($user_id) {
        return Journal::where('user_id', $user_id)->where('is_draft', true)->get();
    }

    public function delete($id){
        $journal = $this->findByUUID($id);
        return $journal->delete();
    }

    public function getPendingApprovedJournals()
    {
        return Journal::whereIn('approval_status', ['pending', 'approved_with_comment'])->get();
    }

    public function getJournalsInProgress() {
        return Journal::where('approval_status', 'in-progress')->get();
    }

    public function getJournalsReviewed() {
        return Journal::where('approval_status', 'reviewed')->get();
    }

    public function getApprovedJournals(){
        return Journal::where('approval_status', 'approved')->get();
    }

    public function getRejectedJournals(){
        return Journal::where('approval_status', 'declined')->get();
    }

    public function getJournalsForReviewer($user_id) {
        $journals = Journal::whereHas('reviewers', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->orderBy('created_at', 'desc')->paginate(10);
        // dd($journals);
        return $journals;
    }

    /**
     * @param $request
     * @param Journal $journal
     * @return Journal
     */
    public function extracted($request, Journal $journal): Journal
    {
        $journal->title = $request->title;
        $journal->author = $request->author;
        $journal->country = $request->country;
        $journal->journal_language = $request->journal_language;
        $journal->abstract = $request->abstract;
        $journal->is_active = $request->submit == 'submit' ? true : false;

        // if request has manuscripts, upload the file
        if ($request->hasFile('manuscripts')) {
            $path = 'journals'; // Define the path variable
            $disk = 'public'; // Define the path variable

            $file = $request->file('manuscripts');
            $fileName = Str::slug($request->title, '-'). '.'.$file->getClientOriginalExtension();
            $journal->journal_format = '.' . $file->getClientOriginalExtension();

            if (!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }

            $storedPath = $file->storeAs($path, $fileName, $disk);
            $journal->journal_url = $storedPath;
        }


        $journal->slug = Str::slug($request->title, '-');
        $journal->description = $request->description ?: $request->abstract;

        // If request has cover_image, upload the file
        if ($request->hasFile('cover_image')) {
            $path = 'cover_images'; // Define the path variable
            $disk = 'public'; // Define the path variable
            $coverFile = $request->file('cover_image');
            $coverName = Str::slug($request->title, '-'). '.'.$coverFile->getClientOriginalExtension();
            if (!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }
            $coverPath = $file->storeAs($path, $coverName, $disk);
            $journal->cover_image = $coverPath;
        }

        $journal->uuid = Str::uuid();
        $journal->approval_status = 'pending';
        $journal->meta_title = $request->meta_title;
        $journal->meta_keywords = $request->meta_keywords;
        $journal->meta_description = $request->meta_description;

        $journal->institution = $request->institution;
        $journal->license = json_encode($request->license);
        $journal->approval_level = 0;
        $journal->user_id = $request->user_id ? $request->user_id : Auth::id();
        $journal->category_id = $request->category_id;
        $journal->sub_category_id = $request->sub_category_id;
        $journal->sub_sub_category_id = $request->sub_sub_category_id;

//        $journal->created_by = $request->created_by;
//        $journal->updated_by = $request->updated_by;
//        $journal->approved_by = $request->approved_by;

        $journal->accept = $request->accept == 'on' ? true : false;
        $journal->agree = $request->agree == 'on' ? true : false;
        $journal->is_draft = $request->submit == 'draft' ? true : false;
        // dd($journal);
        $journal->save();
        return $journal;
    }


    // search journal
    public function searchJournal($request)
    {
        $query = Journal::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('author', 'like', "%$search%")
                    ->orWhere('country', 'like', "%$search%")
                    ->orWhere('journal_language', 'like', "%$search%")
                    ->orWhere('abstract', 'like', "%$search%")
                    ->orWhere('meta_title', 'like', "%$search%")
                    ->orWhere('meta_keywords', 'like', "%$search%")
                    ->orWhere('meta_description', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhere('institution', 'like', "%$search%");
            });
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('sub_category_id')) {
            $query->where('sub_category_id', $request->sub_category_id);
        }

        if ($request->has('sub_sub_category_id')) {
            $query->where('sub_sub_category_id', $request->sub_sub_category_id);
        }

        if ($request->has('approval_status')) {
            $query->where('approval_status', $request->approval_status);
        }


        $query->where('approval_status', 'approved');
        $query->where('is_active', true);
        $query->where('is_draft', false);
        return $query->paginate(10);
    }

    public function likeJournal($request) {
        $journal = $this->findByUUID($request->uuid);
        $journal->likes += 1;
        $journal->save();
        return $journal;
    }

    public function getPendingApprovedJournalsForReviewer()
    {
        $userId = Auth::id();

        $journalQuery = Journal::where('approval_status', 'pending')
            ->whereIn('id', function ($query) use ($userId) {
                $query->select('journal_id')
                    ->from('reviewers')
                    ->where('user_id', $userId);
            });
// dd($journalQuery);
        return $journalQuery->paginate(100);
    }

    public function getInProgressJournalsForReviewer()
    {
        $userId = Auth::id();

        $journalQuery = Journal::where('approval_status', 'in-progress')
            ->whereIn('id', function ($query) use ($userId) {
                $query->select('journal_id')
                    ->from('reviewers')
                    ->where('user_id', $userId);
            });
// dd($journalQuery);
        return $journalQuery->paginate(100);
    }

    public function getApprovedJournalsForReviewer()
    {
        $userId = Auth::id();

        $journalQuery = Journal::where('approval_status', 'approved')
            ->whereIn('id', function ($query) use ($userId) {
                $query->select('journal_id')
                    ->from('reviewers')
                    ->where('user_id', $userId);
            });
// dd($journalQuery);
        return $journalQuery->paginate(100);
    }

    public function getDeclinedJournalsForReviewer()
    {
        $userId = Auth::id();

        $journalQuery = Journal::where('approval_status', 'declined')
            ->whereIn('id', function ($query) use ($userId) {
                $query->select('journal_id')
                    ->from('reviewers')
                    ->where('user_id', $userId);
            });
// dd($journalQuery);
        return $journalQuery->paginate(100);
    }

    public function getReviewedJournalsForReviewer()
    {
        $userId = Auth::id();

        $journalQuery = Journal::where('approval_status', 'reviewed')
            ->whereIn('id', function ($query) use ($userId) {
                $query->select('journal_id')
                    ->from('reviewers')
                    ->where('user_id', $userId);
            });
// dd($journalQuery);
        return $journalQuery->paginate(100);
    }

    public function dislikeJournal($request) {
        $journal = $this->findByUUID($request->uuid);
        $journal->dislikes += 1;
        $journal->save();
        return $journal;
    }

    public function getJournalLikes($request) {
        $journal = $this->findByUUID($request->uuid);
        return $journal->likes;
    }

    public function findBySlug($slug) {
        return Journal::where('slug', $slug)->first();
    }

    public function approveJournal($uuid) {
        $journal = $this->findByUUID($uuid);
        $journal->approval_status = 'approved';
        $journal->approved_by = ['id' => Auth::id(), 'name' => Auth::user()->fullname];
        $journal->save();
        return $journal;
    }

    /**
     * @description Notify authors of their journal status changes or updates.
     * @param $journal
     * @return array $mailData
     * @return void
    */
    protected function notifyAuthor($journal, array $maildata)
    {
        $author = User::find($journal->user_id);
        // dd($author->email);

        if ($author && $author->email)
        {
            if (isset($maildata['messageBody'])) {
                Mail::to($author->email)->send(new JournalStatusChangeNotificationMail($journal, $author, $maildata['messageBody']));
            }
        }
    }

        /**
     * Notify author and editors of change request.
     */
    private function notifyChangeRequested(Journal $journal, int $editorId, array $changes, array $maildata)
    {
        // Notify the author
        $author = User::find($journal->user_id);
        // TODO: Implement template
        // Mail::to($author->email)->send(new ChangeRequested($journal, $changes));

        // Notify all attached editors
        $editors = User::whereIn('id', collect($journal->editors)->pluck('editor_id'))->get();
        foreach ($editors as $editor) {
            if ($editor->id !== $editorId) {
                // TODO: Implement template
                // Mail::to($editor->email)->send(new EditorNotification($journal, $changes));
            }
        }
    }

        /**
     * Notify editor when author updates changes.
     */
    private function notifyEditorOnUpdate(Journal $journal, $updatedChanges, array $maildata)
    {
        $editorsToNotify = collect($updatedChanges)->filter(fn($change) => $change['status'] === 'resolved')
            ->pluck('editor_id')
            ->unique();

        foreach ($editorsToNotify as $editorId) {
            $editor = User::find($editorId);
            if ($editor) {
                // TODO: Implement template
                // Mail::to($editor->email)->send(new ChangeResolved($journal, $updatedChanges));
            }
        }
    }

    /**
     * Request changes to a journal.
     */
    public function requestChange($journal_id, array $changes, $editor_id): Journal
    {
        return DB::transaction(function () use ($journal_id, $changes, $editor_id) {
            $journal = Journal::findOrFail($journal_id);

            $existingChanges = $journal->change_requests ?? [];
            foreach ($changes as $change) {
                $existingChanges[] = [
                    'field' => $change['field'],
                    'current_value' => $journal->{$change['field']},
                    'suggested_change' => $change['suggested_change'],
                    'comment' => $change['comment'] ?? null,
                    'editor_id' => $editor_id,
                    'status' => 'pending',
                    'timestamp' => now()->toISOString(),
                ];
            }

            // Update journal status
            $journal->update([
                'approval_status' => 'changes_requested',
                'change_requests' => $existingChanges,
            ]);

            // TODO: Send notifications to author and other editors
            // $this->notifyChangeRequested($journal, $editor_id, $existingChanges);

            return $journal;
        });
    }

    /**
     * Handle author update and compare changes.
     */
    public function authorUpdate($journalId, array $updatedFields, $authorId): Journal
    {
        return DB::transaction(function () use ($journalId, $updatedFields, $authorId) {
            $journal = Journal::findOrFail($journalId);
            $updatedChanges = collect($journal->change_requests)->map(function ($change) use ($updatedFields, $journal) {
                if (isset($updatedFields[$change['field']]) && $change['status'] === 'pending') {
                    $updatedValue = $updatedFields[$change['field']];
                    if ($updatedValue === $change['suggested_change']) {
                        // Mark change as resolved
                        $change['status'] = 'resolved';
                        $change['resolved_at'] = now()->toISOString();

                        // Update journal field
                        $journal->{$change['field']} = $updatedValue;
                    }
                    $change['author_update'] = $updatedValue;
                }
                return $change;
            });

            // Save updated fields and changes
            $journal->update([
                'change_requests' => $updatedChanges,
            ]);
            $journal->save();

            // TODO: Notify the editor who requested the change
            // $this->notifyEditorOnUpdate($journal, $updatedChanges);

            return $journal;
        });
    }

    // Approve journal with comment
    public function approveJournalWithComment($uuid, $request)
    {
        DB::beginTransaction();

        try {
            $journal = $this->findByUUID($uuid);

            // NOTE: Prevent duplicate reviews if the status is in-progress
            $approvedBy = collect(json_decode($journal->approved_by, true));
            if ($journal->approval_status === 'in-progress' && $approvedBy->contains('id', Auth::id())) {
                return response()->json(['message' => 'You have already reviewed this journal.'], 403);
            }

            // NOTE: Update reviewer details
            $reviewer = Reviewer::where('user_id', Auth::id())->where('journal_id', $journal->id)->first();
            if (!$reviewer) {
                return response()->json(['message' => 'You are not assigned as a reviewer for this journal.'], 403);
            }

            $reviewer->is_accepted = $request->action === "approve" ? 1 : 0;
            $reviewer->comment = $request->comment;
            $reviewer->save();

            // NOTE: Save reviewer's approval in the journal
            $approvedBy->push(['id' => Auth::id(), 'name' => Auth::user()->fullname]);
            $journal->approved_by = $approvedBy->toJson();

            JournalComment::create([
                'comment' => $request->comment,
                'user_id' => Auth::id(),
                'journal_id' => $journal->id,
            ]);

            // NOTE: Calculate approval percentage
            $reviewers = Reviewer::where('journal_id', $journal->id)->count();
            $reviewersApproved = Reviewer::where('journal_id', $journal->id)->where('is_accepted', 1)->count();
            $reviewersResponded = Reviewer::where('journal_id', $journal->id)->whereNotNull('comment')->count();

            $approvalPercentage = $reviewers > 0 ? ($reviewersApproved / $reviewers) * 100 : 0;

            // NOTE: Update journal approval status
            if ($reviewers === $reviewersResponded) {
                if ($approvalPercentage > 50) {
                    $journal->approval_status = 'reviewed';
                    $messageBody = "Your manuscript titled '{$journal->title}' has been approved for publication.";
                } else {
                    $journal->approval_status = 'declined';
                    $messageBody = "Your manuscript titled '{$journal->title}' has been declined for publication.";
                }
            } else {
                $journal->approval_status = 'in-progress';
                $messageBody = "Your manuscript titled '{$journal->title}' is still under review.";
            }

            $journal->save();

            DB::commit();

            // NOTE: Notify the author
            $this->notifyAuthor($journal, ['messageBody' => $messageBody]);

            // NOTE: Notify admins and other roles
            $roles = ['Admin', 'Editor in Chief', 'Managing Editor', 'Desk Editor'];
            $users = User::role($roles)->get();
            foreach ($users as $user) {
                Mail::to($user->email)->send(new JournalStatusChangeNotificationMail($journal, $user, $messageBody));
            }

            return $journal;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function getJournalsApprovedByUser($user_id) {
        return Journal::where('approved_by', 'like', '%'.$user_id.'%')->get();
    }

    public function getJournalsAssignedToUser($user_id) {
        return Journal::where('user_id', $user_id)->get();
    }

 public function declineJournalWithComment($uuid, $request)
{
    DB::beginTransaction();

    try {
        $journal = $this->findByUUID($uuid);

        $declinedBy = collect(json_decode($journal->approved_by, true));
        if ($journal->approval_status === 'in-progress' && $declinedBy->contains('id', Auth::id())) {
            return response()->json(['message' => 'You have already reviewed this journal.'], 403);
        }

        $reviewer = Reviewer::where('user_id', Auth::id())->where('journal_id', $journal->id)->first();
        if (!$reviewer) {
            return response()->json(['message' => 'You are not assigned as a reviewer for this journal.'], 403);
        }

        $reviewer->is_accepted = 0;
        $reviewer->comment = $request->comment;
        $reviewer->save();

        $declinedBy->push(['id' => Auth::id(), 'name' => Auth::user()->fullname]);
        $journal->approved_by = $declinedBy->toJson();

        JournalComment::create([
            'comment' => $request->comment,
            'user_id' => Auth::id(),
            'journal_id' => $journal->id,
        ]);

        $reviewers = Reviewer::where('journal_id', $journal->id)->count();
        $reviewersDeclined = Reviewer::where('journal_id', $journal->id)->where('is_accepted', 0)->count();
        $reviewersResponded = Reviewer::where('journal_id', $journal->id)->whereNotNull('comment')->count();

        $declinePercentage = $reviewers > 0 ? ($reviewersDeclined / $reviewers) * 100 : 0;

        if ($reviewers === $reviewersResponded) {
            if ($declinePercentage > 50) {
                $journal->approval_status = 'declined';
                $messageBody = "Your manuscript titled '{$journal->title}' has been declined for publication.";
            } else {
                $journal->approval_status = 'reviewed';
                $messageBody = "Your manuscript titled '{$journal->title}' has been reviewed.";
            }
        } else {
            $journal->approval_status = 'in-progress';
            $messageBody = "Your manuscript titled '{$journal->title}' is still under review.";
        }

        $journal->save();

        DB::commit();

        $this->notifyAuthor($journal, ['messageBody' => $messageBody]);

        $roles = ['Admin', 'Editor in Chief', 'Managing Editor', 'Desk Editor'];
        $users = User::role($roles)->get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new JournalStatusChangeNotificationMail($journal, $user, $messageBody));
        }

        return $journal;
    } catch (\Exception $e) {
        DB::rollBack();
        return $e;
    }
}

protected function sendManuscriptSubmissionNotifications($journal)
    {
        // Notify the author
        $author = User::find($journal->user_id);
        Mail::to($author->email)->send(new ManuscriptSubmissionNotification($author, $journal, 'Author'));

        // Notify editors and admins
        $roles = ['Admin', 'Editor in Chief', 'Managing Editor'];
        $users = User::role($roles)->get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new ManuscriptSubmissionNotification($user, $journal, 'Editor'));
        }
    }

    /**
     * Approve manuscript for publication (final editor decision)
     */
    public function approveForPublication($uuid, $comment = null)
    {
        $journal = $this->findByUUID($uuid);

        // Ensure manuscript has completed review process
        if ($journal->approval_status !== 'reviewed') {
            throw new \Exception('Manuscript must complete the review process before editorial decisions can be made. Current status: ' . $journal->approval_status);
        }

        // Check minimum review requirement (at least 2 reviews)
        $completedReviews = $journal->reviewerAssignments()
            ->whereNotNull('review_submitted_at')
            ->count();

        if ($completedReviews < 2) {
            throw new \Exception('At least 2 reviews must be completed before approval. Currently ' . $completedReviews . ' review(s) completed.');
        }

        $oldStatus = $journal->approval_status;

        $journal->approval_status = 'approved';
        $user = Auth::user();
        $journal->approved_by = [
            'id' => Auth::id() ?? 1, 
            'name' => $user ? $user->fullname : 'System'
        ];
        $journal->editor_decision_date = now();

        if ($comment) {
            $journal->editor_decision_comment = $comment;
        }

        $journal->save();

        // Send comprehensive notifications
        $this->sendApprovalNotifications($journal, $comment, $oldStatus);

        return $journal;
    }

    /**
     * Reject manuscript (final editor decision)
     */
    public function rejectManuscript($uuid, $reason)
    {
        $journal = $this->findByUUID($uuid);

        // Ensure manuscript has completed review process
        if ($journal->approval_status !== 'reviewed') {
            throw new \Exception('Manuscript must complete the review process before editorial decisions can be made. Current status: ' . $journal->approval_status);
        }

        // Check minimum review requirement (at least 2 reviews)
        $completedReviews = $journal->reviewerAssignments()
            ->whereNotNull('review_submitted_at')
            ->count();

        if ($completedReviews < 2) {
            throw new \Exception('At least 2 reviews must be completed before rejection. Currently ' . $completedReviews . ' review(s) completed.');
        }

        $oldStatus = $journal->approval_status;

        $journal->approval_status = 'declined';
        $journal->declined_by = ['id' => Auth::id(), 'name' => Auth::user()->fullname];
        $journal->editor_decision_date = now();
        $journal->editor_decision_comment = $reason;
        $journal->save();

        // Send comprehensive notifications
        $this->sendRejectionNotifications($journal, $reason, $oldStatus);

        return $journal;
    }

    /**
     * Request revisions from author (editor decision)
     */
    public function requestRevisions($uuid, $changes)
    {
        $journal = $this->findByUUID($uuid);

        // Ensure manuscript has completed review process
        if ($journal->approval_status !== 'reviewed') {
            throw new \Exception('Manuscript must complete the review process before editorial decisions can be made. Current status: ' . $journal->approval_status);
        }

        $oldStatus = $journal->approval_status;

        $journal->approval_status = 'pending';
        $journal->editor_decision_date = now();
        $journal->editor_decision_comment = $changes;
        $journal->save();

        // Create journal comment for tracking
        JournalComment::create([
            'journal_id' => $journal->id,
            'user_id' => Auth::id(),
            'comment' => $changes,
            'comment_type' => 'revision_request'
        ]);

        // Send comprehensive notifications
        $this->sendRevisionRequestNotifications($journal, $changes, $oldStatus);

        return $journal;
    }

    /**
     * Submit review comments and rating (for Associate Editors)
     */
    public function submitReview($journal_uuid, $reviewer_id, $comment, $rating, $recommendation, $criteria_ratings = [], $confidential_comments = null, $is_finalizing = true)
    {
        $journal = $this->findByUUID($journal_uuid);
        $reviewer = User::find($reviewer_id);

        // Find or create reviewer assignment record
        $reviewerAssignment = Reviewer::where('journal_id', $journal->id)
            ->where('user_id', $reviewer_id)
            ->first();

        if (!$reviewerAssignment) {
            // Create new reviewer assignment if it doesn't exist
            $reviewerAssignment = Reviewer::create([
                'journal_id' => $journal->id,
                'user_id' => $reviewer_id,
                'fullname' => $reviewer->fullname,
                'status' => 'accepted',
                'assigned_at' => now()
            ]);
        }

        // Check if review already submitted
        if ($reviewerAssignment->review_submitted_at) {
            throw new \Exception('Review has already been submitted for this manuscript.');
        }

        // Update the reviewer assignment record (always finalized)
        $reviewerAssignment->update([
            'comment' => $comment,
            'confidential_comments' => $confidential_comments,
            'rating' => $rating,
            'criteria_ratings' => $criteria_ratings,
            'recommendation' => $recommendation,
            'review_submitted_at' => now(),
            'status' => 'completed'
        ]);

        // Update reviewer's rating in the reviewers_ratings array
        $reviewersRatings = $journal->reviewers_ratings ?? [];
        $reviewersRatings[$reviewer_id] = [
            'rating' => $rating,
            'comment' => $comment,
            'recommendation' => $recommendation,
            'criteria_ratings' => $criteria_ratings,
            'confidential_comments' => $confidential_comments,
            'submitted_at' => now(),
            'reviewer_name' => $reviewer->fullname,
            'reviewer_email' => $reviewer->email
        ];

        $journal->reviewers_ratings = $reviewersRatings;

        // Calculate average rating
        $totalRatings = count($reviewersRatings);
        $sumRatings = array_sum(array_column($reviewersRatings, 'rating'));

        $journal->total_ratings = $totalRatings;
        $journal->rating_percentage = ($sumRatings / $totalRatings) * 20; // Convert to percentage (1-5 scale to 0-100)

        // Change status to "reviewed" immediately after any review submission
        // Editor can only approve/decline if at least 2 reviews are done
        $journal->approval_status = 'reviewed';

        $journal->save();

        // Create journal comment for tracking (public review)
        JournalComment::create([
            'journal_id' => $journal->id,
            'user_id' => $reviewer_id,
            'comment' => $comment,
            'comment_type' => 'review'
        ]);

        // Create separate comment for confidential feedback if provided
        if (!empty($confidential_comments)) {
            JournalComment::create([
                'journal_id' => $journal->id,
                'user_id' => $reviewer_id,
                'comment' => $confidential_comments,
                'comment_type' => 'confidential_review'
            ]);
        }

        // Send comprehensive notifications
        $this->sendReviewSubmittedNotifications($journal, $reviewer, $rating, $recommendation);

        return $journal;
    }

    /**
     * Upload revised manuscript version (for Authors)
     */
    public function uploadRevision($journal_uuid, $revision_file, $revision_notes, $author_id)
    {
        $journal = $this->findByUUID($journal_uuid);
        $author = User::find($author_id);

        // Store the revised file
        $filePath = $revision_file->store('manuscript_revisions', 'public');

        // Create manuscript version record
        $version = \App\Models\ManuscriptVersion::create([
            'journal_id' => $journal->id,
            'version_number' => $this->getNextVersionNumber($journal->id),
            'file_path' => $filePath,
            'revision_notes' => $revision_notes,
            'uploaded_by' => $author_id,
            'uploaded_at' => now()
        ]);

        // Update journal status back to review if it was pending revisions
        if ($journal->approval_status === 'pending') {
            $journal->approval_status = 'in-progress';
        }

        $journal->save();

        // Send comprehensive notifications
        $this->sendRevisionUploadedNotifications($journal, $author, $revision_notes);

        return $version;
    }

    /**
     * Get next version number for manuscript
     */
    private function getNextVersionNumber($journal_id)
    {
        $lastVersion = \App\Models\ManuscriptVersion::where('journal_id', $journal_id)
            ->orderBy('version_number', 'desc')
            ->first();

        return $lastVersion ? $lastVersion->version_number + 1 : 1;
    }

    /**
     * Send comprehensive notifications for manuscript approval
     */
    private function sendApprovalNotifications($journal, $comment, $oldStatus)
    {
        $author = User::find($journal->user_id);
        $actionUrl = route('dashboard');

        // Notify author
        if ($author) {
            $author->notify(new ManuscriptStatusChangedNotification(
                $journal,
                $oldStatus,
                'approved',
                $comment ?? 'Your manuscript has been approved for publication.',
                $actionUrl
            ));
        }

        // Notify all editors and Associate Editors
        $this->notifyEditorsOfDecision($journal, 'approved', "Manuscript \"{$journal->title}\" has been approved for publication.");
    }

    /**
     * Send comprehensive notifications for manuscript rejection
     */
    private function sendRejectionNotifications($journal, $reason, $oldStatus)
    {
        $author = User::find($journal->user_id);
        $actionUrl = route('dashboard');

        // Notify author
        if ($author) {
            $author->notify(new ManuscriptStatusChangedNotification(
                $journal,
                $oldStatus,
                'declined',
                "Your manuscript has been declined. Reason: {$reason}",
                $actionUrl
            ));
        }

        // Notify all editors and Associate Editors
        $this->notifyEditorsOfDecision($journal, 'declined', "Manuscript \"{$journal->title}\" has been declined.");
    }

    /**
     * Send comprehensive notifications for revision requests
     */
    private function sendRevisionRequestNotifications($journal, $changes, $oldStatus)
    {
        $author = User::find($journal->user_id);
        $actionUrl = route('dashboard');

        // Notify author
        if ($author) {
            $author->notify(new ManuscriptStatusChangedNotification(
                $journal,
                $oldStatus,
                'pending',
                "Revisions have been requested for your manuscript. Changes needed: {$changes}",
                $actionUrl
            ));
        }

        // Notify all editors and Associate Editors
        $this->notifyEditorsOfDecision($journal, 'pending', "Revisions have been requested for manuscript \"{$journal->title}\".");
    }

    /**
     * Send comprehensive notifications for review submission
     */
    private function sendReviewSubmittedNotifications($journal, $reviewer, $rating, $recommendation)
    {
        // Notify all editors about the review submission
        $editors = $this->getEditorsForNotification();
        foreach ($editors as $editor) {
            $editor->notify(new ReviewSubmittedNotification($journal, $reviewer, $rating, $recommendation));
        }

        // If all reviews are complete, notify author
        if ($journal->approval_status === 'reviewed') {
            $author = User::find($journal->user_id);
            if ($author) {
                $author->notify(new ManuscriptStatusChangedNotification(
                    $journal,
                    'in-progress',
                    'reviewed',
                    'All reviews have been completed for your manuscript. The editorial decision is pending.',
                    route('dashboard')
                ));
            }
        }
    }

    /**
     * Send comprehensive notifications for revision uploads
     */
    private function sendRevisionUploadedNotifications($journal, $author, $revisionNotes)
    {
        // Notify all editors and Associate Editors
        $editors = $this->getEditorsForNotification();
        $assignedReviewers = $this->getAssignedReviewers($journal);

        $allNotifiees = $editors->merge($assignedReviewers);

        foreach ($allNotifiees as $user) {
            $user->notify(new RevisionUploadedNotification($journal, $author, $revisionNotes));
        }
    }

    /**
     * Get all editors for notifications (Managing Editor, Editor in Chief)
     */
    private function getEditorsForNotification()
    {
        return User::whereHas('roles', function($query) {
            $query->whereIn('name', ['managing-editor', 'editor-in-chief']);
        })->get();
    }

    /**
     * Get assigned reviewers (Associate Editors) for a journal
     */
    private function getAssignedReviewers($journal)
    {
        if (!$journal->reviewers) {
            return collect();
        }

        $reviewerIds = array_column($journal->reviewers, 'reviewer_id');
        return User::whereIn('id', $reviewerIds)->get();
    }

    /**
     * Notify all editors of editorial decisions
     */
    private function notifyEditorsOfDecision($journal, $status, $message)
    {
        $editors = $this->getEditorsForNotification();
        $actionUrl = route('editor.journals.preview', [$journal->uuid, $journal->slug]);

        foreach ($editors as $editor) {
            $editor->notify(new ManuscriptStatusChangedNotification(
                $journal,
                $journal->approval_status,
                $status,
                $message,
                $actionUrl
            ));
        }
    }

    public function getUserSubmissionsWithDetails($user_id) {
        return Journal::where('user_id', $user_id)
            ->with([
                'reviewers:id,journal_id,user_id,comment,rating,recommendation,created_at',
                'reviewers.user:id,fullname,email',
                'category:id,name',
                'sub_category:id,name'
            ])
            ->withCount('reviewers')
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($journal) {
                // Get latest version info if exists
                $latestVersion = ManuscriptVersion::where('journal_id', $journal->id)
                    ->orderBy('version_number', 'desc')
                    ->first();

                $journal->latest_version = $latestVersion;
                $journal->version_count = ManuscriptVersion::where('journal_id', $journal->id)->count();

                // Get review summary
                $reviews = $journal->reviewers ?? collect();
                $journal->review_summary = [
                    'total_reviews' => $reviews->count(),
                    'average_rating' => $reviews->avg('rating'),
                    'recommendations' => $reviews->pluck('recommendation')->countBy(),
                    'completed_reviews' => $reviews->where('comment', '!=', null)->count()
                ];

                // Parse change requests if they exist
                if ($journal->change_requests) {
                    $journal->formatted_change_requests = collect($journal->change_requests)
                        ->map(function ($request) {
                            return [
                                'category' => $request['category'] ?? 'General',
                                'description' => $request['description'] ?? $request,
                                'status' => $request['status'] ?? 'pending',
                                'requested_at' => $request['requested_at'] ?? now()
                            ];
                        });
                }

                return $journal;
            });
    }

    /**
     * Get complete version history for a journal
     */
    public function getVersionHistory($journal_uuid)
    {
        $journal = $this->findByUUID($journal_uuid);

        return \App\Models\ManuscriptVersion::where('journal_id', $journal->id)
            ->with(['author:id,fullname'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($version) {
                return [
                    'id' => $version->id,
                    'version_number' => $version->version_number,
                    'changes_summary' => $version->changes_summary,
                    'revision_notes' => $version->revision_notes,
                    'created_at' => $version->created_at,
                    'author' => $version->author->fullname ?? 'Unknown',
                    'file_path' => $version->file_path,
                    'status' => $version->status ?? 'submitted',
                    'parent_version_id' => $version->parent_version_id
                ];
            });
    }

    /**
     * Compare two versions of a manuscript
     */
    public function compareVersions($journal_uuid, $version1_id, $version2_id)
    {
        $journal = $this->findByUUID($journal_uuid);

        $version1 = \App\Models\ManuscriptVersion::where('journal_id', $journal->id)
            ->with('author:id,fullname')
            ->findOrFail($version1_id);

        $version2 = \App\Models\ManuscriptVersion::where('journal_id', $journal->id)
            ->with('author:id,fullname')
            ->findOrFail($version2_id);

        // Ensure version2 is newer than version1 for consistent comparison
        if ($version1->created_at > $version2->created_at) {
            [$version1, $version2] = [$version2, $version1];
        }

        $comparison = $version2->compareWith($version1);

        // Add metadata
        $comparison['metadata'] = [
            'journal_title' => $journal->title,
            'older_version' => [
                'id' => $version1->id,
                'version_number' => $version1->version_number,
                'created_at' => $version1->created_at,
                'author' => $version1->author->fullname ?? 'Unknown'
            ],
            'newer_version' => [
                'id' => $version2->id,
                'version_number' => $version2->version_number,
                'created_at' => $version2->created_at,
                'author' => $version2->author->fullname ?? 'Unknown'
            ]
        ];

        return $comparison;
    }

    /**
     * Get detailed information about a specific version
     */
    public function getVersionDetails($version_id)
    {
        $version = \App\Models\ManuscriptVersion::with(['author:id,fullname', 'journal:id,title,uuid'])
            ->findOrFail($version_id);

        // Get current version to determine if this is the current version
        $currentVersion = $this->getCurrentVersion($version->journal_id);
        $isCurrentVersion = $currentVersion && $currentVersion->id === $version->id;

        return [
            'id' => $version->id,
            'version_number' => $version->version_number,
            'title' => $version->title,
            'abstract' => $version->abstract,
            'content' => $version->content,
            'changes_summary' => $version->changes_summary,
            'revision_notes' => $version->revision_notes,
            'created_at' => $version->created_at,
            'author' => $version->author->fullname ?? 'Unknown',
            'file_path' => $version->file_path,
            'status' => $isCurrentVersion ? 'current' : ($version->status ?? 'submitted'),
            'journal' => [
                'id' => $version->journal->id,
                'title' => $version->journal->title,
                'uuid' => $version->journal->uuid,
                'current_version_id' => $currentVersion ? $currentVersion->id : null
            ],
            'version_tree' => $version->getVersionTree()
        ];
    }

    /**
     * Revert manuscript to a previous version (creates new version based on old one)
     */
    public function revertToVersion($journal_uuid, $version_id, $user_id)
    {
        $journal = $this->findByUUID($journal_uuid);
        $targetVersion = \App\Models\ManuscriptVersion::where('journal_id', $journal->id)
            ->findOrFail($version_id);

        // Create new version based on the target version
        $nextVersionNumber = \App\Models\ManuscriptVersion::getNextVersionNumber($journal->id, false); // Major version change for reverts

        $newVersion = \App\Models\ManuscriptVersion::create([
            'journal_id' => $journal->id,
            'version_number' => $nextVersionNumber,
            'title' => $targetVersion->title,
            'abstract' => $targetVersion->abstract,
            'content' => $targetVersion->content,
            'changes_summary' => "Reverted to version {$targetVersion->version_number}",
            'revision_notes' => "This version reverts the manuscript to version {$targetVersion->version_number} as requested",
            'created_by' => $user_id,
            'uploaded_by' => $user_id,
            'uploaded_at' => now(),
            'file_path' => $targetVersion->file_path, // Copy file path or create new file
            'parent_version_id' => $this->getCurrentVersion($journal->id)->id,
            'status' => 'reverted'
        ]);

        // Update main journal fields to reflect the reverted content
        $journal->update([
            'title' => $targetVersion->title,
            'abstract' => $targetVersion->abstract,
            'content' => $targetVersion->content
        ]);

        return $newVersion;
    }    /**
     * Helper method to get current version of a journal
     */
    private function getCurrentVersion($journal_id)
    {
        return \App\Models\ManuscriptVersion::where('journal_id', $journal_id)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
