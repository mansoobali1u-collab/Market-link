<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FarmerRegisteredNotification extends Notification
{
    use Queueable;

    public function __construct(public User $farmer)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Farmer Registered',
            'message' => $this->farmer->name . ' signed up as a farmer and is waiting for approval.',
            'user_id' => $this->farmer->id,
        ];
    }
}
