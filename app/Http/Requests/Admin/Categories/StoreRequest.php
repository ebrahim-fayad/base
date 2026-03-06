<?php

namespace App\Http\Requests\Admin\Categories;

use App\Rules\ImageRule;
use App\Rules\UniqueTranslation;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|array|size:'.count(languages()),
            'name.*' => ['required', 'min:3', 'max:191', 'string' , new UniqueTranslation(table:'categories', column:'name', conditions:[ 'parent_id' =>request()->input('parent_id')])],
            'parent_id' => 'nullable|exists:categories,id',
            'image' => ['required',new ImageRule()],
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'parent_id' =>request()->input('parent_id'),
        ]);
    }
}
