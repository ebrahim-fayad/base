<?php

namespace App\Models\Programs;

use App\Models\AllUsers\User;
use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * تسجيل إكمال المستخدم لنشاط بدني: اليوزر X خلص النشاط Y وجاب فيه Z نقطة.
 *
 * @property int $id
 * @property int $user_id
 * @property int $level_id
 * @property int $level_day_id
 * @property int $daily_activity_id
 * @property int $points
 */
class PhysicalActivityCompletion extends BaseModel
{
    protected $table = 'physical_activity_completions';

    protected $fillable = [
        'user_id',
        'level_id',
        'level_day_id',
        'daily_activity_id',
        'rate',
    ];

    protected $casts = [
        'rate' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class)->withTrashed();
    }

    public function levelDay(): BelongsTo
    {
        return $this->belongsTo(LevelDay::class)->withTrashed();
    }

    public function dailyActivity(): BelongsTo
    {
        return $this->belongsTo(Exercise::class, 'daily_activity_id');
    }
}
