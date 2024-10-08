<?php
namespace App\Repositories\LikeJournal;
use App\Repositories\LikeJournal\LikeJournalContract;
use App\Models\JournalLike as LikeJournal;
use App\Models\DislikeJournal;

class EloquentLikeJournalRepository implements LikeJournalContract {
    public function likeJournal($journalId, $userId) {
        // Remove journal from the dislikes table
        $this->removeDislikeFromJournal($journalId, $userId);

        // Add journal to the likes table
        return $this->addLikeToJournal($journalId, $userId);
    }

    public function dislikeJournal($journalId, $userId) {
        // Remove journal from the likes table
        $this->removeLikeFromJournal($journalId, $userId);

        // Add dislike to the dislikes table
        return $this->addDislikeToJournal($journalId, $userId);
    }

    private function addLikeToJournal($journalId, $userId) {
        $likeJournal = new LikeJournal();
        $likeJournal->journal_id = $journalId;
        $likeJournal->user_id = $userId;
        $likeJournal->save();
        // dd($likeJournal);
        return $likeJournal;
    }

    private function addDislikeToJournal($journalId, $userId) {
        // Add dislike logic here
        $dislikeJournal = new DislikeJournal();
        $dislikeJournal->journal_id = $journalId;
        $dislikeJournal->user_id = $userId;
        $dislikeJournal->save();
        return $dislikeJournal;
    }

    public function removeLikeFromJournal($journalId, $userId) {
        $likeJournal = LikeJournal::where('journal_id', $journalId)
            ->where('user_id', $userId)
            ->first();

        if ($likeJournal) {
            $likeJournal->delete();
            return true;
        }
        return false;
    }

    // remove dislike from journal
    private function removeDislikeFromJournal($journalId, $userId) {
        $dislikeJournal = DislikeJournal::where('journal_id', $journalId)
            ->where('user_id', $userId)
            ->first();

        if ($dislikeJournal) {
            $dislikeJournal->delete();
            return true;
        }
        return false;
    }

    public function checkIfUserHasLikedJournal($journalId, $userId) {
        return LikeJournal::where('journal_id', $journalId)
            ->where('user_id', $userId)
            ->exists();
    }
}
