<?php

namespace Database\Seeders;

use App\Services\CountryCities\CountryService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countryService = new CountryService();
        DB::table('countries')->insert([
            [
                'name'          => json_encode(['ar' => 'السعودية', 'en' => 'Saudi Arabia'], JSON_UNESCAPED_UNICODE),
                'key'           => '966',
                'flag' => $countryService->getFlagByCountryName('Saudi Arabia'),
                'created_at'    => \Carbon\Carbon::now()->subMonth(rand(0, 6)),
            ],
        ]);
    }
}
