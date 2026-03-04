<?php

namespace App\Enums;

use App\Traits\EnumRetriever;

/**
 * Incentive point category (نقاط التحفيز).
 * Stored as TINYINT in DB.
 */
enum IncentivePointType: int
{
    use EnumRetriever;

    case PhysicalActivity = 1;
    case DietPlan = 2;
    case BonusDiet = 3;
    case BonusDietAndPhysicalActivity = 4;

    /**
     * Translation key for the point type (admin panel).
     */
    public function translationKey(): string
    {
        return match ($this) {
            self::PhysicalActivity => 'admin.incentive_point_type_physical_activity',
            self::DietPlan => 'admin.incentive_point_type_diet_plan',
            self::BonusDiet => 'admin.incentive_point_type_bonus_diet',
            self::BonusDietAndPhysicalActivity => 'admin.incentive_point_type_bonus_diet_and_physical_activity',
        };
    }

    /**
     * Localized label for the point type (Arabic/English based on app locale).
     */
    public function label(): string
    {
        return __($this->translationKey());
    }
}
