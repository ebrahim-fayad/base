<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of introparteners ----------*/

$controller = 'LandingPage\IntroPartnerController';
Route::get('introparteners', [
    'uses'  => $controller . '@index',
    'as'    => 'introparteners.index',
    'title' => 'success_Partners.index',
    'sub_link'  => true,
]);

# introparteners update
Route::get('introparteners/{id}/Show', [
    'uses'  => $controller . '@show',
    'as'    => 'introparteners.show',
    'title' => 'success_Partners.show',
]);

# socials store
Route::get('introparteners/create', [
    'uses'  => $controller . '@create',
    'as'    => 'introparteners.create',
    'title' => 'success_Partners.create_page',
]);

# introparteners store
Route::post('introparteners/store', [
    'uses'  => $controller . '@store',
    'as'    => 'introparteners.store',
    'title' => 'success_Partners.create',
]);

# introparteners update
Route::get('introparteners/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'introparteners.edit',
    'title' => 'success_Partners.edit_page',
]);

# introparteners update
Route::put('introparteners/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'introparteners.update',
    'title' => 'success_Partners.edit',
]);

# introparteners delete
Route::delete('introparteners/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'introparteners.delete',
    'title' => 'success_Partners.delete',
]);

#delete all introparteners
Route::post('delete-all-introparteners', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'introparteners.deleteAll',
    'title' => 'success_Partners.delete_all',
]);
/*------------ end Of introparteners ----------*/
