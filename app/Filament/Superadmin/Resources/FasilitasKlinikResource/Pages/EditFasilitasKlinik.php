<?php

namespace App\Filament\Superadmin\Resources\FasilitasKlinikResource\Pages;

use App\Filament\Superadmin\Resources\FasilitasKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditFasilitasKlinik extends EditRecord
{
    protected static string $resource = FasilitasKlinikResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterSave(): void
    {
        Actions\Action::make()
            ->label('Berhasil diedit')
            ->success()
            ->send();
    }
}
