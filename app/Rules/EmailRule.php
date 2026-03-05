<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule as LaravelRule;

class EmailRule implements Rule
{
    protected $table;
    protected $column;
    protected $exceptId;
    protected $conditions;

    public function __construct($table, $column = 'email', $exceptId = null, $conditions = [])
    {
        $this->table = $table;
        $this->column = $column;
        $this->exceptId = $exceptId;
        $this->conditions = $conditions;

    }

    public function passes($attribute, $value)
    {
        // أولاً: التحقق من صحة الإيميل بنفس إعداداتك
        $emailValidator = Validator::make(
            [$attribute => $value],
            [
                $attribute => [
                    LaravelRule::email()
                        ->rfcCompliant(false)
                        ->validateMxRecord()
                        ->preventSpoofing(),
                ],
            ]
        );

        if ($emailValidator->fails()) {
            $this->message = __('validation.email');
            return false;
        }

        // ثانياً: التحقق من الـ Unique
        $exists = DB::table($this->table)
            ->where($this->column, $value)
            ->when($this->exceptId, fn($q) => $q->where('id', '!=', $this->exceptId))
            ->where($this->conditions)
            ->exists();

        if ($exists) {
            $this->message = __('validation.unique');
            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->message ?? 'The :attribute is invalid.';
    }
}
