<?php

namespace App\Traits\Excel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

trait ExportHelpersTrait
{
    /**
     * Default namespace for models when only the short name is passed.
     */
    protected static string $exportModelNamespace = 'App\Models';

    /**
     * Resolve the model class from the request safely.
     *
     * - If a fully qualified class name is passed (contains \), use it directly.
     * - If only the model name is passed (e.g. "Admin"), prepend the default namespace (e.g. App\Models\Admin).
     *
     * @return string|null The resolved class name, or null if missing/invalid input.
     */
    protected function resolveModelFromRequest(Request $request): ?string
    {
        $model = $request->query('model') ?? $request->input('model');

        if ($model === null || !is_string($model)) {
            return null;
        }

        $model = trim($model);
        if ($model === '') {
            return null;
        }

        // Fully qualified class name: use as-is (e.g. App\Models\AllUsers\Admin)
        if (str_contains($model, '\\')) {
            return $model;
        }

        // Short name: prepend default namespace (e.g. Admin → App\Models\Admin)
        $namespace = rtrim(static::$exportModelNamespace, '\\');
        return $namespace . '\\' . $model;
    }

    /**
     * Validate that the given string is a valid Eloquent model class.
     * Throws ValidationException if not; otherwise returns the same class name.
     *
     * @throws ValidationException
     */
    protected function validateModelClass(string $modelClass): string
    {
        if ($modelClass === '') {
            throw ValidationException::withMessages([
                'model' => [__('Model parameter is required for export.')],
            ]);
        }

        if (!class_exists($modelClass)) {
            throw ValidationException::withMessages([
                'model' => [__('Export model class does not exist: :class.', ['class' => $modelClass])],
            ]);
        }

        if (!is_subclass_of($modelClass, Model::class)) {
            throw ValidationException::withMessages([
                'model' => [__('Export model must be an Eloquent model: :class.', ['class' => $modelClass])],
            ]);
        }

        return $modelClass;
    }

    protected function resolveModel(string $model, ?string $modelPath = null): string
    {
        $model = trim($model);
        $modelPath = $modelPath !== null ? trim($modelPath) : '';

        if ($modelPath !== '') {
            $class = str_contains($modelPath, '\\')
                ? $modelPath
                : "App\Models\\{$modelPath}";
        } else {
            $class = $model === '' ? '' : (str_contains($model, '\\') ? $model : "App\Models\\{$model}");
        }

        return $class;
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

    /**
     * Convert column key to human-readable label.
     * created_at -> Created At, first_name -> First Name, parent.name -> Parent Name
     */
    public function labelFromKey(string $key): string
    {
        if (str_contains($key, '.')) {
            $parts = array_map(fn ($part) => Str::title(str_replace('_', ' ', $part)), explode('.', $key));
            return implode(' ', $parts);
        }
        return Str::title(str_replace('_', ' ', $key));
    }

    /**
     * Get all exportable columns for a model: value_key => label.
     * If the model defines exportableColumns() (or getExportableColumns()), that is used.
     * Otherwise falls back to fillable + id + timestamps + relation columns.
     */
    public function getExportableColumns(string $modelClass): array
    {
        if (!class_exists($modelClass) || !is_subclass_of($modelClass, Model::class)) {
            return [];
        }

        try {
            /** @var Model $instance */
            $instance = app($modelClass);
        } catch (\Throwable) {
            return [];
        }

        // إذا الموديل فيه دالة تعرّف أعمدة التصدير نستخدمها (وتظهر في السيلكت)
        foreach (['exportableColumns', 'getExportableColumns', 'exportColumns'] as $method) {
            if (method_exists($instance, $method)) {
                $result = $instance->$method();
                if (is_array($result)) {
                    return $this->normalizeExportableColumns($result);
                }
            }
        }

        // Fallback: fillable + id + timestamps + relations
        $columns = [];
        $fillable = $instance->getFillable();
        $baseKeys = array_merge(
            in_array('id', $fillable, true) ? [] : ['id'],
            $fillable
        );
        if ($instance->usesTimestamps()) {
            $baseKeys = array_merge($baseKeys, ['created_at', 'updated_at']);
        }
        $baseKeys = array_values(array_unique($baseKeys));

        foreach ($baseKeys as $key) {
            $columns[$key] = $this->labelFromKey($key);
        }

        try {
            foreach ($this->getRelationColumnKeys($instance) as $key) {
                $columns[$key] = $this->labelFromKey($key);
            }
        } catch (\Throwable) {
            // Skip relation columns if any model has no connection (e.g. CLI/queue context)
        }

        return $columns;
    }

    /**
     * Normalize exportable columns from model method.
     * Accepts:
     * - ['key' => 'Label', ...]
     * - ['key1', 'key2'] (labels via labelFromKey)
     * - [['value' => 'id', 'label' => '#'], ...] (e.g. exportColumns())
     */
    protected function normalizeExportableColumns(array $columns): array
    {
        if (empty($columns)) {
            return [];
        }
        $first = reset($columns);
        if (is_array($first) && array_key_exists('value', $first) && array_key_exists('label', $first)) {
            $normalized = [];
            foreach ($columns as $row) {
                $normalized[$row['value']] = $row['label'];
            }
            return $normalized;
        }
        $isAssoc = array_keys($columns) !== range(0, count($columns) - 1);
        if ($isAssoc) {
            return $columns;
        }
        $normalized = [];
        foreach ($columns as $key) {
            $normalized[$key] = $this->labelFromKey($key);
        }
        return $normalized;
    }

    /**
     * Get relation column keys (e.g. parent.name, city.name) for the model.
     */
    protected function getRelationColumnKeys(Model $instance): array
    {
        $keys = [];
        $methods = get_class_methods($instance);
        foreach ($methods as $method) {
            if ($method === 'getRelations' || str_starts_with($method, 'get') || str_starts_with($method, 'set')) {
                continue;
            }
            try {
                $ref = new \ReflectionMethod($instance, $method);
                if ($ref->getNumberOfParameters() > 0) {
                    continue;
                }
                $value = $instance->$method();
                if ($value instanceof \Illuminate\Database\Eloquent\Relations\Relation) {
                    $related = $value->getRelated();
                    $relatedFillable = $related->getFillable();
                    $displayKey = in_array('name', $relatedFillable, true) ? 'name' : (in_array('id', $relatedFillable, true) ? 'id' : null);
                    if ($displayKey) {
                        $keys[] = "{$method}.{$displayKey}";
                    }
                }
            } catch (\Throwable) {
                continue;
            }
        }
        return $keys;
    }

    /**
     * Build export config (cols, values, image_columns) from selected column keys.
     */
    public function buildExportConfigFromColumns(string $modelClass, array $selectedColumns): array
    {
        $allowed = $this->getExportableColumns($modelClass);
        $selectedColumns = array_values(array_intersect($selectedColumns, array_keys($allowed)));
        $cols = array_map(fn ($key) => $allowed[$key], $selectedColumns);
        $values = $selectedColumns;
        $imageColumns = [];
        $imagePath = defined($modelClass . '::IMAGEPATH') ? $modelClass::IMAGEPATH : 'images';
        foreach ($values as $col) {
            if (str_contains(strtolower($col), 'image')) {
                $imageColumns[$col] = $imagePath;
            }
        }
        return [
            'cols' => $cols,
            'values' => $values,
            'image_columns' => $imageColumns,
        ];
    }
}
