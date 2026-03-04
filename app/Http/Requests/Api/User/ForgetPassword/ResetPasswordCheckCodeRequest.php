<?php

namespace App\Http\Requests\Api\User\ForgetPassword;

use App\Enums\AuthUpdatesAttributesEnum;
use App\Http\Requests\Api\BaseApiRequest;
use App\Models\AllUsers\User;

class ResetPasswordCheckCodeRequest extends BaseApiRequest
{
    public function rules()
    {
        return [
            'password'     => 'required|string|min:6|confirmed',
            'country_code' => 'required',
            'phone'        => 'required|exists:users,phone',
            'update'       => 'nullable',
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
            'update'       => User::where(['phone' => $phone, 'country_code' => $countryCode])->first() ? User::where(['phone' => $phone, 'country_code' => $countryCode])->first()->authUpdates()->where([
                'attribute'     => $phone,
                'country_code'  => $countryCode,
                'type'          => AuthUpdatesAttributesEnum::Password->value,
            ])->first() : null,
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->checkIfUserExists($validator);
        });
    }

    private function checkIfUserExists($validator): void
    {
        if (!$this->user) {
            $validator->errors()->add('not_user', trans('auth.failed'));
        }

        if (!$this->update) {
            $validator->errors()->add('not_user', trans('apis.send_change_password_request_first'));
        }
    }
}
