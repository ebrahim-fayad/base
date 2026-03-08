<?php

namespace App\Http\Requests\Admin\PublicSections\Images;

use App\Rules\ImageRule;
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
            'image'                => ['nullable',new ImageRule()],
            'title' => 'required|array|size:'.count(languages()),
            'title.*' => ['required', 'min:3', 'max:191', 'string', new UniqueTranslation(table:'images', column:'title', exceptId:$this->id)],
        ];
    }
}
