<?php

namespace App\Enums;

enum NotificationTypeEnum: string
{
    // ==========================
    // General / عام
    // ==========================
    case CREATE_ORDER = 'create_order';

    // ==========================
    // Users & Providers / المستخدمين والمزودين
    // ==========================
    case NEW_USER_REGISTRATION = 'new_user_registration';
    case NEW_PROVIDER_REGISTRATION = 'new_provider_registration';
    case New_Provider = 'new_provider';
    case Provider_Approved = 'provider_approved';
    case Provider_Rejected = 'provider_rejected';
    case Admin_User_Block = 'admin_user_blocked';

    // ==========================
    // Complaints / الشكاوى
    // ==========================
    case NEW_COMPLAINT = 'new_complaint';
    case ORDER_COMPLAINT = 'order_complaint';

    // ==========================
    // Orders Status / حالة الطلبات
    // ==========================
    case New = 'new_order';
    case Accepted = 'accepted_order';
    case Preparing = 'preparing_order';
    case Prepared = 'prepared_order';
    case Delivered_to_delegate = 'delivered_to_delegate_order';
    case On_the_way_to_client = 'on_the_way_to_client_order';
    case Delegate_at_location = 'delegate_at_location_order';
    case Client_delivered = 'client_delivered_order';
    case Cancelled = 'cancelled_order'; // after provider acceptance and after provider prepared the order only
    case On_may_way_to_provider = 'on_my_way_to_provider_order';

    case Order_Rejected = 'order_rejected';
    case Order_Cancel = 'order_cancel';
    case User_Cancel_Unoffered_Order = 'user_cancel_unoffered_order';
    case NEW_ORDER_RESERVATION = 'new_order_reservation';
    case ORDER_CONFIRMED = 'order_confirmed';

    // ==========================
    // Negotiation Orders / طلبات التفاوض
    // ==========================
    case Negotiation_Pending = 'pending_negotiation_order';
    case Negotiation_Invoice_declined = 'invoice_declined_negotiation_order';
    case Negotiation_Invoice_paid = 'invoice_paid_negotiation_order';
    case Negotiation_Invoice_generated = 'generated_invoice_negotiation_order';

    // ==========================
    // Payments & Settlements / المدفوعات والتسويات
    // ==========================
    case ORDER_WAS_PAID = 'paid_order';
    case ORDER_SETTLEMENT = 'order_settlement';
    case ACCEPT_ORDER_SETTLEMENT = 'accept_order_settlement';
    case REJECT_ORDER_SETTLEMENT = 'reject_order_settlement';
    case NEW_ORDER_SETTLEMENT = 'new_order_settlement';

    case Order_Fully_Paid = 'order_fully_paid';
    case Order_First_Partially_Paid = 'order_first_partially_paid';
    case Order_Second_Partially_Paid = 'order_second_partially_paid';

    case Order_Bank_Transfer = 'order_bank_transfer';
    case Bank_Transfer_Fully_Paid = 'bank_transfer_fully_paid';
    case Bank_Transfer_First_Partially_Paid = 'bank_transfer_first_partially_paid';
    case Bank_Transfer_Second_Partially_Paid = 'bank_transfer_second_partially_paid';

    // ==========================
    // Offers / العروض
    // ==========================
    case Order_Offer_Accepted = 'order_offer_accepted';
    case Order_Rejected_Other_Offers = 'order_rejected_other_offers';
    case Order_Offer_Rejected = 'order_offer_rejected';
    case Order_Invoice_Accepted = 'order_invoice_accepted';
    case Order_Invoice_Rejected = 'order_invoice_rejected';

    case Search_For_Other_Offers = 'search_for_other_offers';

    // ==========================
    // Admin & System Actions / إجراءات الإدارة والنظام
    // ==========================
    case Addition_Request = 'addition_request';
    case Send_Offer = 'send_offer';
    case Send_Invoice = 'send_invoice';

    // ==========================
    // Ratings & Feedback / التقييمات والتغذية الراجعة
    // ==========================
    case Rate_From_User = 'rate_from_user';

    // ==========================
    // Contact & Support / التواصل والدعم
    // ==========================
    case NEW_CONTACT_US = 'new_contact_us';
}
