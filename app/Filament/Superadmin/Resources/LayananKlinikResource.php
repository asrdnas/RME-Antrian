<?php

namespace App\Filament\Superadmin\Resources;

use App\Filament\Superadmin\Resources\LayananKlinikResource\Pages;
use App\Models\LayananKlinik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LayananKlinikResource extends Resource
{
    protected static ?string $model = LayananKlinik::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('navbar_id')
                    ->label('Slug Navbar')
                    ->relationship('navbar', 'name')
                    ->required(),

                Forms\Components\TextInput::make('nama')
                    ->label('Nama Layanan')
                    ->required(),

                Forms\Components\TextInput::make('tag')
                    ->label('Tag Layanan'),

                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->rows(4)
                    ->required(),

                Forms\Components\FileUpload::make('gambar')
                    ->label('Gambar')
                    ->image()
                    ->directory('layanan')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Gambar'),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Layanan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('navbar.name')
                    ->label('Slug Navbar'),

                Tables\Columns\ToggleColumn::make('is_featured')
                    ->label('Tampil di Home'),

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
            'index' => Pages\ListLayananKliniks::route('/'),
            'create' => Pages\CreateLayananKlinik::route('/create'),
            'edit' => Pages\EditLayananKlinik::route('/{record}/edit'),
        ];
    }
}
