<?php

namespace App\Http\Requests\Admin\PublicSections\Fqs;

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
            'question' => 'required|array|size:'.count(languages()),
            'question.*' => ['required', 'min:3', 'max:191', 'string', new UniqueTranslation(table:'fqs', column:'question', exceptId:$this->id)],
            'answer' => 'required|array|size:'.count(languages()),
            'answer.*' => ['required', 'min:3', 'max:191', 'string'],
        ];
    }
}
