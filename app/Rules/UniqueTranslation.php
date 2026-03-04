<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueTranslation implements Rule
{
    protected $table;
    protected $column;
    protected $exceptId;
    protected $langs;
    protected $conditions;

    public function __construct($table, $column = 'name', $exceptId = null, $conditions = [])
    {
        $this->table = $table;
        $this->column = $column;
        $this->exceptId = $exceptId;
        $this->conditions = $conditions;
        $this->langs = languages();
    }

    public function passes($attribute, $value)
    {
        foreach ($this->langs as $lang) {
            $exists = DB::table($this->table)
                ->where($this->column . '->' . $lang, $value)
                ->when($this->exceptId, fn($q) => $q->where('id', '!=', $this->exceptId))
                ->where($this->conditions)
                ->exists();

            if ($exists) return false;
        }

        return true;
    }

    public function message()
    {
        return __('validation.unique');
    }
}
