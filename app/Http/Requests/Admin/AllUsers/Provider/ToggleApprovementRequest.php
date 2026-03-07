<?php

namespace App\Http\Requests\Admin\AllUsers\Provider;

use App\Enums\ApprovementStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ToggleApprovementRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id'=>'required|integer|exists:providers,id',
            'is_approved'=>['required','integer',Rule::in(ApprovementStatusEnum::values())],
            'refuse_reason'=>'required_if:is_approved,'.ApprovementStatusEnum::REJECTED->value.'|max:255'
        ];
    }
}
