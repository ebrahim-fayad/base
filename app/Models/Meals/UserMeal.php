<?php

namespace App\Models\Meals;

use App\Models\AllUsers\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserMeal extends Model
{
    protected $table = 'user_meals';

    protected $fillable = [
        'user_id',
        'meal_type_id',
        'date',
        'total_calories',
        'total_protein',
        'total_carbohydrates',
        'total_fats',
    ];

    protected $casts = [
        'date'                  => 'date',
        'total_calories'        => 'decimal:2',
        'total_protein'         => 'decimal:2',
        'total_carbohydrates'   => 'decimal:2',
        'total_fats'            => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mealType(): BelongsTo
    {
        return $this->belongsTo(MealType::class, 'meal_type_id')->withTrashed();
    }

    public function components(): HasMany
    {
        return $this->hasMany(UserMealComponent::class, 'user_meal_id');
    }
}
