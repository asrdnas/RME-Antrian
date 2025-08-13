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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            ->columns([
                Tables\Columns\TextColumn::make('no_antrian')->label('No Antrian')->sortable(),
                Tables\Columns\TextColumn::make('patient.no_rme')->label('No RME'),
                Tables\Columns\TextColumn::make('patient.nama_pasien')->label('Nama Pasien')->sortable(),
                Tables\Columns\TextColumn::make('patient.alamat_pasien')->label('Alamat Pasien')->limit(20),
                Tables\Columns\TextColumn::make('status')->label('Status'),
                Tables\Columns\TextColumn::make('tanggal')->label('Tanggal')->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'dipanggil' => 'Dipanggil',
                        'selesai' => 'Selesai',
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
            ]);
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
