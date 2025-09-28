<?php

namespace App\Filament\TenagaMedis\Pages;

use Filament\Pages\Page;

class DashboardTenagaMedis extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.tenaga-medis.pages.dashboard-tenaga-medis';
    protected static ?string $title = 'Statistik Antrian';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $slug = 'dashboard-tenaga-medis';

    public static function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatistikAntrian::class,
            \App\Filament\Widgets\TrenAntrianBulanan::class,
        ];
    }
}
