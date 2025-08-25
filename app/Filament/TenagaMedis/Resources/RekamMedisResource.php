<?php

namespace App\Filament\TenagaMedis\Resources;

use App\Filament\TenagaMedis\Resources\RekamMedisResource\Pages;
use App\Models\RekamMedis;
use App\Models\Patient;
use App\Models\Admin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Filament\Tables\Actions\ActionGroup;

class RekamMedisResource extends Resource
{
    protected static ?string $model = RekamMedis::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';
    protected static ?string $navigationLabel = 'Rekam Medis';

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
        return $form->schema([
            // ===== Identitas Pasien =====
            Forms\Components\Fieldset::make('Identitas Pasien')
                ->schema([
Forms\Components\TextInput::make('no_rme')
    ->label('No. RME')
    ->prefixIcon('heroicon-o-identification')
    ->reactive()
    ->afterStateUpdated(function ($state, callable $set) {
        $patient = Patient::where('no_rme', $state)->first();

        if ($patient) {
            $set('patient_id', $patient->id);
            $set('nama_pasien', $patient->nama_pasien);

            // Ambil antrian terakhir pasien
            $antrian = \App\Models\Antrian::where('patient_id', $patient->id)
                ->latest()
                ->first();

            if ($antrian) {
                $set('waktu_kedatangan', optional($antrian->created_at)->format('H:i'));
                $set('waktu_mulai', $antrian->waktu_mulai ? Carbon::parse($antrian->waktu_mulai)->format('H:i') : null);
                $set('waktu_selesai', $antrian->waktu_selesai ? Carbon::parse($antrian->waktu_selesai)->format('H:i') : null);
            } else {
                $set('waktu_kedatangan', null);
                $set('waktu_mulai', null);
                $set('waktu_selesai', null);
            }

            // Total kunjungan dihitung dari rekam medis
            $totalKunjungan = RekamMedis::where('patient_id', $patient->id)->count();
            $set('total_kunjungan', $totalKunjungan);

        } else {
            $set('patient_id', null);
            $set('nama_pasien', '');
            $set('waktu_kedatangan', null);
            $set('waktu_mulai', null);
            $set('waktu_selesai', null);
            $set('total_kunjungan', null);
        }
    })
    ->required(),



                    Forms\Components\Placeholder::make('total_kunjungan')
                        ->label('Total Kunjungan')
                        ->content(fn($get) => $get('total_kunjungan') ?? '-'),

                    Forms\Components\Hidden::make('patient_id')->required(),

                    Forms\Components\TextInput::make('nama_pasien')
                        ->label('Nama Pasien')
                        ->prefixIcon('heroicon-o-user-circle')
                        ->disabled()
                        ->dehydrated(false),

                    // Auto set ID sesuai panel
                    Forms\Components\Hidden::make('dokter_id')
                        ->default(fn() => Filament::getCurrentPanel()->getId() === 'tenaga-medis' ? Auth::id() : null),

                    Forms\Components\Hidden::make('admin_id')
                        ->default(fn() => Filament::getCurrentPanel()->getId() === 'admin' ? Auth::id() : null),

                    // Dokter name (readonly untuk tenaga-medis)
                    Forms\Components\TextInput::make('dokter_name')
                        ->label('Dokter')
                        ->prefixIcon('heroicon-o-user')
                        ->default(fn() => Filament::getCurrentPanel()->getId() === 'tenaga-medis' ? Auth::user()->name : null)
                        ->disabled()
                        ->visible(fn() => Filament::getCurrentPanel()->getId() === 'tenaga-medis'),

                    // Dropdown dokter (untuk admin)
                    Forms\Components\Select::make('dokter_id')
                        ->label('Dokter')
                        ->prefixIcon('heroicon-o-user')
                        ->relationship('dokter', 'name')
                        ->searchable()
                        ->placeholder('Pilih Dokter...')
                        ->visible(fn() => Filament::getCurrentPanel()->getId() === 'admin'),
                ])
                ->columns(3)
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
                                ->reactive()
                                ->disabled()
                                ->dehydrated(false),

                            Forms\Components\TimePicker::make('waktu_mulai')
                                ->label('Mulai')
                                ->prefixIcon('heroicon-o-play')
                                ->reactive()
                                ->disabled()
                                ->dehydrated(false),

                            Forms\Components\TimePicker::make('waktu_selesai')
                                ->label('Selesai')
                                ->prefixIcon('heroicon-o-stop')
                                ->reactive()
                                ->disabled()
                                ->dehydrated(false),

                        ]),
                ])
                ->extraAttributes([
                    'style' => 'background-color:#1e1e1e; border:1px solid #2e2e2e; border-radius:8px; padding:15px;'
                ]),


            // Pemeriksaan
            Forms\Components\Fieldset::make('Pemeriksaan')
                ->schema([
                    Forms\Components\Textarea::make('anamnesa')
                        ->label('📝 Anamnesa')
                        ->rows(3)
                        ->required(),

                    Forms\Components\Textarea::make('pemeriksaan')
                        ->label('👁 Pemeriksaan Fisik')
                        ->rows(3)
                        ->required(),

                    Forms\Components\Select::make('kesadaran')
                        ->label('Kesadaran')
                        ->prefixIcon('heroicon-o-light-bulb')
                        ->options([
                            'Sadar' => 'Sadar',
                            'Tidak Sadar' => 'Tidak Sadar',
                        ])
                        ->required(),
                ])
                ->extraAttributes([
                    'style' => 'background-color:#1e1e1e; border:1px solid #2e2e2e; border-radius:8px; padding:15px;'
                ]),

            // Tanda Vital
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
                            'Rawat Inap' => 'Rawat Inap',
                        ])
                        ->required(),

                    Forms\Components\TextInput::make('tenaga_medis')
                        ->label('Tenaga Medis')
                        ->prefixIcon('heroicon-o-user-group')
                        ->required(),

                    Forms\Components\Textarea::make('terapi')
                        ->label('💊 Terapi')
                        ->rows(3),

                    Forms\Components\Textarea::make('resep')
                        ->label('🧾 Resep / Obat')
                        ->rows(2),

                    Forms\Components\Fieldset::make('Diagnosa ICD-10')
                        ->schema([
                            Forms\Components\TextInput::make('kode_icd10')
                                ->label('Kode ICD-10')
                                ->prefixIcon('heroicon-o-hashtag'),

                            Forms\Components\TextInput::make('deskripsi_icd10')
                                ->label('Deskripsi Diagnosa')
                                ->prefixIcon('heroicon-o-document-text'),
                        ]),
                ])
                ->extraAttributes([
                    'style' => 'background-color:#1e1e1e; border:1px solid #2e2e2e; border-radius:8px; padding:15px;'
                ]),

            // Keterangan Tambahan
            Forms\Components\Fieldset::make('Keterangan Tambahan')
                ->schema([
                    Forms\Components\Textarea::make('catatan')
                        ->label('🗒 Catatan')
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
            ->columns([
                Tables\Columns\TextColumn::make('patient.no_rme')
                    ->label('NO RME')
                    // ->badge() // kasih badge
                    ->color('primary') // warna biru biar standout
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('patient.nama_pasien')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y') // format tanggal cantik
                    ->badge()
                    ->color('secondary')
                    ->sortable(),

                Tables\Columns\TextColumn::make('kode_icd10')
                    ->label('Kode ICD-10')
                    ->default('-')
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
                        'danger'  => 'Rawat Inap',
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
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->label('Aksi'), // label optional
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
