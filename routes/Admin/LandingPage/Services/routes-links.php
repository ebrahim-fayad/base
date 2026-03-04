<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of introservices ----------*/

$controller = 'LandingPage\IntroServiceController';
Route::get('introservices', [
    'uses'  => $controller . '@index',
    'as'    => 'introservices.index',
    'title' => 'our_services.index',
    'sub_link'  => true,
]);
# introservices update
Route::get('introservices/{id}/Show', [
    'uses'  => $controller . '@show',
    'as'    => 'introservices.show',
    'title' => 'our_services.show',
]);
# socials store
Route::get('introservices/create', [
    'uses'  => $controller . '@create',
    'as'    => 'introservices.create',
    'title' => 'our_services.create_page',
]);
# introservices store
Route::post('introservices/store', [
    'uses'  => $controller . '@store',
    'as'    => 'introservices.store',
    'title' => 'our_services.create',
]);

# socials update
Route::get('introservices/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'introservices.edit',
    'title' => 'our_services.edit_page',
]);

# introservices update
Route::put('introservices/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'introservices.update',
    'title' => 'our_services.edit',
]);

# introservices delete
Route::delete('introservices/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'introservices.delete',
    'title' => 'our_services.delete',
]);

#delete all introservices
Route::post('delete-all-introservices', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'introservices.deleteAll',
    'title' => 'our_services.delete_all',
]);
/*------------ end Of introservices ----------*/
