<?php
namespace App\Repositories\Journal;

use App\Jobs\SendReviewerInvitationJob;
use App\Jobs\UserManuscriptJob;
use App\Mail\SendReviewerInvitationNotification;
use App\Repositories\Journal\JournalContract;
use App\Models\Journal;
use App\Models\JournalComment;
use App\Models\Reviewer;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EloquentJournalRepository implements JournalContract {
    public function create($request) {
        // dd($request->all());
        $journal = new Journal();
        return $this->extracted($request, $journal);
    }

    public function submitManuscript($request) {
        $journal = new Journal();
        return $this->extracted($request, $journal);
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

    public function getApprovedJournals(){
        return Journal::where('approval_status', 'approved')->get();
    }

    public function getRejectedJournals(){
        return Journal::where('approval_status', 'declined')->get();
    }

    public function getJournalsForReviewer($user_id) {
        $journals = Journal::whereHas('reviewers', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->get();
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
        $journal->user_id = $request->user_id ? $request->user_id : auth()->user()->id;
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
        $journal->approved_by = ['id' => auth()->user()->id, 'name' => auth()->user()->fullname];
        $journal->save();
        return $journal;
    }

    // Approve journal with comment
    public function approveJournalWithComment($uuid, $request) {

        // begin DB transaction
        DB::beginTransaction();

        try {
            $updateReviewer = Reviewer::where('user_id', auth()->user()->id)->first();
            $updateReviewer->is_accepted = $request->action == "approve" ? 1:0;
            $updateReviewer->comment = $request->comment;
            $updateReviewer->save();

            $journal = $this->findByUUID($uuid);
            // $journal->approval_status = 'approved_with_comment';
            $approvedBy = json_decode($journal->approved_by, true) ?? [];
            $approvedBy[] = [
                'id' => auth()->user()->id,
                'name' => auth()->user()->fullname
            ];
            $journal->approved_by = $approvedBy;
            // $journal->approval_comment = $request->comment;
            $journal->approved_by = json_encode($journal->approved_by);
            $journal->save();

            //save the comment
            $comment = new JournalComment();
            $comment->comment = $request->comment;
            $comment->user_id = auth()->user()->id;
            $comment->journal_id = $journal->id;
            $comment->save();

            $reviewers = Reviewer::where('journal_id', $journal->id)->pluck('user_id')->toArray();
            $reviewersApproved = Reviewer::where(['journal_id' => $journal->id, 'is_accepted' => 1])->pluck('user_id')->toArray();
            $reviewersResponded = Reviewer::where(['journal_id' => $journal->id])->whereNotNull('comment')->pluck('user_id')->toArray();

            // if($request->action == "approve"){
                $reviewersArray = $reviewersApproved;

                if (!in_array(auth()->user()->id, $reviewersArray)) {
                    if($request->action == "approve"){
                        $reviewersArray[] = auth()->user()->id;
                    }
                }
                $percent = (count($reviewersApproved)/$journal->reviewers_count)*100;

                if (count($reviewers) == count($reviewersResponded)) {
                    if ($percent > 50) {
                        $journal->approval_status = 'approved';

                        $details['user'] = User::find($journal->user_id);
                        $details['journal'] = $journal;
                        $details['messageBody'] = "Your manuscript with the title: ".$journal->title." has been approved for publication.";
                        dispatch(new UserManuscriptJob($details));

                    }else{
                        $journal->approval_status = 'declined';

                        $details['user'] = User::find($journal->user_id);
                        $details['journal'] = $journal;
                        $details['messageBody'] = "Your manuscript with the title: ".$journal->title." has been declined for publication.";
                        dispatch(new UserManuscriptJob($details));
                    }
                }else{
                    $journal->approval_status = 'in-progress';
                }

                $journal->reveiwers = $reviewersArray;
                $journal->save();
            // }


            // end DB transaction
            DB::commit();

            return $journal;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getJournalsApprovedByUser($user_id) {
        return Journal::where('approved_by', 'like', '%'.$user_id.'%')->get();
    }

    public function getJournalsAssignedToUser($user_id) {
        return Journal::where('user_id', $user_id)->get();
    }

    public function declineJournal($uuid) {
        $journal = $this->findByUUID($uuid);
        $journal->approval_status = 'declined';
        $journal->approved_by = ['id' => auth()->user()->id, 'name' => auth()->user()->fullname];
        $journal->save();
        return $journal;
    }


}
