<?php

namespace App\Http\Requests\Api\User\Profile;

use App\Http\Requests\Api\BaseApiRequest;

class UpdateProfileRequest extends BaseApiRequest
{
    public function rules()
    {
        return [
            'name'                 => 'sometimes|string|max:50|min:2',
            'image'                => 'sometimes|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'age'                  => ['sometimes', 'integer', 'min:18', 'max:100'],
            'weight'               => ['sometimes', 'numeric', 'min:0', 'max:500'],
            'height'               => ['sometimes', 'numeric', 'min:0', 'max:300'],
            'waist_circumference'  => ['sometimes', 'numeric', 'min:0', 'max:250'],
            'lat'                  => ['sometimes', 'numeric', 'between:-90,90'],
            'lng'                  => ['sometimes', 'numeric', 'between:-180,180'],
            'map_desc'             => 'sometimes|string|max:255',
        ];
    }
}
