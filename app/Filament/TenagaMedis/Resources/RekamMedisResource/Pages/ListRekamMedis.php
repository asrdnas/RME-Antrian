<?php

namespace App\Filament\TenagaMedis\Resources\RekamMedisResource\Pages;

use App\Filament\TenagaMedis\Resources\RekamMedisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRekamMedis extends ListRecords
{
    protected static string $resource = RekamMedisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
