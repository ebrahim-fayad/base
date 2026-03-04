<?php

namespace App\Http\Requests\Api\User\Auth;

use App\Http\Requests\Api\BaseApiRequest;
use App\Models\AllUsers\User;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class ActivateRequest extends BaseApiRequest
{
    use GeneralTrait;

    public function rules()
    {
        return [
            'code'         => 'required|digits:4',
            'country_code' => ['required', 'numeric', 'digits_between:1,5', Rule::exists('countries', 'key')],
            'phone'        => [
                'required',
                'numeric',
                'digits_between:9,10',
                Rule::exists('users', 'phone')
                    ->where('country_code', fixPhone($this->country_code ?? 966))
                    // ->whereNull('password')->whereNull('name')
            ],
            'device_id'    => 'required|max:250',
            'device_type'  => 'in:ios,android',
            'lang'         => 'in:en,ar',
            'user'         => ['nullable'],
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


            if (!$this->user) {
                $validator->errors()->add('not_user', trans('auth.failed'));
            } else {
                if (!$this->isCodeCorrect($this->user, $this->code)) {
                    $validator->errors()->add('wrong_code', trans('auth.code_invalid'));
                }
                if (Carbon::parse($this->user->code_expire)->isPast()) {
                    $validator->errors()->add('code_expired', trans('auth.code_expired'));
                }
            }
        });
    }
}
