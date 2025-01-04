<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JournalStatusChangeNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $journal;
    public $user;
    public $messageBody;

    /**
     * Create a new message instance.
     */
    public function __construct($journal, $user, $messageBody)
    {
        $this->journal = $journal;
        $this->user = $user;
        $this->messageBody = $messageBody;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->view('emails.journal-status-change-notification')
                    ->with([
                        'journal' => $this->journal,
                        'user' => $this->user,
                        'messageBody' => $this->messageBody,
                    ]);
    }
}
