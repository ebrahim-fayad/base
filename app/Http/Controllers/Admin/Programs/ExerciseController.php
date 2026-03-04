<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Programs\StoreDailyActivityRequest;
use App\Http\Requests\Admin\Programs\UpdateDailyActivityRequest;
use App\Models\Programs\Exercise;
use App\Models\Programs\Level;
use App\Models\Programs\LevelDay;
use App\Traits\ReportTrait;
use Illuminate\Http\JsonResponse;

class ExerciseController extends Controller
{
    use ReportTrait;

    public function store(StoreDailyActivityRequest $request, int $levelId, int $dayId): JsonResponse
    {
        $levelDay = LevelDay::where('level_id', $levelId)->findOrFail($dayId);

        if ($levelDay->exercises()->count() >= Exercise::MAX_EXERCISES_PER_DAY) {
            return response()->json([
                'key' => 'error',
                'msg' => __('admin.programs.max_exercises_per_day'),
            ], 422);
        }

        $data = $request->validated();
        $levelDay->exercises()->create($data);
        $this->addToLog(' إضافة تمرين');
        return response()->json(['url' => route('admin.levels.show', $levelId)]);
    }

    public function update(UpdateDailyActivityRequest $request, int $levelId, int $dayId, int $exerciseId): JsonResponse
    {
        $exercise = Exercise::where('level_day_id', $dayId)
            ->whereHas('levelDay', fn($q) => $q->where('level_id', $levelId))
            ->findOrFail($exerciseId);

        $data = $request->validated();
        $exercise->update($data);
        $this->addToLog(' تعديل تمرين');
        return response()->json(['url' => route('admin.levels.show', $levelId)]);
    }

    public function destroy(int $levelId, int $dayId, int $exerciseId): JsonResponse
    {
        $exercise = Exercise::where('level_day_id', $dayId)
            ->whereHas('levelDay', fn($q) => $q->where('level_id', $levelId))
            ->findOrFail($exerciseId);
        $exercise->delete();
        $this->addToLog(' حذف تمرين');
        return response()->json(['id' => $exerciseId]);
    }
}
