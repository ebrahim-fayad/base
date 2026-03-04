<?php

namespace App\Traits\Users;

use App\Models\Day;
use App\Models\City;
use App\Models\Rate;
use App\Models\Order;
use App\Models\Country;
use App\Models\DayProvider;
use App\Enums\OrderStatusEnum;



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

    public function rates(){
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
        return $this->hasMany(Order::class);
    }
    public function activeOrders()
    {
        return $this->orders()->whereIn('status', [OrderStatusEnum::NEW->value, OrderStatusEnum::WAIT_APPROVE->value]);
    }

}
