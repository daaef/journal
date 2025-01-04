<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManuscriptSubmissionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $journal;
    public $role;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $journal, $role)
    {
        $this->user = $user;
        $this->journal = $journal;
        $this->role = $role;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.manuscript_submission')
                    ->with([
                        'user' => $this->user,
                        'journal' => $this->journal,
                        'role' => $this->role,
                    ]);
    }
}
