<?php

namespace App\Models\Programs;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Level extends BaseModel
{
    use HasTranslations, SoftDeletes;

    const DURATION_DAYS = 30;

    protected $fillable = [
        'name',
        'description',
        'subscription_price',
        'active',
        'order',
        'level_number',
    ];

    public $translatable = ['name', 'description'];

    protected $casts = [
        'active' => 'boolean',
        'subscription_price' => 'decimal:2',
        'order' => 'integer',
    ];

    public function days()
    {
        return $this->hasMany(LevelDay::class)->orderBy('day_number');
    }

    public function subscriptions()
    {
        return $this->hasMany(LevelSubscription::class);
    }

    public function getOrderNumberAttribute(): int
    {
        return (int) $this->order;
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeOrder($query)
    {
        return $query->reorder('order');
    }

    /**
     * Ensure the level has exactly 30 days. Creates missing days if any.
     */
    public function ensureHasThirtyDays(): self
    {
        $existingDayNumbers = $this->days()->pluck('day_number')->toArray();
        for ($day = 1; $day <= self::DURATION_DAYS; $day++) {
            if (!in_array($day, $existingDayNumbers)) {
                $this->days()->create(['day_number' => $day]);
            }
        }
        return $this;
    }
}
