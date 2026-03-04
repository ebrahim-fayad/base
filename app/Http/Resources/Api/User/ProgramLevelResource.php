<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramLevelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'level_number' => $this->level_number ?? (string) $this->order,
            'description' => $this->description,
            'subscription_price' => (float) $this->subscription_price,
        ];
    }
}
