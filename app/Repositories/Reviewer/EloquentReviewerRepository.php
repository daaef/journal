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
        // Get users by uuid for the requesr array
        foreach ($reviewers as $key => $value) {
            # code...
            // dd($value);
            $user = User::where('uuid', $value)->first();

            // check if the user is already a reviewer
            $reviewer = Reviewer::where('journal_id', $journal->id)->where('user_id', $user->id)->first();

            // create a new reviewer if the user is not a reviewer
            if(!$reviewer){
                $reviewer = new Reviewer();
                $reviewer->fullname = $user->fullname;
                $reviewer->journal_id = $journal->id;
                $reviewer->user_id = $user->id;
                $reviewer->token = Str::random(64); // Generate unique token for invitation
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

        // Update the reviewers count
        //get all reviewers for the journal
        $reviewers = Reviewer::where('journal_id', $journal->id)->get();
        $journal->reviewers_count = count($reviewers);
        $journal->save();

        return $journal;
    }
}
