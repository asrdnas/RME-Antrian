<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ValidasiPasienResource\Pages;
use App\Models\Antrian;
use App\Models\Patient;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use App\Filament\Resources\AntrianResource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

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
                Tables\Columns\TextColumn::make('no_rme')
                    ->label('No RME'),

                Tables\Columns\TextColumn::make('nama_kk')
                    ->label('Nama Kepala Keluarga (KK)')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama_pasien')
                    ->label('Nama Pasien')
                    ->searchable(),

                Tables\Columns\TextColumn::make('umur')
                    ->label('Umur')
                    ->icon('heroicon-o-clock')
                    ->alignCenter()
                    ->getStateUsing(function ($record) {

                        if (! $record->tanggal_lahir) {
                            return '-';
                        }

                        $lahir = Carbon::parse($record->tanggal_lahir);
                        $diff = $lahir->diff(now());

                        return "{$diff->y} Th {$diff->m} Bln {$diff->d} Hr";
                    }),


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
                    ->icon('heroicon-o-check')
                    ->visible(fn ($record) => $record->status_validasi === 'pending')
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
                        $record->update([
                            'status_validasi' => 'approved',
                        ]);

                        // Buat antrian baru
                        Antrian::create([
                            'patient_id' => $record->id,
                            'pelayanan' => $data['pelayanan'],
                            'ruangan' => $data['pelayanan'] === 'Gilut'
                                ? 'Cluster 4'
                                : 'Cluster 3',
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

    private static function getFormSchema(): array
    {
        return [
            Forms\Components\Hidden::make('no_rme')
                ->default(fn () => Patient::generateNoRme()),

            Forms\Components\Section::make('Data Pribadi Pasien')
                ->schema([

                    Forms\Components\TextInput::make('nama_kk')
                        ->label('Nama Kepala Keluarga')
                        ->required(),

                    Forms\Components\TextInput::make('nama_pasien')
                        ->label('Nama Lengkap')
                        ->required()
                        ->afterStateUpdated(
                            fn ($state, callable $set) => $set('nama_pasien', strtoupper($state))
                        ),

                    Forms\Components\TextInput::make('tempat_lahir')
                        ->label('Tempat Lahir')
                        ->required()
                        ->afterStateUpdated(
                            fn ($state, callable $set) => $set('tempat_lahir', strtoupper($state))
                        ),

                    Forms\Components\DatePicker::make('tanggal_lahir')
                        ->label('Tanggal Lahir')
                        ->required(),

                    Forms\Components\Placeholder::make('umur')
                        ->label('Umur')
                        ->content(function ($get) {

                            $tanggalLahir = $get('tanggal_lahir');

                            if (! $tanggalLahir) {
                                return '-';
                            }

                            $lahir = Carbon::parse($tanggalLahir);
                            $now = Carbon::now();

                            $diff = $lahir->diff($now);

                            return "{$diff->y} Tahun {$diff->m} Bulan {$diff->d} Hari";
                        })
                        ->reactive(),

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

                    Forms\Components\Radio::make('pekerjaan_pasien')
                        ->label('Pekerjaan')
                        ->options([
                            'dibawah_umur' => 'Di Bawah Umur',
                            'pelajar' => 'Pelajar',
                            'mahasiswa' => 'Mahasiswa',
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
                        ->visible(fn ($get) => $get('pekerjaan_pasien') === 'lain-lain'
                        ),
                ]),
        ];
    }
}
