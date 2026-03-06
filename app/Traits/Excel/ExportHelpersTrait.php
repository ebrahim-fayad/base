<?php

namespace App\Traits\Excel;

use Illuminate\Support\Str;

trait ExportHelpersTrait
{
    protected function resolveModel(string $model, ?string $modelPath = null): string
    {
        if ($modelPath) {
            return str_contains($modelPath, '\\')
                ? $modelPath
                : "App\Models\\{$modelPath}";
        }

        return "App\Models\\{$model}";
    }

    protected function prepareConditions(array $conditions): array
    {
        return collect($conditions)
            ->map(fn ($value) => $value === 'null' ? null : $value)
            ->toArray();
    }
    

    protected function extractRelations(array $values): array
    {
        return collect($values)
            ->filter(fn ($value) => str_contains($value, '.'))
            ->map(fn ($value) => explode('.', $value)[0])
            ->unique()
            ->values()
            ->toArray();
    }

    protected function fileName(string $modelClass): string
    {
        return strtolower(Str::plural(class_basename($modelClass)))
            . '-reports-' . now()->format('Y-m-d') . '.xlsx';
    }
}
