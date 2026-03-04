@extends('admin.layout.master')
@php use App\Enums\ComplaintStatusEnum; @endphp
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <style>
        .complaint-images-gallery {
            margin-top: 10px;
        }

        .image-gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: #fff;
            padding: 5px;
        }

        .image-gallery-item:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        }

        .complaint-gallery-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.4s ease;
            display: block;
        }

        .image-gallery-item:hover .complaint-gallery-img {
            transform: scale(1.1);
        }

        .modal-image-view {
            max-height: 75vh;
            width: auto;
            border-radius: 8px;
        }

        .complaint-images-gallery .form-group label {
            font-weight: 600;
            color: #5e5873;
            font-size: 1rem;
        }
    </style>
@endsection
@section('content')
    <section id="multiple-column-form">
        <div class="complaint match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('routes.complaints_and_proposals.show') }}</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">
                            <form>
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.user_name') }}</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control"
                                                        value="{{ $row->user_name ?? $row->complaintable?->name }}"
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.phone') }}</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control"
                                                        value="{{ $row->phone ?? $row->complaintable?->full_phone }}"
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.subject') }}</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" value="{{ $row->subject }}"
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.status') }}</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control"
                                                        value="{{ ComplaintStatusEnum::getTranslatedName($row->status, 'complaintStatusEnum') }}"
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.complaint') }}</label>
                                                <div class="controls">
                                                    <textarea class="form-control" cols="30" complaints="10"
                                                        disabled>{{ $row->complaint }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($row->images && $row->images->count() > 0)
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label class="mb-2">{{ __('admin.images') }}</label>
                                                    <div class="complaint-images-gallery">
                                                        <div class="row">
                                                            @foreach ($row->images as $image)
                                                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                                                    <div class="image-gallery-item">
                                                                        <img src="{{ $image->image }}" alt="Complaint Image"
                                                                            class="complaint-gallery-img" data-toggle="modal"
                                                                            data-target="#imageModal{{ $image->id }}">
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($row->replay)
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column">{{ __('admin.replay') }}</label>
                                                    <div class="controls">
                                                        <textarea class="form-control" cols="30"
                                                            disabled>{{ $row->replay->replay }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col-12 d-flex justify-content-center mt-3">
                                            {{-- replay button --}}

                                            @if ($row->status == ComplaintStatusEnum::New->value)
                                                <button type="button" class="btn btn-outline-info mr-1 mb-1 start-working-btn"
                                                    data-id="{{ $row->id }}">
                                                    {{ __('admin.start_working') }}
                                                </button>
                                            @endif
                                            @if ($row->status == ComplaintStatusEnum::Pending->value)
                                                <button type="button" class="btn btn-outline-info mr-1 mb-1" data-toggle="modal"
                                                    data-target="#replay">
                                                    {{ __('admin.replay') }}
                                                </button>
                                            @endif
                                            <a href="{{ route('admin.all_complaints') }}" type="reset"
                                                class="btn btn-outline-warning mr-1 mb-1">{{ __('admin.back') }}</a>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.public-sections.complaints.parts.complaint_replay')

        @if ($row->images && $row->images->count() > 0)
            @foreach ($row->images as $image)
                <div class="modal fade" id="imageModal{{ $image->id }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary white">
                                <h5 class="modal-title">{{ __('admin.complaint_image') }}</h5>
                                <button type="button" class="close white" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center p-0">
                                <img src="{{ $image->image }}" alt="Complaint Image" class="img-fluid modal-image-view">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ __('admin.close') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </section>
@endsection

@section('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Handle start working button
            $(document).on('click', '.start-working-btn', function (e) {
                e.preventDefault();
                var btn = $(this);
                var complaintId = btn.data('id');
                var url = "{{ route('admin.complaints.update', ['id' => ':id']) }}".replace(':id',
                    complaintId);

                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        btn.html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                        ).attr('disabled', true);
                    },
                    success: function (response) {
                        Swal.fire({
                            position: 'top-start',
                            type: 'success',
                            title: response.msg ||
                                '{{ __('admin.status_updated_successfully') }}',
                            showConfirmButton: false,
                            timer: 1500,
                            confirmButtonClass: 'btn btn-primary',
                            buttonsStyling: false,
                        });
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function (xhr) {
                        btn.html('{{ __('admin.start_working') }}').attr('disabled', false);
                        var errorMsg = xhr.responseJSON?.msg ||
                            '{{ __('admin.error_occurred') }}';
                        Swal.fire({
                            position: 'top-start',
                            type: 'error',
                            title: errorMsg,
                            showConfirmButton: false,
                            timer: 2000,
                            confirmButtonClass: 'btn btn-primary',
                            buttonsStyling: false,
                        });
                    }
                });
            });

            $(document).on('submit', '.notify-form', function (e) {
                e.preventDefault();
                var url = $(this).attr('action')
                $.ajax({
                    url: url,
                    method: 'post',
                    data: new FormData($(this)[0]),
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $(".send-notify-button").html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                        ).attr('disable', true)
                    },
                    success: function (response) {
                        $(".text-danger").remove()
                        $('.store input').removeClass('border-danger')
                        $(".send-notify-button").html("{{ __('admin.send') }}").attr('disable',
                            false)
                        Swal.fire({
                            position: 'top-start',
                            type: 'success',
                            title: '{{ __('admin.replay_successfullay') }}',
                            showConfirmButton: false,
                            timer: 1500,
                            confirmButtonClass: 'btn btn-primary',
                            buttonsStyling: false,
                        })
                        setTimeout(function () {
                            window.location.replace(response.url)
                        }, 1000);
                    },
                    error: function (xhr) {
                        $(".send-notify-button").html("{{ __('admin.send') }}").attr('disable',
                            false)
                        $(".text-danger").remove()
                        $('.store input').removeClass('border-danger')

                        $.each(xhr.responseJSON.errors, function (key, value) {
                            $('.store input[name=' + key + ']').addClass(
                                'border-danger')
                            $('.store input[name=' + key + ']').after(
                                `<span class="mt-5 text-danger">${value}</span>`);
                            $('.notify-form textarea[name=' + key + ']').addClass(
                                'border-danger')
                            $('.notify-form textarea[name=' + key + ']').after(
                                `<span class="mt-5 text-danger">${value}</span>`);
                            $('.store select[name=' + key + ']').after(
                                `<span class="mt-5 text-danger">${value}</span>`);
                        });
                    },
                });

            });
        });
    </script>
@endsection
