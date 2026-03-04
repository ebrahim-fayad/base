<?php

namespace App\Models;

use App\Enums\IncentivePointType;
use App\Models\AllUsers\User;
use App\Models\Core\BaseModel;
use App\Models\Programs\Level;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Incentive points earned by a user (نقاط التحفيز).
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $level_id
 * @property int $points
 * @property IncentivePointType $type
 */
class IncentivePoint extends BaseModel
{
    protected $table = 'incentive_points';

    protected $fillable = [
        'user_id',
        'level_id',
        'points',
        'type',
    ];

    protected $casts = [
        'points' => 'integer',
        'type' => IncentivePointType::class,
    ];

    /**
     * User that earned the points.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Level associated with the points (optional).
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class)->withTrashed();
    }
}
