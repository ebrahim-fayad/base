<?php

namespace App\Traits\Providers;

use App\Enums\OrderStatusEnum;
use App\Models\City;
use App\Models\Rate;
use App\Models\Country;
use App\Models\DayProvider;
use App\Models\Day;
use App\Models\Order;
use App\Models\Service;



trait RelationsTrait
{
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function rates()
    {
        return $this->morphMany(Rate::class, 'ratingable');
    }
    public function days()
    {
        return $this->belongsToMany(Day::class)
            ->using(DayProvider::class)
            ->withPivot('start_time', 'end_time', 'is_open', 'total_beneficiaries')
            ->withTimestamps();
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'provider_id');
    }

    public function unSettledOrders()
    {
        $orders = $this->orders()->where('is_settled', false)
            ->where('status', OrderStatusEnum::FINISHED->value)
            ->orderBy('created_at', 'desc')
            ->get();
        return $orders;
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'provider_id');
    }

}
