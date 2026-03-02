<?php

namespace App\Filament\Superadmin\Resources\NavbarResource\Pages;

use App\Filament\Superadmin\Resources\NavbarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNavbar extends EditRecord
{
    protected static string $resource = NavbarResource::class;

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
