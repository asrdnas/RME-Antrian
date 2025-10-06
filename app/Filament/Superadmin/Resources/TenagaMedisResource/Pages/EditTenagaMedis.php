<?php

namespace App\Filament\Superadmin\Resources\TenagaMedisResource\Pages;

use App\Filament\Superadmin\Resources\TenagaMedisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditTenagaMedis extends EditRecord
{
    protected static string $resource = TenagaMedisResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Tenaga Medis berhasil diedit')
            ->success()
            ->send();
    }
}
