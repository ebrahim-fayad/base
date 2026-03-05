<?php

namespace App\Rules;
use DB;

use Illuminate\Contracts\Validation\Rule;

class PhoneRule implements Rule
{
    protected $countryCodeValue;
    protected $phoneValue;
    protected $tableName;
    protected $countryCodeColumn;
    protected $phoneColumn;
    protected $exceptId;
    public function __construct($tableName, $countryCodeValue, $phoneValue, $countryCodeColumn = 'country_code', $phoneColumn = 'phone', $exceptId = null, $conditions = [])
    {
        $this->countryCodeValue = $countryCodeValue;
        $this->phoneValue = $phoneValue;
        $this->tableName = $tableName;
        $this->countryCodeColumn = $countryCodeColumn;
        $this->phoneColumn = $phoneColumn;
        $this->exceptId = $exceptId;
        $this->conditions = $conditions;
    }

    public function passes($attribute, $value)
    {
        return !DB::table($this->tableName)
            ->where($this->countryCodeColumn, $this->countryCodeValue)
            ->where($this->phoneColumn, $this->phoneValue)
            ->when($this->exceptId, fn($q) => $q->where('id', '!=', $this->exceptId))
            ->where($this->conditions)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.unique');
    }
}
