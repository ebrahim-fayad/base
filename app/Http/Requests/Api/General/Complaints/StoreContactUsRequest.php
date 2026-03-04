<?php

namespace App\Http\Requests\Api\General\Complaints;

use Illuminate\Validation\Rule;
use App\Enums\ComplaintTypesEnum;
use App\Enums\ComplaintStatusEnum;
use App\Http\Requests\Api\BaseApiRequest;

class StoreContactUsRequest extends BaseApiRequest
{

    public function rules()
    {
        return [
            'user_name' => ['required', 'string', 'min:3', 'max:50'],
            'complaint' => 'required|string|min:3|max:500',
            'complaintable_type' => 'nullable|string',
            'complaintable_id' => 'nullable|integer',
            'type' => ['nullable'],
            'phone' => ['required', 'digits_between:9,15'],
            'country_code' =>['required','string','digits_between:2,5'],

        ];
    }
    public function messages()
    {
        return [

            'complaint.required' => __('apis.complaint.required'),
            'complaint.min' => __('apis.complaint.min'),
            'complaint.max' => __('apis.complaint.max'),
        ];
    }
    public function prepareForValidation()
    {
        $requiredIfAuth = (bool) auth()->check();
        return $this->merge([
            'country_code' => fixPhone($this->country_code ?? 966),
            'user_name' => $requiredIfAuth ? auth()->user()->name : $this->user_name,
            'phone' => $requiredIfAuth ?  fixPhone(auth()->user()->country_code) . fixPhone(auth()->user()->phone) :  fixPhone($this->country_code) . fixPhone($this->phone),
            'email' => $requiredIfAuth ? auth()->user()->email : $this->email,
            'type' =>  ComplaintTypesEnum::ContactUs->value ,
            'complaintable_type' => $requiredIfAuth ? get_class(auth()->user()) : null,
            'complaintable_id' => $requiredIfAuth ? auth()->id() : null,
        ]);
    }
}
