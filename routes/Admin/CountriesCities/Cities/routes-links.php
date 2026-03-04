<?php

use Illuminate\Support\Facades\Route;


/*------------ start Of cities ----------*/

$controller = 'CountriesCities\CityController';
Route::get('cities', [
    'uses'      => $controller . '@index',
    'as'        => 'cities.index',
    'title'     => 'cities.index',
    'sub_link'  => true,
]);

# cities store
Route::get('cities/create', [
    'uses'  => $controller . '@create',
    'as'    => 'cities.create',
    'title' => 'cities.create_page',
]);

# cities store
Route::post('cities/store', [
    'uses'  => $controller . '@store',
    'as'    => 'cities.store',
    'title' => 'cities.create',
]);

# cities update
Route::get('cities/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'cities.edit',
    'title' => 'cities.edit_page',
]);

# cities update
Route::put('cities/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'cities.update',
    'title' => 'cities.edit',
]);

Route::get('cities/{id}/show', [
    'uses'  => $controller . '@show',
    'as'    => 'cities.show',
    'title' => 'cities.show',
]);

# cities delete
Route::delete('cities/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'cities.delete',
    'title' => 'cities.delete',
]);
#delete all cities
Route::post('delete-all-cities', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'cities.deleteAll',
    'title' => 'cities.delete_all',
]);
    /*------------ end Of cities ----------*/
