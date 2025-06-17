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
use App\Services\DocumentConversionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class EloquentJournalRepository implements JournalContract {
    
    protected $documentConversionService;
    
    public function __construct(DocumentConversionService $documentConversionService)
    {
        $this->documentConversionService = $documentConversionService;
    }
    
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
            $disk = 'public'; // Define the disk variable

            $file = $request->file('manuscripts');
            $originalExtension = $file->getClientOriginalExtension();
            
            // Create base filename from title, with fallback
            $titleSlug = $request->title ? Str::slug($request->title, '-') : '';
            if (empty($titleSlug)) {
                // Fallback to timestamp and random string if title is empty or results in empty slug
                $titleSlug = 'manuscript-' . time() . '-' . Str::random(8);
            }
            $baseFileName = $titleSlug;
            
            // Always use .pdf as the final extension since we convert everything to PDF
            $fileName = $baseFileName . '.pdf';
            
            // Ensure directory exists
            if (!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }

            // Convert document to PDF if needed
            $conversionResult = $this->documentConversionService->convertToPdf($file, $path, $fileName);
            
            if ($conversionResult['success']) {
                $journal->journal_url = $conversionResult['path'];
                $journal->journal_format = '.pdf'; // Always PDF after conversion
                
                // Log conversion details for debugging
                if (isset($conversionResult['conversion_failed'])) {
                    Log::warning('Document conversion failed but file stored', [
                        'journal_title' => $request->title,
                        'original_file' => $file->getClientOriginalName(),
                        'message' => $conversionResult['message'],
                        'generated_filename' => $fileName
                    ]);
                    
                    // Set original format if conversion failed
                    $journal->journal_format = '.' . $originalExtension;
                } else {
                    Log::info('Document processed successfully', [
                        'journal_title' => $request->title,
                        'original_file' => $file->getClientOriginalName(),
                        'converted' => !in_array(strtolower($originalExtension), ['pdf']),
                        'message' => $conversionResult['message'],
                        'generated_filename' => $fileName
                    ]);
                }
            } else {
                // If conversion completely fails, throw an exception
                throw new \Exception('Failed to process manuscript file: ' . $conversionResult['message']);
            }
        }


        // Create slug from title, with fallback
        $titleSlugForJournal = $request->title ? Str::slug($request->title, '-') : '';
        if (empty($titleSlugForJournal)) {
            // Fallback to timestamp and random string if title is empty or results in empty slug
            $titleSlugForJournal = 'journal-' . time() . '-' . Str::random(8);
        }
        $journal->slug = $titleSlugForJournal;
        $journal->description = $request->description ?: $request->abstract;

        // If request has cover_image, upload the file
        if ($request->hasFile('cover_image')) {
            $path = 'cover_images'; // Define the path variable
            $disk = 'public'; // Define the path variable
            $coverFile = $request->file('cover_image');
            
            // Create cover filename from title, with fallback
            $coverTitleSlug = $request->title ? Str::slug($request->title, '-') : '';
            if (empty($coverTitleSlug)) {
                // Fallback to timestamp and random string if title is empty or results in empty slug
                $coverTitleSlug = 'cover-' . time() . '-' . Str::random(8);
            }
            $coverName = $coverTitleSlug . '.' . $coverFile->getClientOriginalExtension();
            
            if (!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }
            $coverPath = $coverFile->storeAs($path, $coverName, $disk);
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

        // JAPR Workflow: Status changes based on Associate Editor (Peer Reviewer) count
        // Need 2-3 Associate Editor reviews before Managing Editor can send notice
        $associateEditorReviews = $journal->reviewerAssignments()
            ->whereNotNull('review_submitted_at')
            ->whereHas('user', function($query) {
                $query->whereHas('roles', function($roleQuery) {
                    $roleQuery->where('name', 'Associate Editor');
                });
            })
            ->count();

        if ($associateEditorReviews >= 2) {
            // Enough peer reviews for Managing Editor decision
            $journal->approval_status = 'ready_for_managing_editor_notice';
        } else {
            // Still waiting for more Associate Editor reviews
            $journal->approval_status = 'under_peer_review';
        }

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

    /**
     * Get journals ready for Managing Editor notice (JAPR Workflow)
     */
    public function getJournalsReadyForNotice()
    {
        return Journal::where('approval_status', 'ready_for_managing_editor_notice')
            ->with(['reviewerAssignments.user', 'category', 'user'])
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    /**
     * Send approval notice from Managing Editor (JAPR Workflow)
     */
    public function sendApprovalNotice($uuid, $comment = null)
    {
        $journal = $this->findByUUID($uuid);

        // Ensure manuscript is ready for notice
        if ($journal->approval_status !== 'ready_for_managing_editor_notice') {
            throw new \Exception('Manuscript is not ready for Managing Editor notice. Current status: ' . $journal->approval_status);
        }

        $oldStatus = $journal->approval_status;

        $journal->approval_status = 'approved';
        $user = Auth::user();
        $journal->approved_by = [
            'id' => Auth::id() ?? 1, 
            'name' => $user ? $user->fullname : 'Managing Editor'
        ];
        $journal->editor_decision_date = now();

        if ($comment) {
            $journal->editor_decision_comment = $comment;
        }

        $journal->save();

        // Create journal comment for tracking
        JournalComment::create([
            'journal_id' => $journal->id,
            'user_id' => Auth::id(),
            'comment' => $comment ?? 'Manuscript approved by Managing Editor',
            'comment_type' => 'managing_editor_approval'
        ]);

        // Send comprehensive notifications
        $this->sendApprovalNoticeNotifications($journal, $comment, $oldStatus);

        return $journal;
    }

    /**
     * Send decline notice from Managing Editor (JAPR Workflow)
     */
    public function sendDeclineNotice($uuid, $reason)
    {
        $journal = $this->findByUUID($uuid);

        // Ensure manuscript is ready for notice
        if ($journal->approval_status !== 'ready_for_managing_editor_notice') {
            throw new \Exception('Manuscript is not ready for Managing Editor notice. Current status: ' . $journal->approval_status);
        }

        $oldStatus = $journal->approval_status;

        $journal->approval_status = 'declined';
        $user = Auth::user();
        $journal->declined_by = [
            'id' => Auth::id() ?? 1,
            'name' => $user ? $user->fullname : 'Managing Editor'
        ];
        $journal->editor_decision_date = now();
        $journal->editor_decision_comment = $reason;

        $journal->save();

        // Create journal comment for tracking
        JournalComment::create([
            'journal_id' => $journal->id,
            'user_id' => Auth::id(),
            'comment' => $reason,
            'comment_type' => 'managing_editor_decline'
        ]);

        // Send comprehensive notifications
        $this->sendDeclineNoticeNotifications($journal, $reason, $oldStatus);

        return $journal;
    }

    /**
     * Send notifications for approval notice
     */
    private function sendApprovalNoticeNotifications($journal, $comment, $oldStatus)
    {
        $author = User::find($journal->user_id);
        $actionUrl = route('journals.view', [$journal->slug]);

        // Notify author
        if ($author) {
            $author->notify(new ManuscriptStatusChangedNotification(
                $journal,
                $oldStatus,
                'approved',
                $comment ?? 'Your manuscript has been approved for publication by the Managing Editor.',
                $actionUrl
            ));
        }

        // Notify Editor in Chief and other editors
        $this->notifyEditorsOfDecision($journal, 'approved', "Manuscript \"{$journal->title}\" has been approved by the Managing Editor.");
    }

    /**
     * Send notifications for decline notice
     */
    private function sendDeclineNoticeNotifications($journal, $reason, $oldStatus)
    {
        $author = User::find($journal->user_id);
        $actionUrl = route('dashboard');

        // Notify author
        if ($author) {
            $author->notify(new ManuscriptStatusChangedNotification(
                $journal,
                $oldStatus,
                'declined',
                "Your manuscript has been declined by the Managing Editor. Reason: {$reason}",
                $actionUrl
            ));
        }

        // Notify Editor in Chief and other editors
        $this->notifyEditorsOfDecision($journal, 'declined', "Manuscript \"{$journal->title}\" has been declined by the Managing Editor.");
    }

    /**
     * Helper method to get current version of a journal
     */
    private function getCurrentVersion($journal_id)
    {
        return \App\Models\ManuscriptVersion::where('journal_id', $journal_id)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Get journals by specific status
     */
    public function getJournalsByStatus($status)
    {
        return Journal::where('approval_status', $status)
            ->with(['user', 'category', 'reviewers'])
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    /**
     * Get journals with revision requested (multiple statuses)
     */
    public function getJournalsWithRevisionRequested()
    {
        return Journal::whereIn('approval_status', ['changes_requested', 'revision_requested'])
            ->with(['user', 'category', 'reviewers'])
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    /**
     * Get user submissions with detailed information
     */
    public function getUserSubmissionsWithDetails($user_id) 
    {
        return Journal::where('user_id', $user_id)
            ->with([
                'reviewerAssignments.user',
                'category',
                'comments.user',
                'versions' => function($query) {
                    $query->orderBy('created_at', 'desc');
                }
            ])
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    /**
     * Get version history for a journal
     */
    public function getVersionHistory($journal_uuid)
    {
        $journal = $this->findByUUID($journal_uuid);
        
        return \App\Models\ManuscriptVersion::where('journal_id', $journal->id)
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Compare two versions of a manuscript
     */
    public function compareVersions($journal_uuid, $version1_id, $version2_id)
    {
        $journal = $this->findByUUID($journal_uuid);
        
        $version1 = \App\Models\ManuscriptVersion::where('journal_id', $journal->id)
            ->where('id', $version1_id)
            ->first();
            
        $version2 = \App\Models\ManuscriptVersion::where('journal_id', $journal->id)
            ->where('id', $version2_id)
            ->first();

        if (!$version1 || !$version2) {
            throw new \Exception('One or both versions not found');
        }

        return [
            'version1' => $version1,
            'version2' => $version2,
            'journal' => $journal
        ];
    }

    /**
     * Get details of a specific version
     */
    public function getVersionDetails($version_id)
    {
        return \App\Models\ManuscriptVersion::with(['user', 'journal'])
            ->findOrFail($version_id);
    }

    /**
     * Revert manuscript to a previous version
     */
    public function revertToVersion($journal_uuid, $version_id, $user_id)
    {
        $journal = $this->findByUUID($journal_uuid);
        $targetVersion = \App\Models\ManuscriptVersion::where('journal_id', $journal->id)
            ->where('id', $version_id)
            ->firstOrFail();

        // Create a new version based on the target version
        $newVersion = \App\Models\ManuscriptVersion::create([
            'journal_id' => $journal->id,
            'user_id' => $user_id,
            'title' => $targetVersion->title,
            'abstract' => $targetVersion->abstract,
            'content' => $targetVersion->content,
            'file_path' => $targetVersion->file_path,
            'version_number' => $this->getNextVersionNumber($journal->id),
            'change_summary' => "Reverted to version {$targetVersion->version_number}",
            'is_current' => true
        ]);

        // Update journal with reverted content
        $journal->update([
            'title' => $targetVersion->title,
            'abstract' => $targetVersion->abstract,
            'journal_url' => $targetVersion->file_path
        ]);

        // Mark other versions as not current
        \App\Models\ManuscriptVersion::where('journal_id', $journal->id)
            ->where('id', '!=', $newVersion->id)
            ->update(['is_current' => false]);

        return $newVersion;
    }
}
