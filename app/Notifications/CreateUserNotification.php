<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateUserNotification extends Notification
{
    use Queueable;
    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        // set user information here
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // dd($this->user->email);
        return (new MailMessage)
        ->subject('Welcome to ' . config('app.name') . '!')
        ->greeting('Hello ' . $this->user->fullname . '!')
        ->line('We are excited to have you on board. Your account has been successfully created.')
        ->line('Here are your account details:')
        ->line('**Username:** ' . $this->user->username)
        ->line('**Email:** ' . $this->user->email)
        ->action('Login to Your Account', url('/auth/login'))
        ->line('If you have any questions or need assistance, feel free to reply to this email or contact our support team.')
        ->line('Thank you for joining us!')
        ->salutation('Best Regards,')
        ->salutation(config('app.name') . ' Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
