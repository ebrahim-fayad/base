<?php

use Illuminate\Support\Facades\Route;

$controller = 'MealItems\MealItemController';
$analyticsController = 'MealItems\MealAnalyticsController';

Route::get('meal-analytics', [
    'uses'     => $analyticsController . '@index',
    'as'       => 'meal_analytics.index',
    'title'    => 'meal_analytics.index',
    'sub_link' => true,
]);

Route::get('meal-items', [
    'uses'      => $controller . '@index',
    'as'        => 'meal_items.index',
    'title'     => 'meal_items.index',
    'sub_link'  => true,
]);

Route::get('meal-items/{id}/show', [
    'uses'  => $controller . '@show',
    'as'    => 'meal_items.show',
    'title' => 'meal_items.show',
]);

Route::get('meal-items/create', [
    'uses'  => $controller . '@create',
    'as'    => 'meal_items.create',
    'title' => 'meal_items.create_page',
]);

Route::post('meal-items/store', [
    'uses'  => $controller . '@store',
    'as'    => 'meal_items.store',
    'title' => 'meal_items.create',
]);

Route::get('meal-items/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'meal_items.edit',
    'title' => 'meal_items.edit_page',
]);

Route::put('meal-items/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'meal_items.update',
    'title' => 'meal_items.edit',
]);

Route::delete('meal-items/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'meal_items.delete',
    'title' => 'meal_items.delete',
]);

Route::post('delete-all-meal-items', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'meal_items.deleteAll',
    'title' => 'meal_items.delete_all',
]);