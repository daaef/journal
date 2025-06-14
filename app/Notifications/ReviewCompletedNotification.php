<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewCompletedNotification extends Notification
{
    use Queueable;

    protected $journal;
    protected $reviewer;
    protected $decision;
    protected $comment;

    public function __construct($journal, $reviewer, $decision, $comment = null)
    {
        $this->journal = $journal;
        $this->reviewer = $reviewer;
        $this->decision = $decision;
        $this->comment = $comment;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Review Completed - ' . $this->journal->title)
            ->greeting('Hello ' . $notifiable->fullname . '!')
            ->line('A review has been completed for manuscript: ' . $this->journal->title)
            ->line('Reviewer: ' . $this->reviewer->fullname)
            ->line('Decision: ' . ucwords($this->decision))
            ->when($this->comment, function ($mail) {
                return $mail->line('Comments: ' . $this->comment);
            })
            ->action('View Details', url('/editor/journals/preview/' . $this->journal->uuid . '/' . $this->journal->slug))
            ->line('Thank you for your attention.');
    }

    public function toArray(object $notifiable): array
    {
        $decisionColors = [
            'approve' => 'bg-green-100 text-green-600',
            'decline' => 'bg-red-100 text-red-600',
            'revision' => 'bg-yellow-100 text-yellow-600'
        ];

        return [
            'type' => 'review_completed',
            'title' => 'Review Completed',
            'message' => $this->reviewer->fullname . ' has completed review for "' . $this->journal->title . '"',
            'journal_id' => $this->journal->id,
            'journal_uuid' => $this->journal->uuid,
            'journal_slug' => $this->journal->slug,
            'reviewer_name' => $this->reviewer->fullname,
            'decision' => $this->decision,
            'comment' => $this->comment,
            'completed_at' => now(),
            'action_url' => '/editor/journals/preview/' . $this->journal->uuid . '/' . $this->journal->slug,
            'icon' => 'ph-check-square',
            'color' => $decisionColors[$this->decision] ?? 'bg-blue-100 text-blue-600'
        ];
    }
}
