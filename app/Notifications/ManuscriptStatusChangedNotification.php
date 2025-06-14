<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ManuscriptStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $journal;
    protected $oldStatus;
    protected $newStatus;
    protected $message;
    protected $actionUrl;

    /**
     * Create a new notification instance.
     */
    public function __construct($journal, $oldStatus, $newStatus, $message = null, $actionUrl = null)
    {
        $this->journal = $journal;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->message = $message;
        $this->actionUrl = $actionUrl;
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
        $statusMessages = [
            'submitted' => 'has been successfully submitted',
            'in-progress' => 'is now under review',
            'reviewed' => 'has completed the review process',
            'approved' => 'has been approved for publication',
            'declined' => 'has been declined',
            'pending' => 'requires revisions'
        ];

        $statusMessage = $statusMessages[$this->newStatus] ?? 'status has been updated';

        return (new MailMessage)
            ->subject("Manuscript Status Update: {$this->journal->title}")
            ->greeting("Hello {$notifiable->fullname}!")
            ->line("Your manuscript \"{$this->journal->title}\" {$statusMessage}.")
            ->when($this->message, function ($mail) {
                return $mail->line($this->message);
            })
            ->when($this->actionUrl, function ($mail) {
                return $mail->action('View Manuscript', $this->actionUrl);
            }, function ($mail) {
                return $mail->action('View Manuscript', route('dashboard'));
            })
            ->line('Thank you for using our journal management system!');
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        $statusColors = [
            'submitted' => 'info',
            'in-progress' => 'warning',
            'reviewed' => 'secondary',
            'approved' => 'success',
            'declined' => 'danger',
            'pending' => 'warning'
        ];

        $statusIcons = [
            'submitted' => 'ph-paper-plane-tilt',
            'in-progress' => 'ph-clock',
            'reviewed' => 'ph-check-circle',
            'approved' => 'ph-check-circle',
            'declined' => 'ph-x-circle',
            'pending' => 'ph-warning'
        ];

        return [
            'title' => 'Manuscript Status Updated',
            'message' => "Your manuscript \"{$this->journal->title}\" status changed from {$this->oldStatus} to {$this->newStatus}",
            'journal_id' => $this->journal->id,
            'journal_uuid' => $this->journal->uuid,
            'journal_title' => $this->journal->title,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'action_url' => $this->actionUrl ?: route('dashboard'),
            'icon' => $statusIcons[$this->newStatus] ?? 'ph-bell',
            'color' => $statusColors[$this->newStatus] ?? 'primary',
            'type' => 'manuscript_status_change'
        ];
    }
}
