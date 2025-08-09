<?php

namespace App\Filament\TenagaMedis\Resources\AntrianResource\Pages;

use App\Filament\TenagaMedis\Resources\AntrianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAntrian extends EditRecord
{
    protected static string $resource = AntrianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
