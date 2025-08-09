<?php

namespace App\Filament\TenagaMedis\Resources\AntrianResource\Pages;

use App\Filament\TenagaMedis\Resources\AntrianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAntrians extends ListRecords
{
    protected static string $resource = AntrianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
