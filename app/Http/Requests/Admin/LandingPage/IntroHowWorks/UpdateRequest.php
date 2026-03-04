<?php

namespace App\Http\Requests\Admin\LandingPage\IntroHowWorks;

use App\Rules\UniqueTranslation;
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
            'title' => 'required|array|size:'.count(languages()),
            'title.*' => ['required', 'min:3', 'max:191', 'string', new UniqueTranslation('intro_how_works', 'title', $this->id)],
            'image'    => 'nullable|image'  ,
        ];
    }
}
