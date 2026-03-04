<?php

namespace App\Http\Requests\Admin\AllUsers\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNutritionalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'daily_calories'      => 'nullable|integer|min:0|max:10000',
            'daily_protein'       => 'nullable|integer|min:0|max:1000',
            'daily_carbohydrates' => 'nullable|integer|min:0|max:1000',
            'daily_fats'          => 'nullable|integer|min:0|max:1000',
        ];
    }
}
