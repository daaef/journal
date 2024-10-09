<?php
namespace App\Repositories\MyJournalCollection;
interface MyJournalCollectionContract {
    public function addJournalToMyCollection($request);
    public function removeJournalFromMyCollection($request);
    public function checkJournalInMyCollection($request);
}
