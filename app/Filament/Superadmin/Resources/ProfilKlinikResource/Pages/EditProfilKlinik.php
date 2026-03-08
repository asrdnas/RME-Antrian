<?php

namespace App\Filament\Superadmin\Resources\ProfilKlinikResource\Pages;

use App\Filament\Superadmin\Resources\ProfilKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditProfilKlinik extends EditRecord
{
    protected static string $resource = ProfilKlinikResource::class;
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
