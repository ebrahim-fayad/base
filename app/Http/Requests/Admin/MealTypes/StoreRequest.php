<?php

namespace App\Http\Requests\Admin\MealTypes;

use App\Rules\UniqueTranslation;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'   => 'required|array|size:' . count(languages()),
            'name.*' => ['required', 'string', 'min:2', 'max:191', new UniqueTranslation(table: 'meal_types', column: 'name')],
            'active' => 'required|boolean',
        ];
    }
}
