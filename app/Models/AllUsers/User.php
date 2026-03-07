<?php

namespace App\Models\AllUsers;

use App\Models\Core\AuthBaseModel;
use App\Observers\UserObserver;
use App\Traits\Users\RelationsTrait;
use App\Traits\Users\SettersGettersTrait;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([UserObserver::class])]

class User extends AuthBaseModel
{
    use RelationsTrait,SettersGettersTrait;
    const IMAGEPATH = 'users';

    protected $fillable = [
        'name',
        'country_code',
        'phone',
        'image',
        'lat',
        'lng',
        'map_desc',
        'password',
        'age',
        'weight',
        'height',
        'waist_circumference',
        'daily_calories',
        'daily_protein',
        'daily_carbohydrates',
        'daily_fats',

        'is_blocked',
        'active',
        'lang',
        'is_notify',
        'code',
        'code_expire',
    ];

    protected $casts = [
        'is_blocked'  => 'boolean',
        'active'      => 'boolean',
        'is_notify'   => 'boolean',
    ];

    /**
     * أعمدة التصدير (تظهر في مودال اختيار الأعمدة).
     */
    public function exportableColumns(): array
    {
        return [
            'id'        => '#',
            'name'      => __('admin.name'),
            'phone'     => __('admin.phone'),
            'country_code' => __('admin.country_code'),
            'image'     => __('admin.image'),
            'active'    => __('admin.active'),
            'is_blocked' => __('admin.is_blocked'),
            'created_at' => __('admin.created_at'),
        ];
    }

    /**
     * قيمة العمود عند التصدير (لتحويل البوليانات لنص واضح بدل 1/0).
     * أي موديل يريد تحكم في عرض عمود يصدر هذه الدالة ويُرجع النص المطلوب.
     */
    public function getExportValue(string $column): mixed
    {
        return match ($column) {
            'active'     => $this->active ? __('admin.activate') : __('admin.dis_activate'),
            'is_blocked' => $this->is_blocked ? __('admin.is_blocked') : __('admin.not_blocked'),
            'is_notify'  => $this->is_notify ? __('admin.activate') : __('admin.dis_activate'),
            default      => data_get($this, $column),
        };
    }
}
