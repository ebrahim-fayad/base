<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueIfExists implements Rule
{
    protected $table;
    protected $column;
    protected $conditions;
    protected $country_code;

    public function __construct($table, $column = 'phone', $country_code = 966, $conditions = [])
    {
        $this->table = $table;
        $this->column = $column;
        $this->conditions = $conditions;
        $this->country_code = $country_code;
    }

    public function passes($attribute, $value)
    {
        $user = DB::table($this->table)->where($this->column, $value)->whereNull('deleted_at')->first();
        return ($user && $user->country_code == $this->country_code) || !$user;
    }

    public function message()
    {
        return __('validation.unique');
    }
}
