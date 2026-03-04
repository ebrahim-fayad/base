<?php

return [
    'userProductOfferEnum' => [
        'new'      => 'عرض سعر جديد',
        'accepted' => 'تم قبول عرض السعر',
        'rejected' => 'تم رفض عرض السعر',
    ],

    'packageTypeEnum' => [
        'dailty'  => 'يوم',
        'weekly'  => 'أسبوع',
        'monthly' => 'شهر',
        'yearly'  => 'سنة',
        'status_details_yearly'  => 'باقة سنوية',
        'status_details_weekly'  => 'باقة أسبوعية',
        'status_details_monthly' => 'باقة شهرية',
    ],

    'paymentMethodEnum' => [
        'half' => 'نصف المبلغ',
        'full' => 'المبلغ كاملًا',

        'status_details_half' => 'دفع نصف قيمة الطلب ، والنصف الآخر بعد الاستلام',
        'status_details_full' => 'دفع كامل قيمة الطلب',
    ],
    'paymentTypeEnum' => [
        'ONLINE' => 'إلكتروني',
        'WALLET' => 'محفظة',
        'CASH'   => 'دفع نقدي',
        'BANK_TRANSFER'=>'حوالة بنكية',
        'UNDEFINED'       => 'غير محدد',

        'status_details_online' => 'دفع عبر الإنترنت',
        'status_details_wallet' => 'دفع عبر المحفظة',
        'status_details_cash'   => 'دفع نقدي',
        'status_details_bank_transfer'   => 'حوالة بنكية',
    ],

    'productPreparationTimeUnitEnum' => [
        'minute' => 'دقيقة',
        'hour' => 'ساعة',
        'day'   => 'يوم',
        'week' => 'أسبوع',

        'status_details_minute' => '',
        'status_details_hour' => '',
        'status_details_day' => '',
        'status_details_week'   => '',
    ],

    'orderPayTypeEnum' => [
        ''       => 'غير محدد',
        'online' => 'إلكتروني',
        'wallet' => 'محفظة',
        'cash'   => 'دفع نقدي',

        'status_details_online' => '',
        'status_details_wallet' => '',
        'status_details_cash'   => '',
    ],
    'payTypeEnum' => [
        'online' => 'إلكتروني',
        'wallet' => 'محفظة',
        'cash'   => 'دفع نقدي',
        'bank_transfer'=>'حوالة بنكية',
        ''       => 'غير محدد',

        'status_details_online' => '',
        'status_details_wallet' => '',
        'status_details_cash'   => '',
        'status_details_bank_transfer'   => '',

    ],

    "orderType"     => [
        'normal'        => 'عادي',
        'scheduled'            => 'مجدول',
        'return'         => 'إرجاع',
        'special'         => 'خاص',

        'status_details_normal'                               => 'طلب عادي',
        'status_details_scheduled'                           => 'طلب غير نشط / مجدول',
        'status_details_return'                           => 'طلب إرجاع',
        'status_details_special'                           => 'طلب خاص',
    ],
    "orderPayStatus"     => [
        'pending'        => 'قيد الانتظار',
        'downpayment'    => 'دفعة مقدمة',
        'done'           => 'تم الدفع',
        'returned'       => 'تم الإرجاع',

        'status_details_pending'        => 'بانتظار الدفع',
        'status_details_downpayment'    => 'تم دفع الدفعة المقدمة',
        'status_details_done'           => 'تم الدفع بالكامل',
        'status_details_returned'       => 'تم إرجاع المبلغ',
    ],

    "orderDeliveryTypeEnum"     => [
        'shop'        => 'من المحل',
        'delegate'            => 'المندوب',
        'delivery_to_someone' => 'توصيل لشخص آخر',

        'status_details_shop'                           => 'الإستلام من المحل',
        'status_details_delegate'                           => 'التوصيل من خلال المندوب',
        'status_details_delivery_to_someone'                           => 'التوصيل لشخص آخر',
    ],


    "orderStatus"     => [
        'waitapprove'        => 'بانتظار القبول',
        'waitpay'            => 'بانتظار الدفع',
        'paydone'            => 'تم الدفع',
        'inprogrss'          => 'جاري التجهيز',
        'processed'          => 'تم التجهيز',
        'delegateaccepted'   => 'تم قبول الطلب من المندوب',
        'deliverdtodelegate' => 'تم التسليم للمندوب',
        'onway'              => 'جاري التوصيل',
        'delivered'              => 'تم التوصيل',
        'finished'           => 'طلب مكتمل',
        'refused'            => 'طلب مرفوض',
        'cancel'            => 'طلب ملغي',

        'status_details_scheduled'                           => 'طلب غير نشط / مجدول',
        'status_details_waitapprove'                         => 'تم ارسال طلبك بنجاح بإنتظار قبول التاجر',
        'status_details_waitpay'                             => 'تم قبول طلبك بنجاح , يرجي دفع تكلفة الطلب',
        'status_details_paydone'                             => 'تم الدفع بنجاح, جاري تجهيز طلبك',
        'status_details_inprogrss'                           => 'تم الدفع بنجاح , جاري تجهيز طلبك ',
        'status_details_processed'                           => 'تم تجهيز طلبك , جاري التسليم للمندوب',
        'status_details_delegateaccepted'                    => 'تم قبول الطلب من المندوب, وجاري التوجهه اليك',
        'status_details_deliverdtodelegate'                  => 'تم التسليم للمندوب ,جاري توصيل طلبك',
        'status_details_onway'                               => 'تم التسليم للمندوب ,جاري توصيل طلبك',
        'status_details_delivered'                           => 'بكل سرور تم توصيل طلبك بنجاح',
        'status_details_finished'                            => 'تم الاستلام بنجاح , يرجي ادخال التقييمات',
        'status_details_cancel'                              => 'قمت بالغاء الطلب',
        'status_details_refused'                             => 'قام مقدم الخدمة برفض طلبك',

    ],

    "specialOrderStatusEnum"    => [
        "new"                     => "جديد",
        "accepted"                => "مقبول",
        "paid"                    => "تم الدفع",
        "rejected"                => "مرفوض",
        "status_details_new"      => "ظلب خاص جديد",
        "status_details_accepted" => "تم قبول الطلب الخاص",
        "status_details_paid"     => "تم دفع الطلب الخاص",
        "status_details_rejected" => "تم رفض الطلب الخاص",
    ],
    "specialOrderOfferStatusEnum"    => [
        "new"                     => "جديد",
        "accepted"                => "مقبول",
        "paid"                    => "تم الدفع",
        "rejected"                => "مرفوض",
        "status_details_new"      => "ظلب خاص جديد",
        "status_details_accepted" => "تم قبول الطلب الخاص",
        "status_details_paid"     => "تم دفع الطلب الخاص",
        "status_details_rejected" => "تم رفض الطلب الخاص",
    ],

    "shippingMethodEnum"    => [
        'self'                => "ذاتي",
        'status_details_self' => 'التوصيل ذاتي',
    ],

    "profitMethodEnum"    => [
        'commission'     => 'عمولة',
        'subscription'   => 'اشتراك',
        'status_details_commission'     => 'عمولة علي الطلب علي حسب تحديد الادمن',
        'status_details_subscription'   => 'اشتراك شهري في الباقة المختارة',
    ],
    "returnOrderStatus"    => [
        "new"                => "جديد",
        "pending"            => "قيد المراجعة",
        "accepted"            => "تم القبول",
        "provideraccepted"            => "تم القبول من مقدم الخدمة",
        "providerrejected"            => "تم الرفض من مقدم الخدمة",
        "adminpending"                => "قيد المراجعة من الإدارة",
        "adminaccepted"               => "تم القبول من الإدارة",
        "receivedfromclient" => "تم الإرجاع",
        "deliveredtoprovider" => "تم التسليم لمقدم الخدمة",
        'delegateaccepted' => 'تم القبول من المندوب',
        "finished" => "مكتمل",
        "refused" => "مرفوض",
        "status_details_new" => "طلب الإرجاع جديد",
        "status_details_pending" => "جاري مراجعة طلب الإرجاع من قبل الإدارة",
        "status_details_provideraccepted" => "تم قبول طلب الإرجاع من قبل مقدم الخدمة",
        "status_details_providerrejected" => "تم رفض طلب الإرجاع من قبل مقدم الخدمة",
        "status_details_adminpending"=> "طلب الإرجاع قيد المراجعة من قبل الإدارة",
        "status_details_adminaccepted"=> "تم قبول طلب الإرجاع من قبل الإدارة",

        "status_details_accepted" => "تم قبول الطلب بنجاح ، جاري إرسال المندوب",
        "status_details_receivedfromclient" => "تم إرجاع الطلب بنجاح",
        "status_details_deliveredtoprovider" => "تم تسليم طلب الإرجاع لمقدم الخدمة",
        "status_details_delegateaccepted" => "تم قبول طلب الإرجاع من قبل المندوب",
        "status_details_finished" => "تم الانتهاء من طلب الإرجاع",
        "status_details_refused" => "تم رفض طلب الإرجاع",
    ],

    "userTypesEnum" => [
        'individual' => 'فرد',
        'company' => 'شركة',
        'status_details_individual' => '',
        'status_details_company' => '',
    ],
    "orderStatusEnum" => [
        'NEW' => 'تم الشراء وارسال الطلب للمستلم',
        'WAIT_APPROVE' => 'في انتظار تاكيد الموعد',
        'FINISHED' => 'مؤكد',
        'CANCELLED' => 'لم يتم التاكيد',
    ],
    'orderProviderStatusEnum' => [
        'NEW' => 'جديد',
        'WAIT_APPROVE' => 'في انتظار تاكيدك للوقت المحدد',
        'FINISHED' => 'مؤكد',
        'CANCELLED' => 'لم يتم التاكيد',
    ],
    'settlementStatusEnum' => [
        'PENDING' => 'جديد',
        'ACCEPTED' => 'منتهية',
        'REJECTED' => 'مرفوضة',
    ],

    "complaintStatusEnum"=>[
        'New' => 'جديدة',
        'Pending' => 'قيد المراجعة',
        'Finished' => 'منتهية',

        'status_details_New' => '',
        'status_details_Pending' => '',
        'status_details_Replayed' => '',
    ],
    "ComplaintTypesEnum"=>[
        'Complaint' => 'شكوى',
        'ContactUs' => 'رسالة تواصل',
        'OrderComplaint' => 'شكوى علي طلب',
    ],
    "orderOfferStatusEnum"=>[
        'new' => 'تم ارسال عرض سعر',
        'accepted' => 'تم قبول عرض سعر',
        'create_invoice' => 'تم اصدار الفاتورة',
        'accepted_invoice' => 'تم قبول الفاتورة',
        'rejected_invoice' => 'تم رفض الفاتورة',
        'rejected' => 'تم رفض عرض سعر',

        'status_details_new' => 'تم إنشاء عرض جديد.',
        'status_details_accepted' => 'تم قبول عرضك.',
        'status_details_create_invoice' => 'تم اصدار فاتورة ',
        'status_details_accepted_invoice' => 'تم قبول الفاتورة.',
        'status_details_rejected_invoice' => 'بانتظار اصدار فاتورة جديدة',
        'status_details_rejected' => 'تم رفض عرضك.',
    ],

    'approvementStatusEnum'=>[
        'pending' => 'قيد المراجعة',
        'approved' => 'مقبول',
        'rejected' => 'مرفوض',

        'status_details_pending' => 'تم ارسال طلبك في انتظار رد الادارة',
        'status_details_approved' => 'تم قبول طلب التسوية الخاص بك',
        'status_details_rejected' => 'تم رفض طلب التسوية الخاص بك',
    ],


    'registerTypeEnum' => [
        'normal' => 'عادي',
        'nafaz' => 'نفاذ',

        'status_details_normal' => '',
        'status_details_nafaz' => '',
    ],

    'orderTypeEnum'=>[
        'service' => 'خدمة',
        'consult' => 'استشارة',
        'special' => 'خاصة',

        'status_details_service' => '',
        'status_details_consult' => '',
        'status_details_special' => '',
    ],
    'payStatusEnum'=>[
        'pending'=> 'قيد الانتظار',
        'partial_paid'=>'مدفوع جزئياً',
        'fully_paid'=>'مدفوع بالكامل',
        'unpaid'=>'غير مدفوع',

        'status_details_pending' => 'الدفع لم يكتمل بعد',
        'status_details_partial_paid' => 'تم دفع جزء من المبلغ فقط',
        'status_details_fully_paid' => 'تم دفع المبلغ بالكامل',
        'status_details_unpaid' => 'لم يتم دفع أي مبلغ',
    ],

];
