<?php
namespace App\Repositories\Journal;
interface JournalContract {
    public function create($request);
    public function submitManuscript($request);
    public function update($request, $id);
    public function getUserSubmissions($user_id);
    public function getUserSubmissionsWithDetails($user_id);
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
    public function getJournalsReviewed();
    public function getReviewedJournalsForReviewer();
    public function getDeclinedJournalsForReviewer();
    public function searchJournal($request);
    public function likeJournal($uuid);
    public function dislikeJournal($uuid);
    public function getJournalLikes($uuid);
    public function getJournalsForReviewer($user_id);
    public function approveForPublication($uuid, $comment = null);
    public function rejectManuscript($uuid, $reason);
    public function requestRevisions($uuid, $changes);
    public function submitReview($journal_uuid, $reviewer_id, $comment, $rating, $recommendation, $criteria_ratings = [], $confidential_comments = null, $is_finalizing = true);
    public function uploadRevision($journal_uuid, $revision_file, $revision_notes, $author_id);
    
    // Version Control Methods
    public function getVersionHistory($journal_uuid);
    public function compareVersions($journal_uuid, $version1_id, $version2_id);
    public function getVersionDetails($version_id);
    public function revertToVersion($journal_uuid, $version_id, $user_id);
}
