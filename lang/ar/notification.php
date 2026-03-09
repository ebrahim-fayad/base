<?php

use App\Enums\NegotiationOrderStatusEnum;
use App\Enums\NotificationTypeEnum;

return [

    'title_admin_notify' => 'اشعار اداري ',
    'title_user_blocked'        => 'حظر',
    'body_user_blocked'         => 'تم حظرك من قبل الادارة',
    'body_admin_user_blocked'   => 'تم حظرك من قبل الادارة',
    'title_admin_user_deleted'  => 'حذف الحساب',
    'body_admin_user_deleted'   => 'تم حذف حسابك من قبل الادارة',
    // Normal Orders
    'title_' . NotificationTypeEnum::ORDER_WAS_PAID->value => 'تم دفع رسوم الطلب  ',
    'body_' . NotificationTypeEnum::ORDER_WAS_PAID->value  => ' قام العميل بدفع رسوم الطلب رقم  (  :order_num )',
    'title_' . NotificationTypeEnum::New->value => ' طلب جديد ',
    'body_' . NotificationTypeEnum::New->value  => ' طلب منتجات جديد رقم الطلب (  :order_num )',
    'title_' . NotificationTypeEnum::Accepted->value => ' قبول الطلب ',
    'body_' . NotificationTypeEnum::Accepted->value  => ' تم قبول طلب منتجات، رقم الطلب (  :order_num )',
    'title_' . NotificationTypeEnum::Preparing->value => ' طلب قيد التجهيز ',
    'body_' . NotificationTypeEnum::Preparing->value  => ' طلبك دخل مرحلة التجهيز، رقم الطلب (  :order_num )',
    'title_' . NotificationTypeEnum::Prepared->value => ' انتهاء التجهيز ',
    'body_' . NotificationTypeEnum::Prepared->value  => ' تم الانتهاء من تجهيز طلبك، رقم الطلب (  :order_num )',
    'title_' . NotificationTypeEnum::Delivered_to_delegate->value => ' تسليم الطلب للمندوب ',
    'body_' . NotificationTypeEnum::Delivered_to_delegate->value  => ' تم تسليم طلبك للمندوب رقم الطلب (  :order_num )',
    'title_' . NotificationTypeEnum::On_the_way_to_client->value => ' المندوب في الطريق اليك ',
    'body_' . NotificationTypeEnum::On_the_way_to_client->value  => ' المندوب في الطريق إليك، رقم الطلب (  :order_num )',
    'title_' . NotificationTypeEnum::Delegate_at_location->value => ' المندوب قام بتسليم الطلب ',
    'body_' . NotificationTypeEnum::Delegate_at_location->value  => ' المندوب قام بعملية التسليم، رقم الطلب (  :order_num )',
    'title_' . NotificationTypeEnum::Client_delivered->value => ' العميل قام بالاستلام ',
    'body_' . NotificationTypeEnum::Client_delivered->value  => ' العميل قام بالاستلام، رقم الطلب (  :order_num )',
    'title_' . NotificationTypeEnum::Cancelled->value => ' الغاء الطلب ',
    'body_' . NotificationTypeEnum::Cancelled->value  => ' تم الغاء الطب، رقم الطلب (  :order_num )',
    'title_' . NotificationTypeEnum::On_may_way_to_provider->value => ' المندوب في الطريق اليك ',
    'body_' . NotificationTypeEnum::On_may_way_to_provider->value  => ' المندوب في الطريق لإستلام المنتجات، رقم الطلب (  :order_num )',
    // Negotiation Orders
    'title_' . NotificationTypeEnum::Negotiation_Pending->value => 'طلب تفاوض جديد',
    'body_' . NotificationTypeEnum::Negotiation_Pending->value  => 'تم تقديم طلب تفاوض جديد، رقم الطلب (:order_num)',
    'title_' . NotificationTypeEnum::Negotiation_Invoice_declined->value => 'تم رفض الفاتورة',
    'body_' . NotificationTypeEnum::Negotiation_Invoice_declined->value  => 'تم رفض الفاتورة الخاصة بطلب التفاوض، رقم الطلب (:order_num)',
    'title_' . NotificationTypeEnum::Negotiation_Invoice_paid->value => 'تم دفع الفاتورة',
    'body_' . NotificationTypeEnum::Negotiation_Invoice_paid->value  => 'تم دفع الفاتورة الخاصة بطلب التفاوض،، رقم الطلب (:order_num)',
    'title_' . NotificationTypeEnum::Negotiation_Invoice_generated->value => 'تم انشاء فاتورة',
    'body_' . NotificationTypeEnum::Negotiation_Invoice_generated->value  => 'تم انشاء الفاتورة الخاصة بطلب التفاوض،، رقم الطلب (:order_num)',


    'title_' . NotificationTypeEnum::NEW_PROVIDER_REGISTRATION->value => 'تسجيل مزود خدمة جديد',
    'body_' . NotificationTypeEnum::NEW_PROVIDER_REGISTRATION->value  => 'تم تسجيل مزود خدمة جديد  ',

    'title_' . NotificationTypeEnum::ORDER_SETTLEMENT->value => 'تم إرسال طلب تسوية',
    'body_' . NotificationTypeEnum::ORDER_SETTLEMENT->value  => 'تم ارسال طلب تسوية رقم :settlement_num',

    'title_' . NotificationTypeEnum::Order_Rejected->value => 'رفض الطلب من مقدم الخدمة',
    'body_' . NotificationTypeEnum::Order_Rejected->value  => 'تم رفض الطلب من مقدم الخدمة رقم :order_num',

    // orders
    'title_new'               => 'طلب جديد',
    'body_new'                => 'يوجد طلب جديد، رقم الطلب (:order_num)',

    'title_negotiating'       => 'طلب قيد التفاوض',
    'body_negotiating'        => 'الطلب رقم (:order_num) حالياً قيد التفاوض',

    'title_pay_pending'       => 'الدفع قيد الانتظار',
    'body_pay_pending'        => 'الطلب رقم (:order_num) في انتظار إتمام الدفع',

    'title_current'           => 'طلب جاري تنفيذه',
    'body_current'            => 'الطلب رقم (:order_num) جاري تنفيذه حالياً',

    'title_provider_finished' => 'مقدم الخدمة أنهى الطلب',
    'body_provider_finished'  => 'قام مقدم الخدمة بإنهاء الطلب رقم (:order_num)، في انتظار التأكيد',

    'title_finished'          => 'تم إكمال الطلب',
    'body_finished'           => 'تم الانتهاء من الطلب رقم (:order_num) بنجاح',

    'title_cancel'            => 'تم إلغاء الطلب',
    'body_cancel'             => 'تم إلغاء الطلب رقم (:order_num)',

    // order offers
    'title_'.NotificationTypeEnum::Order_Rejected_Other_Offers->value => 'تم قبول عرض سعر آخر',
    'body_'.NotificationTypeEnum::Order_Rejected_Other_Offers->value => 'تم قبول عرض سعر آخر، رقم الطلب (:order_num)',

    'title_'.NotificationTypeEnum::Order_Offer_Accepted->value => 'تم قبول عرض السعر',
    'body_'.NotificationTypeEnum::Order_Offer_Accepted->value => 'تم قبول عرض السعر، رقم الطلب (:order_num)',

    'title_'.NotificationTypeEnum::Order_Offer_Rejected->value => 'تم رفض عرض السعر',
    'body_'.NotificationTypeEnum::Order_Offer_Rejected->value => 'تم رفض عرض السعر، رقم الطلب (:order_num)',

    'title_' . NotificationTypeEnum::Search_For_Other_Offers->value => 'فرصة جديدة متاحة',
    'body_' . NotificationTypeEnum::Search_For_Other_Offers->value => 'العميل يبحث الآن عن عروض جديدة للطلب رقم (:order_num). قدّم عرضك الأفضل الآن!',

    'title_'.NotificationTypeEnum::Order_Invoice_Accepted->value => 'تم قبول الفاتورة',
    'body_'.NotificationTypeEnum::Order_Invoice_Accepted->value => 'تم قبول الفاتورة لهذا الطلب من قبل العميل، رقم الطلب (:order_num)',

    'title_'.NotificationTypeEnum::Order_Invoice_Rejected->value => 'تم رفض الفاتورة',
    'body_'.NotificationTypeEnum::Order_Invoice_Rejected->value => 'تم رفض الفاتورة لهذا الطلب من قبل العميل، رقم الطلب (:order_num)',

    'title_'.NotificationTypeEnum::Order_First_Partially_Paid->value => 'تم دفع جزء أول من الطلب',
    'body_'.NotificationTypeEnum::Order_First_Partially_Paid->value => 'تم دفع جزء من الفاتورة من قبل العميل للمرة الأولى، رقم الطلب (:order_num)',

    'title_'.NotificationTypeEnum::Order_Second_Partially_Paid->value => 'تم دفع جزء ثاني من الطلب',
    'body_'.NotificationTypeEnum::Order_Second_Partially_Paid->value => 'تم دفع جزء من الفاتورة من قبل العميل للمرة الثانية، رقم الطلب (:order_num)',

    'title_'.NotificationTypeEnum::Order_Fully_Paid->value => 'تم دفع الطلب بالكامل',
    'body_'.NotificationTypeEnum::Order_Fully_Paid->value => 'تم دفع الفاتورة لهذا الطلب بالكامل من قبل العميل، رقم الطلب (:order_num)',
    'title_'.NotificationTypeEnum::Admin_User_Block->value => 'تم حظر المستخدم',
    'body_'.NotificationTypeEnum::Admin_User_Block->value => 'تم حظرك من قبل الادارة',
    'title_'.NotificationTypeEnum::Admin_User_Delete->value => 'تم حذف حسابك',
    'body_'.NotificationTypeEnum::Admin_User_Delete->value => 'تم حذف حسابك من قبل الادارة، لن تتمكن من تسجيل الدخول مرة أخرى',

    'title_' . NotificationTypeEnum::Order_Bank_Transfer->value => 'تم إرسال حوالة بنكية للطلب',
    'body_'  . NotificationTypeEnum::Order_Bank_Transfer->value => 'قام المستخدم :user_name بإرسال حوالة بنكية للطلب رقم :order_num، يرجى التحقق من الصورة المرفقة.',

    'title_' . NotificationTypeEnum::User_Cancel_Unoffered_Order->value => 'تم إلغاء الطلب',
    'body_'  . NotificationTypeEnum::User_Cancel_Unoffered_Order->value => 'تم إلغاء الطلب رقم :order_num بواسطة الإدارة لعدم وجود أي عروض اسعار',

    'title_' . NotificationTypeEnum::Bank_Transfer_First_Partially_Paid->value => 'دفعة أولى جزئية عبر الحوالة البنكية',
    'body_'  . NotificationTypeEnum::Bank_Transfer_First_Partially_Paid->value => 'قام العميل برفع حوالة بنكية للدفعة الأولى الجزئية من الطلب رقم (:order_num). يرجى المراجعة والتأكيد',

    'title_' . NotificationTypeEnum::Bank_Transfer_Second_Partially_Paid->value => 'دفعة ثانية جزئية عبر الحوالة البنكية',
    'body_'  . NotificationTypeEnum::Bank_Transfer_Second_Partially_Paid->value => 'قام العميل برفع حوالة بنكية للدفعة الثانية الجزئية من الطلب رقم (:order_num). يرجى المراجعة والتأكيد',

    'title_' . NotificationTypeEnum::Bank_Transfer_Fully_Paid->value => 'دفعة كاملة عبر الحوالة البنكية',
    'body_'  . NotificationTypeEnum::Bank_Transfer_Fully_Paid->value => 'قام العميل برفع حوالة بنكية للدفعة الكاملة من الطلب رقم (:order_num). يرجى المراجعة والتأكيد',

    'title_' . NotificationTypeEnum::New_Provider->value => ' مقدم خدمة جديد',
    'body_'  . NotificationTypeEnum::New_Provider->value => 'قام المقدم :user_name بالتسجيل، يرجى التحقق',

    'title_' . NotificationTypeEnum::Addition_Request->value => 'طلب اضافة جديد',
    'body_'  . NotificationTypeEnum::Addition_Request->value => 'قام مقدم الخدمة :user_name بطلب اضافة :addition_type، يرجى التحقق',

    'title_'.NotificationTypeEnum::ACCEPT_ORDER_SETTLEMENT->value => 'تم قبول طلب التسوية',
    'body_'.NotificationTypeEnum::ACCEPT_ORDER_SETTLEMENT->value => 'تمت الموافقة على طلب التسوية، رقم التسوية (:order_num)',

    'title_'.NotificationTypeEnum::REJECT_ORDER_SETTLEMENT->value => 'تم رفض طلب التسوية',
    'body_'.NotificationTypeEnum::REJECT_ORDER_SETTLEMENT->value => 'تم رفض طلب التسوية، رقم التسوية (:order_num)',

    'title_'.NotificationTypeEnum::Send_Offer->value => 'تم ارسال عرض سعر',
    'body_'.NotificationTypeEnum::Send_Offer->value => 'تم ارسال عرض سعر علي الطلب رقم :order_num',

    'title_'.NotificationTypeEnum::Send_Invoice->value => 'تم ارسال فاتورة',
    'body_'.NotificationTypeEnum::Send_Invoice->value => 'تم ارسال فاتورة علي الطلب رقم :order_num',

    'title_'.NotificationTypeEnum::CREATE_ORDER->value => 'طلب جديد',
    'body_'.NotificationTypeEnum::CREATE_ORDER->value => 'تم إنشاء الطلب رقم (:order_num), يمكنك الاطلاع عليه ',

    'title_'.NotificationTypeEnum::Order_Cancel->value => 'تم إلغاء الطلب',
    'body_'.NotificationTypeEnum::Order_Cancel->value => 'تم إلغاء الطلب رقم (:order_num)',

    'title_'.NotificationTypeEnum::Rate_From_User->value => 'تم إرسال تقييم',
    'body_'.NotificationTypeEnum::Rate_From_User->value => 'تم تقييمك من قبل المستخدم :user_name',

    'title_'.NotificationTypeEnum::Provider_Approved->value => 'تمت الموافقة على حسابك',
    'body_'.NotificationTypeEnum::Provider_Approved->value => 'تمت مراجعة حسابك والموافقة عليه بنجاح، يمكنك الآن استخدام التطبيق بكامل المزايا',

    'title_'.NotificationTypeEnum::Provider_Rejected->value => 'تم رفض حسابك',
    'body_'.NotificationTypeEnum::Provider_Rejected->value => 'تمت مراجعة حسابك ورفضه، برجاء التواصل مع الإدارة لمزيد من التفاصيل',

    'title_' . NotificationTypeEnum::NEW_CONTACT_US->value => 'رسالة تواصل جديد',
    'body_' . NotificationTypeEnum::NEW_CONTACT_US->value => 'تم استلام رسالة تواصل جديد، رقم الرسالة :complaint_num',
    'title_' . NotificationTypeEnum::NEW_COMPLAINT->value => 'شكوى جديدة',
    'body_' . NotificationTypeEnum::NEW_COMPLAINT->value => 'تم ارسال شكوي جديدة من قبل العميل :user_name برقم الشكوى :complaint_num',
    'title_' . NotificationTypeEnum::NEW_USER_REGISTRATION->value => 'تسجيل مستخدم جديد',
    'body_' . NotificationTypeEnum::NEW_USER_REGISTRATION->value => 'تم تسجيل مستخدم جديد',
    'title_' . NotificationTypeEnum::NEW_ORDER_RESERVATION->value => 'طلب جديد',
    'body_' . NotificationTypeEnum::NEW_ORDER_RESERVATION->value => 'تم إنشاء طلب جديد، يمكنك الاطلاع عليه ',
    'title_' . NotificationTypeEnum::ORDER_CONFIRMED->value => 'تم تأكيد الطلب',
    'body_' . NotificationTypeEnum::ORDER_CONFIRMED->value => 'تم تأكيد الطلب رقم :order_num',
    'title_' . NotificationTypeEnum::ORDER_COMPLAINT->value => 'شكوى جديدة',
    'body_' . NotificationTypeEnum::ORDER_COMPLAINT->value => 'تم ارسال شكوي جديدة من قبل العميل :user_name علي الطلب رقم :order_num',
    'title_' . NotificationTypeEnum::NEW_ORDER_SETTLEMENT->value => 'طلب تسوية جديد',
    'body_' . NotificationTypeEnum::NEW_ORDER_SETTLEMENT->value => 'تم ارسال طلب تسوية جديد، يمكنك الاطلاع عليه ',
];
