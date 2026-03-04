<?php

namespace App\Http\Requests\Admin\LandingPage\IntroFqs;

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
        $id = $this->id ?? null;
        return [
            'title' => 'required|array|size:'.count(languages()),
            'title.*' => ['required', 'min:3', 'max:191', 'string', new UniqueTranslation(table:'intro_fqs', column:'title', exceptId: $id, conditions: ['intro_fqs_category_id' => $this->intro_fqs_category_id])],
            'description' => 'required|array|size:'.count(languages()),
            'description.*' => ['required', 'min:3', 'max:191', 'string'],
            'intro_fqs_category_id' => 'required|exists:intro_fqs_categories,id' ,
        ];
    }
}
