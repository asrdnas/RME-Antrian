<?php

namespace App\Filament\Resources\RekamMedisResource\Pages;

use App\Filament\Resources\RekamMedisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditRekamMedis extends EditRecord
{
    protected static string $resource = RekamMedisResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Rekam Medis berhasil diedit')
            ->success()
            ->send();
    }
}
