<?php

namespace App\Filament\Superadmin\Resources\StatsKlinikResource\Pages;

use App\Filament\Superadmin\Resources\StatsKlinikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditStatsKlinik extends EditRecord
{
    protected static string $resource = StatsKlinikResource::class;

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
