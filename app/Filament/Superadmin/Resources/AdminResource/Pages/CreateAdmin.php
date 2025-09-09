<?php

namespace App\Filament\Superadmin\Resources\AdminResource\Pages;

use App\Filament\Superadmin\Resources\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;
}
