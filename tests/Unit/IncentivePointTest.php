<?php

namespace Tests\Unit;

use App\Enums\IncentivePointType;
use App\Models\AllUsers\User;
use App\Models\IncentivePoint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncentivePointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Record can be created with valid attributes.
     */
    public function test_incentive_point_record_can_be_created(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'phone' => '500000' . random_int(100000, 999999),
            'country_code' => '966',
        ]);

        $point = IncentivePoint::create([
            'user_id' => $user->id,
            'points' => 50,
            'type' => IncentivePointType::PhysicalActivity->value,
        ]);

        $this->assertDatabaseHas('incentive_points', [
            'id' => $point->id,
            'user_id' => $user->id,
            'points' => 50,
            'type' => 1,
        ]);
        $this->assertSame(50, $point->points);
        $this->assertSame($user->id, $point->user_id);
    }

    /**
     * Type is cast to IncentivePointType enum when reading from DB.
     */
    public function test_type_is_casted_to_incentive_point_type_enum(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'phone' => '500001' . random_int(100000, 999999),
            'country_code' => '966',
        ]);

        $point = IncentivePoint::create([
            'user_id' => $user->id,
            'points' => 100,
            'type' => IncentivePointType::BonusDietAndPhysicalActivity,
        ]);

        $point->refresh();

        $this->assertInstanceOf(IncentivePointType::class, $point->type);
        $this->assertSame(IncentivePointType::BonusDietAndPhysicalActivity, $point->type);
        $this->assertSame(4, $point->type->value);
        $this->app->setLocale('en');
        $this->assertSame('Bonus for diet and physical activity', $point->type->label());
    }
}
