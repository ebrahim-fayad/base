<?php

namespace App\Models\Meals;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMealComponent extends Model
{
    protected $fillable = [
        'user_meal_id',
        'meal_item_id',
        'quantity_grams',
        'calculated_calories',
        'calculated_protein',
        'calculated_carbohydrates',
        'calculated_fats',
    ];

    protected $casts = [
        'quantity_grams'         => 'decimal:2',
        'calculated_calories'    => 'decimal:2',
        'calculated_protein'     => 'decimal:2',
        'calculated_carbohydrates' => 'decimal:2',
        'calculated_fats'        => 'decimal:2',
    ];

    public function userMeal(): BelongsTo
    {
        return $this->belongsTo(UserMeal::class);
    }

    public function mealItem(): BelongsTo
    {
        return $this->belongsTo(MealItem::class)->withTrashed();
    }
}
