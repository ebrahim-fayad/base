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

        // إذا كان الإشعار للحذف أو الحظر، نرسله بشكل متزامن
        if (isset($this->data['type']) && 
            in_array($this->data['type'], ['admin_user_blocked', 'admin_user_deleted', 'block'])) {
            SendFirebaseNotificationToMultipleJob::dispatchSync($notifiable, $this->data);
        } else {
            SendFirebaseNotificationToMultipleJob::dispatch($notifiable, $this->data);
        }
        
        return $this->data;
    }
}
