<?php

namespace App\Http\Resources\Api\User;

use App\Models\Programs\Level;
use App\Models\Programs\LevelSubscription;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramLevelDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = auth('user')->user();
        $isSubscribed = $this->getIsSubscribed($user);
        $availableToSubscribe = $this->getAvailableToSubscribe($user, $isSubscribed);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'level_number' => $this->level_number ?? (string) $this->order,
            'description' => $this->description,
            'subscription_price' => (float) $this->subscription_price,
            'order' => $this->order,
            'active' => $this->active,
            'days_count' => $this->when(isset($this->days_count), fn() => $this->days_count),
            'days' => $this->whenLoaded('days', fn() => $this->days->take(1)->map(function ($day) {
                return [
                    'id' => $day->id,
                    'day_number' => $day->day_number,
                    'exercises' => $day->relationLoaded('exercises')
                        ? $day->exercises->map(fn($exercise) => [
                            'id' => $exercise->id,
                            'exercise_name' => $exercise->exercise_name,
                            'description' => $exercise->description,
                            'image' => $exercise->image,
                        ])->values()
                        : [],
                ];
            })->values()),
            'is_subscribed' => $isSubscribed,
            'available_to_subscribe' => $availableToSubscribe,
        ];
    }

    protected function getIsSubscribed($user): bool
    {
        if (!$user) {
            return false;
        }

        return LevelSubscription::where('user_id', $user->id)
            ->where('level_id', $this->id)
            ->exists();
    }

    protected function getAvailableToSubscribe($user, bool $isSubscribed): bool
    {
        if (!$user || $isSubscribed) {
            return false;
        }

        // المستوى الأول متاح للاشتراك بدون شروط
        if ($this->order <= 1) {
            return true;
        }

        // يجب أن يكون المستخدم مشتركاً في المستوى السابق وأن يكون اشتراكه مكتملاً (30 يوم)
        $previousLevel = Level::where('order', $this->order - 1)->first();
        $previousSubscription = $previousLevel
            ? LevelSubscription::where('user_id', $user->id)->where('level_id', $previousLevel->id)->first()
            : null;

        return !$previousLevel || ($previousSubscription && $previousSubscription->completed_days >= Level::DURATION_DAYS);
    }
}
