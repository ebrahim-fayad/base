<?php

namespace App\Http\Requests\Admin\LandingPage\IntroSliders;

use App\Rules\UniqueTranslation;
use Illuminate\Foundation\Http\FormRequest;

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
            'image'          => 'required|image' ,
            'title' => 'required|array|size:'.count(languages()),
            'title.*' => ['required', 'min:3', 'max:191', 'string', new UniqueTranslation(table:'intro_sliders', column:'title')],
            'description' => 'required|array|size:'.count(languages()),
            'description.*' => ['required', 'min:3', 'max:191', 'string'],
        ];

    }
}
