<?php

namespace App\Jobs;

use App\Models\Postulante;
use App\Notifications\PostulanteAceptadoNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotificarPostulanteAceptadoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $postulante;

    /**
     * Create a new job instance.
     */
    public function __construct(Postulante $postulante)
    {
        $this->postulante = $postulante;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->postulante->notify(new PostulanteAceptadoNotification($this->postulante));
    }
}
