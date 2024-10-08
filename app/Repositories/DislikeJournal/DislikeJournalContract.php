<?php
namespace App\Repositories\DislikeJournal;
interface DislikeJournalContract {
    public function checkIfUserHasLikedJournal($journal_id, $user_id);
}
