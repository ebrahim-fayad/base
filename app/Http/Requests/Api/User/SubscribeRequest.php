<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\BaseApiRequest;
use App\Models\Programs\Level;
use App\Models\Programs\LevelSubscription;

class SubscribeRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'level_id' => ['required', 'integer', 'exists:levels,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'level_id' => $this->route('id'),
        ]);
    }

    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated($key, $default);
        if ($key === null) {
            $validated['user_id'] = auth('user')->id();
        }

        return $validated;
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $level = Level::find($this->level_id);

            if (!$level || !$level->active) {
                $validator->errors()->add('level', __('apis.level_not_available'));
                return;
            }

            $user = auth('user')->user();

            $alreadySubscribed = LevelSubscription::where('user_id', $user->id)
                ->where('level_id', $this->level_id)
                ->exists();

            if ($alreadySubscribed) {
                $validator->errors()->add('already_subscribed', __('apis.already_subscribed'));
                return;
            }

            if ($level->order > 1) {
                $previousLevel = Level::where('order', $level->order - 1)->first();
                $prevSub = $previousLevel
                    ? LevelSubscription::where('user_id', $user->id)
                        ->where('level_id', $previousLevel->id)
                        ->first()
                    : null;

                if (!$prevSub || $prevSub->completed_days < Level::DURATION_DAYS) {
                    $validator->errors()->add('previous_level_required', __('apis.complete_previous_level_first'));
                }
            }
        });
    }
}
