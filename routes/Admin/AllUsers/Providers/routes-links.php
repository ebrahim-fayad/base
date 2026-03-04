<?php

use Illuminate\Support\Facades\Route;


$controller = 'AllUsers\ProviderController';
/*------------ start Of providers Controller ----------*/

Route::get('providers', [
    'uses'     => $controller . '@index',
    'as'       => 'providers.index',
    'sub_link' => true,
    'title'    => 'providers.index',
]);


# providers store
Route::get(
    'providers/create',
    [
        'uses'  => $controller . '@create',
        'as'    => 'providers.create',
        'title' => 'providers.create_page',
    ]
);

# providers update
Route::get('providers/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'providers.edit',
    'title' => 'providers.edit_page',
]);
#store
Route::post('providers/store', [
    'uses'  => $controller . '@store',
    'as'    => 'providers.store',
    'title' => 'providers.create',
]);

#update
Route::put('providers/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'providers.update',
    'title' => 'providers.edit',
]);

Route::get('providers/{id}/show', [
    'uses'  => $controller . '@show',
    'as'    => 'providers.show',
    'title' => 'providers.show',
]);

#delete
Route::delete('providers/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'providers.delete',
    'title' => 'providers.delete',
]);

#delete
Route::post('delete-all-providers', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'providers.deleteAll',
    'title' => 'providers.delete_all',
]);

#notify
Route::post(
    'admins/providers/notify',
    [
        'uses'  => $controller . '@notify',
        'as'    => 'providers.notify',
        'title' => 'providers.Send_user_notification',
    ]
);
Route::post(
    'admins/providers/update-balance/{id}',
    [
        'uses'  => $controller . '@updateBalance',
        'as'    => 'providers.updateBalance',
        'title' => 'providers.updateBalance',
    ]
);
Route::post(
    'admins/providers/block-user',
    [
        'uses'  => $controller . '@block',
        'as'    => 'providers.block',
        'title' => 'providers.block_user',
    ]
);

Route::post(
    'admins/providers/toggle-approvement',
    [
        'uses'  => $controller . '@toggleApprovement',
        'as'    => 'providers.toggleApprovement',
        'title' => 'providers.toggleApprovement',
    ]
);

# Get provider updates
Route::get(
    'admins/providers/{id}/updates',
    [
        'uses'  => $controller . '@getProviderUpdates',
        'as'    => 'providers.getUpdates',
        'title' => 'providers.updates',
    ]
);

# toggle provider update
Route::post(
    'admins/providers/updates/{updateId}/toggle',
    [
        'uses'  => $controller . '@toggleProviderUpdate',
        'as'    => 'providers.updates-toggle',
        'title' => 'providers.updates-toggle',
    ]
);
/*------------ end Of providers Controller ----------*/
