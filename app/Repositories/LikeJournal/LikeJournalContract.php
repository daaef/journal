<?php
namespace App\Repositories\LikeJournal;
interface LikeJournalContract {
    public function likeJournal($journalId, $userId);
    public function dislikeJournal($journalId, $userId);
    public function checkIfUserHasLikedJournal($journalId, $userId);
}
