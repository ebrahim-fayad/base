<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of images ----------*/

$controller = 'PublicSections\ImageController';
Route::get('images', [
    'uses'     => $controller . '@index',
    'as'       => 'images.index',
    'title'    => 'advertising_banners.index',
    'sub_link' => true,
]);
Route::get('images/{id}/show', [
    'uses'  => $controller . '@show',
    'as'    => 'images.show',
    'title' => 'advertising_banners.show',
]);
# images store
Route::get('images/create', [
    'uses'  => $controller . '@create',
    'as'    => 'images.create',
    'title' => 'advertising_banners.create_page',
]);

# images store
Route::post(
    'images/store',
    [
        'uses'  => $controller . '@store',
        'as'    => 'images.store',
        'title' => 'advertising_banners.create',
    ]
);

# images update
Route::get('images/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'images.edit',
    'title' => 'advertising_banners.edit_page',
]);

# images update
Route::put('images/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'images.update',
    'title' => 'advertising_banners.edit',
]);

# images delete
Route::delete(
    'images/{id}',
    [
        'uses'  => $controller . '@destroy',
        'as'    => 'images.delete',
        'title' => 'advertising_banners.delete',
    ]
);
#delete all images
Route::post('delete-all-images', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'images.deleteAll',
    'title' => 'advertising_banners.delete_all',
]);
/*------------ end Of images ----------*/
