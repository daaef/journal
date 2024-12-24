<?php
namespace App\Repositories\MyJournalCollection;
use App\Repositories\MyJournalCollection\MyJournalCollectionContract;
use App\Models\MyJournalCollection;

class EloquentMyJournalCollectionRepository implements MyJournalCollectionContract {
    public function addJournalToMyCollection($request) {
        $myJournalCollection = new MyJournalCollection();
        $myJournalCollection->journal_id = $request->journal_id;
        $myJournalCollection->user_id = $request->user_id;
        $myJournalCollection->save();
        return $myJournalCollection;
    }

    public function removeJournalFromMyCollection($request){
        $myJournalCollection = MyJournalCollection::where('journal_id', $request->journal_id)->where('user_id', $request->user_id)->first();
        $myJournalCollection->delete();
        return $myJournalCollection;
    }

    // Check if user has added journal to his collection
    public function checkJournalInMyCollection($request) {
        return MyJournalCollection::where('journal_id', $request->journal_id)->where('user_id', $request->user_id)->first();
    }
}
