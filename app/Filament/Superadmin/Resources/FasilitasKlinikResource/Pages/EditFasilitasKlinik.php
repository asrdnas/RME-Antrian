<?php

namespace App\Filament\Superadmin\Resources\FasilitasKlinikResource\Pages;

use App\Filament\Superadmin\Resources\FasilitasKlinikResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditFasilitasKlinik extends EditRecord
{
    protected static string $resource = FasilitasKlinikResource::class;

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
