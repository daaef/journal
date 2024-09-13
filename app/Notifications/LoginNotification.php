<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $platform;
    protected $clientIP;
    protected $userAgent;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $clientIP, $userAgent)
    {
        $this->user = $user;
        $this->platform = env('APP_NAME');
        $this->clientIP = $clientIP;
        $this->userAgent = $userAgent;

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
                    ->subject('Login Notification')
                    ->greeting('Hi ' . $this->user->fullname . '!')
                    ->line('You\'ve successfully logged in to your account on ' . $this->platform . '.')
                    ->line('The details of your login are as follows')
                    ->line('Login Time: '. date('H:i:s, d-m-Y'))
                    ->line('Login IP: '. $this->clientIP)
                    ->line('Device: '. $this->userAgent)
                    ->line('If this wasn\'t you, please reach out to our support team.')
                    ->action('Contact Support', url('/'))
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
