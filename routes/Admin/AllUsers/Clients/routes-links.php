<?php

use Illuminate\Support\Facades\Route;


$controller = 'AllUsers\ClientController';
/*------------ start Of users Controller ----------*/

Route::get('clients', [
    'uses'     => $controller . '@index',
    'as'       => 'clients.index',
    'sub_link' => true,
    'title'    => 'users.index',
]);


# clients store
Route::get(
    'clients/create',
    [
        'uses'  => $controller . '@create',
        'as'    => 'clients.create',
        'title' => 'users.create_page',
    ]
);

# clients update
Route::get('clients/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'clients.edit',
    'title' => 'users.edit_page',
]);
#store
Route::post('clients/store', [
    'uses'  => $controller . '@store',
    'as'    => 'clients.store',
    'title' => 'users.create',
]);

#update
Route::put('clients/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'clients.update',
    'title' => 'users.edit',
]);

Route::get('clients/{id}/show', [
    'uses'  => $controller . '@show',
    'as'    => 'clients.show',
    'title' => 'users.show',
]);
Route::get('clients-complaints/{id}/show', [
    'uses'  => $controller . '@complaints',
    'as'    => 'clients.complaints.show',
    'title' => 'users.complaints',
]);

#delete
Route::delete('clients/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'clients.delete',
    'title' => 'users.delete',
]);

#delete
Route::post('delete-all-clients', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'clients.deleteAll',
    'title' => 'users.delete_all',
]);

#notify
Route::post(
    'admins/clients/notify',
    [
        'uses'  => $controller . '@notify',
        'as'    => 'clients.notify',
        'title' => 'users.Send_user_notification',
    ]
);
Route::post(
    'admins/clients/update-balance/{id}',
    [
        'uses'  => $controller . '@updateBalance',
        'as'    => 'clients.updateBalance',
        'title' => 'users.updateBalance',
    ]
);
Route::post(
    'admins/clients/block-user',
    [
        'uses'  => $controller . '@block',
        'as'    => 'clients.block',
        'title' => 'users.block_user',
    ]
);
/*------------ end Of users Controller ----------*/
