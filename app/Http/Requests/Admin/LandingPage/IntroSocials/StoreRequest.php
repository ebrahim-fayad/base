<?php

namespace App\Http\Requests\Admin\LandingPage\IntroSocials;


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
        $id = $this->id ?? null;
        return [
            'key'  => ['required', 'string', Rule::unique('intro_socials', 'key')->ignore($id)],
            'url' => 'required|url',
            'icon' => ['required', 'string', 'regex:/^fab/'],
        ];
    }

    public function messages()
    {
        return [
            'icon.regex' => __('admin.icon_should_start_with_fab'),
        ];
    }

    public function attributes()
    {
        return [
            'key' => __('admin.name'),
        ];
    }
}
