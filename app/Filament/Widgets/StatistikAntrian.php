<?php

namespace App\Filament\Widgets;

use App\Models\RiwayatAntrian;
use Filament\Widgets\BarChartWidget;


class StatistikAntrian extends BarChartWidget
{
    protected static ?string $heading = 'Statistik Antrian';

    protected function getFilters(): ?array
    {
        return [
            'semua' => 'Semua',
            'hari'   => 'Harian',
            'minggu' => 'Mingguan',
            'bulan'  => 'Bulanan',
        ];
    }

    protected function getData(): array
    {
        $filter = $this->filter ?? 'semua';

        // Label periode
        $today = now()->format('d M Y');
        $startWeek = now()->startOfWeek()->format('d M');
        $endWeek = now()->endOfWeek()->format('d M Y');
        $startMonth = now()->startOfMonth()->format('d M');
        $endMonth = now()->endOfMonth()->format('d M Y');

        // Helper query
        $query = function ($pelayanan, $periode) {
            $q = RiwayatAntrian::query()->where('pelayanan', $pelayanan);

            if ($periode === 'hari') {
                $q->whereDate('tanggal', today());
            } elseif ($periode === 'minggu') {
                $q->whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($periode === 'bulan') {
                $q->whereBetween('tanggal', [now()->startOfMonth(), now()->endOfMonth()]);
            }

            return $q->count();
        };

        $datasets = [];
        $labels = [];

        if ($filter === 'semua') {
            // === UMUM ===
            $umumHarian = $query('Umum', 'hari');
            $umumMingguan = $query('Umum', 'minggu');
            $umumBulanan = $query('Umum', 'bulan');

            // === GILUT ===
            $gilutHarian = $query('Gilut', 'hari');
            $gilutMingguan = $query('Gilut', 'minggu');
            $gilutBulanan = $query('Gilut', 'bulan');

            $datasets = [
                [
                    'label' => 'Umum',
                    'data' => [$umumHarian, $umumMingguan, $umumBulanan],
                    'backgroundColor' => '#3b82f6',
                ],
                [
                    'label' => 'Gilut',
                    'data' => [$gilutHarian, $gilutMingguan, $gilutBulanan],
                    'backgroundColor' => '#10b981',
                ],
            ];

            $labels = [
                "Harian ($today)",
                "Mingguan ($startWeek - $endWeek)",
                "Bulanan ($startMonth - $endMonth)",
            ];
        } else {
            $umum = $query('Umum', $filter);
            $gilut = $query('Gilut', $filter);

            $label = match ($filter) {
                'hari'   => "Hari ini ($today)",
                'minggu' => "Minggu ini ($startWeek - $endWeek)",
                'bulan'  => "Bulan ini ($startMonth - $endMonth)",
            };

            $datasets = [
                [
                    'label' => 'Umum',
                    'data' => [$umum],
                    'backgroundColor' => '#3b82f6',
                ],
                [
                    'label' => 'Gilut',
                    'data' => [$gilut],
                    'backgroundColor' => '#10b981',
                ],
            ];

            $labels = [$label];
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }
}
