<?php

use Illuminate\Support\Facades\Route;

$levelController = 'Programs\LevelController';
$exerciseController = 'Programs\ExerciseController';
$subscriptionController = 'Programs\LevelSubscriptionController';

Route::get('levels', [
    'uses'  => $levelController . '@index',
    'as'    => 'levels.index',
    'title' => 'levels.index',
    'sub_link' => true,
]);
Route::get('levels/create', [
    'uses'  => $levelController . '@create',
    'as'    => 'levels.create',
    'title' => 'levels.create',
]);
Route::post('levels/store', [
    'uses'  => $levelController . '@store',
    'as'    => 'levels.store',
    'title' => 'levels.store',
]);
Route::get('levels/{id}/show', [
    'uses'  => $levelController . '@show',
    'as'    => 'levels.show',
    'title' => 'levels.show',
]);
Route::get('levels/{id}/edit', [
    'uses'  => $levelController . '@edit',
    'as'    => 'levels.edit',
    'title' => 'levels.edit',
]);
Route::put('levels/{id}', [
    'uses'  => $levelController . '@update',
    'as'    => 'levels.update',
    'title' => 'levels.update',
]);
Route::delete('levels/{id}', [
    'uses'  => $levelController . '@destroy',
    'as'    => 'levels.delete',
    'title' => 'levels.delete',
]);
Route::post('delete-all-levels', [
    'uses'  => $levelController . '@destroyAll',
    'as'    => 'levels.deleteAll',
    'title' => 'levels.deleteAll',
]);
Route::post('levels/toggle-status', [
    'uses'  => $levelController . '@toggleStatus',
    'as'    => 'levels.toggleStatus',
    'title' => 'levels.toggleStatus',
]);

// Exercises (per day, max 4)
Route::post('levels/{levelId}/days/{dayId}/exercises', [
    'uses'  => $exerciseController . '@store',
    'as'    => 'levels.days.exercises.store',
    'title' => 'levels.days.exercises.store',
]);
Route::put('levels/{levelId}/days/{dayId}/exercises/{exerciseId}', [
    'uses'  => $exerciseController . '@update',
    'as'    => 'levels.days.exercises.update',
    'title' => 'levels.days.exercises.update',
]);
Route::delete('levels/{levelId}/days/{dayId}/exercises/{exerciseId}', [
    'uses'  => $exerciseController . '@destroy',
    'as'    => 'levels.days.exercises.destroy',
    'title' => 'levels.days.exercises.destroy',
]);

// Subscribers
Route::get('levels/{levelId}/subscribers', [
    'uses'  => $subscriptionController . '@subscribers',
    'as'    => 'levels.subscribers',
    'title' => 'levels.subscribers',
]);
Route::post('levels/subscriptions/toggle-status', [
    'uses'  => $subscriptionController . '@toggleClientStatus',
    'as'    => 'levels.subscriptions.toggleStatus',
    'title' => 'levels.subscriptions.toggleStatus',
]);
