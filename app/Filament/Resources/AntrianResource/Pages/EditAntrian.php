<?php

namespace App\Filament\Resources\AntrianResource\Pages;

use App\Filament\Resources\AntrianResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditAntrian extends EditRecord
{
    protected static string $resource = AntrianResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Antrian berhasil diedit')
            ->success()
            ->send();
    }
}