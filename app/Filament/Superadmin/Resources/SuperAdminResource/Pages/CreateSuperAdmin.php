<?php

namespace App\Filament\Superadmin\Resources\SuperAdminResource\Pages;

use App\Filament\Superadmin\Resources\SuperAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateSuperAdmin extends CreateRecord
{
    protected static string $resource = SuperAdminResource::class;
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Admin berhasil ditambahkan!')
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
