<?php

return [
    'dailyStatusEnum' => [
        'NOT_STARTED' => 'Not started',
        'IN_PROGRESS' => 'In progress',
        'COMPLETED' => 'Completed',
    ],

    'userProductOfferEnum' => [
        'new' => 'New Offer',
        'accepted' => 'Your Offer Accepted',
        'rejected' => 'Your Offer Rejected',
    ],

    'packageTypeEnum' => [
        'dailty' => 'Day',
        'weekly' => 'Week',
        'monthly' => 'Month',
        'yearly' => 'Year',
    ],

    'productPreparationTimeUnitEnum' => [
        'minute' => 'Minute',
        'hour' => 'Hour',
        'day' => 'Day',
        'week' => 'Week',

        'status_details_minute' => '',
        'status_details_hour' => '',
        'status_details_day' => '',
        'status_details_week' => '',
    ],
    'paymentMethodEnum' => [
        'half' => 'Half',
        'full' => 'Full',

        'status_details_half' => 'Pay half of the order and another half after receiving the order',
        'status_details_full' => 'Pay the full amount of the order before delivery',
    ],
    'orderPayTypeEnum' => [
        '' => 'Not Specified',
        'online' => 'Online',
        'wallet' => 'Wallet',
        'cash' => 'Cash',

        'status_details_online' => '',
        'status_details_wallet' => '',
        'status_details_cash' => '',
    ],
    'payTypeEnum' => [
        'online' => 'Online',
        'wallet' => 'Wallet',
        'cash' => 'Cash',
        'bank_transfer'=>'Bank Transfer',
        '' => 'Not Specified',

        'status_details_online' => '',
        'status_details_wallet' => '',
        'status_details_cash' => '',
        'status_details_bank_transfer' => '',
    ],

    "specialOrderOfferStatusEnum" => [
        "new" => "New",
        "status_details_new" => "Under review and receiving offers",
        "accepted" => "Accepted",
        "status_details_accepted" => "Your offer has been accepted",
        "rejected" => "Rejected",
        "status_details_rejected" => "Your offer has been rejected",
    ],

    "orderType" => [
        'normal' => 'Normal',
        'scheduled' => 'Scheduled',
        'return' => 'Return',
        'special' => 'Special',

        'status_details_normal' => 'Normal order',
        'status_details_scheduled' => 'Inactive/Scheduled order',
        'status_details_return' => 'Return order',
        'status_details_special' => 'Special order',
    ],
    "orderPayStatus" => [
        'pending' => 'Pending',
        'downpayment' => 'Down payment',
        'done' => 'Done',
        'returned' => 'Returned',

        'status_details_pending' => 'Pending payment',
        'status_details_downpayment' => 'Down payment made',
        'status_details_done' => 'Fully paid',
        'status_details_returned' => 'Amount refunded',
    ],
    "orderDeliveryTypeEnum" => [
        'shop' => 'Shop',
        'delegate' => 'Delegate',
        'delivery_to_someone' => 'Delivery to someone',

        'status_details_shop' => 'Recieved from shop',
        'status_details_delegate' => 'Delivery by delegate',
        'status_details_delivery_to_someone' => 'Delivery to someone',
    ],

    "orderStatus" => [
        'waitapprove' => 'Waiting for approval',
        'waitpay' => 'Waiting for payment',
        'paydone' => 'Payment done',
        'inprogrss' => 'Preparing',
        'processed' => 'Processed',
        'deliverdtodelegate' => 'Delivered to delegate',
        'delegateaccepted' => 'Delegate accepted',
        'onway' => 'On the way',
        'delivered' => 'Delivered',
        'finished' => 'Finished',
        'refused' => 'Refused',
        'cancel' => 'Cancelled',


        'status_details_scheduled' => 'Inactive/Scheduled order',
        'status_details_waitapprove' => 'Your order has been sent successfully, awaiting merchant approval',
        'status_details_paydone' => 'Payment was completed successfully, your order is being prepared',
        'status_details_waitpay' => 'Your order has been accepted successfully, please pay the order cost',
        'status_details_inprogrss' => 'Payment was completed successfully, your order is being prepared ',
        'status_details_processed' => 'Your order has been prepared and is being delivered to the delegate',
        'status_details_delegateaccepted' => 'The delegate has accepted the order',
        'status_details_deliverdtodelegate' => 'Your order has been delivered to the shipping company, on the way to the customer',
        'status_details_onway' => 'Your order has been delivered to the delegate, on the way to the customer',
        'status_details_delivered' => 'With pleasure , your order has been delivered successfully',
        'status_details_finished' => 'Order received successfully, please enter ratings',
        'status_details_cancel' => 'You have canceled the order',
        'status_details_refused' => 'The service provider has rejected your request',

    ],

    "returnOrderStatus" => [
        "new" => "New",
        "provideraccepted" => "Provider Accepted",
        "providerrejected" => "Provider Rejected",
        "adminpending" => "Admin Pending",
        "adminaccepted" => "Admin Accepted",
        "receivedfromclient" => "Returned",
        "deliveredtoprovider" => "Delivered to provider",
        'delegateaccepted' => 'Delegate accepted',
        "finished" => "Finished",
        "refused" => "Refused",
        "status_details_new" => "The return request is under review",
        "status_details_pending" => "The return request is under review",
        "status_details_provideraccepted" => "The return request is accepted by provider",
        "status_details_providerrejected" => "The return request is rejected by provider",
        "status_details_adminpending" => "The return request is pending by admin",
        "status_details_adminaccepted" => "The return request is accepted by admin",
        "status_details_accepted" => "The return request is accepted",
        "status_details_receivedfromclient" => "The return request is recieved from client",
        "status_details_deliveredtoprovider" => "The return request is deliverd to provider",
        "status_details_delegateaccepted" => "The return request is accepted by delegate",
        "status_details_finished" => "The return request is finished",
        "status_details_refused" => "The return request is refused",
    ],

    "specialOrderStatusEnum" => [
        "new" => "New",
        "accepted" => "Accepted",
        "paid" => "Paid",
        "rejected" => "Rejected",
        "status_details_new" => "New special order",
        "status_details_accepted" => "Your special order has been accepted",
        "status_details_paid" => "Your special order has been paid",
        "status_details_rejected" => "Your special order has been rejected",
    ],
    "userTypesEnum" => [
        'individual' => 'Individual',
        'company' => 'Company',
        'status_details_individual' => '',
        'status_details_company' => '',
    ],
    "complaintStatusEnum"=>[
        'new' => 'New',
        'pending' => 'Pending',
        'replayed' => 'Replayed',

        'status_details_new' => '',
        'status_details_pending' => '',
        'status_details_replayed' => '',
    ],
    "orderOfferStatusEnum"=>[
        'new' => 'New offer sent',
        'accepted' => 'Offer accepted',
        'create_invoice' => 'Create invoice',
        'accepted_invoice' => 'Invoice accepted',
        'rejected_invoice' => 'Invoice rejected',
        'rejected' => 'Offer rejected',

        'status_details_new' => 'A new offer has been created.',
        'status_details_accepted' => 'Your offer has been accepted.',
        'status_details_create_invoice' => 'An invoice has been issued',
        'status_details_accepted_invoice' => 'The invoice has been accepted.',
        'status_details_rejected_invoice' => 'Waiting for a new invoice to be issued',
        'status_details_rejected' => 'Your offer has been rejected.',
    ],

    'approvementStatusEnum' => [
        'pending'   => 'Under Review',
        'approved'  => 'Approved',
        'rejected'  => 'Rejected',

        'status_details_pending'   => 'Your request has been submitted and is awaiting admin review',
        'status_details_approved'  => 'Your settlement request has been approved',
        'status_details_rejected'  => 'Your settlement request has been rejected',
    ],

    'orderStatusEnum' => [
        'new' => 'New',
        'negotiating' => 'Negotiating',
        'pay_Pending' => 'Payment Pending',
        'current' => 'Current',
        'provider_finished' => 'Completed by Provider',
        'finished' => 'Completed',
        'cancel' => 'Canceled',

//        'status_details_new' => 'Your order has been created and is under review.',
        'status_details_new' => 'New',

        'status_details_negotiating' => 'Negotiations are in progress with the service provider.',
        'status_details_pay_Pending' => 'Please complete the payment to proceed with your order.',
        'status_details_current' => 'Your order is currently being processed by the provider.',
        'status_details_provider_finished' => 'The provider has completed the order. Waiting for your confirmation.',
        'status_details_finished' => 'Your order has been successfully completed.',
        'status_details_cancel' => 'The order has been canceled.',
    ],
    'registerTypeEnum' => [
        'normal' => 'Normal',
        'nafaz' => 'Nafaz',

        'status_details_normal' => '',
        'status_details_nafaz' => '',
    ],

    'orderTypeEnum'=>[
        'service' => 'Service',
        'special' => 'Special',
        'consult' => 'Consult',

        'status_details_service' => '',
        'status_details_special' => '',
        'status_details_consult' => '',
    ],

    'payStatusEnum'=>[
        'pending'=> 'Pending',
        'partial_paid'=>'Partial paid',
        'fully_paid'=>'Fully paid',
        'unpaid'=>'unpaid',

        'status_details_pending' => '',
        'status_details_partial_paid' => '',
        'status_details_fully_paid' => '',
        'status_details_unpaid' => '',
    ],

    'settlementTypeEnum'=>[
        'dues'=>'المستحقات',
        'indebtedness'=>'المديونية',

        'status_details_dues'=>'',
        'status_details_indebtedness'=>'',
    ],


];
