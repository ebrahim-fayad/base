<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of intros ----------*/

$controller = 'PublicSections\IntroController';
Route::get('intros', [
    'uses'     => $controller . '@index',
    'as'       => 'intros.index',
    'title'    => 'definition_pages.index',
    'sub_link' => true,
]);

# intros update
Route::get('intros/{id}/Show', [
    'uses'  => $controller . '@show',
    'as'    => 'intros.show',
    'title' => 'definition_pages.show',
]);

# intros store
Route::get(
    'intros/create',
    [
        'uses'  => $controller . '@create',
        'as'    => 'intros.create',
        'title' => 'definition_pages.create_page',
    ]
);

# intros store
Route::post(
    'intros/store',
    [
        'uses'  => $controller . '@store',
        'as'    => 'intros.store',
        'title' => 'definition_pages.create',
    ]
);

# intros update
Route::get('intros/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'intros.edit',
    'title' => 'definition_pages.edit_page',
]);

# intros update
Route::put('intros/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'intros.update',
    'title' => 'definition_pages.edit',
]);

# intros delete
Route::delete(
    'intros/{id}',
    [
        'uses'  => $controller . '@destroy',
        'as'    => 'intros.delete',
        'title' => 'definition_pages.delete',
    ]
);
#delete all intros
Route::post('delete-all-intros', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'intros.deleteAll',
    'title' => 'definition_pages.delete_all',
]);
/*------------ end Of intros ----------*/
