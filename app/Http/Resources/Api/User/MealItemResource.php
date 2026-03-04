<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'calories'      => (float) $this->calories,
            'protein'       => (float) $this->protein,
            'carbohydrates' => (float) $this->carbohydrates,
            'fats'          => (float) $this->fats,
            'per_100g'      => true, // كل القيم بالنسبة لـ 100 جرام
        ];
    }
}
