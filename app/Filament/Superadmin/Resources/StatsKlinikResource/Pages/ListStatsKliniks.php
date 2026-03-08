<?php

namespace App\Filament\Superadmin\Resources\StatsKlinikResource\Pages;

use App\Filament\Superadmin\Resources\StatsKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatsKliniks extends ListRecords
{
    protected static string $resource = StatsKlinikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
