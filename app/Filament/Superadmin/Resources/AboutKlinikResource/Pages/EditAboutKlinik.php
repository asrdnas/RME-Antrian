<?php

namespace App\Filament\Superadmin\Resources\AboutKlinikResource\Pages;

use App\Filament\Superadmin\Resources\AboutKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditAboutKlinik extends EditRecord
{
    protected static string $resource = AboutKlinikResource::class;
protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterSave(): void
    {
        Notification::make()
            ->title('Berhasil diperbarui')
            ->success()
            ->send();
    }
}
