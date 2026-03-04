<?php

namespace Database\Seeders\all_users;

use DB;
use Faker\Factory as Faker;
use App\Models\AllUsers\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    public function run()
    {

        $faker = Faker::create('ar_SA');

        for ($i = 0; $i < 20; $i++) {
            User::create([
                'name'                 => $faker->name,
                'country_code'         => '966',
                'phone'                => "51111111$i",
                'age'                  => rand(18, 65),
                'weight'               => rand(50, 120) + (rand(0, 99) / 100),
                'height'               => rand(150, 200) + (rand(0, 99) / 100),
                'waist_circumference'  => rand(60, 120) + (rand(0, 99) / 100),
                'lat'                  => rand(2400, 3200) / 100,
                'lng'                  => rand(4600, 5400) / 100,
                'map_desc'             => $faker->address,
                'image'                => null,
                'lang'                 => 'ar',
                'password'             => 123456,
                'active'               => rand(0, 1),
                'is_blocked'           => 0,
                'is_notify'            => rand(0, 1),
                'created_at'            => now(),
                'updated_at'            => now(),
            ]);
        }
    }
}
