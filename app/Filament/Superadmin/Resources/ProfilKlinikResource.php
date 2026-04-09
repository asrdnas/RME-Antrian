<?php

namespace App\Filament\Superadmin\Resources;

use App\Filament\Superadmin\Resources\ProfilKlinikResource\Pages;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\SettingInfo;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;

class ProfilKlinikResource extends Resource
{
    protected static ?string $model = SettingInfo::class;

    protected static ?string $navigationLabel = 'Profil Klinik';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Hero Klinik')
                    ->schema([
                        TextInput::make('judul_klinik1')
                            ->label('Judul Klinik Baris 1')
                            ->required(),

                        TextInput::make('judul_highlight1')
                            ->label('Highlight Baris 1')
                            ->required(),

                        TextInput::make('judul_klinik2')
                            ->label('Judul Klinik Baris 2')
                            ->required(),

                        TextInput::make('judul_highlight2')
                            ->label('Highlight Baris 2')
                            ->required(),

                        TextArea::make('deskripsi_klinik')
                            ->label('Deskripsi Klinik')
                            ->rows(4)
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Founder')
                    ->schema([
                        FileUpload::make('foto_founder')
                            ->label('Foto Founder')
                            ->image()
                            ->directory('founder')
                            ->disk('public')
                            ->imagePreviewHeight('150'),

                        TextInput::make('nama_founder')
                            ->label('Nama Founder')
                            ->required(),

                        TextInput::make('jabatan_founder')
                            ->label('Jabatan Founder')
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Kontak')
                    ->schema([
                        TextInput::make('nomor_whatsapp')
                            ->label('Nomor WhatsApp')
                            ->required(),
                    ]),

                Section::make('Lokasi Klinik')
                    ->schema([
                        TextArea::make('alamat')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->required(),

                        TextInput::make('hari_operasional')
                            ->label('Hari Operasional')
                            ->required(),

                        TextInput::make('jam_operasional')
                            ->label('Jam Operasional')
                            ->required(),

                        RichEditor::make('embed_maps')
                            ->label('Embed Google Maps')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto_founder')
                    ->label('Foto')
                    ->circular()
                    ->size(60),

                Tables\Columns\TextColumn::make('judul_klinik1')
                    ->label('Judul')
                    ->searchable()
                    ->limit(20),

                Tables\Columns\TextColumn::make('nama_founder')
                    ->label('Founder')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nomor_whatsapp')
                    ->label('WhatsApp'),

                Tables\Columns\TextColumn::make('jam_operasional')
                    ->label('Jam Operasional'),
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
            'index' => Pages\ListProfilKliniks::route('/'),
            'create' => Pages\CreateProfilKlinik::route('/create'),
            'edit' => Pages\EditProfilKlinik::route('/{record}/edit'),
        ];
    }
}
