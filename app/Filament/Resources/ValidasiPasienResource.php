<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ValidasiPasienResource\Pages;
use App\Models\Patient;
use App\Models\Antrian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class ValidasiPasienResource extends Resource
{
    protected static ?string $model = Patient::class;
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationLabel = 'Validasi Pasien';
    protected static ?string $navigationGroup = 'Manajemen Klinik';

    public static function table(Table $table): Table
    {
        return $table
            ->poll('5s')
            ->query(
                Patient::query()->where('status_validasi', 'pending')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama_pasien')
                    ->label('Nama Pasien')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_rme')
                    ->label('No RME'),
                Tables\Columns\TextColumn::make('alamat_pasien')
                    ->label('Alamat')
                    ->limit(30),
                Tables\Columns\BadgeColumn::make('status_validasi')
                    ->label('Status Validasi')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
            ])
            ->filters([
                SelectFilter::make('status_validasi')
                    ->label('Filter Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending'),
            ])
            ->actions([
                Action::make('validasi')
                    ->label('Validasi')
                    ->color('success')
                    ->visible(fn($record) => $record->status_validasi === 'pending')
                    ->icon('heroicon-o-check')
                    ->form([
                        Forms\Components\Select::make('pelayanan')
                            ->label('Pilih Pelayanan')
                            ->options([
                                'Umum' => 'Umum',
                                'Gilut' => 'Gilut',
                            ])
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        // Update status validasi
                        $record->status_validasi = 'approved';
                        $record->save();

                        // Buat antrian baru
                        Antrian::create([
                            'patient_id' => $record->id,
                            'pelayanan' => $data['pelayanan'],
                            'ruangan' => $data['pelayanan'] === 'Gilut' ? 'Cluster 4' : 'Cluster 3',
                            'no_antrian' => AntrianResource::generateNoAntrian($data['pelayanan']),
                            'status' => 'menunggu',
                            'tanggal' => now(),
                        ]);

                        Notification::make()
                            ->title('Pasien berhasil divalidasi dan masuk antrian')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form->schema(self::getFormSchema());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListValidasiPasiens::route('/'),
        ];
    }

    // Catatan: Fungsi ini sudah dipindahkan ke AntrianResource
    public static function generateNoAntrian(string $pelayanan)
    {
        $count = Antrian::whereDate('tanggal', today())
            ->where('pelayanan', $pelayanan)
            ->count() + 1;
        $prefix = $pelayanan === 'Gilut' ? 'KG' : 'KU';
        return $prefix . str_pad($count, 2, '0', STR_PAD_LEFT);
    }

    private static function getFormSchema(): array
    {
        return [
            // Memanggil metode statis dari model Patient
            Forms\Components\Hidden::make('no_rme')
                ->default(fn() => Patient::generateNoRme()),

            Forms\Components\Section::make('Data Pribadi Pasien')->schema([
                Forms\Components\TextInput::make('nama_pasien')
                    ->label('Nama Lengkap')
                    ->required()
                    ->afterStateUpdated(fn($state, callable $set) => $set('nama_pasien', strtoupper($state))),
                Forms\Components\TextInput::make('nik')
                    ->label('Nomor KTP')
                    ->required()
                    ->numeric()
                    ->length(16)
                    ->unique(Patient::class, 'nik'),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->required()
                    ->afterStateUpdated(fn($state, callable $set) => $set('tempat_lahir', strtoupper($state))),
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->required(),
                Forms\Components\Radio::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'laki-laki' => 'Laki-laki',
                        'perempuan' => 'Perempuan',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('alamat_pasien')
                    ->label('Alamat')
                    ->required(),
                Forms\Components\TextInput::make('no_tlp_pasien')
                    ->label('Nomor Telepon')
                    ->numeric(),
                Forms\Components\TextInput::make('agama_pasien')
                    ->label('Agama'),
                Forms\Components\Radio::make('status_perkawinan_pasien')
                    ->label('Status Perkawinan')
                    ->options([
                        'menikah' => 'Menikah',
                        'belum_menikah' => 'Belum Menikah',
                        'janda' => 'Janda',
                        'duda' => 'Duda',
                    ]),
                Forms\Components\Radio::make('pekerjaan_pasien')
                    ->label('Pekerjaan')
                    ->options([
                        'pns' => 'PNS',
                        'tni' => 'TNI',
                        'polisi' => 'Polisi',
                        'bumn' => 'BUMN',
                        'bumd' => 'BUMD',
                        'karyawan_swasta' => 'Karyawan Swasta',
                        'petani' => 'Petani',
                        'pedagang' => 'Pedagang',
                        'lain-lain' => 'Lain-lain',
                    ])
                    ->reactive(),
                Forms\Components\TextInput::make('pekerjaan_pasien_lain')
                    ->label('Pekerjaan Lainnya')
                    ->visible(fn($get) => $get('pekerjaan_pasien') === 'lain-lain'),
                Forms\Components\Radio::make('pendidikan_pasien')
                    ->label('Pendidikan')
                    ->options([
                        'tidak_lulus' => 'Tidak Lulus',
                        'sd' => 'SD',
                        'smp' => 'SMP',
                        'sma' => 'SMA',
                        'slta' => 'SLTA',
                        's1' => 'Sarjana S1',
                        's2' => 'S2',
                        's3' => 'S3',
                        'lain-lain' => 'Lain-lain',
                    ])
                    ->reactive(),
                Forms\Components\TextInput::make('pendidikan_pasien_lain')
                    ->label('Pendidikan Lainnya')
                    ->visible(fn($get) => $get('pendidikan_pasien') === 'lain-lain'),
            ])->columns(2),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        // Hitung pasien dengan status pending
        $count = Patient::where('status_validasi', 'pending')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger'; // bisa 'primary', 'success', 'warning', 'danger'
    }

}
