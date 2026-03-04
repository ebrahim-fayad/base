<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of intromessages ----------*/

$controller = 'LandingPage\IntroMessagesController';
Route::get('intromessages', [
    'uses'  => $controller . '@index',
    'as'    => 'intromessages.index',
    'title' => 'customer_messages.index',
    'sub_link'  => true,
]);

# socials update
Route::get('intromessages/{id}', [
    'uses'  => $controller . '@show',
    'as'    => 'intromessages.show',
    'title' => 'customer_messages.show',
]);

# intromessages delete
Route::delete('intromessages/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'intromessages.delete',
    'title' => 'customer_messages.delete',
]);

#delete all intromessages
Route::post('delete-all-intromessages', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'intromessages.deleteAll',
    'title' => 'customer_messages.delete_all',
]);
/*------------ end Of intromessages ----------*/
