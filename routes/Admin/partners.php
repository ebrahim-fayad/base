<?php

use Illuminate\Support\Facades\Route;

$controller = 'PartenersController';

Route::get('partners', [
    'uses'      => $controller . '@index',
    'as'        => 'partners.index',
    'title'     => 'partners.index',
    'icon'      => '<i class="feather icon-image"></i>',
    'type'      => 'parent',
    'sub_route' => false,
    'child'     => [
        'partners.create',
        'partners.store',
        'partners.edit',
        'partners.update',
        'partners.show',
    ]
]);

Route::get('partners/create', [
    'uses'  => $controller . '@create',
    'as'    => 'partners.create',
    'title' => 'partners.create_page',
]);

Route::post('partners/store', [
    'uses'  => $controller . '@store',
    'as'    => 'partners.store',
    'title' => 'partners.add',
]);

Route::get('partners/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'partners.edit',
    'title' => 'partners.edit_page',
]);

Route::put('partners/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'partners.update',
    'title' => 'partners.edit',
]);

Route::get('partners/{id}/Show', [
    'uses'  => $controller . '@show',
    'as'    => 'partners.show',
    'title' => 'partners.show',
]);

Route::delete('partners/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'partners.delete',
    'title' => 'partners.delete',
]);

Route::post('delete-all-partners', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'partners.deleteAll',
    'title' => 'partners.delete_all',
]);

/*------------ end Of partners ----------*/
