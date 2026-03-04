<?php

namespace App\Http\Resources\Api\User;

use App\Http\Resources\Api\Basics\BasicResource;
use App\Models\CountryCity\Country;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private $token = '';

    public function setToken($value)
    {
        $this->token = $value;
        return $this;
    }

    public function toArray($request)
    {
        return [
            'id'                   => $this?->id,
            'name'                 => $this?->name,
            'country_code'         => $this?->country_code,
            'country_flag'         => Country::where('key', 'like', '%' . $this->country_code . '%')->first()?->flag,
            'phone'                => $this?->phone,
            'full_phone'           => $this?->full_phone,
            'image'                => $this?->image,
            'age'                  => $this?->age,
            'weight'               => $this?->weight,
            'height'               => $this?->height,
            'waist_circumference'  => $this?->waist_circumference,
            'lat'                  => $this?->lat,
            'lng'                  => $this?->lng,
            'map_desc'             => $this?->map_desc,
            'lang'                 => $this?->lang,
            'is_notify'            => $this?->is_notify,
            'need_to_complete_data' => $this->needToCompleteData(),
            'token'                => $this->when($this->token, $this->token),
        ];
    }

    public function needToCompleteData()
    {
        return !isset($this->age, $this->weight, $this->height, $this->waist_circumference);
    }
}
