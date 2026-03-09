<?php

namespace App\Filament\Superadmin\Resources\FasilitasKlinikResource\Pages;

use App\Filament\Superadmin\Resources\FasilitasKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateFasilitasKlinik extends CreateRecord
{
    protected static string $resource = FasilitasKlinikResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterSave(): void
    {
        Actions\Action::make('success')
            ->label('Berhasil ditambahkan')
            ->button()
            ->success()
            ->send();
    }
}
