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

class PasienResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'Manajemen Klinik';

    protected static ?string $navigationLabel = 'Pasien';

    protected static ?string $pluralModelLabel = 'Daftar Pasien';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Isi form jika perlu
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
                    ->icon('heroicon-o-user'),

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
                    ->label('Export to Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->outlined()
                    ->action(fn() => Excel::download(new PasiensExport, 'pasiens.xlsx')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->button()
                    ->color('info'),

                // Mengubah aksi 'tambahKeAntrian'
                Action::make('tambahKeAntrian')
                    ->label('Tambah ke Antrian')
                    ->icon('heroicon-o-plus-circle')
                    ->color('primary')
                    ->outlined()
                    ->form([
                        Forms\Components\Select::make('pelayanan')
                            ->label('Pilih Pelayanan')
                            ->options([
                                'Dokter Umum' => 'Dokter Umum',
                                'Dokter Gigi' => 'Dokter Gigi',
                            ])
                            ->required()
                            ->native(false),
                    ])
                    ->action(function (array $data, $record, $livewire) {
                        $pelayanan = $data['pelayanan'];
                        $exists = Antrian::where('patient_id', $record->id)
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
                            'pelayanan' => $pelayanan,
                            'ruangan' => $pelayanan === 'Dokter Gigi' ? 'Cluster 2' : 'Cluster 1',
                            'no_antrian' => \App\Filament\Resources\AntrianResource::generateNoAntrian($pelayanan),
                            'status' => 'menunggu',
                            'tanggal' => now(),
                        ]);

                        Notification::make()
                            ->title('Pasien berhasil ditambahkan ke antrian.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Relation managers jika ada
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPasiens::route('/'),
            'create' => Pages\CreatePasien::route('/create'),
            'edit' => Pages\EditPasien::route('/{record}/edit'),
        ];
    }
}