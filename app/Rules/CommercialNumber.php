<?php

namespace App\Rules;


use DB;
use Illuminate\Contracts\Validation\Rule;


class CommercialNumber implements Rule
{

    protected $tableName;
    protected $commercialNumberColumn = 'commercial_number';
    protected $exceptId;
    protected $conditions;
    public function __construct($tableName, $exceptId = null, $conditions = [])
    {
        $this->tableName = $tableName;
        $this->exceptId = $exceptId;
        $this->conditions = $conditions;
    }

    public function passes($attribute, $value)
    {
        return !DB::table($this->tableName)
            ->where($this->commercialNumberColumn, $value)
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
