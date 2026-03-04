<?php

namespace App\Http\Controllers\Admin\Core;

use App\Exports\MasterExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function __construct()
    {
        if (ob_get_length()) {
            ob_end_clean(); // this
            ob_start(); // and this
        }
    }

    public function master($export, Request $request)
    {
        // Handle both full class path and simple class name
        $modelPath = $export;
        $modelName = class_basename($export);

        // Ensure we can call the method (e.g., Country, City, etc.)
        if (!method_exists($this, $modelName)) {
            throw new \BadMethodCallException("Export method for {$modelName} does not exist.");
        }

        $data = $this->$modelName($request);
        return $this->masterExport($export, $data['cols'], $data['values'], $modelPath, $request->all());
    }

    public function User(): array
    {
        return [
            'cols' => ['#', __('admin.name'), __('admin.email'), __('admin.phone')],
            'values' => ['id', 'name', 'email', 'full_phone']
        ];
    }

    public function Country(): array
    {
        return [
            'cols' => ['#', __('admin.name'), __('admin.key')],
            'values' => ['id', 'name', 'key'],
        ];
    }

    public function Admin(): array
    {
        return [
            'cols' => ['#', __('admin.name'), __('admin.email'), __('admin.phone')],
            'values' => ['id', 'name', 'email', 'full_phone'],
        ];
    }

    public function masterExport($model, $cols, $values, $modelPath = null, $request = [])
    {
        $folderName = strtolower(Str::plural(class_basename($model)));

        // Resolve model class path
        if ($modelPath) {
            // If modelPath is provided but doesn't contain namespace, prepend App\Models\
            if (!str_contains($modelPath, '\\')) {
                $model = "App\Models\\$modelPath";
            } else {
                $model = $modelPath;
            }
        } else {
            $model = "App\Models\\$model";
        }

        $model = app($model);
        $conditions = $request['conditions'] ?? [];
        foreach ($conditions as $key => $value) {
            if ($value === 'null') {
                $conditions[$key] = null;
            }
        }

        // Detect relationships from values array and eager load them
        $relationsToLoad = [];
        foreach ($values as $value) {
            if (str_contains($value, '.')) {
                $parts = explode('.', $value);
                // Get the relationship name (first part before the dot)
                $relationName = $parts[0];
                if (!in_array($relationName, $relationsToLoad)) {
                    $relationsToLoad[] = $relationName;
                }
            }
        }

        $modelClass = get_class($model);
        $query = $model::latest()->when(isset($request['searchArray']), function ($query) use ($request, $modelClass) {
            if (method_exists($modelClass, 'scopeSearch'))
                $query->search($request['searchArray']);
        })->where($conditions);

        // Eager load relationships if needed
        if (!empty($relationsToLoad)) {
            $query->with($relationsToLoad);
        }

        $records = $query->get();
        return Excel::download(new MasterExport($records, 'master-excel', ['cols' => $cols, 'values' => $values]), $folderName . '-reports-' . Carbon::now()->format('Y-m-d') . '.xlsx');
    }
}
