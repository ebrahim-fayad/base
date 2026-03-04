<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Iban implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Check if value is a string
        if (!is_string($value)) {
            return false;
        }

        // Check if it starts with "SA" and is followed by exactly 22 digits
        // Pattern: SA followed by exactly 22 digits
        return preg_match('/^SA\d{22}$/', $value) === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.iban');
    }
}

