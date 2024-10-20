<?php
namespace App\Repositories\Reviewer;
interface ReviewerContract {
    public function SaveJournalReviewers($request, $uuid);
}
