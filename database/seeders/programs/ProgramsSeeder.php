<?php

namespace Database\Seeders\programs;

use Illuminate\Database\Seeder;

class ProgramsSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProgramTableSeeder::class,
            DailyActivityTableSeeder::class,
        ]);
    }
}
