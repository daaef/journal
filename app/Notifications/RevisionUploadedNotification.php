<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RevisionUploadedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $journal;
    protected $author;
    protected $revisionNotes;

    /**
     * Create a new notification instance.
     */
    public function __construct($journal, $author, $revisionNotes = null)
    {
        $this->journal = $journal;
        $this->author = $author;
        $this->revisionNotes = $revisionNotes;
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
            ->subject("Revision Uploaded: {$this->journal->title}")
            ->greeting("Hello {$notifiable->fullname}!")
            ->line("A revised version has been uploaded for the manuscript \"{$this->journal->title}\".")
            ->line("Author: {$this->author->fullname}")
            ->when($this->revisionNotes, function ($mail) {
                return $mail->line("Revision Notes: {$this->revisionNotes}");
            })
            ->action('Review Revision', route('editor.journal.preview', $this->journal->uuid))
            ->line('Thank you for using our journal management system!');
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Revision Uploaded',
            'message' => "Revised version uploaded for \"{$this->journal->title}\" by {$this->author->fullname}",
            'journal_id' => $this->journal->id,
            'journal_uuid' => $this->journal->uuid,
            'journal_title' => $this->journal->title,
            'author_name' => $this->author->fullname,
            'revision_notes' => $this->revisionNotes,
            'action_url' => route('editor.journal.preview', $this->journal->uuid),
            'icon' => 'ph-upload',
            'color' => 'warning',
            'type' => 'revision_uploaded'
        ];
    }
}
