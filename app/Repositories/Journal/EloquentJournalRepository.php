<?php
namespace App\Repositories\Journal;
use App\Repositories\Journal\JournalContract;
use App\Models\Journal;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EloquentJournalRepository implements JournalContract {
    public function create($request) {
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
        return Journal::where('approval_status', 'approved')->get();
    }

    public function findByUUID($uuid) {
        return Journal::where('uuid', $uuid)->first();
    }

    public function getUserSubmissions($user_id) {
        return Journal::where('user_id', $user_id)->get();
    }

    public function delete($id){
        $journal = $this->findByUUID($id);
        return $journal->delete();
    }

    public function getPendingApprovedJournals()
    {
        return Journal::where('approval_status', 'pending')->get();
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
            $coverPath = $file->storeAs($path, $fileName, $disk);
            $journal->cover_image = $coverPath;
        }


        $journal->uuid = Str::uuid();

        $journal->approval_status = 'pending';
        $journal->meta_title = $request->meta_title;
        $journal->meta_keywords = $request->meta_keywords;
        $journal->meta_description = $request->meta_description;

        $journal->institution = $request->institution;
        $journal->license = $request->license;
        $journal->approval_level = 0;
        $journal->user_id = $request->user_id ? $request->user_id : auth()->user()->id;
        $journal->category_id = $request->category_id;
        $journal->sub_category_id = $request->sub_category_id;
        $journal->sub_sub_category_id = $request->sub_sub_category_id;

//        $journal->created_by = $request->created_by;
//        $journal->updated_by = $request->updated_by;
//        $journal->approved_by = $request->approved_by;

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
                    ->orWhere('abstract', 'like', "%$search%");
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
        $journal->approved_by = auth()->user()->fullname;
        $journal->save();
        return $journal;
    }

}
