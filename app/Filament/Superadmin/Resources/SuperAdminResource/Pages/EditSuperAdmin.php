<?php

namespace App\Filament\Superadmin\Resources\SuperAdminResource\Pages;

use App\Filament\Superadmin\Resources\SuperAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditSuperAdmin extends EditRecord
{
    protected static string $resource = SuperAdminResource::class;

   protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Admin berhasil diedit')
            ->success()
            ->send();
    }
}
