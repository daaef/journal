<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewerAssignedNotification extends Notification
{
    use Queueable;

    protected $journal;
    protected $reviewer;
    protected $token;

    public function __construct($journal, $reviewer, $token = null)
    {
        $this->journal = $journal;
        $this->reviewer = $reviewer;
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $acceptUrl = route('journals.accept', ['token' => $this->token]);
        $declineUrl = route('journals.decline', ['token' => $this->token]);

        return (new MailMessage)
            ->subject('Review Invitation - ' . $this->journal->title)
            ->greeting('Hello ' . $notifiable->fullname . '!')
            ->line('You have been invited to review a manuscript.')
            ->line('Title: ' . $this->journal->title)
            ->line('Abstract: ' . substr(strip_tags($this->journal->abstract), 0, 200) . '...')
            ->action('Accept Review', $acceptUrl)
            ->line('Or decline this invitation: ' . $declineUrl)
            ->line('Thank you for your consideration.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'reviewer_assigned',
            'title' => 'Review Invitation',
            'message' => 'You have been assigned to review "' . $this->journal->title . '"',
            'journal_id' => $this->journal->id,
            'journal_uuid' => $this->journal->uuid,
            'journal_slug' => $this->journal->slug,
            'token' => $this->token,
            'assigned_at' => now(),
            'action_url' => '/reviewer/journals/preview/' . $this->journal->uuid . '/' . $this->journal->slug,
            'icon' => 'ph-user-check',
            'color' => 'bg-green-100 text-green-600'
        ];
    }
}
