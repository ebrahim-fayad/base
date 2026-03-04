<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of complaints ----------*/

$controller = 'Core\ComplaintController';
Route::get('all-complaints', [
    'as' => 'all_complaints',
    'uses' => $controller . '@index',
    'sub_link' => true,
    'title' => 'complaints_and_proposals.index',
]);

# socials update
Route::get('complaints/{id}', [
    'uses' => $controller . '@show',
    'as' => 'complaints.show',
    'title' => 'complaints_and_proposals.show',
]);


# complaints delete
Route::delete('complaints/{id}', [
    'uses' => $controller . '@destroy',
    'as' => 'complaints.delete',
    'title' => 'complaints_and_proposals.delete',
]);

#delete all complaints
Route::post('delete-all-complaints', [
    'uses' => $controller . '@destroyAll',
    'as' => 'complaints.deleteAll',
    'title' => 'complaints_and_proposals.delete_all',
]);

# complaints replay
Route::post('complaints/{id}/replay', [
    'uses' => $controller . '@replay',
    'as' => 'complaints.replay',
    'title' => 'complaints_and_proposals.replay',
]);

# complaints update
Route::put('complaints/{id}/update', [
    'uses' => $controller . '@update',
    'as' => 'complaints.update',
    'title' => 'complaints_and_proposals.update',
]);
/*------------ end Of complaints ----------*/
