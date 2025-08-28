<?php

namespace App\Filament\TenagaMedis\Resources\RekamMedisResource\Pages;

use App\Filament\TenagaMedis\Resources\RekamMedisTenagaMedisResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRekamMedis extends CreateRecord
{
    protected static string $resource = RekamMedisResource::class;

    protected function getRedirectUrl(): string
    {
        // Balik ke list Rekam Medis
        return $this->getResource()::getUrl('index');
    }
}
