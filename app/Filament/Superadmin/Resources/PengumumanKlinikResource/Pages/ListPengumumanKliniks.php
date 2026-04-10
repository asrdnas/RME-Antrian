<?php

namespace App\Filament\Superadmin\Resources\PengumumanKlinikResource\Pages;

use App\Filament\Superadmin\Resources\PengumumanKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengumumanKliniks extends ListRecords
{
    protected static string $resource = PengumumanKlinikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
