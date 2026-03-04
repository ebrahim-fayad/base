<?php

namespace App\Notifications;

use App\Jobs\Firebase\SendFirebaseNotificationToMultipleJob;
use App\Traits\FirebaseTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;


class BaseNotification extends Notification
{
    use Queueable, FirebaseTrait;

    public $data;

    public function via(mixed $notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $this->data['guard'] = $notifiable->guard;

        SendFirebaseNotificationToMultipleJob::dispatch($notifiable, $this->data);
        return $this->data;
    }
}
