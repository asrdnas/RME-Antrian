<?php

namespace App\Filament\Resources\RiwayatAntrianResource\Pages;

use App\Filament\Resources\RiwayatAntrianResource;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatAntrians extends ListRecords
{
    protected static string $resource = RiwayatAntrianResource::class;

    // Tidak perlu header actions jika tidak ada create
    // protected function getHeaderActions(): array
    // {
    //     return [];
    // }
}
