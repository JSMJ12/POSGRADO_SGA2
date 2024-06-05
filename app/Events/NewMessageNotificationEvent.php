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

class NewMessageNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    public $notifiable;

    public function __construct(NewMessageNotification2 $notification, $notifiable)
    {
        $this->notification = $notification;
        $this->notifiable = $notifiable;
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('canal_p')];
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->notification->id,
            'message' => [
                'content' => $this->notification->message->message,
                'sender' => [
                    'name' => $this->notification->message->sender->name,
                ],
                'receiver' => [
                    'name' => $this->notification->message->receiver->name,
                ],
            ],
        ];
    }
}

