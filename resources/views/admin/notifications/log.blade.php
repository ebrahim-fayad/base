@extends('admin.layout.master')

@section('content')
<div class="content-body">
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h4>{{ __('admin.notifications_log') }}</h4>
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-primary">
            <i class="feather icon-arrow-right"></i> {{ __('admin.send_notification') }}
        </a>
    </div>

    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('admin.date') }}</th>
                                <th>{{ __('admin.send_to') }}</th>
                                <th>{{ __('admin.notification_type') }}</th>
                                <th>{{ __('admin.the_title_in_arabic') }}</th>
                                <th>{{ __('admin.recipients_count') }}</th>
                                <th>{{ __('admin.the_admin') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                                    <td>{{ __('admin.notification_user_type.' . $log->user_type) }}</td>
                                    <td>{{ __('admin.notification_channel.' . $log->type) }}</td>
                                    <td>{{ $log->title ?? $log->body ?? '-' }}</td>
                                    <td>{{ $log->recipients_count }}</td>
                                    <td>{{ $log->admin?->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">{{ __('admin.there_are_no_matches_matching') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($logs->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
