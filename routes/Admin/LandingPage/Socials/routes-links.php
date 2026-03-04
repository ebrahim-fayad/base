<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of introsocials ----------*/

$controller = 'LandingPage\IntroSocialController';
Route::get('introsocials', [
    'uses'  => $controller . '@index',
    'as'    => 'introsocials.index',
    'title' => 'socials.index',
    'sub_link'  => true,
]);

# introsocials update
Route::get('introsocials/{id}/Show', [
    'uses'  => $controller . '@show',
    'as'    => 'introsocials.show',
    'title' => 'socials.show',
]);
# introsocials store
Route::get('introsocials/create', [
    'uses'  => $controller . '@create',
    'as'    => 'introsocials.create',
    'title' => 'socials.create_page',
]);

# introsocials store
Route::post('introsocials/store', [
    'uses'  => $controller . '@store',
    'as'    => 'introsocials.store',
    'title' => 'socials.create',
]);
# introsocials update
Route::get('introsocials/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'introsocials.edit',
    'title' => 'socials.edit_page',
]);

# introsocials update
Route::put('introsocials/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'introsocials.update',
    'title' => 'socials.edit',
]);

# introsocials delete
Route::delete('introsocials/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'introsocials.delete',
    'title' => 'socials.delete',
]);

#delete all introsocials
Route::post('delete-all-introsocials', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'introsocials.deleteAll',
    'title' => 'socials.delete_all',
]);
/*------------ end Of introsocials ----------*/
