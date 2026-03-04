<?php

namespace App\Models\AllUsers;

use App\Observers\UserObserver;
use App\Models\Core\AuthBaseModel;
use App\Traits\Admin\Users\RelationsTrait;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([UserObserver::class])]

class User extends AuthBaseModel
{
    use RelationsTrait;
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
}
