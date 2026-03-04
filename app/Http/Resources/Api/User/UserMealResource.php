<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMealResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                     => $this->id,
            'meal_type_id'           => $this->meal_type_id,
            'meal_type_name'         => $this->mealType?->name,
            'date'                   => $this->date?->format('Y-m-d'),
            'total_calories'         => (float) $this->total_calories,
            'total_protein'          => (float) $this->total_protein,
            'total_carbohydrates'    => (float) $this->total_carbohydrates,
            'total_fats'             => (float) $this->total_fats,
            'components'             => UserMealComponentResource::collection($this->whenLoaded('components')),
        ];
    }
}
