<?php

namespace App\Http\Requests\Admin\AllUsers\Provider;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PhoneRule;
use App\Rules\ImageRule;
use App\Rules\EmailRule;
use App\Rules\CommercialNumber;

class UpdateRequest extends FormRequest
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
            'phone' => ['required', 'string', 'digits_between:9,11', new PhoneRule(tableName:'providers', countryCodeValue:$this->country_code, exceptId:$this->id, phoneValue:$this->phone, conditions:['deleted_at' => null])],
            'email' => ['nullable', new EmailRule(table:'providers', column:'email', exceptId:$this->id, conditions:['deleted_at' => null])],
            'commercial_image' => ['nullable', new ImageRule( )],
            'identity_numb' => ['required', 'numeric', 'digits_between:10,20', Rule::unique('providers', 'identity_numb')->whereNull('deleted_at')->ignore($this->id)],
            'commercial_number' => ['nullable', 'digits_between:10,20', new CommercialNumber(tableName:'providers', exceptId:$this->id, conditions:['deleted_at' => null])],
            'is_approved'=>['nullable'],
            'active'=>['nullable'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'phone' => fixPhone($this->phone),
            'country_code' => fixPhone($this->country_code ?? 966),
        ]);
    }
}
