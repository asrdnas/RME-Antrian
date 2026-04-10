<?php

namespace App\Filament\Superadmin\Resources;

use App\Filament\Superadmin\Resources\PengumumanKlinikResource\Pages;
use App\Filament\Superadmin\Resources\PengumumanKlinikResource\RelationManagers;
use App\Models\PengumumanKlinik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengumumanKlinikResource extends Resource
{
    protected static ?string $model = PengumumanKlinik::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Management Pengumuman Klinik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
            ->schema([
                Forms\Components\FileUpload::make('gambar')
                    ->disk('public')
                    ->directory('pengumuman-gambar')
                    ->image()
                    ->columnSpan(2)
                    ->required(),
                Forms\Components\Select::make('navbar_id')
                    ->label('Navbar')
                    ->relationship('navbar', 'name')
                    ->required(),

                Forms\Components\DatePicker::make('tanggal')
                    ->default(now())
                    ->required(),

                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
                Forms\Components\RichEditor::make('deskripsi')
                    ->required()
                    ->columnSpan(2),

            ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Gambar'),

                Tables\Columns\TextColumn::make('navbar.name')
                    ->label('Slug Navbar'),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50),
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
            'index' => Pages\ListPengumumanKliniks::route('/'),
            'create' => Pages\CreatePengumumanKlinik::route('/create'),
            'edit' => Pages\EditPengumumanKlinik::route('/{record}/edit'),
        ];
    }
}
