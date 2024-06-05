<?php

namespace App\Listeners;

use App\Events\PostulanteAceptado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\PostulanteAceptadoNotification;

class NotificarPostulanteAceptado implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(PostulanteAceptado $event)
    {
        $postulante = $event->postulante;

        // Buscar el usuario correspondiente en la tabla users
        $usuario = User::where('name', $postulante->nombre1)
                       ->where('apellido', $postulante->apellidop)
                       ->where('email', $postulante->correo_electronico)
                       ->first();

        if ($usuario) {
            // Enviar notificación al usuario
            $usuario->notify(new PostulanteAceptadoNotification($postulante));
        }
    }
}

