<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Postulante;

class PostulanteAceptado implements ShouldBroadcast
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
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('canal_p');
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'postulante' => $this->postulante,
            'message' => '¡Tu solicitud ha sido aceptada y ahora eres oficialmente un alumno! Por favor, haz clic en el enlace para pagar la matrícula.',
        ];
    }
}


