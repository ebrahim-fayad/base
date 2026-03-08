<?php

use App\Enums\NegotiationOrderStatusEnum;
use App\Enums\NotificationTypeEnum;

return [
    'title_admin_notify' => 'Administrative notice',
    'title_user_blocked' => 'Block',
    'body_user_blocked'  => 'Your Account Is Block From Administrative',

    // Products Orders
    'title_' . NotificationTypeEnum::ORDER_WAS_PAID->value => 'Order payment completed',
    'body_' . NotificationTypeEnum::ORDER_WAS_PAID->value => 'The customer has paid for order number (:order_num)',
    'title_' . NotificationTypeEnum::New->value => 'New order',
    'body_' . NotificationTypeEnum::New->value  => 'A new products order, order number (:order_num)',
    'title_' . NotificationTypeEnum::Accepted->value => 'Order accepted',
    'body_' . NotificationTypeEnum::Accepted->value  => 'The product order has been accepted, order number (:order_num)',
    'title_' . NotificationTypeEnum::Preparing->value => 'Order in preparation',
    'body_' . NotificationTypeEnum::Preparing->value  => 'Your order is being prepared, order number (:order_num)',
    'title_' . NotificationTypeEnum::Prepared->value => 'Preparation completed',
    'body_' . NotificationTypeEnum::Prepared->value  => 'Your order has been prepared, order number (:order_num)',
    'title_' . NotificationTypeEnum::Delivered_to_delegate->value => 'Order delivered to delegate',
    'body_' . NotificationTypeEnum::Delivered_to_delegate->value  => 'Your order has been delivered to the delegate, order number (:order_num)',
    'title_' . NotificationTypeEnum::On_the_way_to_client->value => 'Delegate on the way to you',
    'body_' . NotificationTypeEnum::On_the_way_to_client->value  => 'The delegate is on the way to you, order number (:order_num)',
    'title_' . NotificationTypeEnum::Delegate_at_location->value => 'Order delivered by delegate',
    'body_' . NotificationTypeEnum::Delegate_at_location->value  => 'The delegate has delivered your order, order number (:order_num)',
    'title_' . NotificationTypeEnum::Client_delivered->value => 'Order received by client',
    'body_' . NotificationTypeEnum::Client_delivered->value  => 'The client has received the order, order number (:order_num)',
    'title_' . NotificationTypeEnum::Cancelled->value => 'Order cancelled',
    'body_' . NotificationTypeEnum::Cancelled->value  => 'The order has been cancelled, order number (:order_num)',
    'title_' . NotificationTypeEnum::On_may_way_to_provider->value => 'Delegate on the way to provider',
    'body_' . NotificationTypeEnum::On_may_way_to_provider->value  => 'The delegate is on the way to pick up the products, order number (:order_num)',
    // Negotiation Orders
    'title_' . NotificationTypeEnum::Negotiation_Pending->value => 'New Negotiation order',
    'body_' . NotificationTypeEnum::Negotiation_Pending->value  => 'A new Negotiation order, order number (:order_num)',
    'title_' . NotificationTypeEnum::Negotiation_Invoice_declined->value => 'Invoice declined',
    'body_' . NotificationTypeEnum::Negotiation_Invoice_declined->value  => 'The invoice for the product order has been declined, order number (:order_num)',
    'title_' . NotificationTypeEnum::Negotiation_Invoice_paid->value => 'Invoice paid',
    'body_' . NotificationTypeEnum::Negotiation_Invoice_paid->value  => 'The invoice for your order has been paid, order number (:order_num)',
    'title_' . NotificationTypeEnum::Order_Rejected->value => 'Order rejected',
    'body_' . NotificationTypeEnum::Order_Rejected->value  => 'The order has been rejected by the provider, order number (:order_num)',

    // orders

    'title_new'              => 'New Order',
    'body_new'               => 'A new order, order number (:order_num)',

    'title_negotiating'      => 'Order in Negotiation',
    'body_negotiating'       => 'Order number (:order_num) is under negotiation',

    'title_pay_pending'      => 'Payment Pending',
    'body_pay_pending'       => 'Order number (:order_num) is waiting for payment',

    'title_current'          => 'Ongoing Order',
    'body_current'           => 'Order number (:order_num) is now in progress',

    'title_provider_finished'=> 'Provider Completed',
    'body_provider_finished' => 'The provider has completed order number (:order_num), awaiting confirmation',

    'title_finished'         => 'Order Completed',
    'body_finished'          => 'Order number (:order_num) has been successfully completed',

    'title_cancel'           => 'Order Cancelled',
    'body_cancel'            => 'Order number (:order_num) has been cancelled',

    // order

    // offers
    'title_'.NotificationTypeEnum::Order_Rejected_Other_Offers->value => 'Another accepted order offer',
    'body_'.NotificationTypeEnum::Order_Rejected_Other_Offers->value => 'Another order offer has been accepted, order number (:order_num)',

    'title_'.NotificationTypeEnum::Order_Offer_Accepted->value => 'Accepted order offer',
    'body_'.NotificationTypeEnum::Order_Offer_Accepted->value => 'Your order offer has been accepted, order number (:order_num)',

    'title_'.NotificationTypeEnum::Order_Offer_Rejected->value => 'Rejected order offer',
    'body_'.NotificationTypeEnum::Order_Offer_Rejected->value => 'Your order offer has been rejected, order number (:order_num)',

    'title_' . NotificationTypeEnum::Search_For_Other_Offers->value => 'A New Opportunity Is Available',
    'body_' . NotificationTypeEnum::Search_For_Other_Offers->value => 'The client is now accepting new offers for order #:order_num. Submit your best offer now!',

    'title_'.NotificationTypeEnum::Order_Invoice_Accepted->value => 'Invoice accepted',
    'body_'.NotificationTypeEnum::Order_Invoice_Accepted->value => 'The invoice for order has been accepted by client, order number (:order_num)',

    'title_'.NotificationTypeEnum::Order_Invoice_Rejected->value => 'Invoice rejected',
    'body_'.NotificationTypeEnum::Order_Invoice_Rejected->value => 'The invoice for order has been rejected by client, order number (:order_num)',

    'title_'.NotificationTypeEnum::Order_First_Partially_Paid->value => 'Order first partially paid',
    'body_'.NotificationTypeEnum::Order_First_Partially_Paid->value => 'The invoice for order has been partially paid by client for the first time, order number (:order_num)',

    'title_'.NotificationTypeEnum::Order_Second_Partially_Paid->value => 'Order second partially paid',
    'body_'.NotificationTypeEnum::Order_Second_Partially_Paid->value => 'The invoice for order has been partially paid by client for the second time, order number (:order_num)',

    'title_'.NotificationTypeEnum::Order_Fully_Paid->value => 'Order fully paid',
    'body_'.NotificationTypeEnum::Order_Fully_Paid->value => 'The invoice for order has been fully paid by client, order number (:order_num)',

    'title_'.NotificationTypeEnum::Admin_User_Block->value => 'User blocked',
    'body_'.NotificationTypeEnum::Admin_User_Block->value => 'You have been blocked by the administration',

    'title_' . NotificationTypeEnum::Order_Bank_Transfer->value => 'Order bank transfer sent',
    'body_'  . NotificationTypeEnum::Order_Bank_Transfer->value => 'User :user_name has sent a bank transfer for order #:order_num. Please check the attached image',

    'title_' . NotificationTypeEnum::User_Cancel_Unoffered_Order->value => 'Order cancelled',
    'body_'  . NotificationTypeEnum::User_Cancel_Unoffered_Order->value => 'Order number :order_num has been cancelled by Admin because no offers was found',

    'title_' . NotificationTypeEnum::Bank_Transfer_First_Partially_Paid->value => 'Order first partial payment via bank transfer',
    'body_'  . NotificationTypeEnum::Bank_Transfer_First_Partially_Paid->value => 'The client has uploaded a bank transfer for the first partial payment of order (:order_num). Please review and verify it.',

    'title_' . NotificationTypeEnum::Bank_Transfer_Second_Partially_Paid->value => 'Order second partial payment via bank transfer',
    'body_'  . NotificationTypeEnum::Bank_Transfer_Second_Partially_Paid->value => 'The client has uploaded a bank transfer for the second partial payment of order (:order_num). Please review and verify it.',

    'title_' . NotificationTypeEnum::Bank_Transfer_Fully_Paid->value => 'Order fully paid via bank transfer',
    'body_'  . NotificationTypeEnum::Bank_Transfer_Fully_Paid->value => 'The client has uploaded a bank transfer for the full payment of order (:order_num). Please review and verify it.',

    'title_' . NotificationTypeEnum::New_Provider->value => 'New provider',
    'body_'  . NotificationTypeEnum::New_Provider->value => 'The provider :user_name has been registered, please check it',

    'title_' . NotificationTypeEnum::Addition_Request->value => 'New addition request',
    'body_'  . NotificationTypeEnum::Addition_Request->value => 'The provider :user_name has sent an addition request :addition_type, please check it',

    'title_'.NotificationTypeEnum::ACCEPT_ORDER_SETTLEMENT->value => 'Order settlement accepted',
    'body_'.NotificationTypeEnum::ACCEPT_ORDER_SETTLEMENT->value => 'The order settlement has been accepted, order number (:order_num)',

    'title_'.NotificationTypeEnum::REJECT_ORDER_SETTLEMENT->value => 'Order settlement rejected',
    'body_'.NotificationTypeEnum::REJECT_ORDER_SETTLEMENT->value => 'The order settlement has been rejected, order number (:order_num)',

    'title_' . NotificationTypeEnum::ORDER_SETTLEMENT->value => 'Order Settlement',
    'body_' . NotificationTypeEnum::ORDER_SETTLEMENT->value  => 'A settlement has been requested for order number :settlement_num',

    'title_'.NotificationTypeEnum::Send_Offer->value => 'Offer Sent',
    'body_'.NotificationTypeEnum::Send_Offer->value => 'An offer has been sent for order #:order_num',

    'title_'.NotificationTypeEnum::Send_Invoice->value => 'Invoice Sent',
    'body_'.NotificationTypeEnum::Send_Invoice->value => 'An invoice has been sent for order #:order_num',

    'title_'.NotificationTypeEnum::CREATE_ORDER->value => 'New Order',
    'body_'.NotificationTypeEnum::CREATE_ORDER->value => 'An order #:order_num has been created, please check it',

    'title_'.NotificationTypeEnum::Order_Cancel->value => 'Order Cancelled',
    'body_'.NotificationTypeEnum::Order_Cancel->value => 'Order number (:order_num) has been cancelled',

    'title_'.NotificationTypeEnum::Rate_From_User->value => 'Rate sent',
    'body_'.NotificationTypeEnum::Rate_From_User->value => 'You have been rated by user :user_name',

    'title_'.NotificationTypeEnum::Provider_Approved->value => 'Your account has been approved',
    'body_'.NotificationTypeEnum::Provider_Approved->value => 'Your account has been reviewed and approved successfully. You can now use all the features of the app',

    'title_'.NotificationTypeEnum::Provider_Rejected->value => 'Your account has been rejected',
    'body_'.NotificationTypeEnum::Provider_Rejected->value => 'Your account has been reviewed and rejected. Please contact support for more details',

    'title_' . NotificationTypeEnum::NEW_CONTACT_US->value => 'New contact message',
    'body_' . NotificationTypeEnum::NEW_CONTACT_US->value => 'A new contact message has been received, message number :complaint_num',

    'title_' . NotificationTypeEnum::NEW_COMPLAINT->value => 'New complaint',
    'body_' . NotificationTypeEnum::NEW_COMPLAINT->value => 'A new complaint has been sent by user :user_name, complaint number :complaint_num',
    'title_' . NotificationTypeEnum::NEW_USER_REGISTRATION->value => 'New user registration',
    'body_' . NotificationTypeEnum::NEW_USER_REGISTRATION->value => 'A new user has been registered',
    'title_' . NotificationTypeEnum::NEW_ORDER_RESERVATION->value => 'New order reservation',
        'body_' . NotificationTypeEnum::NEW_ORDER_RESERVATION->value => 'A new order reservation has been created, you can view it',
    'title_' . NotificationTypeEnum::ORDER_COMPLAINT->value => 'New complaint',
    'body_' . NotificationTypeEnum::ORDER_COMPLAINT->value => 'A new complaint has been sent by user :user_name on order number :order_num',
    'title_' . NotificationTypeEnum::NEW_ORDER_SETTLEMENT->value => 'New settlement order',
    'body_' . NotificationTypeEnum::NEW_ORDER_SETTLEMENT->value => 'A new settlement order has been sent, you can view it',
    ];
