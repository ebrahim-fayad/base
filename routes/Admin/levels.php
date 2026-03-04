<?php

use Illuminate\Support\Facades\Route;

$controller = 'Programs\LevelController';

/*------------ start Of levels (programs) ----------*/
Route::get('levels/create', [
    'uses'  => $controller . '@create',
    'as'    => 'levels.create',
    'title' => 'levels.create_page',
]);

Route::get('levels/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'levels.edit',
    'title' => 'levels.edit_page',
]);

Route::get('levels/{id}/show', [
    'uses'  => $controller . '@show',
    'as'    => 'levels.show',
    'title' => 'levels.show',
]);

Route::post('levels/store', [
    'uses'  => $controller . '@store',
    'as'    => 'levels.store',
    'title' => 'levels.create',
]);

Route::put('levels/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'levels.update',
    'title' => 'levels.edit',
]);

Route::delete('levels/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'levels.delete',
    'title' => 'levels.delete',
]);

Route::post('delete-all-levels', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'levels.deleteAll',
    'title' => 'levels.delete_all',
]);

Route::post('levels/toggle-status', [
    'uses'  => $controller . '@toggleStatus',
    'as'    => 'levels.toggleStatus',
    'title' => 'levels.toggle_status',
]);

Route::get('levels', [
    'uses'          => $controller . '@index',
    'as'            => 'levels.index',
    'title'         => 'levels.index',
    'icon'          => '<i class="feather icon-award"></i>',
    'type'          => 'parent',
    'has_sub_route' => false,
    'child'         => [
        'levels.create',
        'levels.edit',
        'levels.update',
        'levels.show',
        'levels.delete',
        'levels.deleteAll',
    ],
]);

/*------------ end Of levels Controller ----------*/
