<!-- Dashboard Notification Container -->
<div id="dashboard-notification-container"></div>

<!-- FireBase -->
<!-- The core Firebase JS SDK is always required and must be listed first -->
{{-- <script src="https://www.gstatic.com/firebasejs/7.6.1/firebase.js"></script> --}}
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-firestore.js"></script>
<script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('admin/assets/css/dashboard-notifications.css') }}?v={{time()}}">
<script src="{{ asset('admin/assets/js/dashboard-notifications.js') }}?v={{time()}}"></script>

<style>
    /* ========================================
       FCM NOTIFICATION POPUP - PREMIUM STYLE
    ======================================== */
    
    .notification-swal {
        background: #fff !important;
        border: none !important;
        border-left: 4px solid #7367F0 !important;
        border-radius: 12px !important;
        box-shadow: 0 8px 24px rgba(115, 103, 240, 0.2), 
                    0 0 0 0 rgba(115, 103, 240, 0.4) !important;
        cursor: pointer !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        padding: 1.25rem 1.5rem !important;
        min-width: 350px !important;
        max-width: 400px !important;
        position: relative !important;
    }
    
    /* Pulse effect للفت الانتباه */
    @keyframes pulse {
        0% {
            box-shadow: 0 8px 24px rgba(115, 103, 240, 0.2), 
                        0 0 0 0 rgba(115, 103, 240, 0.4);
        }
        50% {
            box-shadow: 0 8px 24px rgba(115, 103, 240, 0.3), 
                        0 0 0 10px rgba(115, 103, 240, 0);
        }
        100% {
            box-shadow: 0 8px 24px rgba(115, 103, 240, 0.2), 
                        0 0 0 0 rgba(115, 103, 240, 0);
        }
    }
    
    .notification-swal.swal2-show {
        animation: fadeInBounce 0.6s cubic-bezier(0.4, 0, 0.2, 1), 
                   shake 0.5s ease-in-out 0.6s,
                   pulse 1.5s ease-in-out 1.1s !important;
    }

    .notification-swal:hover {
        transform: translateY(-4px) translateX(-2px) !important;
        box-shadow: 0 12px 32px rgba(115, 103, 240, 0.3) !important;
        border-left-width: 6px !important;
    }

    /* Notification Image */
    .notification-swal .swal2-image {
        margin: 0 0 1rem 0 !important;
        max-width: 56px !important;
        max-height: 56px !important;
        border-radius: 10px !important;
        object-fit: cover !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }

    /* Notification Title */
    .notification-title {
        color: #5E5873 !important;
        font-weight: 700 !important;
        font-size: 15px !important;
        margin-bottom: 0.5rem !important;
        line-height: 1.4 !important;
        letter-spacing: -0.01em !important;
    }

    /* Notification Content */
    .notification-content {
        color: #6E6B7B !important;
        font-size: 13px !important;
        line-height: 1.6 !important;
        font-weight: 500 !important;
    }

    /* Close Button */
    .swal2-close,
    .notification-close {
        color: #B9B9C3 !important;
        opacity: 0.7 !important;
        transition: all 0.2s ease !important;
        width: 32px !important;
        height: 32px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 8px !important;
        font-size: 24px !important;
        cursor: pointer !important;
        position: absolute !important;
        top: 10px !important;
        right: 10px !important;
        z-index: 10 !important;
    }

    .swal2-close:hover,
    .notification-close:hover {
        opacity: 1 !important;
        background: rgba(234, 84, 85, 0.1) !important;
        color: #ea5455 !important;
        transform: scale(1.1) !important;
    }
    
    [dir="rtl"] .swal2-close,
    [dir="rtl"] .notification-close {
        right: auto !important;
        left: 10px !important;
    }

    /* Progress Bar */
    .swal2-timer-progress-bar {
        background: linear-gradient(90deg, #7367F0 0%, #9E95F5 100%) !important;
        height: 3px !important;
    }

    /* Hide animation */
    .swal2-hide {
        animation: fadeOut 0.3s ease-out forwards !important;
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        to {
            opacity: 0;
            transform: translateY(-20px) scale(0.9);
        }
    }

    /* تأكد من إزالة الإشعار بعد الاختفاء */
    .swal2-container.swal2-backdrop-hide {
        display: none !important;
    }

    /* Container - تحديد الموضع بدقة */
    .swal2-container.swal2-top-end {
        position: fixed !important;
        top: 0 !important;
        right: 0 !important;
        bottom: auto !important;
        left: auto !important;
        z-index: 99999 !important;
        pointer-events: none !important;
        padding: 80px 20px 0 0 !important;
        align-items: flex-start !important;
        justify-content: flex-end !important;
    }
    
    .swal2-container.swal2-top-end > .swal2-popup {
        position: relative !important;
        pointer-events: all !important;
        z-index: 99999 !important;
    }

    /* ========================================
       DARK MODE SUPPORT
    ======================================== */
    
    .dark-layout .notification-swal {
        background: #283046 !important;
        border-left-color: #7367F0 !important;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4) !important;
    }

    .dark-layout .notification-swal:hover {
        box-shadow: 0 12px 32px rgba(115, 103, 240, 0.4) !important;
    }

    .dark-layout .notification-title {
        color: #D0D2D6 !important;
    }

    .dark-layout .notification-content {
        color: #B4B7BD !important;
    }

    .dark-layout .notification-close {
        color: #828D99 !important;
    }

    .dark-layout .notification-close:hover {
        background: rgba(115, 103, 240, 0.15) !important;
        color: #7367F0 !important;
    }

    .dark-layout .notification-swal .swal2-image {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3) !important;
    }

    /* ========================================
       RTL SUPPORT
    ======================================== */
    
    [dir="rtl"] .notification-swal {
        border-left: none !important;
        border-right: 4px solid #7367F0 !important;
        padding-right: 1.5rem !important;
        padding-left: 1.25rem !important;
    }

    [dir="rtl"] .notification-swal:hover {
        transform: translateY(-4px) translateX(2px) !important;
        border-right-width: 6px !important;
        border-left-width: 0 !important;
    }

    [dir="rtl"] .swal2-container.swal2-top-end {
        right: auto !important;
        left: 0 !important;
        padding: 80px 0 0 20px !important;
        align-items: flex-start !important;
        justify-content: flex-start !important;
    }

    /* ========================================
       ANIMATION
    ======================================== */
    
    @keyframes fadeInBounce {
        0% {
            transform: translateY(-100%) scale(0.8);
            opacity: 0;
        }
        50% {
            transform: translateY(10px) scale(1.05);
            opacity: 1;
        }
        100% {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
    }

    @keyframes shake {
        0%, 100% {
            transform: translateX(0);
        }
        10%, 30%, 50%, 70%, 90% {
            transform: translateX(-5px);
        }
        20%, 40%, 60%, 80% {
            transform: translateX(5px);
        }
    }

    .notification-swal {
        animation: fadeInBounce 0.6s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }


    /* ========================================
       RESPONSIVE
    ======================================== */
    
    @media (max-width: 768px) {
        .notification-swal {
            min-width: 280px !important;
            max-width: calc(100vw - 40px) !important;
            padding: 1rem 1.25rem !important;
        }

        .swal2-container.swal2-top-end {
            padding: 60px 10px 0 0 !important;
        }

        [dir="rtl"] .swal2-container.swal2-top-end {
            padding: 60px 0 0 10px !important;
        }

        .notification-title {
            font-size: 14px !important;
        }

        .notification-content {
            font-size: 12px !important;
        }
    }
</style>

<script>
    // Your web app's Firebase configuration
    const firebaseConfig = {
        apiKey: "{{ config('fcm.api_key') }}",
        authDomain: "{{ config('fcm.auth_domain') }}",
        projectId: "{{ config('fcm.project_id') }}",
        storageBucket: "{{ config('fcm.storage_bucket') }}",
        messagingSenderId: "{{ config('fcm.messaging_sender_id') }}",
        appId: "{{ config('fcm.app_id') }}",
        measurementId: "{{ config('fcm.measurement_id') }}"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    //firebase.analytics();

    const messaging = firebase.messaging();
    window.fcmMessageing = messaging;

    //messaging.usePublicVapidKey("");

    Notification.requestPermission().then((permission) => {
        if (permission === 'granted') {

        } else {

        }
    });

    messaging.getToken().then((currentToken) => {
        if (currentToken) {

            let sessionAdmin = '{{ session()->get('admin_device_id') }}';
            if ('{{ auth()->guard('admin')->check() }}' && sessionAdmin === '') {
                // setDevice('admin');
            }
        }
    }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
    });

    @if ($authType == 'admin')
        messaging.onMessage(function(payload) {
            // إذا كان الإشعار لحظر أو حذف الأدمن → تسجيل خروج فوري
            let dataType = payload['data'] && payload['data']['type'] ? payload['data']['type'] : null;
            if (dataType === 'block' || dataType === 'admin_user_blocked' || dataType === 'admin_user_deleted') {
                // تشغيل صوت الإشعار
                let soundNotify = document.getElementById("soundNotify");
                if (soundNotify) {
                    soundNotify.play().catch(function(error) {
                        console.log('Error playing notification sound:', error);
                    });
                }
                
                // تحديد الرسالة حسب النوع
                let messageTitle = dataType === 'admin_user_deleted' ? '{{ __("notification.title_admin_user_deleted") }}' : '{{ __("auth.blocked") }}';
                let messageText = dataType === 'admin_user_deleted' ? '{{ __("notification.body_admin_user_deleted") }}' : '{{ __("notification.body_admin_user_blocked") }}';
                
                // عرض رسالة الحظر أو الحذف
                Swal.fire({
                    icon: 'warning',
                    title: messageTitle,
                    text: messageText,
                    confirmButtonText: '{{ __("admin.ok") }}',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    window.location.href = '{{ route("admin.logout") }}';
                });
                return;
            }

            let countNotify = $('#countNotify');
            let currentCount = parseInt(countNotify.data('num')) || 0;
            let newCount = currentCount + 1;
            countNotify.text(newCount);
            countNotify.data('num', newCount);
            countNotify.show();
            let x = document.getElementById("soundNotify");
            if (x) {
                x.play();
            }

            // Get current locale
            let currentLocale = window.language || '{{ app()->getLocale() }}' || 'ar';

            // Get notification title and body
            let notificationTitle = payload['notification']['title'];
            let notificationBody = payload['notification']['body'];

            // If we have notification type in data, try to get translated version
            if (payload['data'] && payload['data']['type']) {
                // Prepare data for translation
                let translationData = {
                    type: payload['data']['type'],
                    locale: currentLocale,
                    _token: '{{ csrf_token() }}'
                };

                // Add all data fields to translation request
                for (let key in payload['data']) {
                    if (key !== 'type' && payload['data'][key] !== null && payload['data'][key] !== undefined) {
                        translationData[key] = payload['data'][key];
                    }
                }

                // Make AJAX call to get translated notification
                $.ajax({
                    url: '{{ route('admin.admins.notifications.translate') }}',
                    method: 'POST',
                    data: translationData,
                    success: function(response) {
                        if (response.success && response.title && response.body) {
                            notificationTitle = response.title;
                            notificationBody = response.body;
                        }
                        showNotification(notificationTitle, notificationBody, payload);
                    },
                    error: function() {
                        // If translation fails, use original notification
                        showNotification(notificationTitle, notificationBody, payload);
                    }
                });
            } else {
                // No type available, show original notification
                showNotification(notificationTitle, notificationBody, payload);
            }
        });

        function showNotification(title, body, payload) {
            const notificationUrl = payload && payload.data && payload.data.url ? payload.data.url : null;
            const notificationImage = payload && payload.notification && payload.notification.image ? payload.notification.image : null;
            const notificationType = payload && payload.data && payload.data.type ? payload.data.type : 'default';

            let avatarContent = null;
            let avatarText = null;

            if (notificationImage) {
                avatarContent = notificationImage;
            } else {
                avatarText = title.charAt(0).toUpperCase();
            }

            if (window.DashboardNotification && window.DashboardNotification.show) {
                window.DashboardNotification.show({
                    title: title,
                    message: body,
                    avatar: avatarContent,
                    avatarText: avatarText,
                    url: notificationUrl,
                    type: notificationType,
                    onClose: () => {
                        markLatestNotificationAsRead();
                    }
                });
            } else {
                console.error('DashboardNotification not loaded');
            }
        }

        // دالة لتحديد آخر إشعار كمقروء (الإشعار الذي تم استلامه للتو)
        function markLatestNotificationAsRead() {
            $.ajax({
                url: '{{ route("admin.admins.notifications.markLatestAsRead") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // تحديث عدد الإشعارات غير المقروءة
                        let countNotify = $('#countNotify');
                        if (response.unread_count > 0) {
                            countNotify.text(response.unread_count);
                            countNotify.data('num', response.unread_count);
                            countNotify.show();
                        } else {
                            countNotify.hide();
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error marking notification as read:', error);
                }
            });
        }
    @endif
</script>
