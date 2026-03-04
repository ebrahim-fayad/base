<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<footer class="footer footer-static footer-light">
    <p class="clearfix blue-grey lighten-2 mb-0">
        <span class="float-md-left d-block d-md-inline-block mt-25">
            {{ __('admin.Copyrights') }} &copy; {{ \Carbon\Carbon::now()->year }}
            {{-- <a class="text-bold-800 grey darken-2" href="https://aait.sa/" target="_blank">,</a>
            {{ __('admin.all_rights_reserved') }} --}}
        </span>
        {{-- <span class="float-md-right d-none d-md-block">
            <a href="https://aait.sa/" rel="follow" target="_blank"> {{ __('admin.awamer_alshabaka') }}</a>
            <a href="mailto:sales@aait.sa"><i class="feather icon-mail pink"></i></a>
            <a href="tel:920005929"><i class="feather icon-phone pink"></i></a>
        </span> --}}
    </p>
</footer>
<script>
    window.language = "{{ app()->getLocale() }}";
</script>
<script src="{{ asset('admin/app-assets/vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('admin/app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('admin/app-assets/js/core/app.js') }}"></script>
<script src="{{ asset('admin/app-assets/js/scripts/components.js') }}"></script>
<script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/flatpickr.js') }}"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/{{ app()->getLocale() }}.js"></script>
<script src="{{ asset('admin/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('admin/app-assets/js/scripts/forms/select/form-select2.js') }}"></script>
<script src="{{ asset('admin/main.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<x-admin.firebase authType="admin" />
<script>
    $(document).ready(function() {
        $(".country-code").select2({
            width: "100%",
            closeOnSelect: true,
            placeholder: "",
            templateSelection: iformat,
            templateResult: iformat,
            allowHtml: true,
            dropdownParent: $(".select-icon"),
            allowClear: false,
            dir: "rtl",
        });

        $(document).on('keydown', function(e) {
            // لو المستخدم ضغط Enter
            if (e.key === "Enter" || e.keyCode === 13) {
                // لو الفوكس مش على زرار close
                if (!$(e.target).is('.uploadedBlock .close')) {
                    // امنع السلوك الافتراضي (زي حذف الصورة أو submit)
                    e.preventDefault();
                    return false;
                }
            }
        });

        // هنا لو فعلاً الفوكس على زرار close و ضغط Enter
        $('.uploadedBlock .close').on('keydown', function(e) {
            if (e.key === "Enter" || e.keyCode === 13) {
                // هنا فقط شغل كود الحذف
                $(this).closest('.uploadedBlock').remove(); // مثال لحذف الصورة
            }
        });

        function iformat(icon, badge, color) {
            var originalOption = icon.element;
            var originalOptionBadge = $(originalOption).data("badge");
            var originalOptionColor = $(originalOption).data("img");
            return $(
                `<span class="flex-span"> ${originalOptionColor} <span>${icon.text}</span></span>`
            );
        }

                    // Hide delete button when table content is refreshed
            var tableContent = $('.table_content_append');
            var observer = new MutationObserver(function(mutations) {
                // Hide delete button and uncheck all checkboxes after table refresh
                setTimeout(function() {
                    $('.delete_all_button').hide();
                    $('#checkedAll').prop('checked', false);
                    $('.checkSingle').prop('checked', false);
                }, 100);
            });

            if (tableContent.length) {
                observer.observe(tableContent[0], {
                    childList: true,
                    subtree: true
                });
            }
    });

</script>
<script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-messaging-compat.js"></script>
{{-- <script>
    const firebaseConfig = {
        apiKey: "{{ env('FB_API_KEY') }}",
        authDomain: "{{ env('FB_AUTH_DOMAIN') }}",
        projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
        storageBucket: "{{ env('FB_STORAGE_BUCKET') }}",
        messagingSenderId: "{{ env('FB_MESSAGING_SENDER_ID') }}",
        appId: "{{ env('FB_APP_ID') }}",
    };

    // Init Firebase
    firebase.initializeApp(firebaseConfig);

    // Init Messaging
    const messaging = firebase.messaging();


    Notification.requestPermission().then((permission) => {


        if (permission === "granted") {

            messaging.getToken({
                vapidKey: "{{ env('FB_VAPID_KEY') }}"


            }).then((token) => {

                document.getElementById("device_id").value = token;
            });
        } else {
            console.log("Notification permission denied.");
        }
    });

</script> --}}
<x-admin.alert />
{{-- <x-socket /> --}}

@yield('js')

</body>

</html>
