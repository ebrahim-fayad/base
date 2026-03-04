<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DashboardExport implements FromView, ShouldAutoSize, WithEvents
{
    public function __construct(
        private array $stats,
        private array $engagementStats,
        private array $subscriptionRatesByProgram,
    ) {}

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(app()->getLocale() == 'ar');
            },
        ];
    }

    public function view(): View
    {
        return view('admin.export.dashboard-excel', [
            'stats' => $this->stats,
            'engagementStats' => $this->engagementStats,
            'subscriptionRatesByProgram' => $this->subscriptionRatesByProgram,
        ]);
    }
}
