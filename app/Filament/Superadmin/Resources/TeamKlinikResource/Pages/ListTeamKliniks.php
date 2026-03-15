<?php

namespace App\Filament\Superadmin\Resources\TeamKlinikResource\Pages;

use App\Filament\Superadmin\Resources\TeamKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeamKliniks extends ListRecords
{
    protected static string $resource = TeamKlinikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
