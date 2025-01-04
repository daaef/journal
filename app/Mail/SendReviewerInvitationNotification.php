<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendReviewerInvitationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $journal;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $journal)
    {
        $this->user = $user;
        $this->journal = $journal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.invite_reviewer')
                    ->with([
                        'user' => $this->user,
                        'journal' => $this->journal,
                    ]);
    }
}
