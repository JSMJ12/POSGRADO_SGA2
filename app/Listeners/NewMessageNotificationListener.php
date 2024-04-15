<?php

namespace App\Listeners;

use App\Events\NewMessageNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewMessageNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewMessageNotificationEvent $event)
    {
        $event->notifiable->notify($event->notification);
    }//
    
}
