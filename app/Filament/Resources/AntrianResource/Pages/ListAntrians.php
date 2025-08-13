<?php

namespace App\Filament\Resources\AntrianResource\Pages;

use App\Filament\Resources\AntrianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAntrians extends ListRecords
{
    protected static string $resource = AntrianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Tombol Create seperti biasa
            Actions\CreateAction::make(),

            Actions\Action::make('riwayat')
            ->label('Riwayat Antrian')
            ->icon('heroicon-o-clock')
            ->url(fn () => url('/admin/riwayat-antrians')),
        ];
    }
}
