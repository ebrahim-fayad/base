<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\BaseApiRequest;
use App\Models\Programs\LevelSubscription;
use App\Models\Programs\PhysicalActivityCompletion;
use Carbon\Carbon;

class CompleteExerciseRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:level_subscriptions,id'],
            'daily_activity_id' => ['required', 'integer', 'exists:daily_activities,id'],
            'rate' => ['required', 'integer', 'in:25,50,75,100'],
        ];
    }

    public function attributes(): array
    {
        return [
            'id' => __('apis.validation.subscription_id'),
            'daily_activity_id' => __('apis.validation.daily_activity_id'),
            'subscription' => __('apis.validation.subscription'),
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $subscription = LevelSubscription::where('user_id', auth('user')->id())
                ->where('id', $this->id)
                ->first();
            if (!$subscription) {
                $validator->errors()->add('subscription', __('apis.not_found'));
            } else {
                // إكمال التمرين مسموح فقط في "يومه" (نفس التاريخ): لا إكمال ليوم قديم أو مستقبلي.
                $today = Carbon::today();
                $subscriptionStart = Carbon::parse($subscription->created_at)->startOfDay();
                $canCompleteToday = $subscription->completed_days === 0
                    ? ($today->isSameDay($subscriptionStart) || $today->isAfter($subscriptionStart))
                    : (!$subscription->last_completed_day_date || $today->isAfter(Carbon::parse($subscription->last_completed_day_date)));
                if (!$canCompleteToday) {
                    $validator->errors()->add('daily_activity_id', __('apis.exercise_complete_only_in_its_day'));
                }

                $currentDayNumber = (int) $subscription->completed_days + 1;
                $subscription->level->loadMissing('days');
                $levelDay = $subscription->level->days()->where('day_number', $currentDayNumber)->with('exercises')->first();
                if (!$levelDay) {
                    $validator->errors()->add('daily_activity_id', __('apis.not_found'));
                } else {
                    $exercise = $levelDay->exercises()->where('id', $this->daily_activity_id)->first();
                    if (!$exercise) {
                        $validator->errors()->add('daily_activity_id', __('apis.not_found'));
                    } else {
                        $exists = PhysicalActivityCompletion::query()
                            ->where('user_id', auth('user')->id())
                            ->where('level_id', $subscription->level_id)
                            ->where('level_day_id', $levelDay->id)
                            ->where('daily_activity_id', $this->daily_activity_id)
                            ->exists();
                        if ($exists) {
                            $validator->errors()->add('daily_activity_id', __('apis.exercise_already_completed'));
                        }
                    }
                }
            }
        });
    }

    public function validated($key = null, $default = null)
    {
        $subscription = LevelSubscription::where('user_id', auth('user')->id())
            ->where('id', $this->id)
            ->with('level')
            ->first();
        $currentDayNumber = (int) $subscription->completed_days + 1;
        $levelDay = $subscription->level->days()->where('day_number', $currentDayNumber)->with('exercises')->first();
        $exercise = $levelDay->exercises()->where('id', $this->daily_activity_id)->first();
        $data = parent::validated($key, $default);
        $data['user_id'] = auth('user')->id();
        $data['level_id'] = $subscription->level_id;
        $data['level_day_id'] = $levelDay->id;
        $data['points_earned'] = $exercise->incentive_points;
        return $data;
    }
}
