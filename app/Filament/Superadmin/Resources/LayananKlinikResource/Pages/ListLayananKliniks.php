<?php

namespace App\Filament\Superadmin\Resources\LayananKlinikResource\Pages;

use App\Filament\Superadmin\Resources\LayananKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLayananKliniks extends ListRecords
{
    protected static string $resource = LayananKlinikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
