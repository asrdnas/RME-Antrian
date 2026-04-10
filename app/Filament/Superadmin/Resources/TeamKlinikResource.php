<?php

namespace App\Filament\Superadmin\Resources;

use App\Filament\Superadmin\Resources\TeamKlinikResource\Pages;
use App\Filament\Superadmin\Resources\TeamKlinikResource\RelationManagers;
use App\Models\TeamKlinik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamKlinikResource extends Resource
{
    protected static ?string $model = TeamKlinik::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->label('Gambar')
                    ->image()
                    ->directory('team-klinik')
                    ->required(),
                Forms\Components\TextInput::make('hero_title')
                    ->label('Judul Hero')
                    ->required(),
                Forms\Components\Textarea::make('hero_description')
                    ->label('Deskripsi Hero')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi Lengkap')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Gambar'),
                Tables\Columns\TextColumn::make('hero_title')->label('Judul Hero'),
                Tables\Columns\TextColumn::make('hero_description')->label('Deskripsi Hero')->limit(50),
                Tables\Columns\TextColumn::make('description')->label('Deskripsi Lengkap')->limit(50),
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
            'index' => Pages\ListTeamKliniks::route('/'),
            'create' => Pages\CreateTeamKlinik::route('/create'),
            'edit' => Pages\EditTeamKlinik::route('/{record}/edit'),
        ];
    }
}
