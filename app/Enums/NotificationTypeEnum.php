<?php

namespace App\Enums;

enum
NotificationTypeEnum: string
{
    case ADMIN_NOTIFY = 'admin_notify';
    case NEW_USER_REGISTRATION = 'new_user_registration';
    case NEW_MATCH_BOOKED = 'new_match_booked';
    case USER_ADDED_GUEST = 'user_added_guest';
    case NEW_STADIUM_ADDED = 'new_stadium_added';
    case NEW_GAME_ADDED = 'new_game_added';
    case GAME_UPDATED = 'game_updated';
    case NEW_CONTACTS_MESSAGE_ADDED = 'new_contacts_message_added';
    case USER_BLOCKED = 'block';
    case DELETE_ACCOUNT = 'delete_account';
    case PROVIDER_UPDATE_ACCEPTED = 'provider_update_accepted';
    case PROVIDER_UPDATE_REJECTED = 'provider_update_rejected';
    case NEW_PROVIDER_UPDATE_REQUEST = 'new_provider_update_request';
    case UPDATE_ACCOUNT = 'update_account';
}
