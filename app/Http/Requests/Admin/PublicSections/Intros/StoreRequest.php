<?php

namespace App\Http\Requests\Admin\PublicSections\Intros;

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
            'title' => 'required|array|size:'.count(languages()),
            'title.*' => ['required', 'min:3', 'max:191', 'string', new UniqueTranslation(table:'intros', column:'title', exceptId:$this->id)],
            'description' => 'required|array|size:'.count(languages()),
            'description.*' => ['required', 'min:3', 'max:191', 'string'],
            'image' => ['required','image','mimes:jpeg,jpg,png,webp','max:2048'],
        ];
    }
}
