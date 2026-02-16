<?php

namespace App\Filament\Superadmin\Resources\JadwalDokterResource\Pages;

use App\Filament\Superadmin\Resources\JadwalDokterResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJadwalDokter extends CreateRecord
{
    protected static string $resource = JadwalDokterResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Jadwal berhasil ditambahkan')
            ->success()
            ->send();
    }
}
