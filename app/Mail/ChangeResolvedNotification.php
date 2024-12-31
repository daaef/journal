<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangeResolved extends Mailable
{
    use Queueable, SerializesModels;

    public $journal;
    public $changes;
    public $messageBody;

    public function __construct($journal, $changes, $messageBody)
    {
        $this->journal = $journal;
        $this->changes = $changes;
        $this->messageBody = $messageBody;
    }

    public function build()
    {
        return $this->subject('Author Update for Requested Changes')
            ->view('emails.change_resolved');
    }
}
