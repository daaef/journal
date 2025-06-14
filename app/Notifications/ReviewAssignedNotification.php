<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $journal;
    protected $assignedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct($journal, $assignedBy)
    {
        $this->journal = $journal;
        $this->assignedBy = $assignedBy;
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
            ->subject("Review Assignment: {$this->journal->title}")
            ->greeting("Hello {$notifiable->fullname}!")
            ->line("You have been assigned as an Associate Editor to review the manuscript \"{$this->journal->title}\".")
            ->line("Assigned by: {$this->assignedBy->fullname}")
            ->line("Please log in to your dashboard to accept or decline this review assignment.")
            ->action('View Assignment', route('reviewer.my-assigned-reviews'))
            ->line('Thank you for your contribution to the academic review process!');
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Review Assignment',
            'message' => "You have been assigned to review \"{$this->journal->title}\"",
            'journal_id' => $this->journal->id,
            'journal_uuid' => $this->journal->uuid,
            'journal_title' => $this->journal->title,
            'assigned_by' => $this->assignedBy->fullname,
            'action_url' => route('reviewer.my-assigned-reviews'),
            'icon' => 'ph-clipboard-text',
            'color' => 'primary',
            'type' => 'review_assigned'
        ];
    }
}
