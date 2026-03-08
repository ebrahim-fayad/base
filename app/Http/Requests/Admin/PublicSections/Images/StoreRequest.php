<?php

namespace App\Http\Requests\Admin\PublicSections\Images;

use App\Rules\ImageRule;
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
            'image'                => ['required',new ImageRule()],
            'title' => 'required|array|size:'.count(languages()),
            'title.*' => ['required', 'min:3', 'max:191', 'string', new UniqueTranslation(table:'images', column:'title')],
        ];
    }
}
