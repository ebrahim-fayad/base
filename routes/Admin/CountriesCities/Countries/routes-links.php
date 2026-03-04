<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of countries ----------*/

$controller = 'CountriesCities\CountryController';
Route::get('countries', [
    'uses'      => $controller . '@index',
    'as'        => 'countries.index',
    'title'     => 'countries.index',
    'sub_link'  => true,
]);

Route::get('countries/{id}/show', [
    'uses'  => $controller . '@show',
    'as'    => 'countries.show',
    'title' => 'countries.show',
]);

# countries store
Route::get('countries/create', [
    'uses'  => $controller . '@create',
    'as'    => 'countries.create',
    'title' => 'countries.create_page',
]);

# countries store
Route::post('countries/store', [
    'uses'  => $controller . '@store',
    'as'    => 'countries.store',
    'title' => 'countries.create',
]);

# countries update
Route::get('countries/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'countries.edit',
    'title' => 'countries.edit_page',
]);

# countries update
Route::put('countries/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'countries.update',
    'title' => 'countries.edit',
]);

# countries delete
Route::delete('countries/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'countries.delete',
    'title' => 'countries.delete',
]);
#delete all countries
Route::post('delete-all-countries', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'countries.deleteAll',
    'title' => 'countries.delete_all',
]);
/*------------ end Of countries ----------*/
