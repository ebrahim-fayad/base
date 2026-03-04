<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of Roles----------*/

$controller = 'PublicSettings\RoleController';
Route::get('roles', [
    'uses'     => $controller . '@index',
    'as'       => 'roles.index',
    'title'    => 'roles.index',
    'sub_link' => true,
]);

#add role page
Route::get('roles/create', [
    'uses'  => $controller . '@create',
    'as'    => 'roles.create',
    'title' => 'roles.create_page',

]);

#store role
Route::post('roles/store', [
    'uses'  => $controller . '@store',
    'as'    => 'roles.store',
    'title' => 'roles.create',
]);

#edit role page
Route::get(
    'roles/{id}/edit',
    [
        'uses'  => $controller . '@edit',
        'as'    => 'roles.edit',
        'title' => 'roles.edit_page',
    ]
);

#update role
Route::put('roles/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'roles.update',
    'title' => 'roles.edit',
]);

#delete role
Route::delete('roles/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'roles.delete',
    'title' => 'roles.delete',
]);
/*------------ end Of Roles----------*/
