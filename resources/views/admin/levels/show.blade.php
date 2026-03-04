@extends('admin.layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <style>
        .day-card { border: 1px solid #e0e0e0; border-radius: 8px; margin-bottom: 1rem; }
        .day-card-header { padding: 0.75rem 1rem; background: #495057; color: #fff; border-radius: 8px 8px 0 0; font-weight: 600; }
        .day-card-body { padding: 1rem; }
        .exercise-item { padding: 0.5rem; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
        .exercise-item:last-child { border-bottom: none; }
    </style>
@endsection

@section('content')
    <section id="profile-info">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('admin.levels.level') }}: {{ $level->name }}</h4>
                        <div>
                            <a href="{{ route('admin.levels.edit', $level->id) }}"
                                class="btn btn-primary btn-sm">{{ __('admin.edit') }}</a>
                            <a href="{{ route('admin.levels.subscribers', $level->id) }}"
                                class="btn btn-info btn-sm ml-2">
                                {{ __('admin.programs.view_subscribers') }} ({{ $level->subscriptions->count() }})
                            </a>
                            <a href="{{ route('admin.levels.index') }}"
                                class="btn btn-outline-secondary btn-sm">{{ __('admin.back') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>{{ __('admin.programs.subscription_price') }}:</strong>
                                {{ $level->subscription_price }} {{ __('admin.currency') }}
                            </div>
                            <div class="col-md-6">
                                <strong>{{ __('admin.active_status') }}:</strong>
                                {{ $level->active ? __('admin.activate') : __('admin.dis_activate') }}
                            </div>
                        </div>
                        <p><strong>{{ __('admin.description') }}:</strong></p>
                        <div class="description-content">{!! $level->description !!}</div>
                        <p class="text-muted mt-2">{{ __('admin.levels.duration_note') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- 30 days - Add activities --}}
        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    {{ __('admin.programs.duration') }}: 30 {{ __('admin.programs.days_unit') }} — {{ __('admin.programs.add_activities_to_days') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($level->days as $day)
                        <div class="col-md-4 col-lg-3 mb-3">
                            <div class="day-card">
                                <div class="day-card-header">
                                    {{ __('admin.programs.day_n', ['n' => $day->day_number]) }}
                                </div>
                                <div class="day-card-body">
                                    @if($day->exercises->count() < 4)
                                        <button type="button" class="btn btn-sm btn-success mb-2 add-day-exercise"
                                            data-level-id="{{ $level->id }}"
                                            data-day-id="{{ $day->id }}">
                                            <i class="feather icon-plus"></i> {{ __('admin.programs.add_exercise') }}
                                        </button>
                                    @else
                                        <small class="text-muted">{{ __('admin.programs.exercises_count', ['count' => 4]) }}</small>
                                    @endif
                                    <div class="exercises-list">
                                        @foreach ($day->exercises as $exercise)
                                            <div class="exercise-item">
                                                <div>
                                                    <strong>{{ $exercise->exercise_name }}</strong>
                                                    @if ($exercise->getRawOriginal('image'))
                                                        <img src="{{ $exercise->image }}" width="30" height="30" class="rounded ml-1" alt="">
                                                    @endif
                                                    @if (($exercise->incentive_points ?? 0) > 0)
                                                        <span class="badge badge-info ml-1">{{ $exercise->incentive_points }} {{ __('admin.programs.incentive_points') }}</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <a href="#" class="edit-exercise text-primary"
                                                        data-exercise="{{ json_encode([
                                                            'id' => $exercise->id,
                                                            'exercise_name' => $exercise->getTranslations('exercise_name'),
                                                            'description' => $exercise->getTranslations('description'),
                                                            'incentive_points' => $exercise->incentive_points ?? 0,
                                                        ]) }}"
                                                        data-level-id="{{ $level->id }}"
                                                        data-day-id="{{ $day->id }}">
                                                        <i class="feather icon-edit"></i>
                                                    </a>
                                                    <span class="delete-row text-danger cursor-pointer ml-1"
                                                        data-url="{{ route('admin.levels.days.exercises.destroy', [$level->id, $day->id, $exercise->id]) }}">
                                                        <i class="feather icon-trash"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if ($day->exercises->isEmpty())
                                            <small class="text-muted">{{ __('admin.there_are_no_matches_matching') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Modal: Add/Edit Exercise --}}
    <div class="modal fade" id="exerciseModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="exerciseForm" method="POST" class="store">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exerciseModalLabel">{{ __('admin.programs.add_exercise') }}</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        @foreach (languages() as $lang)
                            <div class="form-group">
                                <label>{{ __('admin.programs.exercise_name') }} ({{ $lang == 'ar' ? __('admin.in_ar') : __('admin.in_en') }})</label>
                                <input type="text" class="form-control" name="exercise_name[{{ $lang }}]"
                                    id="exercise_name_{{ $lang }}" required>
                            </div>
                        @endforeach
                        @foreach (languages() as $lang)
                            <div class="form-group">
                                <label>{{ __('admin.description') }} ({{ $lang == 'ar' ? __('admin.in_ar') : __('admin.in_en') }})</label>
                                <textarea class="form-control" name="description[{{ $lang }}]"
                                    id="exercise_description_{{ $lang }}" rows="2" required></textarea>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label>{{ __('admin.image') }}</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.programs.incentive_points') }}</label>
                            <input type="number" class="form-control" name="incentive_points" id="exercise_incentive_points"
                                min="0" value="0" step="1" placeholder="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('admin.cancel') }}</button>
                        <button type="submit" class="btn btn-primary submit-exercise">{{ __('admin.add') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>
    <script>
        var currentLevelId, currentDayId;
        $(document).on('click', '.add-day-exercise', function() {
            currentLevelId = $(this).data('level-id');
            currentDayId = $(this).data('day-id');
            $('#exerciseForm').attr('action', '{{ url('admin/levels') }}/' + currentLevelId + '/days/' + currentDayId + '/exercises');
            $('#exerciseForm').attr('method', 'POST');
            $('#exerciseForm input[name="_method"]').remove();
            $('#exerciseModalLabel').text('{{ __('admin.programs.add_exercise') }}');
            $('#exerciseForm .submit-exercise').text('{{ __('admin.add') }}');
            $('#exerciseForm')[0].reset();
            $('#exerciseModal').modal('show');
        });
        $(document).on('click', '.edit-exercise', function(e) {
            e.preventDefault();
            var exercise = $(this).data('exercise');
            if (!exercise) return;
            currentLevelId = $(this).data('level-id');
            currentDayId = $(this).data('day-id');
            $('#exerciseForm').attr('action', '{{ url('admin/levels') }}/' + currentLevelId + '/days/' + currentDayId + '/exercises/' + exercise.id);
            $('#exerciseForm').attr('method', 'POST');
            if (!$('#exerciseForm input[name="_method"]').length) {
                $('#exerciseForm').prepend('<input type="hidden" name="_method" value="PUT">');
            }
            $('#exerciseForm input[name="_method"]').val('PUT');
            @foreach (languages() as $lang)
                $('#exercise_name_{{ $lang }}').val(exercise.exercise_name && exercise.exercise_name['{{ $lang }}'] ? exercise.exercise_name['{{ $lang }}'] : '');
                $('#exercise_description_{{ $lang }}').val(exercise.description && exercise.description['{{ $lang }}'] ? exercise.description['{{ $lang }}'] : '');
            @endforeach
            $('#exercise_incentive_points').val(exercise.incentive_points != null ? exercise.incentive_points : 0);
            $('#exerciseForm input[name="image"]').val('');
            $('#exerciseModalLabel').text('{{ __('admin.edit') }} {{ __('admin.programs.daily_activity') }}');
            $('#exerciseForm .submit-exercise').text('{{ __('admin.update') }}');
            $('#exerciseModal').modal('show');
        });
        $('#exerciseForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function() {
                    location.reload();
                },
                error: function(xhr) {
                    var msg = xhr.responseJSON && xhr.responseJSON.msg ? xhr.responseJSON.msg : '{{ __("admin.an_error_occurred") }}';
                    Swal.fire({ icon: 'error', title: msg, showConfirmButton: true });
                }
            });
        });
        $(document).on('click', '.delete-row', function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            if (!url) return;
            Swal.fire({
                title: "{{ __('admin.are_you_sure') }}",
                text: "{{ __('admin.are_you_sure_text_one') }}",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __('admin.confirm') }}',
                cancelButtonText: '{{ __('admin.cancel') }}',
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        data: { _token: '{{ csrf_token() }}' },
                        success: function() {
                            location.reload();
                        },
                        error: function(xhr) {
                            var msg = xhr.responseJSON && xhr.responseJSON.msg ? xhr.responseJSON.msg : '{{ __("admin.an_error_occurred") }}';
                            Swal.fire({ icon: 'error', title: msg, showConfirmButton: true });
                        }
                    });
                }
            });
        });
    </script>
@endsection
