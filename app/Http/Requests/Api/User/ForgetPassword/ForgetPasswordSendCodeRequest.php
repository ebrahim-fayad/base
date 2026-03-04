<?php

namespace App\Http\Requests\Api\User\ForgetPassword;

use App\Enums\AuthUpdatesAttributesEnum;
use App\Http\Requests\Api\BaseApiRequest;
use App\Models\AllUsers\User;
use Illuminate\Validation\Rule;

class ForgetPasswordSendCodeRequest extends BaseApiRequest
{
    public function rules()
    {
        return [
            'country_code' => ['required', 'numeric', 'digits_between:1,5', Rule::exists('countries', 'key')],
            'phone'        => ['required', 'numeric', 'digits_between:8,10', Rule::exists('users', 'phone')
                    ->where('country_code', fixPhone($this->country_code))
                    ->whereNull('deleted_at')],
            'attribute'    => ['required'],
            'user'         => ['nullable'],
            'type'         => ['nullable'],
        ];
    }

    public function prepareForValidation()
    {
        $fixedPhone = fixPhone($this->phone);
        $fixedCode = fixPhone($this->country_code ?? 966);

        $this->merge([
            'phone'        => $fixedPhone,
            'country_code' => $fixedCode,
            'user'         => User::where(['phone' => $fixedPhone, 'country_code' => $fixedCode])->first(),
            'attribute'    => $fixedPhone,
            'type'         => AuthUpdatesAttributesEnum::Password->value,
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->user) {
                $validator->errors()->add('phone', __('apis.not_found'));
            }
        });
    }
}
