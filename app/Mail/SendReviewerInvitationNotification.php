<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
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
        $user = $this->user;
        $journal = $this->journal;
        return $this->view('emails.invite_reviewer', compact('user', 'journal'));
    }
}
