<?php

namespace App\Models\Programs;

use App\Models\AllUsers\User;
use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LevelSubscription extends BaseModel
{
    protected $fillable = [
        'user_id',
        'level_id',
        'active',
        'completed_days',
        'last_completed_day_date',
        'incomplete_days',
        'extra_days',
    ];

    protected $casts = [
        'active' => 'boolean',
        'completed_days' => 'integer',
        'last_completed_day_date' => 'date',
        'incomplete_days' => 'integer',
        'extra_days' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class)->withTrashed();
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
