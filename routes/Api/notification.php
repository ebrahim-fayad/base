<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\General\NotificationController;

// notifications
Route::controller(NotificationController::class)->group(function () {
    Route::patch('switch-notify', 'switchNotificationStatus');
    Route::get('notifications', 'getNotifications');
    Route::get('count-notifications', 'countUnreadNotifications');
    Route::delete('delete-notification/{notification_id}', 'deleteNotification');
    Route::delete('delete-notifications', 'deleteNotifications');
});
// notifications
