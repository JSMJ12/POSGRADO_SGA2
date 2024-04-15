<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Notifications\NewMessageNotification2;

class NewMessageNotificationEvent
{
    use Dispatchable, SerializesModels;

    public $notification;

    public $notifiable;

    public function __construct(NewMessageNotification2 $notification, $notifiable)
    {
        $this->notification = $notification;
        $this->notifiable = $notifiable;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('canal_p'),
        ];
    }
}
