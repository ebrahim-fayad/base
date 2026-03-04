<?php

namespace Database\Factories;

use App\Models\Programs\Level;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Programs\Level>
 */
class LevelFactory extends Factory
{
    protected $model = Level::class;

    public function definition(): array
    {
        return [
            'name' => ['en' => 'Level ' . $this->faker->word(), 'ar' => 'مستوى'],
            'description' => ['en' => $this->faker->sentence(), 'ar' => 'وصف'],
            'subscription_price' => 0,
            'active' => true,
            'order' => 1,
            'level_number' => (string) $this->faker->numberBetween(1, 5),
        ];
    }
}
