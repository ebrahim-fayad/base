<?php

namespace App\Http\Requests\Admin\Programs;

use App\Models\Programs\Level;
use Illuminate\Foundation\Http\FormRequest;

class StoreLevelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|array|size:' . count(languages()),
            'name.*' => 'required|string|min:2|max:255',
            'description' => 'required|array|size:' . count(languages()),
            'description.*' => 'required|string|min:2',
            'level_number' => 'nullable|string|max:100',
            'subscription_price' => 'required|numeric|min:0',
            'active' => 'boolean',
            'order' => 'required|integer|min:0',
        ];
    }

    protected function prepareForValidation(): void
    {
        // عند إلغاء التفعيل الـ checkbox لا يُرسل في الطلب، لذلك الافتراضي false
        $this->merge([
            'active' => $this->boolean('active', false),
            'order' => Level::max('order') + 1,
        ]);
    }
}
