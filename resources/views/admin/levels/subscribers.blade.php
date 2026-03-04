@extends('admin.layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
@endsection

@section('content')
<section id="profile-info">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __('admin.programs.subscribers') }} - {{ $level->name }}</h4>
                    <a href="{{ route('admin.levels.show', $level->id) }}" class="btn btn-outline-secondary btn-sm">{{ __('admin.back') }}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.name') }}</th>
                                    <th>{{ __('admin.age') }}</th>
                                    <th>{{ __('admin.weight') }}</th>
                                    <th>{{ __('admin.height') }}</th>
                                    <th>{{ __('admin.waist_circumference') }}</th>
                                    <th>{{ __('admin.programs.completed_days') }}</th>
                                    <th>{{ __('admin.programs.incomplete_days') }}</th>
                                    <th>{{ __('admin.programs.extra_days') }}</th>
                                    <th>{{ __('admin.active_status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subscriptions as $sub)
                                    <tr>
                                        <td>
                                            @if($sub->user)
                                                <a href="{{ route('admin.clients.show', ['id' => $sub->user->id]) }}">{{ $sub->user->name }}</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $sub->user->age ?? '-' }}</td>
                                        <td>{{ $sub->user->weight ?? '-' }} {{ __('admin.kg_unit') }}</td>
                                        <td>{{ $sub->user->height ?? '-' }} {{ __('admin.cm_unit') }}</td>
                                        <td>{{ $sub->user->waist_circumference ?? '-' }} {{ __('admin.cm_unit') }}</td>
                                        <td>{{ $sub->completed_days }}</td>
                                        <td>{{ $sub->incomplete_days }}</td>
                                        <td>{{ $sub->extra_days }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm {{ $sub->active ? 'btn-success' : 'btn-secondary' }} subscription-toggle-status"
                                               data-id="{{ $sub->id }}"
                                               data-url="{{ route('admin.levels.subscriptions.toggleStatus') }}">
                                                {{ $sub->active ? __('admin.activate') : __('admin.dis_activate') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($subscriptions->isEmpty())
                                    <tr>
                                        <td colspan="9" class="text-center">{{ __('admin.there_are_no_matches_matching') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if($subscriptions->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $subscriptions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>
    <script>
        $(document).on('click', '.subscription-toggle-status', function(e) {
            e.preventDefault();
            var $btn = $(this);
            $.ajax({
                url: $btn.data('url'),
                method: 'post',
                data: { id: $btn.data('id'), _token: '{{ csrf_token() }}' },
                dataType: 'json',
                success: function(r) {
                    Swal.fire({ position: 'top-start', icon: 'success', title: r.message, showConfirmButton: false, timer: 1200 });
                    location.reload();
                },
                error: function() {
                    Swal.fire({ position: 'top-start', icon: 'error', title: '{{ __("admin.an_error_occurred") }}', showConfirmButton: false, timer: 1500 });
                }
            });
        });
    </script>
@endsection
