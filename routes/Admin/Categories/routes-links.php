<?php

use Illuminate\Support\Facades\Route;

$controller = 'Categories\CategoryController';
/*------------ start Of categories Controller ----------*/

// يجب تعريف create قبل {parent_id?} وإلا Laravel يطابق "create" كـ parent_id ويعرض index
Route::get('categories/create/{parent_id?}', [
    'uses'  => $controller . '@create',
    'as'    => 'categories.create',
    'title' => 'categories.create_page',
]);

Route::get('categories/{parent_id?}', [
    'uses'     => $controller . '@index',
    'as'       => 'categories.index',
    'sub_link' => true,
    'title'    => 'categories.index',
]);

Route::get('categories/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'categories.edit',
    'title' => 'categories.edit_page',
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

Route::get('categories/{id}/show', [
    'uses'  => $controller . '@show',
    'as'    => 'categories.show',
    'title' => 'categories.show',
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

/*------------ end Of categories Controller ----------*/

