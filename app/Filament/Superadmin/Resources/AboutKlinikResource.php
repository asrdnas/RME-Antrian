<?php

namespace App\Filament\Superadmin\Resources;

use App\Filament\Superadmin\Resources\AboutKlinikResource\Pages;
use App\Filament\Superadmin\Resources\AboutKlinikResource\RelationManagers;
use App\Models\AboutKlinik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutKlinikResource extends Resource
{
    protected static ?string $model = AboutKlinik::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('badge')
                ->label('Badge')
                ->required(),

            Forms\Components\TextInput::make('title')
                ->label('Title')
                ->required(),

            Forms\Components\TextInput::make('highlight')
                ->label('Highlight')
                ->required(),

            Forms\Components\Textarea::make('description')
                ->label('Deskripsi')
                ->rows(4)
                ->required(),

            Forms\Components\FileUpload::make('image')
                ->label('Gambar')
                ->image()
                ->directory('about'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

            Tables\Columns\TextColumn::make('badge')
                ->label('Badge')
                ->searchable(),

            Tables\Columns\TextColumn::make('title')
                ->label('Title')
                ->searchable(),

            Tables\Columns\ImageColumn::make('image')
                ->label('Gambar'),
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
            'index' => Pages\ListAboutKliniks::route('/'),
            'create' => Pages\CreateAboutKlinik::route('/create'),
            'edit' => Pages\EditAboutKlinik::route('/{record}/edit'),
        ];
    }
}
