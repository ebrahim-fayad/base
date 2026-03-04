<?php

namespace App\Http\Requests\Api\User\Meal;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'components'   => 'required|array|min:1',
            'components.*.meal_item_id'   => 'required|exists:meal_items,id',
            'components.*.quantity_grams' => 'required|numeric|min:0.1|max:10000',
        ];
    }

    public function attributes(): array
    {
        return [
            'components.*.meal_item_id'   => __('validation.attributes.meal_item_component'),
            'components.*.quantity_grams' => __('validation.attributes.quantity_grams_component'),
        ];
    }
}
