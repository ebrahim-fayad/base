<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of categories and services ----------*/
$controller = 'Categories\CategoryController';

// المسارات المحددة أولاً (مثل create, edit, show) حتى لا تُلتقط من categories/{parent_id?}
Route::get('categories/create/{parent_id?}', [
    'uses'  => $controller . '@create',
    'as'    => 'categories.create',
    'title' => 'categories.create_page',
]);

Route::get('categories/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'categories.edit',
    'title' => 'categories.edit_page',
]);

Route::get('categories/{id}/show', [
    'uses'  => $controller . '@show',
    'as'    => 'categories.show',
    'title' => 'categories.show',
]);

Route::post('categories/store', [
    'uses'  => $controller . '@store',
    'as'    => 'categories.store',
    'title' => 'categories.create',
]);

Route::put('categories/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'categories.update',
    'title' => 'categories.edit',
]);

Route::delete('categories/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'categories.delete',
    'title' => 'categories.delete',
]);

Route::post('delete-all-categories', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'categories.deleteAll',
    'title' => 'categories.delete_all',
]);

// الـ index في الآخر: categories و categories/{parent_id}
Route::get('categories/{parent_id?}', [
    'uses'          => $controller . '@index',
    'as'            => 'categories.index',
    'title'         => 'categories.index',
    'icon'          => '<i class="ficon feather icon-grid"></i>',
    'type'          => 'parent',
    'has_sub_route' => false,
    'child'         => [
        'categories.create',
        'categories.edit',
        'categories.update',
        'categories.show',
        'categories.delete',
        'categories.deleteAll',
    ],
]);

/*------------ end Of categories Controller ----------*/

