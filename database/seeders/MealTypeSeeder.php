<?php

namespace Database\Seeders;

use App\Models\Meals\MealType;
use Illuminate\Database\Seeder;

class MealTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name'  => ['ar' => 'فطار', 'en' => 'Breakfast'],
                'active' => true,
            ],
            [
                'name'  => ['ar' => 'غداء', 'en' => 'Lunch'],
                'active' => true,
            ],
            [
                'name'  => ['ar' => 'عشاء', 'en' => 'Dinner'],
                'active' => true,
            ],
            [
                'name'  => ['ar' => 'سناكس', 'en' => 'Snacks'],
                'active' => true,
            ],
        ];

        if (MealType::count() > 0) {
            return;
        }

        foreach ($types as $data) {
            MealType::create($data);
        }
    }
}
