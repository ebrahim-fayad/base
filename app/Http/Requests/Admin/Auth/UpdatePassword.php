<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePassword extends FormRequest
{
    public function rules()
    {
        return [
            'old_password' => 'required|min:6|different:password',
            'password'     => 'required|min:6|confirmed',
        ];
    }

    protected function getRedirectUrl()
    {
        return route('admin.profile.profile', ['tap' => 'password']);
    }
}
