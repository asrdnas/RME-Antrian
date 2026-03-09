<?php

namespace App\Filament\Superadmin\Resources\LayananKlinikResource\Pages;

use App\Filament\Superadmin\Resources\LayananKlinikResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditLayananKlinik extends EditRecord
{
    protected static string $resource = LayananKlinikResource::class;

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
