<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of introhowworks ----------*/

$controller = 'LandingPage\IntroHowWorkController';
Route::get('introhowworks', [
    'uses'  => $controller . '@index',
    'as'    => 'introhowworks.index',
    'title' => 'how_the_site_works.index',
    'sub_link'  => true,
]);

# introhowworks store
Route::get('introhowworks/create', [
    'uses'  => $controller . '@create',
    'as'    => 'introhowworks.create',
    'title' => 'how_the_site_works.create_page',
]);
# introfqscategories update
Route::get('introhowworks/{id}/Show', [
    'uses'  => $controller . '@show',
    'as'    => 'introhowworks.show',
    'title' => 'how_the_site_works.show',
]);

# introhowworks update
Route::get('introhowworks/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'introhowworks.edit',
    'title' => 'how_the_site_works.edit_page',
]);

# introhowworks store
Route::post('introhowworks/store', [
    'uses'  => $controller . '@store',
    'as'    => 'introhowworks.store',
    'title' => 'how_the_site_works.create',
]);

# introhowworks update
Route::put('introhowworks/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'introhowworks.update',
    'title' => 'how_the_site_works.edit',
]);

# introhowworks delete
Route::delete('introhowworks/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'introhowworks.delete',
    'title' => 'how_the_site_works.delete',
]);

#delete all introhowworks
Route::post('delete-all-introhowworks', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'introhowworks.deleteAll',
    'title' => 'how_the_site_works.delete_all',
]);
    /*------------ end Of introhowworks ----------*/
