<?php

namespace App\Http\Requests\Api\User\Auth;

use App\Enums\UserTypesEnum;
use App\Http\Requests\Api\BaseApiRequest;
use App\Models\AllUsers\User;
use Illuminate\Validation\Rule;

class ResendCodeRequest extends BaseApiRequest
{

    public function rules()
    {
        return [
            'country_code' => ['required', 'numeric', 'digits_between:1,5', Rule::exists('countries', 'key')],
            'phone'        => [
                'required',
                'numeric',
                'digits_between:9,10',
                Rule::exists('users', 'phone')->where('country_code', fixPhone($this->country_code ?? 966))
            ],
            'user'         => 'nullable'
        ];
    }

    public function prepareForValidation()
    {
        $country_code = fixPhone($this->country_code ?? 966);
        $this->merge([
            'phone'        => fixPhone($this->phone),
            'country_code' => $country_code,
            'user'         => User::where(['phone' => fixPhone($this->phone), 'country_code' => $country_code,'active' => false])->first(),
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if ($this->user) {
                if ($this->user->is_blocked) {
                    $validator->errors()->add('blocked', trans('auth.blocked'));
                }
            }else{
                $validator->errors()->add('not_user', trans('auth.failed'));
            }
        });
    }
}
