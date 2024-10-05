<?php
namespace App\Repositories\Journal;
interface JournalContract {
    public function create($request);
    public function submitManuscript($request);
    public function update($request, $id);
    public function destroy($id);
    public function findById($id);
    public function getAll();
    public function findByUUID($uuid);
    public function delete($id);
    public function getPendingApprovedJournals();
    public function getApprovedJournals();
    public function searchJournal($request);
}
