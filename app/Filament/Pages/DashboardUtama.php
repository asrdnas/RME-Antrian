<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class DashboardUtama extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.dashboard-utama';
    protected static ?string $title = 'Statistik Antrian';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $slug = 'dashboard'; // ganti dashboard default

    public static function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatistikAntrian::class,
            \App\Filament\Widgets\TrenAntrianBulanan::class, // <--- Tambah ini
        ];
    }

}
