<?php

namespace App\Filament\Superadmin\Resources\AboutKlinikResource\Pages;

use App\Filament\Superadmin\Resources\AboutKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateAboutKlinik extends CreateRecord
{
    protected static string $resource = AboutKlinikResource::class;
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
