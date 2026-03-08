<?php

namespace App\Filament\Superadmin\Resources\AboutKlinikResource\Pages;

use App\Filament\Superadmin\Resources\AboutKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAboutKliniks extends ListRecords
{
    protected static string $resource = AboutKlinikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
