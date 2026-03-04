<?php

namespace App\Http\Requests\Api\User\Auth;

use App\Models\AllUsers\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\BaseApiRequest;

class LoginRequest extends BaseApiRequest
{

    public function rules()
    {
        return [
            'country_code' => ['required', 'numeric', 'digits_between:1,5', Rule::exists('countries', 'key')],
            'phone'        => ['required', 'numeric', 'digits_between:9,10'],
            'device_id'    => ['required', 'min:5', 'max:250', 'string'],
            'device_type'  => ['required', 'in:ios,android', 'string'],
            'lang'         => ['required', 'in:en,ar', 'string'],
            'user'         => 'nullable',
            'password'     => 'required|string|min:6|max:50',
        ];
    }

    public function prepareForValidation()
    {
        $country_code = fixPhone($this->country_code ?? 966);
        $this->merge([
            'phone'        => fixPhone($this->phone),
            'country_code' => $country_code,
            'user'         => User::where(['phone' => fixPhone($this->phone), 'country_code' => $country_code])->first(),
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if ($this->user) {
                if ($this->user->is_blocked) {
                    $validator->errors()->add('blocked', trans('auth.blocked'));
                }
                if (!$this->user->active) {
                    $this->user->sendVerificationCode();
                    $validator->errors()->add('needActive', trans('auth.not_active'));
                }
                if (!Hash::check($this->password, $this->user->password)) {
                    $validator->errors()->add('wrong_password', trans('auth.failed'));
                }
            } else {
                $validator->errors()->add('not_user', trans('auth.failed'));
            }
        });
    }
}
