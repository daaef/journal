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
        $journal->uuid = Str::uuid();
        $journal->description = $request->description;
        $journal->is_active = true;
        $journal->save();
        return $journal;
    }

    public function update($request, $id) {
        $journal = $this->findByUUID($id);
        $journal->title = $request->title;
        $journal->slug = Str::slug($request->title, '-');
        $journal->uuid = Str::uuid();
        $journal->description = $request->description;
        $journal->is_active = $request->is_active == 1 ? true : false;
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
