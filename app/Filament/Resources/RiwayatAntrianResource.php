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

    protected static ?string $pluralModelLabel = 'Daftar Riwayat Antrian';

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
                Tables\Columns\TextColumn::make('no_antrian')
                    ->label('No Antrian')
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('no_rme')
                    ->label('No RME')
                    ->icon('heroicon-o-identification')
                    ->copyable()
                    ->copyMessage('No RME berhasil disalin')
                    ->color('info'),

                Tables\Columns\TextColumn::make('nama_pasien')
                    ->label('Nama Pasien')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->icon('heroicon-o-user'),

                Tables\Columns\TextColumn::make('alamat_pasien')
                    ->label('Alamat Pasien')
                    ->limit(20)
                    ->tooltip(fn($record) => $record->alamat_pasien)
                    ->icon('heroicon-o-map-pin'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'menunggu',
                        'info'    => 'dipanggil',
                        'success' => 'selesai',
                    ])
                    ->icons([
                        'heroicon-o-clock'        => 'menunggu',
                        'heroicon-o-megaphone'    => 'dipanggil',
                        'heroicon-o-check-circle' => 'selesai',
                    ])
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->icon('heroicon-o-calendar')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('tanggal_reset')
                    ->label('Tanggal Reset')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->icon('heroicon-o-arrow-path')
                    ->alignCenter(),
            ])
            ->filters([
                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal Antrian'),
                    ])
                    ->query(fn($query, array $data) =>
                        $query->when(
                            $data['tanggal'],
                            fn($q, $tanggal) => $q->whereDate('tanggal', $tanggal)
                        )
                    ),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->color('danger'),
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
