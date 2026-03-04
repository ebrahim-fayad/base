<?php

use App\Http\Controllers\Api\General\ChatController;
use Illuminate\Support\Facades\Route;

// chat
Route::group(['controller' => ChatController::class], function () {
    Route::get('create-room',                             'createRoom');
    Route::post('create-private-room',                    'createPrivateRoom');
    Route::get('room-members/{room}',                     'getRoomMembers');
    Route::get('join-room/{room}',                        'joinRoom');
    Route::get('leave-room/{room}',                       'leaveRoom');
    Route::get('get-room-messages/{room}',                'getRoomMessages');
    Route::get('get-room-unseen-messages/{room}',         'getRoomUnseenMessages');
    Route::get('get-rooms/{type?}',                       'getMyRooms');
    Route::delete('delete-message-copy/{message}',        'deleteMessageCopy');
    Route::post('send-message/{room}',                    'sendMessage');
    Route::post('upload-room-file/{room}',                'uploadRoomFile');
});
// chat
