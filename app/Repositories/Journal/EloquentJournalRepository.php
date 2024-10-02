<?php
namespace App\Repositories\Journal;
use App\Repositories\Journal\JournalContract;
use App\Models\Journal;
use Illuminate\Support\Str;

class EloquentJournalRepository implements JournalContract {
    public function create($request) {
        $journal = new Journal();
        $journal->title = $request->title;
        $journal->slug = Str::slug($request->title, '-');
        $journal->description = $request->description;
        $journal->cover_image = uploadFile($request->cover_image, auth()->user()->id.Str::slug($request->title, '-'), 'cover_images');
        $journal->is_active = true;
        $journal->uuid = Str::uuid();
        $journal->journal_format = '.pdf';
        $journal->journal_language = $request->journal_language;
        $journal->journal_url = uploadFile($request->journal_url, auth()->user()->id.Str::slug($request->title, '-'), 'journals');
        $journal->approval_status = 'pending';
        $journal->meta_title = $request->meta_title;
        $journal->meta_keywords = $request->meta_keywords;
        $journal->meta_description = $request->meta_description;
        $journal->abstract = $request->abstract;
        $journal->institution = $request->institution;
        $journal->license = $request->license;
        $journal->approval_level = 'level0';
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

    public function update($request, $id) {
        $journal = $this->findByUUID($id);
        $journal->title = $request->title;
        $journal->slug = Str::slug($request->title, '-');
        $journal->description = $request->description;
        $journal->cover_image = uploadFile($request->cover_image, auth()->user()->id.Str::slug($request->title, '-'), 'cover_images');
        $journal->is_active = true;
        $journal->uuid = Str::uuid();
        $journal->journal_format = '.pdf';
        $journal->journal_language = $request->journal_language;
        $journal->journal_url = uploadFile($request->journal_url, auth()->user()->id.Str::slug($request->title, '-'), 'journals');
        $journal->approval_status = 'pending';
        $journal->meta_title = $request->meta_title;
        $journal->meta_keywords = $request->meta_keywords;
        $journal->meta_description = $request->meta_description;
        $journal->abstract = $request->abstract;
        $journal->institution = $request->institution;
        $journal->license = $request->license;
        $journal->approval_level = 'level0';
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

    public function destroy($id) {
        $journal = $this->findByUUID($id);
        $journal->delete();
        return $journal;
    }

    public function findById($id) {
        return Journal::findOrFail($id);
    }

    public function getAll() {
        return Journal::all();
    }

    public function findByUUID($uuid) {
        return Journal::where('uuid', $uuid)->first();
    }

    public function delete($id){
        $journal = $this->findByUUID($id);
        return $journal->delete();
    }
}
