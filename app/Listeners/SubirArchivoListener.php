<?php

namespace App\Listeners;

use App\Events\SubirArchivoEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\SubirArchivoNotification;

class SubirArchivoListener
{
    public function handle(SubirArchivoEvent $event)
    {
        $postulante = $event->postulante;
        $usuario = User::where('name', $postulante->nombre1)
                       ->where('apellido', $postulante->apellidop)
                       ->where('email', $postulante->correo_electronico)
                       ->first();

        if ($usuario) {
            $usuario->notify(new SubirArchivoNotification($postulante));
        }
    }
}


        // Buscar el usuario correspondiente en la tabla users
        $usuario = User::where('name', $postulante->nombre1)
                       ->where('apellido', $postulante->apellidop)
                       ->where('email', $postulante->correo_electronico)
                       ->first();

        if ($usuario) {
            // Enviar notificación al usuario
            $usuario->notify(new PostulanteAceptadoNotification($postulante));
        }