<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JournalStatusChangedNotification extends Notification
{
    use Queueable;

    protected $journal;
    protected $oldStatus;
    protected $newStatus;
    protected $message;

    public function __construct($journal, $oldStatus, $newStatus, $message = null)
    {
        $this->journal = $journal;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->message = $message;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $statusMessages = [
            'approved' => 'Your manuscript has been approved!',
            'rejected' => 'Your manuscript requires revisions.',
            'in-progress' => 'Your manuscript is under review.',
            'pending' => 'Your manuscript is pending review.'
        ];

        return (new MailMessage)
            ->subject('Manuscript Status Update - ' . $this->journal->title)
            ->greeting('Hello ' . $notifiable->fullname . '!')
            ->line($statusMessages[$this->newStatus] ?? 'Your manuscript status has been updated.')
            ->line('Title: ' . $this->journal->title)
            ->line('Status: ' . ucwords(str_replace('-', ' ', $this->newStatus)))
            ->when($this->message, function ($mail) {
                return $mail->line('Comments: ' . $this->message);
            })
            ->action('View Manuscript', url('/journals/preview/' . $this->journal->uuid . '/' . $this->journal->slug))
            ->line('Thank you for your submission.');
    }

    public function toArray(object $notifiable): array
    {
        $statusColors = [
            'approved' => 'bg-green-100 text-green-600',
            'rejected' => 'bg-red-100 text-red-600',
            'in-progress' => 'bg-yellow-100 text-yellow-600',
            'pending' => 'bg-blue-100 text-blue-600'
        ];

        $statusIcons = [
            'approved' => 'ph-check-circle',
            'rejected' => 'ph-x-circle',
            'in-progress' => 'ph-clock',
            'pending' => 'ph-hourglass'
        ];

        return [
            'type' => 'journal_status_changed',
            'title' => 'Manuscript Status Updated',
            'message' => 'Your manuscript "' . $this->journal->title . '" status changed to ' . ucwords(str_replace('-', ' ', $this->newStatus)),
            'journal_id' => $this->journal->id,
            'journal_uuid' => $this->journal->uuid,
            'journal_slug' => $this->journal->slug,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'comment' => $this->message,
            'updated_at' => now(),
            'action_url' => '/journals/preview/' . $this->journal->uuid . '/' . $this->journal->slug,
            'icon' => $statusIcons[$this->newStatus] ?? 'ph-bell',
            'color' => $statusColors[$this->newStatus] ?? 'bg-gray-100 text-gray-600'
        ];
    }
}
