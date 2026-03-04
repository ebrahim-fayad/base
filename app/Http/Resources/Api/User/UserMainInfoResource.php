<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserMainInfoResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'                   => $this?->id,
            'name'                 => $this?->name,
            'age'                  => $this?->age,
            'weight'               => $this?->weight,
            'height'               => $this?->height,
            'waist_circumference'  => $this?->waist_circumference,
        ];
    }
}
