<?php

namespace App\Http\Requests\Api\User\ForgetPassword;

use App\Enums\AuthUpdatesAttributesEnum;
use App\Http\Requests\Api\BaseApiRequest;
use App\Models\AllUsers\User;
use Illuminate\Validation\Rule;

class ForgetPasswordCheckCodeRequest extends BaseApiRequest
{
    public function rules()
    {
        return [
            'code'         => 'required|digits:4',
            'country_code' => ['required', 'numeric', 'digits_between:1,5', Rule::exists('countries', 'key')],
            'phone'        => ['required', 'numeric', 'digits_between:8,10', Rule::exists('users', 'phone')
            ->where('country_code', fixPhone($this->country_code))
            ->whereNull('deleted_at')],
            'user'         => ['nullable'],
            'type'         => ['nullable'],
            'attribute'    => ['nullable'],
        ];
    }

    public function prepareForValidation()
    {
        $phone = fixPhone($this->phone);
        $countryCode = fixPhone($this->country_code ?? 966);

        $this->merge([
            'phone'        => $phone,
            'country_code' => $countryCode,
            'user'         => User::where(['phone' => $phone, 'country_code' => $countryCode])->first(),
            'type'         => AuthUpdatesAttributesEnum::Password->value,
            'attribute'    => $phone,
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $this->checkIfUserExists($validator);
            $this->checkIfCodeIsValid($validator);

        });
    }

    private function checkIfUserExists($validator): void
    {
        if (!$this->user) {
            $validator->errors()->add('not_user', trans('auth.failed'));
        }
    }

    private function checkIfCodeIsValid($validator): void
    {
        $update = $this?->user?->authUpdates()
            ->where(['type' => AuthUpdatesAttributesEnum::Password->value, 'code' => $this->code])->first();

        if (!$update || $update->code == null) {
            $validator->errors()->add('wrong_code', trans('auth.code_invalid'));
        }
    }
}
