<?php

namespace App\Filament\Resources\AntrianResource\Pages;

use App\Filament\Resources\AntrianResource;
use Filament\Resources\Pages\EditRecord;

class EditAntrian extends EditRecord
{
    protected static string $resource = AntrianResource::class;

    // Tidak perlu field nik saat edit,
    // validasi antrian sudah diatur di CreateAntrian
}
