<?php

namespace App\Traits\Admin\Users;

use App\Models\Programs\LevelSubscription;
use App\Models\Programs\PhysicalActivityCompletion;
use App\Models\Meals\UserMeal;
use App\Models\IncentivePoint;

trait RelationsTrait
{
    public function levelSubscriptions()
    {
        return $this->hasMany(LevelSubscription::class);
    }

    public function physicalActivityCompletions()
    {
        return $this->hasMany(PhysicalActivityCompletion::class);
    }

    public function userMeals()
    {
        return $this->hasMany(UserMeal::class);
    }
    public function incentivePoints()
    {
        return $this->hasMany(IncentivePoint::class);
    }
    public function hasActiveSubscription(): bool
    {
        return $this->levelSubscriptions()->active()->exists();
    }
}
