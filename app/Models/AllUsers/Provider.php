<?php

namespace App\Models\AllUsers;

use App\Models\Rate;
use App\Models\Admin;
use App\Models\Ability;
use App\Models\Service;
use App\Models\Category;
use App\Models\Contract;
use App\Models\PreviousWork;
use App\Models\CancelContract;
use App\Models\ProviderUpdate;
use App\Models\Core\AuthBaseModel;
use App\Observers\ProviderObserver;
use App\Enums\ApprovementStatusEnum;
use App\Models\Settlement\Settlement;
use Spatie\Translatable\HasTranslations;
use App\Traits\Providers\RelationsTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Traits\Providers\SettersGettersTrait;

#[ObservedBy([ProviderObserver::class])]
class Provider extends AuthBaseModel
{
    use RelationsTrait, HasTranslations,SettersGettersTrait;
    const IMAGEPATH = 'providers';
    public $translatable = ['bio'];
    protected $fillable = [
        'image',
        'name',
        'country_code',
        'phone',
        'email',
        'lang',
        'bio',
        'commercial_image',
        'identity_numb',
        'active',
        'is_blocked',
        'is_approved',
        'is_notify',
        'map_desc',
        'lat',
        'lng',
        'code',
        'code_expire',
    ];

    protected $casts = [
        'active'     => 'boolean',
        'is_blocked'    => 'boolean',
        'is_notify'     => 'boolean',
        'is_approved'   => 'integer',
        'code'          => 'integer',
        'code_expire'   => 'datetime',
    ];


    public function scopeAvailable($query)
    {
        $query->where('active', true)
            ->where('is_approved', ApprovementStatusEnum::APPROVED->value)
            ->where('is_blocked', false)
            ->where('is_notify', true);
    }
    public function settlements()
    {
        return $this->hasMany(Settlement::class, 'id');
    }

    public function updateRequest(){
        return $this->hasMany(ProviderUpdate::class, 'provider_id');
    }






}
