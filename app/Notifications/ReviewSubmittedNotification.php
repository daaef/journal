<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $journal;
    protected $reviewer;
    protected $rating;
    protected $recommendation;

    /**
     * Create a new notification instance.
     */
    public function __construct($journal, $reviewer, $rating, $recommendation)
    {
        $this->journal = $journal;
        $this->reviewer = $reviewer;
        $this->rating = $rating;
        $this->recommendation = $recommendation;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Review Submitted: {$this->journal->title}")
            ->greeting("Hello {$notifiable->fullname}!")
            ->line("A review has been submitted for the manuscript \"{$this->journal->title}\".")
            ->line("Reviewer: {$this->reviewer->fullname}")
            ->line("Rating: {$this->rating}/5")
            ->line("Recommendation: {$this->recommendation}")
            ->action('View Manuscript', route('editor.journal.preview', $this->journal->uuid))
            ->line('Thank you for using our journal management system!');
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Review Submitted',
            'message' => "Review submitted for \"{$this->journal->title}\" by {$this->reviewer->fullname}",
            'journal_id' => $this->journal->id,
            'journal_uuid' => $this->journal->uuid,
            'journal_title' => $this->journal->title,
            'reviewer_name' => $this->reviewer->fullname,
            'rating' => $this->rating,
            'recommendation' => $this->recommendation,
            'action_url' => route('editor.journal.preview', $this->journal->uuid),
            'icon' => 'ph-star',
            'color' => 'info',
            'type' => 'review_submitted'
        ];
    }
}
