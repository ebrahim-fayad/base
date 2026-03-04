<?php

use App\Enums\NegotiationOrderStatusEnum;
use App\Enums\NotificationTypeEnum;

return [
    // Stadium Matches Notifications
    'title_' . NotificationTypeEnum::ADMIN_NOTIFY->value => 'إشعار إداري',
    'body_' . NotificationTypeEnum::ADMIN_NOTIFY->value => 'لديك إشعار إداري جديد',

    'title_' . NotificationTypeEnum::NEW_USER_REGISTRATION->value => 'مستخدم جديد',
    'body_' . NotificationTypeEnum::NEW_USER_REGISTRATION->value => 'تم تسجيل مستخدم جديد في التطبيق',

    'title_' . NotificationTypeEnum::NEW_MATCH_BOOKED->value => 'حجز مباراة جديد',
    'body_' . NotificationTypeEnum::NEW_MATCH_BOOKED->value => 'تم حجز مباراة جديدة',

    'title_' . NotificationTypeEnum::USER_ADDED_GUEST->value => 'إضافة ضيف',
    'body_' . NotificationTypeEnum::USER_ADDED_GUEST->value => 'تم إضافة ضيف للمباراة',

    'title_' . NotificationTypeEnum::NEW_STADIUM_ADDED->value => 'ملعب جديد',
    'body_' . NotificationTypeEnum::NEW_STADIUM_ADDED->value => 'تم إضافة ملعب جديد',

    'title_' . NotificationTypeEnum::NEW_GAME_ADDED->value => 'مباراة جديدة',
    'body_' . NotificationTypeEnum::NEW_GAME_ADDED->value => 'تم إضافة مباراة جديدة',

    'title_' . NotificationTypeEnum::GAME_UPDATED->value => 'تحديث المباراة',
    'body_' . NotificationTypeEnum::GAME_UPDATED->value => 'تم تحديث معلومات المباراة',

    'title_' . NotificationTypeEnum::NEW_CONTACTS_MESSAGE_ADDED->value => 'رسالة تواصل جديدة',
    'body_' . NotificationTypeEnum::NEW_CONTACTS_MESSAGE_ADDED->value => 'تم إرسال رسالة تواصل جديدة',

    'title_' . NotificationTypeEnum::USER_BLOCKED->value => 'حظر المستخدم',
    'body_' . NotificationTypeEnum::USER_BLOCKED->value => 'تم حظر حسابك من قبل الإدارة',

    'title_' . NotificationTypeEnum::DELETE_ACCOUNT->value => 'حذف الحساب',
    'body_' . NotificationTypeEnum::DELETE_ACCOUNT->value => 'تم حذف حسابك من قبل الإدارة',

    'title_' . NotificationTypeEnum::PROVIDER_UPDATE_ACCEPTED->value => 'قبول طلب التعديل',
    'body_' . NotificationTypeEnum::PROVIDER_UPDATE_ACCEPTED->value => 'تم قبول طلب تعديل بياناتك من قبل الإدارة',

    'title_' . NotificationTypeEnum::PROVIDER_UPDATE_REJECTED->value => 'رفض طلب التعديل',
    'body_' . NotificationTypeEnum::PROVIDER_UPDATE_REJECTED->value => 'تم رفض طلب تعديل بياناتك من قبل الإدارة',

    'title_' . NotificationTypeEnum::NEW_PROVIDER_UPDATE_REQUEST->value => 'طلب تعديل بيانات',
    'body_' . NotificationTypeEnum::NEW_PROVIDER_UPDATE_REQUEST->value => 'تم إرسال طلب تعديل بيانات من قبل مقدم الخدمة',
    'title_' . NotificationTypeEnum::UPDATE_ACCOUNT->value => 'تحديث الحساب',
    'body_' . NotificationTypeEnum::UPDATE_ACCOUNT->value => 'تم تحديث بيانات حسابك',
];
