<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use App\Events\NotificationSent;

class EnhancedManuscriptStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $journal;
    protected $oldStatus;
    protected $newStatus;
    protected $message;
    protected $priority;

    /**
     * Create a new notification instance.
     */
    public function __construct($journal, $oldStatus, $newStatus, $message = null, $priority = 'normal')
    {
        $this->journal = $journal;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->message = $message;
        $this->priority = $priority;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];
        
        // Check user preferences for email notifications
        $preferences = $notifiable->notification_preferences ?? [];
        if (($preferences['email']['manuscript_status'] ?? true)) {
            $channels[] = 'mail';
        }
        
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusText = ucfirst(str_replace('_', ' ', $this->newStatus));
        
        return (new MailMessage)
            ->subject("Manuscript Status Updated: {$this->journal->title}")
            ->greeting("Hello {$notifiable->fullname}!")
            ->line("The status of your manuscript has been updated.")
            ->line("**Manuscript:** {$this->journal->title}")
            ->line("**Previous Status:** " . ucfirst(str_replace('_', ' ', $this->oldStatus)))
            ->line("**New Status:** {$statusText}")
            ->when($this->message, function ($mail) {
                return $mail->line("**Message:** {$this->message}");
            })
            ->action('View Manuscript', route('journals.view', $this->journal->slug))
            ->line('Thank you for using our journal management system!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $statusText = ucfirst(str_replace('_', ' ', $this->newStatus));
        
        return [
            'type' => 'manuscript_status',
            'title' => 'Manuscript Status Updated',
            'message' => "Your manuscript \"{$this->journal->title}\" status changed to {$statusText}",
            'action_url' => route('journals.view', $this->journal->slug),
            'icon' => $this->getStatusIcon($this->newStatus),
            'color' => $this->getStatusColor($this->newStatus),
            'priority' => $this->priority,
            'journal_id' => $this->journal->id,
            'journal_title' => $this->journal->title,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'custom_message' => $this->message,
        ];
    }

    /**
     * Handle the notification after it's stored
     */
    public function afterStoredToDabase($notifiable, $notification)
    {
        // Broadcast real-time notification
        broadcast(new NotificationSent($notifiable, $notification));
    }

    /**
     * Get icon based on status
     */
    private function getStatusIcon($status): string
    {
        return match($status) {
            'approved' => 'ph-check-circle',
            'rejected' => 'ph-x-circle',
            'revision_requested' => 'ph-pencil-circle',
            'in_progress' => 'ph-clock',
            'reviewed' => 'ph-eye',
            default => 'ph-info'
        };
    }

    /**
     * Get color based on status
     */
    private function getStatusColor($status): string
    {
        return match($status) {
            'approved' => 'success',
            'rejected' => 'danger',
            'revision_requested' => 'warning',
            'in_progress' => 'primary',
            'reviewed' => 'info',
            default => 'secondary'
        };
    }
}
