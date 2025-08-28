<?php

namespace App\Filament\TenagaMedis\Resources\RekamMedisResource\Pages;

use App\Filament\TenagaMedis\Resources\RekamMedisTenagaMedisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRekamMedis extends ListRecords
{
    protected static string $resource = RekamMedisTenagaMedisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
