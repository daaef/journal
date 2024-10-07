<?php
namespace App\Repositories\DislikeJournal;
use App\Repositories\DislikeJournal\DislikeJournalContract;
use App\Models\DislikeJournal;

class EloquentDislikeJournalRepository implements DislikeJournalContract {
    public function checkIfUserHasLikedJournal($journal_id, $user_id) {
        return DislikeJournal::where('journal_id', $journal_id)->where('user_id', $user_id)->first();
    }
}
