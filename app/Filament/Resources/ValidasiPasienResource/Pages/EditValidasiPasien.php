<?php

namespace App\Filament\Resources\ValidasiPasienResource\Pages;

use App\Filament\Resources\ValidasiPasienResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditValidasiPasien extends EditRecord
{
    protected static string $resource = ValidasiPasienResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
