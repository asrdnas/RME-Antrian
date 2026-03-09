<?php

namespace App\Filament\Superadmin\Resources;

use App\Filament\Superadmin\Resources\StatsKlinikResource\Pages;
use App\Filament\Superadmin\Resources\StatsKlinikResource\RelationManagers;
use App\Models\StatsKlinik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatsKlinikResource extends Resource
{
    protected static ?string $model = StatsKlinik::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
           ->schema([
            Forms\Components\TextInput::make('icon')
                ->label('Icon FontAwesome')
                ->placeholder('fas fa-user-md')
                ->required()
                ->maxLength(255)
                ->helperText('Contoh: fas fa-user-md, fas fa-tooth'),

            Forms\Components\TextInput::make('title')
                ->label('Judul / Angka')
                ->placeholder('3+')
                ->required()
                ->maxLength(100),

            Forms\Components\TextInput::make('description')
                ->label('Deskripsi')
                ->placeholder('Dokter Umum')
                ->required()
                ->maxLength(255),

            Forms\Components\Toggle::make('highlight')
                ->label('Highlight Card')
                ->helperText('Aktifkan jika ingin card ditampilkan berbeda (contoh BPJS)')
                ->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
           ->columns([
            Tables\Columns\TextColumn::make('icon')
                ->label('Icon')
                ->searchable(),

            Tables\Columns\TextColumn::make('title')
                ->label('Judul')
                ->searchable(),

            Tables\Columns\TextColumn::make('description')
                ->label('Deskripsi')
                ->searchable(),

            Tables\Columns\ToggleColumn::make('highlight')
                ->label('Highlight'),
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListStatsKliniks::route('/'),
            'create' => Pages\CreateStatsKlinik::route('/create'),
            'edit' => Pages\EditStatsKlinik::route('/{record}/edit'),
        ];
    }
}
