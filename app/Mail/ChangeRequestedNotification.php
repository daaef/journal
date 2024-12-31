<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangeRequested extends Mailable
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
        return $this->subject('Change Request for Journal')
            ->view('emails.change_requested');
    }
}
