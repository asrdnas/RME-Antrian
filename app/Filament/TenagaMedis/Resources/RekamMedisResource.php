<?php

namespace App\Filament\TenagaMedis\Resources;

use App\Filament\TenagaMedis\Resources\RekamMedisResource\Pages;
use App\Models\RekamMedis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RekamMedisTenagaMedisResource extends Resource
{
    protected static ?string $model = RekamMedis::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    // Label navigasi di sidebar
    protected static ?string $navigationLabel = 'Rekam Medis';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                // Patient Information section
                Forms\Components\Fieldset::make('Informasi Pasien')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('no_rme')
                                    ->label('No. RME')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->afterStateHydrated(
                                        fn($set, $record) =>
                                        $set('no_rme', $record?->patient?->no_rme)
                                    ),

                                Forms\Components\TextInput::make('nama_pasien')
                                    ->label('Nama Pasien')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->afterStateHydrated(
                                        fn($set, $record) =>
                                        $set('nama_pasien', $record?->patient?->nama_pasien)
                                    ),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('total_kunjungan')
                                    ->label('Total Kunjungan')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->afterStateHydrated(
                                        fn($set, $record) =>
                                        $set('total_kunjungan', $record?->patient?->total_kunjungan)
                                    ),
                                // Bidang untuk jenis pelayanan, dibuat disabled saat mengedit
                                Forms\Components\Select::make('pelayanan')
                                    ->label('Pelayanan')
                                    ->prefixIcon('heroicon-o-building-library')
                                    ->options([
                                        'Umum' => 'Umum',
                                        'Gilut' => 'Gilut',
                                    ])
                                    ->required(),
                            ]),

                        // Bidang select untuk nama dokter, dibuat disabled saat mengedit
                        Forms\Components\Select::make('dokter_id')
                            ->label('Nama Dokter')
                            ->prefixIcon('heroicon-o-user-circle')
                            ->relationship(name: 'dokter', titleAttribute: 'name')
                            ->searchable()
                            ->preload()

                            ->required(),
                    ])
                    ->extraAttributes([
                        'style' => 'background-color:#1e1e1e; border:1px solid #2e2e2e; border-radius:8px; padding:15px;'
                    ]),

                // Waktu & Tanggal
                Forms\Components\Fieldset::make('Waktu & Tanggal')
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->prefixIcon('heroicon-o-calendar')
                            ->default(now())
                            ->required(),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TimePicker::make('waktu_kedatangan')
                                    ->label('Kedatangan')
                                    ->prefixIcon('heroicon-o-clock')
                                    ->reactive(),

                                Forms\Components\TimePicker::make('waktu_mulai')
                                    ->label('Mulai')
                                    ->prefixIcon('heroicon-o-play')
                                    ->reactive(),

                                Forms\Components\TimePicker::make('waktu_selesai')
                                    ->label('Selesai')
                                    ->prefixIcon('heroicon-o-stop')
                                    ->reactive(),
                            ]),
                    ])
                    ->extraAttributes([
                        'style' => 'background-color:#1e1e1e; border:1px solid #2e2e2e; border-radius:8px; padding:15px;'
                    ]),

                // Pemeriksaan
                Forms\Components\Fieldset::make('Pemeriksaan')
                    ->schema([
                        Forms\Components\Textarea::make('anamnesa')
                            ->label('Anamnesa')
                            ->rows(3)
                            ->required(),

                        Forms\Components\Textarea::make('pemeriksaan')
                            ->label('Pemeriksaan Fisik')
                            ->rows(3)
                            ->required(),

                        Forms\Components\Select::make('kesadaran')
                            ->label('Kesadaran')
                            ->prefixIcon('heroicon-o-light-bulb')
                            ->options([
                                'Compos Mentis' => 'Compos Mentis',
                                'Apatis' => 'Apatis',
                                'Somnolen' => 'Somnolen',
                                'Sopor' => 'Sopor',
                                'Koma' => 'Koma',
                            ])
                            ->required(),
                    ])
                    ->extraAttributes([
                        'style' => 'background-color:#1e1e1e; border:1px solid #2e2e2e; border-radius:8px; padding:15px;'
                    ]),

                // Tanda Vital & Pengukuran
                Forms\Components\Fieldset::make('Tanda Vital & Pengukuran')
                    ->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('tinggi_badan')
                                ->label('Tinggi Badan')
                                ->prefixIcon('heroicon-o-arrow-up')
                                ->numeric()
                                ->suffix('cm'),

                            Forms\Components\TextInput::make('berat_badan')
                                ->label('Berat Badan')
                                ->prefixIcon('heroicon-o-scale')
                                ->numeric()
                                ->suffix('kg'),

                            Forms\Components\TextInput::make('sistole')
                                ->label('Sistole')
                                ->prefixIcon('heroicon-o-heart')
                                ->numeric()
                                ->suffix('mmHg'),

                            Forms\Components\TextInput::make('diastole')
                                ->label('Diastole')
                                ->prefixIcon('heroicon-o-heart')
                                ->numeric()
                                ->suffix('mmHg'),

                            Forms\Components\TextInput::make('respiratory_rate')
                                ->label('RR')
                                ->prefixIcon('heroicon-o-sparkles')
                                ->numeric()
                                ->suffix('x/menit')
                                ->required(),

                            Forms\Components\TextInput::make('heart_rate')
                                ->label('HR')
                                ->prefixIcon('heroicon-o-heart')
                                ->numeric()
                                ->suffix('bpm')
                                ->required(),
                        ]),
                    ])
                    ->extraAttributes([
                        'style' => 'background-color:#1e1e1e; border:1px solid #2e2e2e; border-radius:8px; padding:15px;'
                    ]),

                // Diagnosa & Terapi
                Forms\Components\Fieldset::make('Diagnosa & Terapi')
                    ->schema([
                        Forms\Components\Select::make('kasus_lama_baru')
                            ->label('Kasus')
                            ->prefixIcon('heroicon-o-clipboard')
                            ->options([
                                'Lama' => 'Lama',
                                'Baru' => 'Baru',
                            ])
                            ->required(),

                        Forms\Components\Select::make('status_pulang')
                            ->label('Status Pulang')
                            ->prefixIcon('heroicon-o-home')
                            ->options([
                                'Pulang' => 'Pulang',
                                'Rujuk' => 'Rujuk',
                                'Rawat Jalan' => 'Rawat Jalan',
                            ])
                            ->required(),

                        Forms\Components\Textarea::make('terapi')
                            ->label('Terapi')
                            ->rows(3),

                        Forms\Components\Textarea::make('resep')
                            ->label('Resep / Obat')
                            ->rows(2),

                            Forms\Components\Fieldset::make('Diagnosa ICD-10')
                            ->schema([
                        Forms\Components\TextInput::make('kode_icd10')
                            ->label('Kode ICD-10')
                            ->prefixIcon('heroicon-o-hashtag')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state) {
                                        $icd = \App\Models\IcdCode::where('code', $state)->first();
                                        if ($icd) {
                                            $set('deskripsi_icd10', $icd->description);
                                        } else {
                                            $set('deskripsi_icd10', 'Kode tidak ditemukan');
                                        }
                                    } else {
                                        $set('deskripsi_icd10', null);
                                    }
                                }),
                        Forms\Components\Textarea::make('deskripsi_icd10')
                            ->label('Deskripsi Diagnosa')
                            ->rows(3)
                            ->disabled(), // biar user tidak bisa ubah manual
                                ])
                                ->columns(2),
                    ])
                    ->extraAttributes([
                        'style' => 'background-color:#1e1e1e; border:1px solid #2e2e2e; border-radius:8px; padding:15px;'
                    ]),

                // Keterangan Tambahan
                Forms\Components\Fieldset::make('Keterangan Tambahan')
                    ->schema([
                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(2),
                    ])
                    ->extraAttributes([
                        'style' => 'background-color:#1e1e1e; border:1px solid #2e2e2e; border-radius:8px; padding:15px;'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->recordUrl(null) // <- ini bikin row tidak bisa diklik
        ->striped() // baris selang-seling warna
        ->columns([
            Tables\Columns\TextColumn::make('patient.no_rme')
                ->label('No RME')
                ->searchable()
                ->sortable()
                ->copyable()
                ->icon('heroicon-o-identification')
                ->iconColor('primary')
                ->alignCenter(),

                Tables\Columns\TextColumn::make('patient.nama_pasien')
                ->label('Nama Pasien')
                ->searchable()
                ->sortable()
                ->icon('heroicon-o-user-circle')
                ->iconColor('success')
                ->weight('bold') // nama jadi tebal
                ->wrap() // biar alamat panjang nggak kepotong
                ->tooltip(fn ($record) => $record->patient->alamat_pasien ?? '-')
                ->alignCenter(),

            Tables\Columns\TextColumn::make('patient.total_kunjungan')
                ->label('Total Kunjungan')
                ->sortable()
                ->badge()
                ->color(fn ($state) => $state > 5 ? 'success' : 'warning')
                ->icon('heroicon-o-chart-bar')
                ->alignCenter(),

            Tables\Columns\TextColumn::make('pelayanan')
                ->label('Pelayanan')
                ->badge()
                ->color('info')
                ->icon('heroicon-o-briefcase')
                ->alignCenter(),

            Tables\Columns\TextColumn::make('tanggal')
                ->label('Tanggal')
                ->dateTime('d/m/Y')
                ->sortable()
                ->icon('heroicon-o-calendar-days')
                ->iconColor('warning')
                ->alignCenter(),

            Tables\Columns\BadgeColumn::make('status_rekam_medis')
                ->label('Status')
                ->colors([
                    'danger' => 'pending',
                    'success' => 'approved',
                ])
                ->icons([
                    'heroicon-o-clock' => 'pending',
                    'heroicon-o-check-circle' => 'approved',
                ])
                ->formatStateUsing(fn($state) => ucfirst($state))
                ->alignCenter(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status_rekam_medis')
                ->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                ])
                ->label('Status Rekam Medis')
                ->native(false), // dropdown lebih modern

            Tables\Filters\Filter::make('tanggal')
                ->form([
                    Forms\Components\DatePicker::make('dari_tanggal')
                        ->placeholder('Dari Tanggal')
                        ->native(false),
                    Forms\Components\DatePicker::make('sampai_tanggal')
                        ->placeholder('Sampai Tanggal')
                        ->native(false),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['dari_tanggal'],
                            fn(Builder $query, $date): Builder => $query->whereDate('tanggal', '>=', $date),
                        )
                        ->when(
                            $data['sampai_tanggal'],
                            fn(Builder $query, $date): Builder => $query->whereDate('tanggal', '<=', $date),
                        );
                })
                ->label('Filter Tanggal'),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListRekamMedis::route('/'),
            'edit' => Pages\EditRekamMedis::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['patient']);
    }
}
