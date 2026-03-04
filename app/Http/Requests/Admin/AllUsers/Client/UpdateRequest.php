<?php

namespace App\Http\Requests\Admin\AllUsers\Client;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

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
            'name'                 => 'required|max:50|min:2',
            'is_blocked'           => 'nullable|boolean',
            'image'                => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'phone'                => ['required', 'integer', 'digits_between:9,11', Rule::unique('users', 'phone')->whereNull('deleted_at')->ignore($this->id)],
            'country_code'         => 'required|numeric|digits_between:2,5',
            'age'                  => 'nullable|integer|min:18|max:120',
            'weight'               => 'nullable|numeric|min:0|max:500',
            'height'               => 'nullable|numeric|min:0|max:300',
            'waist_circumference'  => 'nullable|numeric|min:0|max:250',
            'lat'                  => 'nullable|numeric|between:-90,90',
            'lng'                  => 'nullable|numeric|between:-180,180',
            'map_desc'             => 'nullable|string|max:255',
            'password'             => 'nullable|string',
            'is_notify'            => 'nullable|boolean',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'phone' => fixPhone($this->phone),
            'country_code' => '966'
        ]);
    }
}
