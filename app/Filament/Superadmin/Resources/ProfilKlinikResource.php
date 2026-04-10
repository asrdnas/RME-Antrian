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
use Filament\Forms\Components\Textarea; // Perbaikan penulisan 'a' kecil
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;

class ProfilKlinikResource extends Resource
{
    protected static ?string $model = SettingInfo::class;

    protected static ?string $navigationLabel = 'Profil Klinik';

    protected static ?string $navigationGroup = 'Management Profil Klinik';

    protected static ?string $navigationIcon = 'heroicon-o-home-modern'; // Icon lebih relevan untuk profil klinik

    protected static ?string $pluralModelLabel = 'Profil Klinik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Hero Klinik')
                    ->description('Pengaturan tampilan utama (Hero Section) pada website.')
                    ->schema([
                        TextInput::make('judul_klinik1')
                            ->label('Judul Klinik Baris 1')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('judul_highlight1')
                            ->label('Highlight Baris 1')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('judul_klinik2')
                            ->label('Judul Klinik Baris 2')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('judul_highlight2')
                            ->label('Highlight Baris 2')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('deskripsi_klinik')
                            ->label('Deskripsi Klinik')
                            ->rows(4)
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Founder')
                    ->description('Informasi mengenai pendiri klinik.')
                    ->schema([
                        FileUpload::make('foto_founder')
                            ->label('Foto Founder')
                            ->image()
                            ->directory('founder')
                            ->disk('public')
                            ->imagePreviewHeight('150')
                            ->columnSpanFull(),

                        TextInput::make('nama_founder')
                            ->label('Nama Founder')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('jabatan_founder')
                            ->label('Jabatan Founder')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Kontak & Operasional')
                    ->schema([
                        TextInput::make('nomor_whatsapp')
                            ->label('Nomor WhatsApp')
                            ->tel() // Menggunakan tipe tel untuk input nomor telepon
                            ->placeholder('Contoh: 08123456789')
                            ->required(),

                        TextInput::make('hari_operasional')
                            ->label('Hari Operasional')
                            ->placeholder('Contoh: Senin - Sabtu')
                            ->required(),

                        TextInput::make('jam_operasional')
                            ->label('Jam Operasional')
                            ->placeholder('Contoh: 08:00 - 21:00')
                            ->required(),
                    ])
                    ->columns(3),

                Section::make('Lokasi Klinik')
                    ->schema([
                        Textarea::make('alamat')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),

                        Textarea::make('embed_maps') // Menggunakan Textarea agar tag <iframe> tidak terfilter
                            ->label('Embed Google Maps (Iframe)')
                            ->placeholder('<iframe src="..."></iframe>')
                            ->helperText('Tempelkan kode iframe dari Google Maps di sini.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto_founder')
                    ->label('Foto')
                    ->circular(),

                Tables\Columns\TextColumn::make('judul_klinik1')
                    ->label('Judul')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('nama_founder')
                    ->label('Founder')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nomor_whatsapp')
                    ->label('WhatsApp')
                    ->copyable(), // Fitur klik untuk copy nomor

                Tables\Columns\TextColumn::make('jam_operasional')
                    ->label('Jam Operasional')
                    ->badge() // Memberikan tampilan badge agar lebih menarik
                    ->color('success'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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