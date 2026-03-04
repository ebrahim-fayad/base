<?php

use Illuminate\Support\Facades\Route;

$controller = 'MealTypes\MealTypeController';

Route::get('meal-types', [
    'uses'      => $controller . '@index',
    'as'        => 'meal_types.index',
    'title'     => 'meal_types.index',
    'sub_link'  => true,
]);

Route::get('meal-types/{id}/show', [
    'uses'  => $controller . '@show',
    'as'    => 'meal_types.show',
    'title' => 'meal_types.show',
]);

Route::get('meal-types/create', [
    'uses'  => $controller . '@create',
    'as'    => 'meal_types.create',
    'title' => 'meal_types.create_page',
]);

Route::post('meal-types/store', [
    'uses'  => $controller . '@store',
    'as'    => 'meal_types.store',
    'title' => 'meal_types.create',
]);

Route::get('meal-types/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'meal_types.edit',
    'title' => 'meal_types.edit_page',
]);

Route::put('meal-types/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'meal_types.update',
    'title' => 'meal_types.edit',
]);

Route::delete('meal-types/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'meal_types.delete',
    'title' => 'meal_types.delete',
]);

Route::post('delete-all-meal-types', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'meal_types.deleteAll',
    'title' => 'meal_types.delete_all',
]);