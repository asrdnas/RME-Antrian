<?php

namespace App\Filament\Superadmin\Resources\ProfilKlinikResource\Pages;

use App\Filament\Superadmin\Resources\ProfilKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfilKliniks extends ListRecords
{
    protected static string $resource = ProfilKlinikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
