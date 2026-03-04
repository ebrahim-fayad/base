<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\all_users\{
    AdminTableSeeder,
    UserTableSeeder,
};
use Database\Seeders\landing_page\{
    IntroFqsCategoryTableSeeder,
    IntroFqsTableSeeder,
    IntroHowWorkTableSeeder,
    IntroPartnerTableSeeder,
    IntroServiceTableSeeder,
    IntroSliderTableSeeder,
    IntroSocialTableSeeder
};
use Database\Seeders\programs\ProgramsSeeder;
use Database\Seeders\MealTypeSeeder;
use Database\Seeders\MealItemSeeder;

use Database\Seeders\public_settings\{
    PermissionTableSeeder,
    RolesTableSeeder,
    SettingSeeder,
    SmsTableSeeder,
};

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(SettingSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(IntroHowWorkTableSeeder::class);
        $this->call(IntroSliderTableSeeder::class);
        $this->call(IntroServiceTableSeeder::class);
        $this->call(IntroFqsCategoryTableSeeder::class);
        $this->call(IntroFqsTableSeeder::class);
        $this->call(IntroPartnerTableSeeder::class);
        $this->call(IntroSocialTableSeeder::class);
        $this->call(ProgramsSeeder::class);
        $this->call(MealTypeSeeder::class);
        $this->call(MealItemSeeder::class);
        $this->call(SmsTableSeeder::class);
        $this->call(PagesTableSeeder::class);
    }
}
