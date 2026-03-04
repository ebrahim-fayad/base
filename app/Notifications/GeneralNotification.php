<?php

namespace App\Notifications;

use Illuminate\Support\Str;

class GeneralNotification extends BaseNotification
{
    public function __construct($model, $type, $roomId = null)
    {
        // هنا نجيب اسم الجدول تبع الموديل ونخليه بصيغة المفرد
        $tableName = Str::singular($model->getTable());

        // هنا نحفظ رقم الموديل (الـ id) في مصفوفة البيانات
        $this->data['model_id'] = $model->id;

        // هنا نحدد نوع الإشعار، لو النوع معرف نأخذ قيمته، ولو مش موجود نأخذ اسم الجدول
        $this->data['type']     = isset($type) ? $type : $tableName;

        // هنا لو عندنا حقل request_num في الموديل، نخزنه في البيانات،
        // ولو مش موجود وجدت order_num نخزنه، غير كذا مايحط شي
        $this->data['request_num'] = $model->request_num ?? $model->order_num ?? null;

        // هنا لو موجود عندنا خاصية model_type في الموديل، نخزن اسم الجدول كموديل تايب
        isset($model->model_type)  ?
            $this->data['model_type'] = $tableName : null;

        isset($roomId) ? $this->data['room_id'] = $roomId : null;
    }
}
