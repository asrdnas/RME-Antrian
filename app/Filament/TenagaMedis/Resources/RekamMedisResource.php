<?php

namespace App\Filament\TenagaMedis\Resources;

use App\Filament\TenagaMedis\Resources\RekamMedisResource\Pages;
use App\Models\RekamMedis;
use App\Models\Pasien;
use App\Models\Admin;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class RekamMedisResource extends Resource
{
    protected static ?string $model = RekamMedis::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';
    protected static ?string $navigationLabel = 'Rekam Medis Gigi';
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Data berhasil disimpan')
            ->success()
            ->send();
    }

    protected function afterSave(): void
    {
    Notification::make()
        ->title('Data berhasil diperbarui')
        ->success()
        ->send();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('patient_id')
                    ->label('Nama Pasien')
                    ->options(
                        Patient::whereNotNull('nama_pasien')
            ->pluck('nama_pasien', 'id')
            ->toArray()
                    )
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('dokter_id')
                    ->label('Dokter')
                    ->relationship('dokter', 'name') // sesuaikan dengan field nama dokter di tabel tenaga_medis
                    ->searchable()
                    ->required(),

                    Forms\Components\Select::make('admin_id')
                    ->label('Admin')
                    ->options(Admin::pluck('name', 'id')) // ambil nama admin sesuai id
                    ->searchable() // biar bisa search
                    ->required(),

                    Forms\Components\DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->default(now()) // otomatis isi tanggal hari ini kalau mau
                    ->required(),

                Forms\Components\Textarea::make('keluhan')
                    ->label('Keluhan Utama')
                    ->rows(3)
                    ->required(),

                Forms\Components\Textarea::make('diagnosis')
                    ->label('Diagnosis')
                    ->rows(3)
                    ->required(),

                Forms\Components\Select::make('tindakan')
                    ->label('Tindakan Medis')
                    ->options([
                        'Tambal Gigi' => 'Tambal Gigi',
                        'Cabut Gigi' => 'Cabut Gigi',
                        'Scaling' => 'Scaling',
                        'Pembersihan Karang Gigi' => 'Pembersihan Karang Gigi',
                        'Pemasangan Behel' => 'Pemasangan Behel',
                        'Perawatan Saluran Akar' => 'Perawatan Saluran Akar',
                        'Pembuatan Gigi Palsu' => 'Pembuatan Gigi Palsu',
                    ])
                    ->required(),

                Forms\Components\Textarea::make('resep')
                    ->label('Resep / Obat')
                    ->rows(2),

                Forms\Components\Textarea::make('catatan')
                    ->label('Catatan Tambahan')
                    ->rows(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pasien.nama')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_kunjungan')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('diagnosis')
                    ->label('Diagnosis')
                    ->limit(30),

                Tables\Columns\TextColumn::make('tindakan')
                    ->label('Tindakan'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime(),

                Tables\Columns\TextColumn::make('dokter.name')
                    ->label('Nama Dokter')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRekamMedis::route('/'),
            'create' => Pages\CreateRekamMedis::route('/create'),
            'edit' => Pages\EditRekamMedis::route('/{record}/edit'),
        ];
    }


}
