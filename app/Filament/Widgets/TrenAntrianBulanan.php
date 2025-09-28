<?php

namespace App\Filament\Widgets;

use App\Models\RiwayatAntrian;
use Filament\Widgets\LineChartWidget;

class TrenAntrianBulanan extends LineChartWidget
{
    protected static ?string $heading = 'Tren Antrian Bulanan';

    protected function getData(): array
    {
        $start = now()->startOfMonth();
        $end   = now()->endOfMonth();

        $dates = [];
        $current = $start->copy();
        while ($current <= $end) {
            $dates[] = $current->format('Y-m-d');
            $current->addDay();
        }

        $umumData = [];
        foreach ($dates as $date) {
            $umumData[] = RiwayatAntrian::where('pelayanan', 'Umum')
                ->whereDate('tanggal', $date)->count();
        }

        $gilutData = [];
        foreach ($dates as $date) {
            $gilutData[] = RiwayatAntrian::where('pelayanan', 'Gilut')
                ->whereDate('tanggal', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Umum',
                    'data' => $umumData,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.3)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Gilut',
                    'data' => $gilutData,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.3)',
                    'tension' => 0.4,
                ],
            ],
            'labels' => collect($dates)->map(fn($d) => date('d M', strtotime($d)))->toArray(),
        ];
    }
}
