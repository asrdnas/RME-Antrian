<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PasienResource\Pages;
use App\Models\Patient;
use App\Models\Antrian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PasiensExport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class PasienResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'Master Data Klinik';

    protected static ?string $navigationLabel = 'Pasien';

    protected static ?string $pluralModelLabel = 'Daftar Pasien';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_pasien')
                    ->label('Nama Pasien')
                    ->required()
                    ->default(fn($record) => $record?->nama_pasien)
                    ->reactive()
                    ->prefixIcon('heroicon-o-user'),

                Forms\Components\TextInput::make('nik')
                    ->label('NIK')
                    ->required()
                    ->maxLength(16)
                    ->default(fn($record) => $record?->nik)
                    ->prefixIcon('heroicon-o-identification'),

                // Perbaikan: Sekarang bisa diedit, tapi dengan validasi unik
                Forms\Components\TextInput::make('no_rme')
                    ->label('No RME')
                    ->required()
                    ->default(fn($record) => $record?->no_rme)
                    ->prefixIcon('heroicon-o-identification')
                    ->unique(ignoreRecord: true), // Validasi unik, tapi abaikan record yang sedang diedit

                Forms\Components\Textarea::make('alamat_pasien')
                    ->label('Alamat')
                    ->rows(3)
                    ->default(fn($record) => $record?->alamat_pasien),

                Forms\Components\TextInput::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->default(fn($record) => $record?->tempat_lahir),

                // Perbaikan untuk format tanggal
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->native(false) // Menggunakan datepicker Filament
                    ->displayFormat('d/m/Y') // Format untuk ditampilkan di form
                    ->default(fn($record) => $record?->tanggal_lahir),

                Forms\Components\Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'laki-laki' => 'Laki-laki',
                        'perempuan' => 'Perempuan',
                    ])
                    ->required()
                    ->default(fn($record) => $record?->jenis_kelamin),

                Forms\Components\TextInput::make('no_tlp_pasien')
                    ->label('No Telepon')
                    ->default(fn($record) => $record?->no_tlp_pasien)
                    ->prefixIcon('heroicon-o-phone'),

                Forms\Components\Select::make('status_validasi')
                    ->label('Status Validasi')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required()
                    ->default(fn($record) => $record?->status_validasi),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->columns([
                Tables\Columns\TextColumn::make('nama_pasien')
                    ->label('Nama Pasien')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->icon('heroicon-o-user')
                    ->alignStart(),

                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('NIK berhasil disalin')
                    ->icon('heroicon-o-identification')
                    ->color('info')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('no_rme')
                    ->label('No RME')
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('alamat_pasien')
                    ->label('Alamat')
                    ->alignCenter()
                    ->limit(30)
                    ->tooltip(fn($record) => $record->alamat_pasien)
                    ->icon('heroicon-o-map-pin'),

                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->alignCenter()
                    ->limit(20),

                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date('d/m/Y')
                    ->icon('heroicon-o-calendar')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->badge()
                    ->colors([
                        'pink' => 'Perempuan',
                        'blue' => 'Laki-laki',
                    ])
                    ->icons([
                        'heroicon-o-female' => 'Perempuan',
                        'heroicon-o-user' => 'Laki-laki',
                    ])
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('no_tlp_pasien')
                    ->label('No Telepon')
                    ->icon('heroicon-o-phone')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('total_kunjungan')
                    ->label('Total Kunjungan')
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('status_validasi')
                    ->label('Status validasi')
                    ->sortable()
                    ->badge() // Tambahkan badge untuk tampilan lebih baik
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->alignCenter(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_validasi')
                    ->label('Status Validasi')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->native(false),
            ])
            ->headerActions([
                Action::make('exportExcel')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->outlined()
                    ->button()
                    ->action(fn() => Excel::download(new PasiensExport, 'pasiens.xlsx')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('info')
                    ->button()
                    ->outlined(),

                Action::make('tambahKeAntrian')
                    ->label('Tambah Antrian')
                    ->icon('heroicon-o-plus-circle')
                    ->color('primary')
                    ->button()
                    ->outlined()
                    ->form([
                        Forms\Components\Select::make('pelayanan')
                            ->label('Pilih Pelayanan')
                            ->options([
                                'Umum'  => 'Umum',
                                'Gilut' => 'Gilut',
                            ])
                            ->required()
                            ->native(false),
                    ])
                    ->action(function (array $data, Patient $record) {
                        $pelayanan = $data['pelayanan'];
                        $exists = Antrian::query()
                            ->where('patient_id', $record->id)
                            ->where('pelayanan', $pelayanan)
                            ->whereIn('status', ['menunggu', 'dipanggil'])
                            ->whereDate('tanggal', today())
                            ->exists();

                        if ($exists) {
                            Notification::make()
                                ->title('Pasien sudah ada antrian aktif untuk layanan ini hari ini.')
                                ->warning()
                                ->send();
                            return;
                        }

                        Antrian::create([
                            'patient_id' => $record->id,
                            'pelayanan'  => $pelayanan,
                            'ruangan'    => $pelayanan === 'Gilut' ? 'Cluster 4' : 'Cluster 3',
                            'no_antrian' => \App\Filament\Resources\AntrianResource::generateNoAntrian($pelayanan),
                            'status'     => 'menunggu',
                            'tanggal'    => now(),
                        ]);

                        Notification::make()
                            ->title('Pasien berhasil ditambahkan ke antrian.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->button()
                    ->outlined(),
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
            'index' => Pages\ListPasiens::route('/'),
            'edit' => Pages\EditPasien::route('/{record}/edit'),
        ];
    }
}
