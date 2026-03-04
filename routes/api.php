<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'general'], function () {
    require __DIR__ . '/guards/general.php';
});

Route::group(['prefix' => 'user'], function () {
    require __DIR__ . '/guards/user.php';
});
