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
    public $token;
    /**
     * Create a new message instance.
     */
    public function __construct($user, $journal, $token = null)
    {
        $this->user = $user;
        $this->journal = $journal;
        $this->token = $token;
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
        $token = $this->token;
        return $this->view('emails.invite_reviewer', compact('user', 'journal', 'token'));
    }
}
