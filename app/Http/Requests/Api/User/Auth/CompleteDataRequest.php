<?php

namespace App\Http\Requests\Api\User\Auth;

use App\Http\Requests\Api\BaseApiRequest;
use App\Models\AllUsers\User;
use Illuminate\Validation\Rule;

class CompleteDataRequest extends BaseApiRequest
{

    public function rules()
    {
        return [
            'id'                  => ['required', 'numeric', Rule::exists('users', 'id')->whereNull('deleted_at')],
            'name'                => ['required', 'string', 'min:2', 'max:50'],
            'password'            => ['required', 'string', 'min:6', 'confirmed'],
            'lat'                 => ['required', 'numeric', 'between:-90,90'],
            'lng'                 => ['required', 'numeric', 'between:-180,180'],
            'map_desc'            => ['required', 'string', 'max:255'],
            'is_accept_terms'     => ['required', 'in:1,true'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = User::find($this->id);
            if (!$user) {
                $validator->errors()->add('id', __('apis.not_found'));
            }else{
                if (isset($user->password) && isset($user->name)) {
                    $validator->errors()->add('id', __('auth.user_already_registered'));
                }
            }
        });
    }

    public function validated($key = null, $default = null)
    {
        $user = User::find($this->id);
        $data = parent::validated($key, $default);
        $user && !isset($user->password, $user->name) ? $data['user'] = $user : null;
        return $data;
    }
}
