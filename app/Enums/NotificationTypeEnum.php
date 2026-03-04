<?php

namespace App\Enums;

enum
    NotificationTypeEnum: string
{
    case USER_ACTIVE = 'user_active';

    case CREATE_ORDER = 'create_order';
    case USER_BLOCKED = 'user_blocked';
    case DELETE_ACCOUNT = 'delete_account';

    case NEW_USER_REGISTRATION = 'new_user_registration';
    case NEW_PROVIDER_REGISTRATION = 'new_provider_registration';

    case NEW_COMPLAINT = 'new_complaint';
    case ORDER_COMPLAINT = 'order_complaint';
    case COMPLAINT_REPLAY = 'complaint_replay';

    // Orders
    case New = 'new_order';
    case Accepted = 'accepted_order';
    case Preparing = 'preparing_order';
    case Prepared = 'prepared_order';
    case Delivered_to_delegate = 'delivered_to_delegate_order';
    case Provider_delivered_to_client = 'provider_delivered_to_client_order'; //at from store orders
    case Order_with_delegate = 'order_with_delegate_order';
    case On_the_way_to_client = 'on_the_way_to_client_order';
    case Delegate_at_location = 'delegate_at_location_order';
    case Delegate_delivered_to_client = 'delegate_delivered_to_client_order'; // at from home orders
    case Client_delivered = 'client_delivered_order';
    case Cancelled = 'cancelled_order'; // after provider acceptance and after provider prepared the order only
    case On_may_way_to_provider = 'on_my_way_to_provider_order';
    case ADMIN_NOTIFY = 'admin_notify';

    // Negotiation Orders
    case Negotiation_Pending = 'pending_negotiation_order';
    case Negotiation_Invoice_declined = 'invoice_declined_negotiation_order';
    case Negotiation_Invoice_paid = 'invoice_paid_negotiation_order';
    case Negotiation_Invoice_generated = 'generated_invoice_negotiation_order';
    case ORDER_WAS_PAID = 'paid_order';
    case ORDER_SETTLEMENT = 'order_settlement';
    case ACCEPT_ORDER_SETTLEMENT = 'accept_order_settlement';
    case REJECT_ORDER_SETTLEMENT = 'reject_order_settlement';

    //Orders
    case Order_Rejected = 'order_rejected';

    // Ratings
    case Rate_From_User = 'rate_from_user';
    case Rate_From_Provider = 'rate_from_provider';

    // offers
    case Order_Offer = 'order_offer';
    case Order_Offer_Accepted = 'order_offer_accepted';
    case Order_Rejected_Other_Offers = 'order_rejected_other_offers';
    case Order_Offer_Rejected = 'order_offer_rejected';
    case Order_Invoice_Accepted = 'order_invoice_accepted';
    case Order_Invoice_Rejected = 'order_invoice_rejected';

    case Search_For_Other_Offers = 'search_for_other_offers';
    case Order_Fully_Paid = 'order_fully_paid';
    case Order_First_Partially_Paid = 'order_first_partially_paid';
    case Order_Second_Partially_Paid = 'order_second_partially_paid';

    case Admin_User_Block = 'admin_user_blocked';
    case Order_Bank_Transfer = 'order_bank_transfer';
    case Bank_Transfer_Fully_Paid = 'bank_transfer_fully_paid';
    case Bank_Transfer_First_Partially_Paid = 'bank_transfer_first_partially_paid';
    case Bank_Transfer_Second_Partially_Paid = 'bank_transfer_second_partially_paid';

    case User_Cancel_Unoffered_Order = 'user_cancel_unoffered_order';

    case New_Provider = 'new_provider';
    case Addition_Request = 'addition_request';
    case Send_Offer = 'send_offer';
    case Send_Invoice = 'send_invoice';

    case Order_Cancel = 'order_cancel';

    case Provider_Approved = 'provider_approved';
    case Provider_Rejected = 'provider_rejected';
    case NEW_CONTACT_US = 'new_contact_us';
    case NEW_ORDER_RESERVATION = 'new_order_reservation';
    case ORDER_CONFIRMED = 'order_confirmed';
    case NEW_ORDER_SETTLEMENT = 'new_order_settlement';



}
