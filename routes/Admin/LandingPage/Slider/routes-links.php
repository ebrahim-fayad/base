<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of introsliders ----------*/

$controller = 'LandingPage\IntroSliderController';
Route::get('introsliders', [
    'uses'      => $controller . '@index',
    'as'        => 'introsliders.index',
    'title'     => 'intro_slider.index',
    'sub_link'  => true,
]);

# socials store
Route::get('introsliders/create', [
    'uses'  => $controller . '@create',
    'as'    => 'introsliders.create',
    'title' => 'intro_slider.create_page',
]);

# introsliders store
Route::post('introsliders/store', [
    'uses'  => $controller . '@store',
    'as'    => 'introsliders.store',
    'title' => 'intro_slider.create',
]);

# socials update
Route::get('introsliders/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'introsliders.edit',
    'title' => 'intro_slider.edit_page',
]);

# introsliders update
Route::put('introsliders/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'introsliders.update',
    'title' => 'intro_slider.edit',
]);

# introsliders update
Route::get('introsliders/{id}/Show', [
    'uses'  => $controller . '@show',
    'as'    => 'introsliders.show',
    'title' => 'intro_slider.show',
]);

# introsliders delete
Route::delete('introsliders/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'introsliders.delete',
    'title' => 'intro_slider.delete',
]);

#delete all introsliders
Route::post('delete-all-introsliders', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'introsliders.deleteAll',
    'title' => 'intro_slider.delete_all',
]);
/*------------ end Of introsliders ----------*/
