<?php

namespace App\Models\Core;

use App\Traits\Admin\AuthBaseModel\HelperFunctions;
use App\Traits\Admin\AuthBaseModel\RelationsTrait;
use App\Traits\Admin\AuthBaseModel\SettersGettersTrait;
use App\Traits\SmsTrait;
use App\Traits\UploadTrait;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AuthBaseModel extends Authenticatable
{
    use Notifiable, UploadTrait, HasApiTokens, SmsTrait, SoftDeletes, HasFactory, SettersGettersTrait, RelationsTrait, HelperFunctions;

    const IMAGEPATH = 'users';

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }
}
