<?php

namespace App\Models\Programs;

use App\Models\Core\BaseModel;

class LevelDay extends BaseModel
{
    protected $fillable = [
        'level_id',
        'day_number',
    ];

    protected $casts = [
        'day_number' => 'integer',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class)->withTrashed();
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'level_day_id')->orderBy('id');
    }
}
