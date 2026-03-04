<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of Settings----------*/

$controller = 'PublicSettings\SettingController';
Route::get('settings', [
    'uses'     => $controller . '@index',
    'as'       => 'settings.index',
    'title'    => 'setting.index',
    'sub_link' => true,
]);

#update
Route::put('settings', [
    'uses'  => $controller . '@update',
    'as'    => 'settings.update',
    'title' => 'setting.edit',
]);

/*------------ end Of Settings ----------*/
