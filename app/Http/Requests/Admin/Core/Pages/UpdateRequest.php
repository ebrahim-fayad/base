<?php

namespace App\Http\Requests\Admin\Core\Pages;

use App\Rules\UniqueTranslation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image'                     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'                     => 'required|array|size:'.count(languages()),
            'title.*'                   => ['required', 'min:3', 'max:500', 'string' , new UniqueTranslation('pages', 'title', $this->id)],
            'content'                   => 'required|array|size:'.count(languages()),
            'content.*'                 => ['required', 'min:3', 'max:5000', 'string'],
        ];
    }
}
