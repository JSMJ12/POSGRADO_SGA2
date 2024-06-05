<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Notifications\SubirArchivoNotification;
use App\Models\Postulante;

class SubirArchivoEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $postulante;

    /**
     * Create a new event instance.
     */
    public function __construct(Postulante $postulante)
    {
        $this->postulante = $postulante;
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('canal_p');
    }
    public function broadcastWith()
    {
        return [
            'postulante' => $this->postulante,
            'message' => 'Recuerda subir tus archivos para completar tu proceso de postulación.',
        ];
    }
}
