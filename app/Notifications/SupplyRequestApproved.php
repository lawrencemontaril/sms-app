<?php

namespace App\Notifications;

use App\Models\SupplyRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupplyRequestApproved extends Notification
{
    use Queueable;

    /*
    | -------------------------------------
    |  Create a new notification instance.
    | -------------------------------------
    */
    public function __construct(
        protected SupplyRequest $supplyRequest
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
    | ---------------------------------------------------
    |  Get the array representation of the notification.
    | ---------------------------------------------------
    */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "Your supply request has been approved.",
            'link' => route('supply-requests.show', $this->supplyRequest->id)
        ];
    }
}
