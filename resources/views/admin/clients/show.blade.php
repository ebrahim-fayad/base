@extends('admin.layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <style>
        /*========================================================
                DARK LAYOUT
            =========================================================*/
        #user-profile .profile-img-container {
            position: absolute;
            bottom: -3rem;
            right: 10%;
            width: 80%;
        }

        #user-profile .profile-img-container img {
            border: 0.3rem solid #FFFFFF;
            height: 85px;
            width: 85px;
        }

        #user-profile #profile-info .card-header i {
            position: relative;
            top: -3px;
        }

        #user-profile #profile-info .user-like i {
            font-size: 1.7rem;
        }

        #user-profile #profile-info .suggested-block .user-page-info p {
            margin-bottom: 0;
            font-weight: 500;
        }

        #user-profile #profile-info .suggested-block i {
            cursor: pointer;
        }

        #user-profile .relative {
            position: relative;
        }

        #user-profile .profile-header-nav {
            background-color: #FFFFFF;
            padding: 0.75rem 1rem;
        }

        #user-profile .profile-header-nav .navbar {
            -webkit-box-pack: end;
            -webkit-justify-content: flex-end;
            -ms-flex-pack: end;
            justify-content: flex-end;
        }

        #user-profile .profile-header-nav .navbar .navbar-toggler {
            font-size: 1.7rem;
            color: #626262;
        }

        #user-profile .profile-header-nav .navbar .navbar-toggler:focus {
            outline: none;
        }

        #user-profile .user-latest-img {
            -webkit-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
        }

        #user-profile .user-latest-img:hover {
            -webkit-transform: translateY(-4px) scale(1.2);
            -ms-transform: translateY(-4px) scale(1.2);
            transform: translateY(-4px) scale(1.2);
            z-index: 30;
        }

        #user-profile .block-element .spinner-border {
            border-width: 2px;
        }

        @media only screen and (min-width: 992px) {
            #user-profile .profile-header-nav .navbar .nav-item {
                padding-right: 2.25rem !important;
                padding-left: 2.25rem !important;
            }
        }

        @media only screen and (max-width: 992px) {
            #user-profile .user-latest-img img {
                width: 100%;
            }
        }

        @media only screen and (max-width: 991px) and (min-width: 768px) {
            #user-profile .profile-header-nav .navbar .nav-item {
                padding-right: 1.5rem !important;
                padding-left: 1.5rem !important;
            }
        }

        /* تمييز ألوان التابات: البيانات الأساسية - الشكاوى - المحفظة - الطلبات - الخدمات */
        #user-profile .client-tabs .tab-link {
            border-bottom: 3px solid transparent;
            margin-bottom: -1px;
            padding-bottom: 0.5rem;
            transition: color 0.2s, border-color 0.2s;
        }
        #user-profile .client-tabs .tab-link:hover {
            opacity: 0.85;
        }
        /* البيانات الأساسية - أزرق */
        #user-profile .client-tabs .tab-main_data.active,
        #user-profile .client-tabs .tab-main_data:hover { color: #7367f0 !important; }
        #user-profile .client-tabs .tab-main_data.active { border-bottom-color: #7367f0; }
        /* الشكاوى - برتقالي */
        #user-profile .client-tabs .tab-complaints.active,
        #user-profile .client-tabs .tab-complaints:hover { color: #ff9f43 !important; }
        #user-profile .client-tabs .tab-complaints.active { border-bottom-color: #ff9f43; }
        /* المحفظة - أخضر */
        #user-profile .client-tabs .tab-wallet.active,
        #user-profile .client-tabs .tab-wallet:hover { color: #28c76f !important; }
        #user-profile .client-tabs .tab-wallet.active { border-bottom-color: #28c76f; }
        /* الطلبات - بنفسجي (للاستخدام عند تفعيل التاب) */
        #user-profile .client-tabs .tab-orders.active,
        #user-profile .client-tabs .tab-orders:hover { color: #9c27b0 !important; }
        #user-profile .client-tabs .tab-orders.active { border-bottom-color: #9c27b0; }
        /* الخدمات - تركواز (للاستخدام عند إضافة تاب الخدمات) */
        #user-profile .client-tabs .tab-services.active,
        #user-profile .client-tabs .tab-services:hover { color: #00cfe8 !important; }
        #user-profile .client-tabs .tab-services.active { border-bottom-color: #00cfe8; }
    </style>
@endsection

@section('content')
    <div class="app-content content m-0">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper m-0 p-0">
            <div class="content-body">
                <div id="user-profile">
                    @include('admin.clients.parts.links')

                    <section id="profile-info">
                        <div class="row">

                            <div class="col-lg-8 col-12 refrshed-data ">
                                @include('admin.clients.parts.main_data')

                            </div>

                            <div class="col-lg-4 col-12">
                                @include('admin.clients.parts.charge_wallet')
                                @include('admin.clients.parts.notify')
                            </div>

                        </div>
                    </section>
                </div>

            </div>
        </div>
    </div>
@endsection

{{-- @endsection --}}

@section('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>
    @include('admin.shared.notify')

    {{-- <script>
        $('.store input').attr('disabled', true)
        $('.store textarea').attr('disabled', true)
        $('.store select').attr('disabled', true)
    </script> --}}
    <script>
        $(document).on('click', '.delete-row', function(e) {
            e.preventDefault()
            Swal.fire({
                title: "{{ __('هل تريد الاستمرار ؟') }}",
                text: "{{ __('هل انت متأكد انك تريد استكمال عملية الحذف') }}",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __('admin.confirm') }}',
                confirmButtonClass: 'btn btn-primary',
                cancelButtonText: '{{ __('admin.cancel') }}',
                cancelButtonClass: 'btn btn-danger ml-1',
                buttonsStyling: false,
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "delete",
                        url: $(this).data('url'),
                        data: {
                            deletails: true
                        },
                        dataType: "json",
                        success: (response) => {
                            Swal.fire({
                                position: 'top-start',
                                type: 'success',
                                title: response.msg,
                                showConfirmButton: false,
                                timer: 1500,
                                confirmButtonClass: 'btn btn-primary',
                                buttonsStyling: false,
                            })
                            setTimeout(function() {
                                window.location = '{{ route('admin.clients.index') }}';
                            }, 3000);


                        }
                    });
                }
            })
        });

        $(document).on('click', '.show-details-links li a', function(e) {
            e.preventDefault()
            var url = $(this).data('href')
            $('.client-tabs .tab-link').removeClass('active')
            $(this).addClass('active')
            $.ajax({
                url: url,
                method: 'get',
                data: {},
                dataType: 'json',
                beforeSend: function() {
                    // $(".refrshed-data").html().attr('disable', true)
                },
                success: function(response) {
                    // $(".submit_button").html("{{ __('admin.add') }}").attr('disable', false)

                    $(".refrshed-data").html(response.html)
                },
            });
        });

        $(document).on('submit', '.updateBalance', function(e) {
            e.preventDefault();
            let currency = "{{ __('site.currency') }}";
            var url = $(this).attr('action')
            var button = $(".updateBalance .submit-button");
            var buttonContent = button.html()
            $.ajax({
                url: url,
                method: 'post',
                data: new FormData($(this)[0]),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    button.html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                        ).attr('disabled', true)
                },
                success: (response) => {
                    button.html(buttonContent).attr('disabled', false)
                    Swal.fire({
                        position: 'top-start',
                        type: 'success',
                        title: response.msg,
                        showConfirmButton: false,
                        timer: 1500,
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false,
                    })
                    // Update balance label immediately after successful charge/debt
                    if (response.balance !== undefined) {
                        // Extract balance number from response (might contain currency)
                        var balanceValue = response.balance.toString().replace(/[^0-9.-]/g, '');
                        $('.available_balance').html(Math.round(balanceValue) + ' ' + currency);
                    }

                    // Reload wallet section if it's currently open (check if wallet section exists)
                    var currentContent = $(".refrshed-data").html() || '';
                    if (currentContent.includes('wallet_details') || $(".refrshed-data").find(
                            'table#tab').length > 0) {
                        var walletLink = $('.show-details-links li a[data-href*="type=wallet"]');
                        if (walletLink.length > 0) {
                            var walletUrl = walletLink.data('href');
                            $.ajax({
                                url: walletUrl,
                                method: 'get',
                                data: {},
                                dataType: 'json',
                                success: function(walletResponse) {
                                    $(".refrshed-data").html(walletResponse.html);
                                }
                            });
                        }
                    }

                    $(this)[0].reset()
                    $('.store .text-danger').remove()
                },
                error: function(xhr) {
                    button.html("<i class='feather icon-navigation'></i>{{  __('admin.send') }}").attr(
                        'disabled', false)
                    $(".text-danger").remove()
                    $('.store input').removeClass('border-danger')

                    $.each(xhr.responseJSON.errors, function(key, value) {
                        // if kay has "." it means that input has two languages do this action to handle input name
                        if (key.indexOf(".") >= 0) {
                            var split = key.split('.')
                            key = split[0] + '\\[' + split[1] + '\\]'
                        }

                        $('.store .error.' + key).append(
                            `<span class="mt-5 text-danger">${value}</span>`);
                        // normal inputs
                        $('.store input[name^=' + key + ']').addClass(
                            'border-danger')
                        $('.store input[name^=' + key + '][type!=file]').after(
                            `<span class="text-danger">${value}</span>`);

                        // for select input
                        $('.store select[name^=' + key + ']').addClass(
                            'border-danger')
                        $('.store select[name^=' + key + ']').after(
                            `<span class="mt-1 text-danger">${value}</span>`);
                    });

                }

            });

        });
    </script>
@endsection
