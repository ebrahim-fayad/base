<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Programs\PhysicalActivityCompletion;

class DailyActivityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $this->loadMissing('levelDay','levelDay.level');
        return [
            'id' => $this->id,
            'daily_activity_id' => $this->id,
            'level_day_id' => $this->levelDay->id,
            'level_id' => $this->levelDay->level->id,
            'exercise_name' => $this->exercise_name,
            'description' => $this->description,
            'image' => $this->image,
            'rate' => $this->getRate(),
            'achievement_points' => $this->incentive_points,
            'is_completed' => $this->getIsCompleted(),
        ];
    }

    protected function getIsCompleted(): bool
    {
        return PhysicalActivityCompletion::query()
            ->where('user_id', auth('user')->id())
            ->where('created_at', now()->format('Y-m-d'))
            ->where('level_id', $this->levelDay?->level?->id)
            ->where('level_day_id', $this->levelDay?->id)
            ->where('daily_activity_id', $this->id)
            ->exists();
    }

    protected function getRate(): int
    {
        return PhysicalActivityCompletion::query()
            ->where('user_id', auth('user')->id())
            ->where('created_at', now()->format('Y-m-d'))
            ->where('level_id', $this->levelDay?->level?->id)
            ->where('level_day_id', $this->levelDay?->id)
            ->where('daily_activity_id', $this->id)
            ->first()?->rate ?? 0;
    }
}
