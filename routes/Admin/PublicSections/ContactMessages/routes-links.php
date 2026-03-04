<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of contact messages ----------*/

$controller = 'Core\ContactMessageController';
Route::get('all-contact-messages', [
    'as'       => 'all_contact_messages',
    'uses'     => $controller . '@index',
    'sub_link' => true,
    'title'    => 'customer_messages.index',
]);

# socials update
Route::get('contact-messages/{id}', [
    'uses'  => $controller . '@show',
    'as'    => 'contact_messages.show',
    'title' => 'customer_messages.show',
]);


# contact messages delete
Route::delete('contact-messages/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'contact_messages.delete',
    'title' => 'customer_messages.delete',
]);

#delete all contact messages
Route::post('delete-all-contact-messages', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'contact_messages.deleteAll',
    'title' => 'customer_messages.delete_all',
]);
/*------------ end Of contact messages ----------*/
