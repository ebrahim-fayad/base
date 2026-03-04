<?php

use Illuminate\Support\Facades\Route;
use Routes\Admin\CountriesCities\Cities\CitiesRoutesName;
use Routes\Admin\CountriesCities\Countries\CountriesRoutesName;

/*------------ start Of countries and Cities ----------*/

Route::get('countries-cities', [
    'as'        => 'countries-cities',
    'icon'      => '<i class="feather icon-flag"></i>',
    'title'     => 'countries_cities',
    'type'      => 'parent',
    'has_sub_route' => true,
    'child'     => array_merge(
        CountriesRoutesName::getNames(),
        CitiesRoutesName::getNames(),
        []
    ),
]);

require __DIR__ . '/CountriesCities/Countries/routes-links.php';
require __DIR__ . '/CountriesCities/Cities/routes-links.php';

// Routes without permission
Route::get('country/get-cities', 'CountriesCities\CityController@getCities')->name('country.get-cities');
