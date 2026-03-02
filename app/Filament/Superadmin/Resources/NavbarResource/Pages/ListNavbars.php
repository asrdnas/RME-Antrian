<?php

namespace App\Filament\Superadmin\Resources\NavbarResource\Pages;

use App\Filament\Superadmin\Resources\NavbarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNavbars extends ListRecords
{
    protected static string $resource = NavbarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
