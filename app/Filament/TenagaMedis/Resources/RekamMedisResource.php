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
                    ->relationship('dokter', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('admin_id')
                    ->label('Admin')
                    ->options(Admin::pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->default(now())
                    ->required(),

                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TimePicker::make('waktu_kedatangan')
                        ->label('Waktu Kedatangan')
                        ->default(now()->format('H:i')) // ✅ default supaya tidak error
                        ->required(),

                    Forms\Components\TimePicker::make('waktu_mulai')
                        ->label('Waktu Mulai Pemeriksaan')
                        ->required(),

                    Forms\Components\TimePicker::make('waktu_selesai')
                        ->label('Waktu Selesai Pemeriksaan')
                        ->required(),
                ]),

                Forms\Components\Textarea::make('anamnesa')
                    ->label('Anamnesa')
                    ->rows(3)
                    ->required(),

                Forms\Components\Textarea::make('pemeriksaan')
                    ->label('Pemeriksaan')
                    ->rows(3)
                    ->required(),

                Forms\Components\Select::make('kesadaran')
                    ->label('Kesadaran')
                    ->options([
                        'Sadar' => 'Sadar',
                        'Tidak Sadar' => 'Tidak Sadar',
                    ])
                    ->required(),

                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('tinggi_badan')
                        ->label('Tinggi Badan')
                        ->numeric()
                        ->suffix('cm'),

                    Forms\Components\TextInput::make('berat_badan')
                        ->label('Berat Badan')
                        ->numeric()
                        ->suffix('kg'),

                    Forms\Components\TextInput::make('sistole')
                        ->label('Sistole')
                        ->numeric()
                        ->suffix('mmHg'),

                    Forms\Components\TextInput::make('diastole') // ✅ perbaiki typo
                        ->label('Diastole')
                        ->numeric()
                        ->suffix('mmHg'),
                ]),

                Forms\Components\Textarea::make('resep')
                    ->label('Resep / Obat')
                    ->rows(2),

                Forms\Components\Textarea::make('catatan')
                    ->label('Catatan Tambahan')
                    ->rows(2),

                Forms\Components\TextInput::make('respiratory_rate')
                    ->label('Respiratory Rate (RR)')
                    ->numeric()
                    ->suffix('x/menit')
                    ->required(),

                Forms\Components\TextInput::make('heart_rate')
                    ->label('Heart Rate (HR)')
                    ->numeric()
                    ->suffix('bpm')
                    ->required(),

                Forms\Components\TextInput::make('tenaga_medis')
                    ->label('Tenaga Medis')
                    ->required(),

                Forms\Components\Select::make('status_pulang')
                    ->label('Status Pulang')
                    ->options([
                        'Pulang' => 'Pulang',
                        'Rujuk' => 'Rujuk',
                        'Rawat Inap' => 'Rawat Inap',
                    ])
                    ->required(),

                Forms\Components\Textarea::make('terapi')
                    ->label('Terapi')
                    ->rows(3),

                Forms\Components\Select::make('kasus_lama_baru')
                    ->label('Kasus Lama/Baru')
                    ->options([
                        'Lama' => 'Lama',
                        'Baru' => 'Baru',
                    ])
                    ->required(),

                Forms\Components\Fieldset::make('Diagnosa ICD-10')
                    ->schema([
                        Forms\Components\TextInput::make('kode_icd10')
                            ->label('Kode ICD-10')
                            ->nullable(), // ✅ tidak wajib jika mau
                        Forms\Components\TextInput::make('deskripsi_icd10')
                            ->label('Deskripsi Diagnosa')
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.nama_pasien')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kode_icd10')
                    ->label('Kode ICD-10')
                    ->default('-') // ✅ jika null
                    ->searchable(),

                Tables\Columns\TextColumn::make('deskripsi_icd10')
                    ->label('Diagnosa')
                    ->default('-')
                    ->limit(50)
                    ->tooltip(fn($record) => $record->deskripsi_icd10),

                Tables\Columns\TextColumn::make('tenaga_medis')
                    ->label('Tenaga Medis')
                    ->searchable(),

                Tables\Columns\TextColumn::make('dokter.name')
                    ->label('Nama Dokter')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('status_pulang')
                    ->label('Status Pulang')
                    ->badge()
                    ->colors([
                        'success' => 'Pulang',
                        'warning' => 'Rujuk',
                        'danger' => 'Rawat Inap',
                    ]),
            ])
            ->filters([
                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q, $date) => $q->whereDate('tanggal', '>=', $date))
                            ->when($data['until'], fn($q, $date) => $q->whereDate('tanggal', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
