<?php

namespace App\Http\Requests\Admin\Programs;

use Illuminate\Foundation\Http\FormRequest;

class StoreDailyActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'exercise_name' => 'required|array|size:' . count(languages()),
            'exercise_name.*' => 'required|string|min:2|max:255',
            'description' => 'required|array|size:' . count(languages()),
            'description.*' => 'required|string|min:2',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'incentive_points' => 'nullable|integer|min:0',
        ];
    }
}
