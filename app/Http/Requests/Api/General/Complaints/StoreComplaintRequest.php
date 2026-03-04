<?php

namespace App\Http\Requests\Api\General\Complaints;

use Illuminate\Validation\Rule;
use App\Enums\ComplaintTypesEnum;
use App\Http\Requests\Api\BaseApiRequest;

class StoreComplaintRequest extends BaseApiRequest
{

    public function rules()
    {
        return [
            'user_name' => 'required|string|min:3|max:50',
            'phone' => 'required|string|digits_between:9,11',
            'country_code' => 'required|string|digits_between:2,5',
            'complaint' => 'required|string|min:3|max:500',
            'subject' => 'required|string|min:3|max:50',
            'type' => ['nullable'],
            'complaintable_type' => 'nullable|string',
            'complaintable_id' => 'nullable|integer',
        ];
    }

    public function prepareForValidation()
    {
        $authCheck = auth()->check();
        return $this->merge([
            'type' => ComplaintTypesEnum::Complaint->value,
            'complaintable_type' => $authCheck ? get_class(auth()->user()) : null,
            'complaintable_id' => $authCheck ? auth()->id() : null,
            'user_name' => $authCheck ? auth()->user()->name : $this->user_name,
            'country_code' =>fixPhone($this->country_code ?? 966) ,
            'phone' => $authCheck ? fixPhone($this->country_code . auth()->user()->phone) : fixPhone($this->country_code . $this->phone),
        ]);
    }
}
