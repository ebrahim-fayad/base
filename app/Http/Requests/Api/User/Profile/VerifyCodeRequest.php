<?php

namespace App\Http\Requests\Api\User\Profile;

use Illuminate\Validation\Rule;
use App\Enums\AuthUpdatesAttributesEnum;
use App\Http\Requests\Api\BaseApiRequest;

class VerifyCodeRequest extends BaseApiRequest
{

    public function rules(): array
    {
        return [
            'type'         => ['required', 'numeric', 'in:' . implode(',', array_column(AuthUpdatesAttributesEnum::cases(), 'value'))],
            'code'         => 'required|digits:4|numeric',
            'country_code' => [
                Rule::requiredIf(in_array($this->type, [AuthUpdatesAttributesEnum::Phone->value, AuthUpdatesAttributesEnum::NewPhone->value])),
                'nullable',
                'numeric',
                'digits_between:2,5'
            ],
            'phone'        => [
                Rule::requiredIf(in_array($this->type, [AuthUpdatesAttributesEnum::Phone->value, AuthUpdatesAttributesEnum::NewPhone->value])),
                'nullable',
                'numeric',
                'digits_between:9,10',
                'exists:auth_updates,attribute'
            ],
            'attribute'    => ['nullable', 'string'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'phone'        => fixPhone($this->phone),
            'country_code' => fixPhone($this->country_code ?? 966),
            'attribute'    => $this->phone,
        ]);
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $user = auth('user')->user();
            $row = $user->authUpdates()->where([
                'attribute'    => $this->phone,
                'country_code' => fixPhone($this->country_code ?? 966),
                'type'         => $this->type
            ])->first();

            if (!$row) {
                $validator->errors()->add('not_found', __('apis.send_change_phone_request_first'));
            } elseif ($row->code != $this->code) {
                $validator->errors()->add('not_found', __('apis.invalid_code'));
            }
        });
    }
}
