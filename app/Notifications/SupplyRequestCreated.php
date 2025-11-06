<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupplyRequestCreated extends Notification
{
    use Queueable;

    /*
    | -------------------------------------
    |  Create a new notification instance.
    | -------------------------------------
    */
    public function __construct(
        protected User $requester,
        protected int $supplyRequestId
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
            'message' => "{$this->requester->name} requested for supplies.",
            'link' => route('supply-requests.show', $this->supplyRequestId)
        ];
    }
}
