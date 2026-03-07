<?php

namespace App\Http\Controllers\Admin\Core;

use App\Exports\MasterExport;
use App\Http\Controllers\Controller;
use App\Traits\Excel\ExportHelpersTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    use ExportHelpersTrait;

    public function __construct()
    {
        // Fix output buffer issues with Excel downloads
        if (ob_get_length()) {
            ob_end_clean();
            ob_start();
        }
    }

    /**
     * Return available export columns for a model (for the column-selection modal).
     */
    public function columns(Request $request): JsonResponse
    {
        $modelClass = $this->resolveModelFromRequest($request);

        if (!$modelClass) {
            return response()->json(['columns' => [], 'message' => 'Model parameter is required.'], 422);
        }

        $this->validateModelClass($modelClass);

        $columns = $this->getExportableColumns($modelClass);

        if (empty($columns)) {
            return response()->json(['columns' => [], 'message' => 'No exportable columns found for this model.']);
        }

        return response()->json([
            'columns' => $columns,
            'model' => class_basename($modelClass),
        ]);
    }

    /**
     * Main export entry point. Columns are selected via request.
     */
    public function master(Request $request)
    {
        $modelClass = $this->resolveModelFromRequest($request);

        if (!$modelClass) {
            throw ValidationException::withMessages([
                'model' => [__('Model parameter is required for export.')],
            ]);
        }

        $this->validateModelClass($modelClass);

        $selectedColumns = $request->input('columns', []);
        if (!is_array($selectedColumns)) {
            $selectedColumns = $selectedColumns ? [$selectedColumns] : [];
        }

        $allowedKeys = array_keys($this->getExportableColumns($modelClass));

        if (empty($allowedKeys)) {
            throw ValidationException::withMessages([
                'columns' => [__('No exportable columns are defined for this model.')],
            ]);
        }

        if (empty($selectedColumns)) {
            throw ValidationException::withMessages([
                'columns' => [__('Please select at least one column to export.')],
            ]);
        }

        $invalid = array_diff($selectedColumns, $allowedKeys);
        if (!empty($invalid)) {
            throw ValidationException::withMessages([
                'columns' => [__('Invalid column(s) selected: :columns.', ['columns' => implode(', ', $invalid)])],
            ]);
        }

        $config = $this->buildExportConfigFromColumns($modelClass, $selectedColumns);

        return $this->masterExport(
            $modelClass,
            $config['cols'],
            $config['values'],
            $request->all(),
            $config['image_columns'] ?? []
        );
    }

    /* =========================
     |  Core Export Logic
     |=========================*/

    protected function masterExport(
        string $modelClass,
        array $cols,
        array $values,
        array $request = [],
        array $imageColumns = []
    ) {
        $this->validateModelClass($modelClass);

        // إنشاء instance متصل بالـ Eloquent
        $model = new $modelClass();
        // dd(
        //     $model->getTable(),
        //     $model->getConnectionName(),
        //     $model->getConnection()
        // );

        $query = $model->newQuery()
            ->where($this->prepareConditions($request['conditions'] ?? []))
            ->when(
                isset($request['searchArray']) &&
                is_array($request['searchArray']) &&
                method_exists($modelClass, 'scopeSearch'),
                fn($q) => $q->search($request['searchArray'])
            )
            ->latest()
            ->with($this->extractRelations($values));

        return Excel::download(
            new MasterExport(
                $query->get(),
                'master-excel',
                array_merge(compact('cols', 'values'), ['image_columns' => $imageColumns])
            ),
            $this->fileName($modelClass)
        );
    }

    /* =========================
     |  Helper Methods
     |=========================*/

    protected function resolveModelFromRequest(Request $request): ?string
    {
        $model = $request->input('model');
        if (!$model)
            return null;

        // Support URL-encoded full class names
        return urldecode($model);
    }

    protected function validateModelClass(string $modelClass): string
    {
        if (!class_exists($modelClass) || !is_subclass_of($modelClass, \Illuminate\Database\Eloquent\Model::class)) {
            throw ValidationException::withMessages([
                'model' => [__('Invalid model class for export.')],
            ]);
        }
        return $modelClass;
    }

    protected function extractRelations(array $values): array
    {
        // relations are any columns like 'parent.name' -> extract 'parent'
        return collect($values)
            ->filter(fn($value) => str_contains($value, '.'))
            ->map(fn($value) => explode('.', $value)[0])
            ->unique()
            ->values()
            ->toArray();
    }

    protected function fileName(string $modelClass): string
    {
        return strtolower(class_basename($modelClass)) . '-reports-' . now()->format('Y-m-d') . '.xlsx';
    }

    protected function prepareConditions(array $conditions): array
    {
        return collect($conditions)
            ->map(fn($value) => $value === 'null' ? null : $value)
            ->toArray();
    }

}
