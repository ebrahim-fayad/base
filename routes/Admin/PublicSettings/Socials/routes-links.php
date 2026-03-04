<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of socials ----------*/

$controller = 'PublicSettings\SocialController';
Route::get('socials', [
    'uses'     => $controller . '@index',
    'as'       => 'socials.index',
    'title'    => 'socials.index',
    'sub_link' => true,
]);
# socials update
Route::get('socials/{id}/Show', [
    'uses'  => $controller . '@show',
    'as'    => 'socials.show',
    'title' => 'socials.show',
]);
# socials store
Route::get(
    'socials/create',
    [
        'uses'  => $controller . '@create',
        'as'    => 'socials.create',
        'title' => 'socials.create_page',
    ]
);

# socials store
Route::post('socials', [
    'uses'  => $controller . '@store',
    'as'    => 'socials.store',
    'title' => 'socials.create',
]);
# socials update
Route::get('socials/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'socials.edit',
    'title' => 'socials.edit_page',
]);
# socials update
Route::put('socials/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'socials.update',
    'title' => 'socials.edit',
]);

# socials delete
Route::delete('socials/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'socials.delete',
    'title' => 'socials.delete',
]);

#delete all socials
Route::post('delete-all-socials', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'socials.deleteAll',
    'title' => 'socials.delete_all',
]);
/*------------ end Of socials ----------*/
