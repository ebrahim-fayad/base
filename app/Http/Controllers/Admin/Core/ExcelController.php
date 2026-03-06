<?php

namespace App\Http\Controllers\Admin\Core;

use App\Exports\MasterExport;
use App\Http\Controllers\Controller;
use App\Traits\Excel\ExportHelpersTrait;
use Illuminate\Http\Request;
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
     * Main export entry point
     */
    public function master(string $export, Request $request)
    {
        $methodName = class_basename($export);

        if (!method_exists($this, $methodName)) {
            throw new \BadMethodCallException("Export method {$methodName} does not exist.");
        }

        $config = $this->{$methodName}($request);

        return $this->masterExport(
            $export,
            $config['cols'],
            $config['values'],
            $export,
            $request->all(),
            $config['image_columns'] ?? []
        );
    }

    /* =========================
     |  Export Configurations
     |=========================*/

    public function User(): array
    {
        return [
            'cols' => ['#', __('admin.name'), __('admin.phone')],
            'values' => ['id', 'name', 'full_phone']
        ];
    }

    public function Provider(): array
    {
        return [
            'cols' => ['#', __('admin.name'), __('admin.email'), __('admin.phone'),],
            'values' => ['id', 'name', 'email', 'full_phone'],
            'with' => ['city']
        ];
    }

    public function Category(): array
    {
        return [
            'cols' => ['#', __('admin.name'), __('admin.followed_category'), __('admin.image')],
            'values' => ['id', 'name', 'parent.name', 'image'],
            'image_columns' => ['image' => \App\Models\Category::IMAGEPATH],
        ];
    }
    public function Service(): array
    {
        return [
            'cols' => ['#', __('admin.name')],
            'values' => ['id', 'name'],

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


    public function City(): array
    {
        return [
            'cols' => ['#', __('admin.name'), __('admin.country')],
            'values' => ['id', 'name', 'country.name'],
        ];
    }



    /* =========================
     |  Core Export Logic
     |=========================*/

    protected function masterExport(
        string $model,
        array $cols,
        array $values,
        ?string $modelPath = null,
        array $request = [],
        array $imageColumns = []
    ) {
        $modelClass = $this->resolveModel($model, $modelPath);

        $query = $modelClass::query()
            ->where($this->prepareConditions($request['conditions'] ?? []))
            ->when(
                isset($request['searchArray']) && method_exists($modelClass, 'scopeSearch'),
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
}
