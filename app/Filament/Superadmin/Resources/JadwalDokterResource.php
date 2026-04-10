<?php

namespace App\Filament\Superadmin\Resources;

use App\Filament\Superadmin\Resources\JadwalDokterResource\Pages;
use App\Filament\Superadmin\Resources\JadwalDokterResource\RelationManagers;
use App\Models\JadwalDokter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JadwalDokterResource extends Resource
{
    protected static ?string $model = JadwalDokter::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Jadwal Dokter';
    protected static ?string $navigationGroup = 'Role Management Klinik';

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Select::make('tenaga_medis_id')
                ->label('Dokter')
                ->relationship('tenagaMedis', 'name')
                ->preload()
                ->required(),

            Forms\Components\Select::make('hari')
                ->label('Hari')
                ->options([
                    'Senin' => 'Senin',
                    'Selasa' => 'Selasa',
                    'Rabu' => 'Rabu',
                    'Kamis' => 'Kamis',
                    'Jumat' => 'Jumat',
                    'Sabtu' => 'Sabtu',
                    'Minggu' => 'Minggu',
                ])
                ->required(),

            Forms\Components\TimePicker::make('jam_mulai')
                ->label('Jam Mulai')
                ->required(),

            Forms\Components\TimePicker::make('jam_selesai')
                ->label('Jam Selesai')
                ->required(),

            Forms\Components\Toggle::make('is_active')
                ->label('Status Aktif')
                ->default(true),
        ]);
}


public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('tenagaMedis.name')
                ->label('Nama Dokter')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('hari')
                ->label('Hari')
                ->sortable(),

            Tables\Columns\TextColumn::make('jam_mulai')
                ->label('Mulai'),

            Tables\Columns\TextColumn::make('jam_selesai')
                ->label('Selesai'),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('tenaga_medis_id')
                ->label('Dokter')
                ->relationship('tenagaMedis', 'name'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
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
            'index' => Pages\ListJadwalDokters::route('/'),
            'create' => Pages\CreateJadwalDokter::route('/create'),
            'edit' => Pages\EditJadwalDokter::route('/{record}/edit'),
        ];
    }
}
