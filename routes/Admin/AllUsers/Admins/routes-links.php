<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of Admins Controller ----------*/

$controller = 'AllUsers\AdminController';
Route::get('admins', [
    'uses' => $controller . '@index',
    'as' => 'admins.index',
    'title' => 'admins.index',
    'sub_link' => true,
]);

# admins store
Route::get('show-notifications', [
    'uses' => $controller . '@notifications',
    'as' => 'admins.notifications',
    'title' => 'admins.notification_page',
]);

# admins store
Route::post('delete-notifications', [
    'uses' => $controller . '@deleteNotifications',
    'as' => 'admins.notifications.delete',
    'title' => 'admins.delete_notification',
]);

# admins store
Route::get(
    'admins/create',
    [
        'uses' => $controller . '@create',
        'as' => 'admins.create',
        'title' => 'admins.create_page',
    ]
);

Route::post(
    'admins/block',
    [
        'uses' => $controller . '@block',
        'as' => 'admins.block',
        'title' => 'admins.block',
    ]
);
#store
Route::post('admins/store', [
    'uses' => $controller . '@store',
    'as' => 'admins.store',
    'title' => 'admins.create',
]);

# admins update
Route::get('admins/{id}/edit', [
    'uses' => $controller . '@edit',
    'as' => 'admins.edit',
    'title' => 'admins.edit_page',
]);
#update
Route::put(
    'admins/{id}',
    [
        'uses' => $controller . '@update',
        'as' => 'admins.update',
        'title' => 'admins.edit',
    ]
);

Route::get('admins/{id}/show', [
    'uses' => $controller . '@show',
    'as' => 'admins.show',
    'title' => 'admins.show',
]);

#delete
Route::delete('admins/{id}', [
    'uses' => $controller . '@destroy',
    'as' => 'admins.delete',
    'title' => 'admins.delete',
]);

#delete
Route::post('delete-all-admins', [
    'uses' => $controller . '@destroyAll',
    'as' => 'admins.deleteAll',
    'title' => 'admins.delete_all',
]);

#restore
Route::post('admins/{id}/restore', [
    'uses' => $controller . '@restore',
    'as' => 'admins.restore',
    'title' => 'admins.restore',
]);

# get notification count
Route::get('notification-count', [
    'uses' => $controller . '@getNotificationCount',
    'as' => 'admins.notifications.count',
    'title' => 'admins.notification_count',
]);

# translate notification
Route::post('translate-notification', [
    'uses' => $controller . '@translateNotification',
    'as' => 'admins.notifications.translate',
    'title' => 'admins.translate_notification',
]);

# mark notification as read
Route::post('mark-notification-read/{id}', [
    'uses' => $controller . '@markNotificationAsRead',
    'as' => 'admins.notifications.markAsRead',
    'title' => 'admins.mark_notification_read',
]);

# mark latest notification as read
Route::post('mark-latest-notification-read', [
    'uses' => $controller . '@markLatestNotificationAsRead',
    'as' => 'admins.notifications.markLatestAsRead',
    'title' => 'admins.mark_latest_notification_read',
]);


/*------------ end Of admins Controller ----------*/
