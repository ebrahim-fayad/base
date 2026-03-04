<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMealComponentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'meal_item_id'         => $this->meal_item_id,
            'meal_item_name'       => $this->mealItem?->name,
            'quantity_grams'       => (float) $this->quantity_grams,
            'calculated_calories'  => (float) $this->calculated_calories,
            'calculated_protein'   => (float) $this->calculated_protein,
            'calculated_carbohydrates' => (float) $this->calculated_carbohydrates,
            'calculated_fats'      => (float) $this->calculated_fats,
        ];
    }
}
