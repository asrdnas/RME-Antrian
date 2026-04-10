<?php

namespace App\Filament\Superadmin\Resources\PengumumanKlinikResource\Pages;

use App\Filament\Superadmin\Resources\PengumumanKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreatePengumumanKlinik extends CreateRecord
{
    protected static string $resource = PengumumanKlinikResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Berhasil dibuat')
            ->success()
            ->send();
    }
}
