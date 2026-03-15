<?php

namespace App\Filament\Superadmin\Resources\TeamKlinikResource\Pages;

use App\Filament\Superadmin\Resources\TeamKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateTeamKlinik extends CreateRecord
{
    protected static string $resource = TeamKlinikResource::class;
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
