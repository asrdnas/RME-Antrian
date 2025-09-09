<?php

namespace App\Filament\Superadmin\Resources\TenagaMedisResource\Pages;

use App\Filament\Superadmin\Resources\TenagaMedisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTenagaMedis extends EditRecord
{
    protected static string $resource = TenagaMedisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
