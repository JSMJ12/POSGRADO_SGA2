<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Carbon\Carbon;

class NewMessageNotification2 extends Notification
{
    use Queueable;
    

    // Añade una propiedad para almacenar el mensaje
    public $message;

    /**
     * Create a new notification instance.
     *
     * @param $message
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'broadcast', 'database']; // Agrega el canal 'broadcast'
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Tienes un nuevo mensaje!')
            ->action('Ver mensaje', route('messages.index'));
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        $senderName = $this->message->sender ? $this->message->sender->name : 'Remitente Desconocido';

        return new BroadcastMessage([
            'message' => $this->message,
            'sender_name' => $senderName,
            'link' => route('messages.index'),
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'time' => Carbon::now()->toDateTimeString(),
        ];
    }
    public function toMailUsing($notifiable, $recipient)
    {
        return parent::toMailUsing($notifiable, $recipient)->introLines([]);
    }
}
