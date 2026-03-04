<?php

namespace App\Models\Meals;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class MealType extends BaseModel
{
    use HasTranslations, SoftDeletes;

    protected $fillable = ['name', 'active'];

    public $translatable = ['name'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
