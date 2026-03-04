<?php

namespace App\Observers;

use App\Models\AllUsers\Pharmacy;
use App\Models\AllUsers\DeliveryCompany;
use App\Models\AllUsers\DeliveryMan;
use App\Models\AllUsers\User;

class PageObserver
{
    public function updated($model)
    {
        match($model->slug) {
            'pharmacies-terms' => Pharmacy::query()->update(['is_read_terms' => 0]),
            'delivery-companies-terms' => DeliveryCompany::query()->update(['is_read_terms' => 0]),
            'delivery-men-terms' => DeliveryMan::query()->update(['is_read_terms' => 0]),
            'users-terms' => User::query()->update(['is_read_terms' => 0]),
        };
    }
}
