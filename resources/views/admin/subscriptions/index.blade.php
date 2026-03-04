@extends('admin.layout.master')

@section('content')
    <section id="subscriptions-list">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('routes.subscriptions') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin.name') }}</th>
                                        <th>{{ __('admin.programs.level') }}</th>
                                        <th>{{ __('admin.programs.completed_days') }}</th>
                                        <th>{{ __('admin.programs.incomplete_days') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscriptions as $sub)
                                        <tr>
                                            <td><a
                                                    href="{{ route('admin.clients.show', $sub->user->id) }}">{{ $sub->user->name ?? '-' }}</a>
                                            </td>
                                            <td>{{ $sub->level ? $sub->level->name : '-' }}</td>
                                            <td>{{ $sub->completed_days }}</td>
                                            <td>{{ $sub->incomplete_days }}</td>
                                        </tr>
                                    @endforeach
                                    @if ($subscriptions->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                {{ __('admin.there_are_no_matches_matching') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if ($subscriptions->hasPages())
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
