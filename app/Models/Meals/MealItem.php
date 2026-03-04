<?php

namespace App\Models\Meals;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class MealItem extends BaseModel
{
    use HasTranslations, SoftDeletes;

    const IMAGEPATH = 'meal_items';

    protected $fillable = [
        'name',
        'calories',
        'protein',
        'carbohydrates',
        'fats',
        'active',
        'image',
    ];

    public $translatable = ['name'];

    protected $casts = [
        'calories'      => 'decimal:2',
        'protein'       => 'decimal:2',
        'carbohydrates' => 'decimal:2',
        'fats'          => 'decimal:2',
        'active'        => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
