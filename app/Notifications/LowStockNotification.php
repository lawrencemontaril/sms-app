<?php

namespace App\Notifications;

use App\Models\Supply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    use Queueable;

    /*
    | -------------------------------------
    |  Create a new notification instance.
    | -------------------------------------
    */
    public function __construct(
        protected Supply $supply
    )
    {
        //
    }

    /*
    | -------------------------------------------
    |  Get the notification's delivery channels.
    | -------------------------------------------
    */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /*
    | -------------------------------------------
    |  Get the array representation of the notification.
    | -------------------------------------------
    */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "{$this->supply->name} is running low on stocks.",
            'link' => "/supplies?search={$this->supply->name}"
        ];
    }
}
