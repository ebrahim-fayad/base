<?php

namespace App\Http\Requests\Api\User\Profile;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\BaseApiRequest;

class ChangePasswordRequest extends BaseApiRequest
{

    public function rules(): array
    {
        return [
            'current_password' => 'required|string|min:6|max:50',
            'password' => 'required|string|min:6|max:50|confirmed',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (!Hash::check($this->current_password, auth('user')->user()->password)) {
                $validator->errors()->add('wrong_password', trans('auth.incorrect_pass'));
            }
            if (Hash::check($this->password, auth('user')->user()->password)) {
                $validator->errors()->add('same_password', __('auth.same_password'));
            }
        });
    }
}
