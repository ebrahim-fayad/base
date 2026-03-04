<?php

namespace Database\Factories;

use App\Models\Programs\Level;
use App\Models\Programs\LevelDay;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Programs\LevelDay>
 */
class LevelDayFactory extends Factory
{
    protected $model = LevelDay::class;

    public function definition(): array
    {
        return [
            'level_id' => Level::factory(),
            'day_number' => $this->faker->numberBetween(1, 30),
        ];
    }
}
