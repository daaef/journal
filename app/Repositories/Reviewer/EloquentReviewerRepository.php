<?php
namespace App\Repositories\Reviewer;
use App\Repositories\Reviewer\ReviewerContract;
use App\Models\Reviewer;
use App\Repositories\Journal\JournalContract;
use App\Models\User;
use App\Jobs\SendReviewerInvitationJob;
use App\Notifications\ReviewAssignedNotification;
use Illuminate\Support\Str;


class EloquentReviewerRepository implements ReviewerContract {

    protected $journalRepository;
    public function __construct(JournalContract $journalRepository){
        $this->journalRepository = $journalRepository;
    }

    public function SaveJournalReviewers($request, $uuid){

        $reviewers = $request->reviewers;
        $journal = $this->journalRepository->findByUUID($uuid);
        
        // Clear existing reviewers
        Reviewer::where('journal_id', $journal->id)->delete();
        
        // Get users by uuid for the request array
        foreach ($reviewers as $key => $value) {
            $user = User::where('uuid', $value)->first();

            if ($user) {
                $reviewer = new Reviewer();
                $reviewer->fullname = $user->fullname;
                $reviewer->journal_id = $journal->id;
                $reviewer->user_id = $user->id;
                $reviewer->token = Str::random(64); // Generate unique token for invitation
                $reviewer->status = 'invited';
                $reviewer->assigned_at = now();
                $reviewer->save();

                // Send invitation email to the reviewer
                $details['user'] = $user;
                $details['journal'] = $journal;
                $details['token'] = $reviewer->token; // Include token in email details
                dispatch(new SendReviewerInvitationJob($details));

                // Send in-app notification to Associate Editor
                $user->notify(new ReviewAssignedNotification($journal, auth()->user()));
            }
        }
        
        // Update journal status to in-review
        $journal->update(['approval_status' => 'in-review']);
        
        // Update the reviewers count
        //get all reviewers for the journal
        $reviewers = Reviewer::where('journal_id', $journal->id)->get();
        $journal->reviewers_count = count($reviewers);
        $journal->save();

        return $journal;
    }
}
