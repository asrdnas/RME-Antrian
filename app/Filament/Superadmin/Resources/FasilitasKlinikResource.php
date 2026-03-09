<?php

namespace App\Filament\Superadmin\Resources;

use App\Filament\Superadmin\Resources\FasilitasKlinikResource\Pages;
use App\Filament\Superadmin\Resources\FasilitasKlinikResource\RelationManagers;
use App\Models\FasilitasKlinik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FasilitasKlinikResource extends Resource
{
    protected static ?string $model = FasilitasKlinik::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

   public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Forms\Components\Select::make('navbar_id')
                ->label('Slug Navbar')
                ->relationship('navbar', 'name')
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('nama')
                ->label('Nama Fasilitas')
                ->required(),

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
            'index' => Pages\ListFasilitasKliniks::route('/'),
            'create' => Pages\CreateFasilitasKlinik::route('/create'),
            'edit' => Pages\EditFasilitasKlinik::route('/{record}/edit'),
        ];
    }
}
