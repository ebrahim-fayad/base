<?php

use App\Enums\NegotiationOrderStatusEnum;
use App\Enums\NotificationTypeEnum;

return [
    // Stadium Matches Notifications
    'title_' . NotificationTypeEnum::ADMIN_NOTIFY->value => 'Administrative Notification',
    'body_' . NotificationTypeEnum::ADMIN_NOTIFY->value => 'You have a new administrative notification',

    'title_' . NotificationTypeEnum::NEW_USER_REGISTRATION->value => 'New User Registration',
    'body_' . NotificationTypeEnum::NEW_USER_REGISTRATION->value => 'A new user has registered in the application',

    'title_' . NotificationTypeEnum::NEW_MATCH_BOOKED->value => 'New Match Booked',
    'body_' . NotificationTypeEnum::NEW_MATCH_BOOKED->value => 'A new match has been booked',

    'title_' . NotificationTypeEnum::USER_ADDED_GUEST->value => 'Guest Added',
    'body_' . NotificationTypeEnum::USER_ADDED_GUEST->value => 'A guest has been added to the match',

    'title_' . NotificationTypeEnum::NEW_STADIUM_ADDED->value => 'New Stadium',
    'body_' . NotificationTypeEnum::NEW_STADIUM_ADDED->value => 'A new stadium has been added',

    'title_' . NotificationTypeEnum::NEW_GAME_ADDED->value => 'New Game',
    'body_' . NotificationTypeEnum::NEW_GAME_ADDED->value => 'A new game has been added',

    'title_' . NotificationTypeEnum::GAME_UPDATED->value => 'Game Updated',
    'body_' . NotificationTypeEnum::GAME_UPDATED->value => 'The game information has been updated',

    'title_' . NotificationTypeEnum::NEW_CONTACTS_MESSAGE_ADDED->value => 'New Contact Message',
    'body_' . NotificationTypeEnum::NEW_CONTACTS_MESSAGE_ADDED->value => 'A new contact message has been sent',

    'title_' . NotificationTypeEnum::USER_BLOCKED->value => 'User Blocked',
    'body_' . NotificationTypeEnum::USER_BLOCKED->value => 'Your account has been blocked by the administration',

    'title_' . NotificationTypeEnum::DELETE_ACCOUNT->value => 'Account Deleted',
    'body_' . NotificationTypeEnum::DELETE_ACCOUNT->value => 'Your account has been deleted by the administration',

    'title_' . NotificationTypeEnum::PROVIDER_UPDATE_ACCEPTED->value => 'Update Request Accepted',
    'body_' . NotificationTypeEnum::PROVIDER_UPDATE_ACCEPTED->value => 'Your profile update request has been accepted by the administration',

    'title_' . NotificationTypeEnum::PROVIDER_UPDATE_REJECTED->value => 'Update Request Rejected',
    'body_' . NotificationTypeEnum::PROVIDER_UPDATE_REJECTED->value => 'Your profile update request has been rejected by the administration',

    'title_' . NotificationTypeEnum::NEW_PROVIDER_UPDATE_REQUEST->value => 'Provider Update Request',
    'body_' . NotificationTypeEnum::NEW_PROVIDER_UPDATE_REQUEST->value => 'A new provider update request has been sent',
    'title_' . NotificationTypeEnum::UPDATE_ACCOUNT->value => 'Account Updated',
    'body_' . NotificationTypeEnum::UPDATE_ACCOUNT->value => 'Your account has been updated',
];
