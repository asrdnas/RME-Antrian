<?php

namespace App\Filament\Superadmin\Resources\ProfilKlinikResource\Pages;

use App\Filament\Superadmin\Resources\ProfilKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateProfilKlinik extends CreateRecord
{
    protected static string $resource = ProfilKlinikResource::class;
     protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterSave(): void
    {
        Notification::make()
            ->title('Berhasil ditambahkan')
            ->success()
            ->send();
    }
}
