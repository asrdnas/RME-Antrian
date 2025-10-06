<?php

namespace App\Filament\Superadmin\Resources\TenagaMedisResource\Pages;

use App\Filament\Superadmin\Resources\TenagaMedisResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateTenagaMedis extends CreateRecord
{
    protected static string $resource = TenagaMedisResource::class;
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Tenaga Medis berhasil ditambahkan!')
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
