<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class MasterExport implements FromView, ShouldAutoSize, WithHeadings, WithEvents
{
    private $records;
    private $cols;
    private $values;
    private $view;
    private $options;

    public function __construct($records, $view = 'master-excel', $options = [])
    {
        $this->records = $records;
        $this->view = $view;
        $this->options = $options;
        $this->cols = $this->inArray('cols', []);
        $this->values = $this->inArray('values', []);
    }

    /**
     * @param $key
     * @param $array
     * @param $value
     * @return mixed
     */
    public function inArray($key, $value)
    {
        $return = array_key_exists($key, $this->options) ? $this->options[$key] : $value;
        return $return;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->setRightToLeft(app()->getLocale() == 'ar');

                $this->applyCenterAlignment($sheet);
                $this->addImageDrawings($event);
            },
        ];
    }

    protected function applyCenterAlignment($sheet): void
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        if ($highestRow < 1 || !$highestColumn) {
            return;
        }
        $range = 'A1:' . $highestColumn . $highestRow;
        $sheet->getStyle($range)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
    }

    protected function addImageDrawings(AfterSheet $event): void
    {
        $imageColumns = $this->inArray('image_columns', []);
        if (empty($imageColumns)) {
            return;
        }

        $sheet = $event->sheet->getDelegate();
        $rowHeight = 45;
        $colWidthChars = 7;
        $imageWidth = 36;
        $imageHeight = 38;
        $cellWidthPx = (int) ($colWidthChars * 7);
        $cellHeightPx = (int) ($rowHeight * 1.33);
        $offsetX = (int) max(2, ($cellWidthPx - $imageWidth) / 2);
        $offsetY = (int) max(2, ($cellHeightPx - $imageHeight) / 2);

        foreach ($this->records as $index => $record) {
            $excelRow = $index + 2; // Row 1 = header
            $sheet->getRowDimension($excelRow)->setRowHeight($rowHeight);

            foreach ($imageColumns as $valueKey => $imagePath) {
                $colIndex = array_search($valueKey, $this->values);
                if ($colIndex === false) {
                    continue;
                }

                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
                $sheet->getColumnDimension($colLetter)->setWidth($colWidthChars);

                $imageUrl = data_get($record, $valueKey);
                $drawing = $this->createDrawing($imageUrl, $record, $imagePath, $valueKey);
                if ($drawing) {
                    $drawing->setCoordinates($colLetter . $excelRow);
                    $drawing->setWidth($imageWidth);
                    $drawing->setHeight($imageHeight);
                    $drawing->setOffsetX($offsetX);
                    $drawing->setOffsetY($offsetY);
                    $drawing->setWorksheet($sheet);
                }
            }
        }
    }

    protected function createDrawing(?string $imageUrl, $record, ?string $imagePath, string $valueKey)
    {
        $localPath = $this->resolveLocalPath($record, $imagePath, $valueKey);
        if ($localPath && file_exists($localPath)) {
            $drawing = new Drawing();
            $drawing->setPath($localPath);
            $drawing->setName('Image-' . ($record->id ?? $record->getKey()));
            return $drawing;
        }

        if ($imageUrl && is_string($imageUrl) && (str_starts_with($imageUrl, 'http://') || str_starts_with($imageUrl, 'https://'))) {
            try {
                $imageContent = @file_get_contents($imageUrl);
                if ($imageContent === false) {
                    return null;
                }
                $imageResource = @imagecreatefromstring($imageContent);
                if ($imageResource === false) {
                    return null;
                }
                $drawing = new MemoryDrawing();
                $drawing->setImageResource($imageResource);
                $drawing->setName('Image-' . ($record->id ?? $record->getKey()));
                return $drawing;
            } catch (\Throwable) {
                return null;
            }
        }

        return null;
    }

    protected function resolveLocalPath($record, ?string $imagePath, string $valueKey): ?string
    {
        if (!method_exists($record, 'getRawOriginal')) {
            return null;
        }
        $filename = $record->getRawOriginal($valueKey);
        if (empty($filename) || in_array($filename, ['default.png', 'default.webp'], true)) {
            return null;
        }
        $path = $imagePath ?? (defined(get_class($record) . '::IMAGEPATH') ? $record::IMAGEPATH : 'images');
        $relativePath = 'images/' . $path . '/' . $filename;

        // Try storage path first (Laravel default)
        $storagePath = storage_path('app/public/' . $relativePath);
        if (file_exists($storagePath)) {
            return $storagePath;
        }

        // Fallback: public/storage (when storage:link is used)
        $publicPath = public_path('storage/' . $relativePath);
        return file_exists($publicPath) ? $publicPath : null;
    }

    public function view(): View
    {
        return view('admin.export.' . $this->view, [
            'records' => $this->records,
            'cols' => $this->cols,
            'values' => $this->values,
            'image_columns' => $this->inArray('image_columns', []),
        ]);
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        // TODO: Implement collection() method.
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // TODO: Implement headings() method.
    }
}
