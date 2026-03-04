<?php

namespace App\Http\Requests\Admin\CountriesCities\Country;

use App\Rules\UniqueTranslation;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|array|size:'.count(languages()),
            'name.*' => ['required', 'min:3', 'max:191', 'string' , new UniqueTranslation(table:'countries', column:'name', conditions:['deleted_at' => null])],  // ignore deleted countries when storing
            'key'                    => 'required|unique:countries,key',
            'flag'                   => 'required',
        ];

    }


    public function prepareForValidation()
    {
        $this->merge([
            'key' => fixPhone($this->key),
        ]);
    }
}
