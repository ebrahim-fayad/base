<?php

namespace App\Http\Requests\Admin\MealItems;

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
            'name'          => 'required|array|size:' . count(languages()),
            'name.*'        => ['required', 'string', 'min:2', 'max:191', new UniqueTranslation(table: 'meal_items', column: 'name')],
            'calories'      => 'required|numeric|min:0|max:9999',
            'protein'       => 'required|numeric|min:0|max:999',
            'carbohydrates' => 'required|numeric|min:0|max:999',
            'fats'          => 'required|numeric|min:0|max:999',
            'active'        => 'required|boolean',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ];
    }
}
