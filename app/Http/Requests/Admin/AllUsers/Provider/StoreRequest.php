<?php

namespace App\Http\Requests\Admin\AllUsers\Provider;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\ApprovementStatusEnum;
use App\Rules\PhoneRule;
use App\Rules\ImageRule;
use App\Rules\EmailRule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => ['nullable', new ImageRule( )],
            'name' => ['required', 'min:2','max:50'],
            'country_code' => ['required', 'string', 'digits_between:2,5'],
            'phone' => ['required', 'string', 'digits_between:9,11', new PhoneRule(tableName:'providers', countryCodeValue:$this->country_code, phoneValue:$this->phone, conditions:['deleted_at' => null])],
            'email' => ['nullable',new EmailRule(table:'providers', column:'email', conditions:['deleted_at' => null])],
            'commercial_image' => ['required', new ImageRule( )],
            'identity_numb' => ['required', 'numeric', 'digits_between:10,20', Rule::unique('providers', 'identity_numb')->whereNull('deleted_at')],
            'is_approved'=>['nullable'],
            'active'=>['nullable'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'is_approved'=>ApprovementStatusEnum::APPROVED->value,
            'active'=>true,
            'phone' => fixPhone($this->phone),
            'country_code' => fixPhone($this->country_code??966),
        ]);
    }
}
