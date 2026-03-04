<?php

namespace App\Http\Requests\Api\User\Meal;

use App\Http\Requests\Api\BaseApiRequest;
use Carbon\Carbon;

class StoreMealRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (!$this->has('date')) {
            $this->merge(['date' => Carbon::today()->format('Y-m-d')]);
        }
    }

    public function rules(): array
    {
        return [
            'meal_type_id' => 'required|exists:meal_types,id',
            'date'         => 'required|date|date_format:Y-m-d',
            'components'   => 'required|array|min:1',
            'components.*.meal_item_id'   => 'required|exists:meal_items,id',
            'components.*.quantity_grams' => 'required|numeric|min:0.1|max:10000',
        ];
    }

    public function attributes(): array
    {
        return [
            'meal_type_id'                 => __('validation.attributes.meal_type_id'),
            'components.*.meal_item_id'    => __('validation.attributes.meal_item_component'),
            'components.*.quantity_grams'  => __('validation.attributes.quantity_grams_component'),
        ];
    }
}
