<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JournalSubmittedNotification extends Notification
{
    use Queueable;

    protected $journal;
    protected $author;

    public function __construct($journal, $author)
    {
        $this->journal = $journal;
        $this->author = $author;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Manuscript Submitted')
            ->greeting('Hello ' . $notifiable->fullname . '!')
            ->line('A new manuscript has been submitted for review.')
            ->line('Title: ' . $this->journal->title)
            ->line('Author: ' . $this->author->fullname)
            ->action('Review Manuscript', url('/editor/journals/preview/' . $this->journal->uuid . '/' . $this->journal->slug))
            ->line('Thank you for your attention to this matter.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'journal_submitted',
            'title' => 'New Manuscript Submitted',
            'message' => 'A new manuscript titled "' . $this->journal->title . '" has been submitted by ' . $this->author->fullname,
            'journal_id' => $this->journal->id,
            'journal_uuid' => $this->journal->uuid,
            'journal_slug' => $this->journal->slug,
            'author_name' => $this->author->fullname,
            'submitted_at' => now(),
            'action_url' => '/editor/journals/preview/' . $this->journal->uuid . '/' . $this->journal->slug,
            'icon' => 'ph-file-plus',
            'color' => 'bg-blue-100 text-blue-600'
        ];
    }
}
