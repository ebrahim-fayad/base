<?php

use Illuminate\Support\Facades\Route;

$controller = 'Core\NotificationController';
Route::get('notifications', [
    'uses'      => $controller . '@index',
    'as'        => 'notifications.index',
    'title'     => 'notifications.index',
    'icon'      => '<i class="ficon feather icon-bell"></i>',
    'type'      => 'parent',
    'has_sub_route' => false,
    'child'     => ['notifications.send'],
]);

Route::post('send-notifications', [
    'uses'  => $controller . '@sendNotifications',
    'as'    => 'notifications.send',
    'title' => 'notifications.send',
]);
    /*------------ end Of notifications ----------*/
