<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class NotificationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $notification;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, $notification)
    {
        $this->user = $user;
        $this->notification = $notification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('notifications.' . $this->user->id),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        $data = $this->notification->data;
        
        return [
            'id' => $this->notification->id,
            'type' => $this->notification->type,
            'title' => $data['title'] ?? 'New Notification',
            'message' => $data['message'] ?? '',
            'action_url' => $data['action_url'] ?? '#',
            'icon' => $data['icon'] ?? 'ph-bell',
            'color' => $data['color'] ?? 'primary',
            'priority' => $data['priority'] ?? 'normal',
            'created_at' => $this->notification->created_at->toISOString(),
            'formatted_time' => $this->notification->created_at->diffForHumans(),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'notification.sent';
    }
}
