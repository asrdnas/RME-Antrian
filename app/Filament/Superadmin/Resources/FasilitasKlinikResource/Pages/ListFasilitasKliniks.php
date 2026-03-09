<?php

namespace App\Filament\Superadmin\Resources\FasilitasKlinikResource\Pages;

use App\Filament\Superadmin\Resources\FasilitasKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFasilitasKliniks extends ListRecords
{
    protected static string $resource = FasilitasKlinikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
