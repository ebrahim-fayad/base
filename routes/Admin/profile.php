<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of profile----------*/
Route::get('profile', [
    'uses'  => 'HomeController@profile',
    'as'    => 'profile.profile',
    'title' => 'profile',
])->middleware('auth:admin');

Route::put(
    'profile-update',
    [
        'uses'  => 'HomeController@updateProfile',
        'as'    => 'profile.update',
        'title' => 'update_profile',
    ]
)->middleware('auth:admin');

Route::put('profile-update-password', [
    'uses'  => 'HomeController@updatePassword',
    'as'    => 'profile.update_password',
    'title' => 'update_password',
])->middleware('auth:admin');
  /*------------ end Of profile----------*/
