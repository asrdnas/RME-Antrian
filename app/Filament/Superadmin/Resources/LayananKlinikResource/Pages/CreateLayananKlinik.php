<?php

namespace App\Filament\Superadmin\Resources\LayananKlinikResource\Pages;

use App\Filament\Superadmin\Resources\LayananKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateLayananKlinik extends CreateRecord
{
    protected static string $resource = LayananKlinikResource::class;
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
