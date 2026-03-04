<?php

namespace App\Models\Programs;

use App\Models\Core\BaseModel;
use Spatie\Translatable\HasTranslations;

class Exercise extends BaseModel
{
    use HasTranslations;

    const IMAGEPATH = 'daily_activities';
    const MAX_EXERCISES_PER_DAY = 4;

    protected $table = 'daily_activities';

    protected $fillable = [
        'level_day_id',
        'exercise_name',
        'description',
        'image',
        'incentive_points',
    ];

    protected $casts = [
        'incentive_points' => 'integer',
    ];

    public $translatable = ['exercise_name', 'description'];

    public function levelDay()
    {
        return $this->belongsTo(LevelDay::class);
    }
}
