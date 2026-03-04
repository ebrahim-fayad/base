<?php

namespace App\Http\Requests\Admin\PublicSettings\Role;

use App\Rules\UniqueTranslation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => 'required|array|size:'.count(languages()),
            'name.*'           => ['required', 'max:191','min:3',
            new UniqueTranslation(table:'roles', column:'name',exceptId: $this->id,conditions:['deleted_at' => null])],
            'permissions'      => ['required', 'array'],
        ];
    }
}
