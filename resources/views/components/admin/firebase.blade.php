<!-- FireBase -->
<!-- The core Firebase JS SDK is always required and must be listed first -->
{{-- <script src="https://www.gstatic.com/firebasejs/7.6.1/firebase.js"></script> --}}
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-firestore.js"></script>
<script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>

<style>
    /* SweetAlert Notification Styles - Dashboard Colors */
    .notification-swal {
        border-left: 4px solid #7367F0 !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 12px rgba(115, 103, 240, 0.15) !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        padding-left: 20px !important;
    }

    .notification-swal:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(115, 103, 240, 0.25) !important;
    }

    .notification-swal .swal2-image {
        margin: 0 0 12px 0 !important;
        max-width: 50px !important;
        max-height: 50px !important;
        border-radius: 8px !important;
        object-fit: contain !important;
    }

    .notification-title {
        color: #7367F0 !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        margin-bottom: 8px !important;
    }

    .notification-content {
        color: #5E5873 !important;
        font-size: 14px !important;
        line-height: 1.5 !important;
    }

    .notification-close {
        color: #5E5873 !important;
        opacity: 0.5 !important;
    }

    .notification-close:hover {
        opacity: 1 !important;
    }

    /* Dark Mode Support */
    .dark-layout .notification-swal {
        background: #283046 !important;
        border-left-color: #7367F0 !important;
    }

    .dark-layout .notification-title {
        color: #7367F0 !important;
    }

    .dark-layout .notification-content {
        color: #B4B7BD !important;
    }

    .dark-layout .notification-close {
        color: #B4B7BD !important;
    }

    /* SweetAlert2 Toast Progress Bar */
    .swal2-timer-progress-bar {
        background: #7367F0 !important;
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
            // إذا كان الإشعار لحظر الأدمن → تسجيل خروج فوري
            let dataType = payload['data'] && payload['data']['type'] ? payload['data']['type'] : null;
            if (dataType === 'block') {
                Swal.fire({
                    icon: 'warning',
                    title: '{{ __("auth.blocked") }}',
                    text: '{{ __("notification.body_user_blocked") }}',
                    confirmButtonText: '{{ __("site.logout") }}',
                    allowOutsideClick: false
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
            let notificationConfig = {
                title: title,
                text: body,
                position: 'top-end',
                showConfirmButton: false,
                showCloseButton: true,
                timer: 6000,
                toast: true,
                onOpen: (toast) => {
                    toast.addEventListener('click', () => {
                        const url = payload && payload.data && payload.data.url ?
                            payload.data.url :
                            '/';
                        window.location.href = url;
                    });
                },

                customClass: {
                    popup: 'notification-swal',
                    title: 'notification-title',
                    content: 'notification-content',
                    closeButton: 'notification-close'
                },
                buttonsStyling: false
            };

            if (payload.notification?.image) {
                notificationConfig.imageUrl = payload.notification.image;
                notificationConfig.imageWidth = 50;
                notificationConfig.imageHeight = 50;
            }

            Swal.fire(notificationConfig);
        }
    @endif
</script>
