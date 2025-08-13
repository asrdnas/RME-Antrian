<?php

namespace App\Filament\Resources\RiwayatAntrianResource\Pages;

use App\Filament\Resources\RiwayatAntrianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatAntrian extends EditRecord
{
    protected static string $resource = RiwayatAntrianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
