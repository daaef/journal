<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserManuscriptNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $journal;
    public $messageBody;
    /**
     * Create a new message instance.
     */
    public function __construct($user, $journal, $messageBody)
    {
        $this->user = $user;
        $this->journal = $journal;
        $this->messageBody = $messageBody;
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
        $messageBody = $this->messageBody;
        return $this->view('emails.user_manuscript', compact('user', 'journal', 'messageBody'));
    }

}
