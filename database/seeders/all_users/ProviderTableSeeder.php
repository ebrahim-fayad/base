<?php
namespace Database\Seeders\all_users;


use App\Models\AllUsers\Provider;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Country;
use App\Enums\ApprovementStatusEnum;

class ProviderTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('ar_SA');

        for ($i = 0; $i < 20; $i++) {
            // $country = Country::has('cities')->inRandomOrder()->first();
            // $city = $country->cities()->inRandomOrder()->first();

            $record = [
                'image'              => 'default.png',
                'name'               => 'Wesam - W&S '.$i,
                'country_code'       => '966',
                'phone'              => "51111111$i",
                'email'              => $faker->unique()->email,
                // 'bio'                => [
                //     'ar'=> $faker->paragraph(),
                //     'en'=> $faker->paragraph(),
                // ],

                'lang'               => 'ar',

                'commercial_image'   => 'default.png',
                'identity_numb'      => $faker->numerify('##################'),

                'active'          => rand(0, 1),
                'is_blocked'         => fake()->boolean(20), // 20% chance to be true (blocked) , 0 => not blocked, 1 => blocked
                'is_approved'        => rand(ApprovementStatusEnum::PENDING->value, ApprovementStatusEnum::APPROVED->value), // 50% chance to be pending, 50% chance to be approved
                'is_notify'          => rand(0, 1),


                'map_desc'           => $faker->address,
                'lat'                => $faker->latitude,
                'lng'                => $faker->longitude,


                'created_at'         => now(),
                'updated_at'         => now(),
            ];

            $provider = Provider::create($record);


        }
    }
}
