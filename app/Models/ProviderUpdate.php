<?php

namespace App\Models;

use App\Enums\ApprovementStatusEnum;
use App\Models\AllUsers\Admin;
use App\Models\AllUsers\Provider;
use App\Models\City;
use App\Models\Core\BaseModel;
use App\Models\Country;
use App\Observers\ProviderUpdateObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class ProviderUpdate extends BaseModel
{
    use HasTranslations;
    const IMAGEPATH = 'provider_updates';
    public $translatable = ['bio'];
    protected $fillable = [
        'provider_id',
        'name',
        'email',
        'country_code',
        'phone',
        'bio',
        'image',
        'commercial_number',
        'map_desc',
        'lat',
        'lng',
        'city_id',
        'categories',
    ];

    protected $casts = [
        'provider_id' => 'integer',
        'country_id' => 'integer',
        'city_id' => 'integer',
        'categories' => 'array', // Will encode/decode JSON string automatically
    ];

    /**
     * Get the provider that owns the update.
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * Get the city associated with the update.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}

