<?php

namespace App\Models\Core;

use App\Enums\NotificationTypeEnum;
use App\Traits\NotificationMessageTrait;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use NotificationMessageTrait;

    public function getTypeAttribute($value)
    {
        return $this->data['type'];
    }

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getTitleAttribute($value)
    {
        return isset($this->data['title_' . lang()]) ?
            $this->data['title_' . lang()] :
            $this->getTitle($this->data['type'], lang());
    }

    public function getBodyAttribute($value)
    {
        return $this->getBody($this->data, lang());
    }

    public function getSenderAttribute($value)
    {
        $def = 'App\Models\\' . $this->data['sender_model'];
        $sender = $def::find($this->data['sender']);
        return [
            'name'   => $sender->name,
            'avatar' => $sender->avatar,
        ];
    }

    public function getAdminUrlAttribute()
    {
         if (!empty($this->data['url'])) {
            return $this->data['url'];
        }
        return match ($this->data['type']) {
//            NotificationTypeEnum::New_Provider->value =>
//            route('admin.providers.show', ['id' => $this->data['provider_id']]),
//
//            NotificationTypeEnum::Admin_User_Block->value =>
//            $this->data['user_type'] === 'user'
//                ? route('admin.clients.show', ['id' => $this->data['user_id']])
//                : route('admin.providers.show', ['id' => $this->data['user_id']]),
//
//            NotificationTypeEnum::ORDER_SETTLEMENT->value =>
//            route('admin.settlements.show', ['id' => $this->data['order_id']]),
//
//            NotificationTypeEnum::Addition_Request->value  =>
//            $this->data['addition_type'] == 'category'
//                ? route('admin.categories.index')
//                : route('admin.services.index'),
//
//            NotificationTypeEnum::Bank_Transfer_First_Partially_Paid->value,
//            NotificationTypeEnum::Bank_Transfer_Second_Partially_Paid->value,
//            NotificationTypeEnum::Bank_Transfer_Fully_Paid->value,
//            NotificationTypeEnum::Rate_From_User->value =>
//            match ($this->data['order_type']) {
//                'special' => route('admin.orders.special.show', ['id' => $this->data['order_id']]),
//                'service' => route('admin.orders.services.show', ['id' => $this->data['order_id']]),
//                'consult' => route('admin.orders.consultations.show', ['id' => $this->data['order_id']]),
//                default => route('admin.orders.special.show', ['id' => $this->data['order_id']]),
//            },

            default => route('admin.dashboard'),
        };
    }

}
