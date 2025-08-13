<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiwayatAntrianResource\Pages;
use App\Models\RiwayatAntrian;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Filters\DateFilter;
use Filament\Tables\Table;

class RiwayatAntrianResource extends Resource
{
    protected static ?string $model = RiwayatAntrian::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Riwayat Antrian';
    protected static ?string $navigationGroup = 'BackupData';

    public static function form(Forms\Form $form): Forms\Form
    {
        // Biasanya riwayat tidak perlu diubah, jadi form bisa dikosongkan
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_antrian')->label('No Antrian')->sortable(),
                Tables\Columns\TextColumn::make('no_rme')->label('No RME'),
                Tables\Columns\TextColumn::make('nama_pasien')->label('Nama Pasien')->sortable(),
                Tables\Columns\TextColumn::make('alamat_pasien')->label('Alamat Pasien')->limit(20),
                Tables\Columns\TextColumn::make('status')->label('Status'),
                Tables\Columns\TextColumn::make('tanggal')->label('Tanggal')->dateTime('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('tanggal_reset')->label('Tanggal Reset')->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('tanggal')->label('Tanggal Antrian'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['tanggal'], fn($q, $tanggal) => $q->whereDate('tanggal', $tanggal));
                    }),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(), // Bisa hapus data riwayat satu per satu
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(), // Bisa hapus beberapa sekaligus
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiwayatAntrians::route('/'),
        ];
    }
}
