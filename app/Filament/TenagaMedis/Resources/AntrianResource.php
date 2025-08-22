<?php

namespace App\Filament\TenagaMedis\Resources;

use App\Filament\TenagaMedis\Resources\AntrianResource\Pages;
use App\Filament\TenagaMedis\Resources\AntrianResource\RelationManagers;
use App\Models\Antrian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;

class AntrianResource extends Resource
{
    protected static ?string $model = Antrian::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationLabel = 'Antrian';

    protected static ?string $pluralModelLabel = 'List Antrian Pasien';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->recordUrl(null) // <- ini bikin row tidak bisa diklik
        ->poll('3s')
        ->striped() // zebra row biar lebih enak dilihat
        ->columns([
            Tables\Columns\TextColumn::make('no_antrian')
                ->label('No Antrian')
                ->sortable()
                ->weight('bold')
                ->color('primary'),

            Tables\Columns\TextColumn::make('patient.no_rme')
                ->label('No RME')
                ->color('info'),

            Tables\Columns\TextColumn::make('patient.nama_pasien')
                ->label('Nama Pasien')
                ->sortable()
                ->searchable()
                ->weight('medium'),

            Tables\Columns\TextColumn::make('patient.alamat_pasien')
                ->label('Alamat Pasien')
                ->limit(20)
                ->tooltip(fn ($record) => $record->patient->alamat_pasien),

            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->icon(fn ($state) => match ($state) {
                    'menunggu'  => 'heroicon-o-clock',
                    'dipanggil' => 'heroicon-o-megaphone',
                    'selesai'   => 'heroicon-o-check-circle',
                    default     => 'heroicon-o-minus-circle',
                })
                ->colors([
                    'warning' => 'menunggu',
                    'info'    => 'dipanggil',
                    'success' => 'selesai',
                ]),

            Tables\Columns\TextColumn::make('tanggal')
                ->label('Tanggal')
                ->dateTime('d/m/Y H:i')
                ->color('gray'),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'menunggu'  => 'Menunggu',
                    'dipanggil' => 'Dipanggil',
                    'selesai'   => 'Selesai',
                ]),
        ])
        ->actions([
            Tables\Actions\Action::make('panggilPasien')
                ->label('Panggil Pasien')
                ->icon('heroicon-o-megaphone')
                ->color('warning')
                ->visible(fn($record) => $record->status === 'menunggu')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->update(['status' => 'dipanggil']);
                    Notification::make()
                        ->title('Pasien ' . $record->patient->nama_pasien . ' dipanggil.')
                        ->success()
                        ->send();
                }),

            Tables\Actions\Action::make('tandaiSelesai')
                ->label('Tandai Selesai')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn($record) => $record->status === 'dipanggil')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->update(['status' => 'selesai']);
                    Notification::make()
                        ->title('Pasien ' . $record->patient->nama_pasien . ' ditandai selesai.')
                        ->success()
                        ->send();
                }),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ])
        ->recordClasses(fn ($record) => match ($record->status) {
            'menunggu'  => 'bg-yellow-950/20 hover:bg-yellow-950/40',
            'dipanggil' => 'bg-blue-950/20 hover:bg-blue-950/40',
            'selesai'   => 'bg-green-950/20 hover:bg-green-950/40',
            default     => 'hover:bg-gray-800/50',
        });
}


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAntrians::route('/'),
            'create' => Pages\CreateAntrian::route('/create'),
            'edit' => Pages\EditAntrian::route('/{record}/edit'),
        ];
    }
}
