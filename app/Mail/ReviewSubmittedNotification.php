<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReviewSubmittedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $journal;
    public $reviewer;
    public $recommendation;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $journal, $reviewer, $recommendation)
    {
        $this->user = $user;
        $this->journal = $journal;
        $this->reviewer = $reviewer;
        $this->recommendation = $recommendation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.review_submitted')
                    ->with([
                        'user' => $this->user,
                        'journal' => $this->journal,
                        'reviewer' => $this->reviewer,
                        'recommendation' => $this->recommendation,
                    ])
                    ->subject('Review Submitted for Your Manuscript: ' . $this->journal->title);
    }
}
