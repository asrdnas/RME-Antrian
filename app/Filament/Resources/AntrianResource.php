<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AntrianResource\Pages;
use App\Models\Antrian;
use App\Models\Patient;
use App\Models\RiwayatAntrian;
use App\Models\RekamMedis; // <-- Tambahkan model RekamMedis
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Filament\Facades\Filament;

class AntrianResource extends Resource
{
    protected static ?string $model = Antrian::class;
    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationLabel = 'Antrian';
    protected static ?string $navigationGroup = 'Manajemen Klinik';
    protected static ?string $pluralModelLabel = 'List Antrian Pasien';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nik')
                ->label('NIK Pasien')
                ->required()
                ->length(16)
                ->numeric()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, $get) {
                    $set('patient_id', null);
                    $set('nama_pasien', null);

                    if ($state && strlen($state) === 16) {
                        $patient = Patient::where('nik', $state)->first();
                        if ($patient) {
                            $set('patient_id', $patient->id);
                            $set('nama_pasien', $patient->nama_pasien);

                            $pelayanan = $get('pelayanan');
                            if ($pelayanan) {
                                $existing = Antrian::where('patient_id', $patient->id)
                                    ->where('pelayanan', $pelayanan)
                                    ->where('status', '!=', 'selesai')
                                    ->first();

                                if ($existing) {
                                    Notification::make()
                                        ->title('Pasien sudah ada di antrian untuk pelayanan ini!')
                                        ->danger()
                                        ->send();
                                    $set('patient_id', null);
                                    $set('nama_pasien', null);
                                } else {
                                    $ruanganMapping = [
                                        'Umum' => 'Cluster 3',
                                        'Gilut' => 'Cluster 4',
                                    ];
                                    $set('ruangan', $ruanganMapping[$pelayanan]);

                                    if (!$get('no_antrian')) {
                                        $set('no_antrian', self::generateNoAntrian($pelayanan));
                                    }
                                }
                            }
                        }
                    }
                })
                ->visible(fn($livewire) => $livewire instanceof Pages\CreateAntrian),

            Forms\Components\TextInput::make('nama_pasien')
                ->label('Nama Pasien')
                ->disabled()
                ->reactive()
                ->afterStateHydrated(function ($state, callable $set, $get) {
                    if (empty($state) && $get('patient_id')) {
                        $patient = Patient::find($get('patient_id'));
                        if ($patient)
                            $set('nama_pasien', $patient->nama_pasien);
                    }
                }),

            Forms\Components\Hidden::make('patient_id'),

            Forms\Components\Select::make('pelayanan')
                ->label('Pelayanan')
                ->options([
                    'Umum' => 'Umum',
                    'Gilut' => 'Gilut',
                ])
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, $get, $record) {
                    $patient_id = $get('patient_id');
                    if (!$patient_id) {
                        return;
                    }

                    $oldPelayanan = $record?->pelayanan;

                    $existing = Antrian::where('patient_id', $patient_id)
                        ->where('pelayanan', $state)
                        ->where('status', '!=', 'selesai')
                        ->where('id', '!=', $record?->id)
                        ->first();

                    if ($existing) {
                        Notification::make()
                            ->title('Pasien sudah ada di antrian untuk pelayanan ini!')
                            ->danger()
                            ->send();
                        $set('pelayanan', $oldPelayanan);
                        return;
                    }

                    $ruanganMapping = [
                        'Umum' => 'Cluster 3',
                        'Gilut' => 'Cluster 4',
                    ];
                    $set('ruangan', $ruanganMapping[$state] ?? null);

                    if ($record && $oldPelayanan && $oldPelayanan !== $state) {
                        $set('no_antrian', null);
                        self::renumberAntrian($oldPelayanan);
                    }

                    $newNumber = self::generateNoAntrian($state);
                    $set('no_antrian', $newNumber);
                }),

            Forms\Components\TextInput::make('no_antrian')
                ->label('Nomor Antrian')
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, $get) {
                    $pelayanan = $get('pelayanan');
                    $recordId = $get('record')->id ?? null;

                    if ($pelayanan && $state) {
                        $existing = Antrian::where('pelayanan', $pelayanan)
                            ->where('no_antrian', $state)
                            ->where('id', '!=', $recordId)
                            ->first();

                        if ($existing) {
                            Notification::make()
                                ->title('Nomor antrian sudah dipakai pasien lain!')
                                ->danger()
                                ->send();

                            if ($recordId) {
                                $set('no_antrian', $get('record')->no_antrian);
                            } else {
                                $set('no_antrian', self::generateNoAntrian($pelayanan));
                            }
                        }
                    }
                }),

            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'menunggu' => 'Menunggu',
                    'dipanggil' => 'Dipanggil',
                    'selesai' => 'Selesai',
                ])
                ->default('menunggu')
                ->required(),

            Forms\Components\DateTimePicker::make('tanggal')
                ->label('Tanggal Antrian')
                ->default(now())
                ->required(),

            Forms\Components\Hidden::make('ruangan'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->poll('5s')
            ->columns([
                Tables\Columns\TextColumn::make('no_antrian')->label('No Antrian')->alignCenter()->badge()->color('primary'),
                Tables\Columns\TextColumn::make('patient.no_rme')->label('No RME')->copyable()->icon('heroicon-o-identification')->color('info')->alignCenter(),
                Tables\Columns\TextColumn::make('patient.nama_pasien')->label('Nama Pasien')->sortable()->searchable()->weight('bold')->alignCenter(),
                Tables\Columns\TextColumn::make('patient.alamat_pasien')->label('Alamat Pasien')->limit(20)->tooltip(fn($record) => $record->patient->alamat_pasien)->alignCenter(),
                Tables\Columns\TextColumn::make('pelayanan')->label('Pelayanan')->badge()->color('info')->sortable()->alignCenter(),
                Tables\Columns\TextColumn::make('ruangan')->label('Ruangan')->badge()->color('success')->alignCenter(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'menunggu',
                        'info' => 'dipanggil',
                        'success' => 'selesai',
                    ])
                    ->icons([
                        'heroicon-o-clock' => 'menunggu',
                        'heroicon-o-megaphone' => 'dipanggil',
                        'heroicon-o-check-circle' => 'selesai',
                    ])
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('tanggal')->label('Tanggal')->dateTime('d/m/Y H:i')->sortable()->icon('heroicon-o-calendar')->alignCenter(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'menunggu' => 'Menunggu',
                    'dipanggil' => 'Dipanggil',
                    'selesai' => 'Selesai',
                ])->native(false),
                Tables\Filters\SelectFilter::make('pelayanan')->options([
                    'Umum' => 'Umum',
                    'Gilut' => 'Gilut',
                ])->native(false),
            ])
            ->headerActions([
                Tables\Actions\Action::make('resetAntrian')
                    ->label('Reset & Backup Antrian')
                    ->icon('heroicon-o-archive-box')
                    ->color('success')
                    ->outlined()
                    ->button()
                    ->requiresConfirmation()
                    ->disabled(fn() => Antrian::where('status', '!=', 'selesai')->exists())
                    ->tooltip(fn() => Antrian::where('status', '!=', 'selesai')->exists() ? 'Tidak bisa reset, ada pasien yang belum selesai' : null)
                    ->action(function () {
                        $now = Carbon::now();

                        // Ambil semua antrian sampai hari ini
                        $antrians = Antrian::whereDate('tanggal', '<=', today())
                            ->with('patient')
                            ->get();

                        foreach ($antrians as $antrian) {
                            if ($antrian->patient) {
                                RiwayatAntrian::create([
                                    'no_antrian' => $antrian->no_antrian,
                                    'no_rme' => $antrian->patient->no_rme,
                                    'nama_pasien' => $antrian->patient->nama_pasien,
                                    'alamat_pasien' => $antrian->patient->alamat_pasien,
                                    'pelayanan' => $antrian->pelayanan,
                                    'ruangan' => $antrian->ruangan,
                                    'status' => $antrian->status,
                                    'tanggal' => $antrian->created_at,
                                    'tanggal_reset' => $now,
                                    'waktu_mulai' => $antrian->waktu_mulai,
                                    'waktu_selesai' => $antrian->waktu_selesai,
                                ]);
                            }
                        }

                        // Hapus semua antrian sampai hari ini
                        Antrian::whereDate('tanggal', '<=', today())->delete();

                        Notification::make()
                            ->title('Semua antrian (hari ini & sebelumnya) berhasil di-backup dan di-reset.')
                            ->success()
                            ->send();
                    }),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('panggilPasien')
                    ->label('Panggil')
                    ->icon('heroicon-o-megaphone')
                    ->color('warning')
                    ->outlined()
                    ->visible(fn($record) => $record->status === 'menunggu')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'dipanggil',
                            'waktu_mulai' => now(), // <-- Kolom 'waktu_mulai' diisi di sini
                        ]);
                    }),
                Tables\Actions\Action::make('tandaiSelesai')
                    ->label('Selesai')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->outlined()
                    ->visible(fn($record) => $record->status === 'dipanggil')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'selesai',
                            'waktu_selesai' => now(),
                        ]);

                        // --- LOGIKA BARU: BUAT REKAM MEDIS BARU ---
                        RekamMedis::create([
                            'tanggal' => $record->tanggal, // Mengambil tanggal dari antrian
                            'patient_id' => $record->patient_id,
                            'pelayanan' => $record->pelayanan,
                            'waktu_kedatangan' => $record->created_at, // Menggunakan created_at dari antrian
                            'waktu_mulai' => $record->waktu_mulai,
                            'waktu_selesai' => $record->waktu_selesai,
                            'status_rekam_medis' => 'pending',
                            'dokter_id' => null,
                        ]);

                        Notification::make()
                            ->title('Pasien telah selesai. Rekam medis baru telah dibuat.')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAntrians::route('/'),
            'create' => Pages\CreateAntrian::route('/create'),
            'edit' => Pages\EditAntrian::route('/{record}/edit'),
        ];
    }

    public static function generateNoAntrian(string $pelayanan): string
    {
        $prefix = $pelayanan === 'Gilut' ? 'KG-' : 'KU-';

        $last = Antrian::whereDate('tanggal', today())
            ->where('pelayanan', $pelayanan)
            ->where('status', '!=', 'selesai')
            ->orderBy('no_antrian', 'desc')
            ->value('no_antrian');

        $number = $last ? (int) substr($last, 1) + 1 : 1;
        return $prefix . str_pad($number, 2, '0', STR_PAD_LEFT);
    }

    public static function renumberAntrian(string $pelayanan)
    {
        $antrians = Antrian::where('pelayanan', $pelayanan)
            ->whereDate('tanggal', today())
            ->where('status', '!=', 'selesai')
            ->orderBy('no_antrian')
            ->get();

        $prefix = $pelayanan === 'Gilut' ? 'KG-' : 'KU-';
        $counter = 1;

        foreach ($antrians as $a) {
            $a->no_antrian = $prefix . str_pad($counter, 2, '0', STR_PAD_LEFT);
            $a->save();
            $counter++;
        }
    }
}
