<?php

use Illuminate\Support\Facades\Route;

$controller = 'PublicSettings\PagesController';
Route::get('pages', [
    'uses'      => $controller . '@index',
    'as'        => 'pages.index',
    'title'     => 'pages.index',
    'icon'      => '<i class="feather icon-image"></i>',
    'type'      => 'parent',
    'sub_route' => false,
    'child'     => [
        'pages.edit',
        'pages.update',
        'pages.show'
    ]
]);


# pages update
Route::get('pages/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'pages.edit',
    'title' => 'pages.edit_page'
]);

# pages update
Route::put('pages/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'pages.update',
    'title' => 'pages.edit'
]);

# pages show
Route::get('pages/{id}/Show', [
    'uses'  => $controller . '@show',
    'as'    => 'pages.show',
    'title' => 'pages.show',
]);
    /*------------ end Of pages ----------*/
