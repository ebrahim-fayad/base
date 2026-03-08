<?php

namespace App\Http\Requests\Admin\PublicSections\Complaints;

use Illuminate\Foundation\Http\FormRequest;

class StoreReplayComplaintRequest extends FormRequest
{
    public function rules()
    {
        return [
            'replay' => 'required|string|min:3|max:1500',
            'replayer_id' => 'required|exists:admins,id',
            'replayer_type' => 'required',
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'replayer_id' => auth('admin')->id(),
            'replayer_type' => 'admin',
        ]);
    }
}
