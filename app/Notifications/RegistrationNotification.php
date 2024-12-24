<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationNotification extends Notification
{
    use Queueable;
    protected $user;
    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
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
        return (new MailMessage)
                    ->subject('Activate Your ' . env('APP_NAME') . ' Account')
                    ->greeting('Dear ' . $this->user->fullname . '!')
                    ->line('Thanks for signing up with ' . env('APP_NAME') . '! We\'re excited to have you on board.')
                    ->line('To activate your account, please click the link below and enter the following code:')
                    ->line('Activation Code: ' . $this->user->activation->code)
                    ->action('Activate my Account', route('auth.activate', ['email' => $this->user->email, 'id' => $this->user->activation->uuid]))
                    ->line('This will verify your email address and complete the registration process.')
                    ->line('If you have any issues or questions, feel free to reply to this email or contact our support team at [Support Email]')
                    ->line('Thank you for using our application!');
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
