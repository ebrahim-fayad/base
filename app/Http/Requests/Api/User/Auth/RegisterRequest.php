<?php

namespace App\Http\Requests\Api\User\Auth;

use App\Http\Requests\Api\BaseApiRequest;
use App\Models\AllUsers\User;
use Illuminate\Validation\Rule;

class RegisterRequest extends BaseApiRequest
{

    public function rules()
    {
        return [
            'phone'                => ['required', 'numeric', 'digits_between:9,11'],
            'country_code'         => ['required', 'numeric', 'digits_between:1,5', Rule::exists('countries', 'key')],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'phone'        => fixPhone($this->phone),
            'country_code' => fixPhone($this->country_code ?? 966),
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = User::where(['phone' => fixPhone($this->phone), 'country_code' => fixPhone($this->country_code ?? 966)])
                ->whereNull('deleted_at')->first();
            if ($user && isset($user->password) && isset($user->name)) {
                $validator->errors()->add('phone', __('auth.user_already_registered'));
            }
        });
    }

    public function validated($key = null, $default = null)
    {
        $user = User::where(['phone' => fixPhone($this->phone), 'country_code' => fixPhone($this->country_code ?? 966)])
            ->whereNull('deleted_at')->first();
        $data = parent::validated($key, $default);
        $user && !isset($user->password, $user->name) ? $data['user'] = $user : null;
        return $data;
    }
}
