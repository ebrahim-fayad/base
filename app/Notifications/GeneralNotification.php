<?php

namespace App\Notifications;

use Illuminate\Support\Str;



class GeneralNotification extends BaseNotification
{
    public function __construct($model, $type, $url = null)
    {
        $tableName = Str::singular($model->getTable());
        $this->data['model_id'] = $model->id;
        $this->data['type'] = isset($type) ? $type : $tableName;
        $this->data['url'] = isset($url) ? $url : route('admin.admins.notifications');
        isset($model->request_num) ? $this->data['request_num'] = $model->request_num : null;
        isset($model->complaint_num) ? $this->data['complaint_num'] = $model->complaint_num : null;
        isset($model->model_type) ? $this->data['model_type'] = $tableName : null;
        isset($model->order_num) ? $this->data['order_num'] = $model->order_num : null;
        $this->data['user_name'] = data_get($model, 'complaintable.name')
            ?? data_get($model, 'withdrawable.name')
            ?? data_get($model, 'user_name')
            ?? data_get($model, 'user.name')
            ?? data_get($model, 'name');
    }
}
