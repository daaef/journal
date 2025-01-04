<?php
namespace App\Repositories\Journal;
interface JournalContract {
    public function create($request);
    public function submitManuscript($request);
    public function update($request, $id);
    public function getUserSubmissions($user_id);
    public function destroy($id);
    public function findById($id);
    public function findBySlug($slug);
    public function getAll();
    public function findByUUID($uuid);
    public function delete($id);
    public function getPendingApprovedJournals();
    public function approveJournal($uuid);
    public function requestChange($journal_id, array $changes, $editor_id);
    public function authorUpdate($journalId, array $updatedFields, $authorId);
    public function approveJournalWithComment($uuid, $request);
    public function getJournalsInProgress();
    public function getApprovedJournals();
    public function getRejectedJournals();
    public function getPendingApprovedJournalsForReviewer();
    public function getInProgressJournalsForReviewer();
    public function getApprovedJournalsForReviewer();
    public function getDeclinedJournalsForReviewer();
    public function searchJournal($request);
    public function likeJournal($uuid);
    public function dislikeJournal($uuid);
    public function getJournalLikes($uuid);
    public function getJournalsForReviewer($user_id);
}
