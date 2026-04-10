<?php

namespace App\Filament\Superadmin\Resources\PengumumanKlinikResource\Pages;

use App\Filament\Superadmin\Resources\PengumumanKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditPengumumanKlinik extends EditRecord
{
    protected static string $resource = PengumumanKlinikResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterSave(): void
    {
        Notification::make()
            ->title('Berhasil diedit')
            ->success()
            ->send();
    }
}
