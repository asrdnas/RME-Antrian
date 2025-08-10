<?php

namespace App\Filament\TenagaMedis\Resources\PasienResource\Pages;

use App\Filament\TenagaMedis\Resources\PasienResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPasiens extends ListRecords
{
    protected static string $resource = PasienResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
