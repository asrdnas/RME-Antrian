<?php

namespace App\Filament\TenagaMedis\Resources;

use App\Filament\TenagaMedis\Resources\PasienResource\Pages;
use App\Filament\TenagaMedis\Resources\PasienResource\RelationManagers;
use App\Models\Pasien;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Carbon\Carbon;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PasiensExport;
use App\Models\Antrian;



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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->description('Daftar pasien terbaru lengkap dengan status & riwayat kunjungan.')
            ->striped()
            ->defaultSort('no_rme', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('no_rme')
                    ->label('No RME')
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('nama_kk')
                    ->label('Nama Kepala Keluarga (KK)')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->icon('heroicon-o-user')
                    ->alignStart(),

                Tables\Columns\TextColumn::make('nama_pasien')
                    ->label('Nama Pasien')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->icon('heroicon-o-user')
                    ->alignStart(),

                Tables\Columns\TextColumn::make('alamat_pasien')
                    ->label('Alamat')
                    ->alignCenter()
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->alamat_pasien)
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

                Tables\Columns\TextColumn::make('pekerjaan_pasien')
                    ->label('Pekerjaan')
                    ->alignCenter()
                    ->limit(20),

                Tables\Columns\TextColumn::make('total_kunjungan')
                    ->label('Total Kunjungan')
                    ->sortable()
                    ->badge()
                    ->color('success')
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

            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])

            ->paginated([10, 25, 50])

            ->recordClasses(fn ($record) =>
                'bg-gradient-to-r from-white to-gray-50
                 hover:from-indigo-50 hover:to-white
                 dark:from-gray-900 dark:to-gray-800
                 transition-all duration-200'
            );


        }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount('rekamMedis');
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


// ->actions([
            //     // Tables\Actions\EditAction::make(),

            //     Action::make('tambahKeAntrian')
            //         ->label('Tambah ke Antrian')
            //         ->icon('heroicon-o-plus-circle')
            //         ->requiresConfirmation()
            //         ->action(function ($record, $livewire) {
            //             $exists = Antrian::where('patient_id', $record->id)
            //                 ->whereIn('status', ['menunggu', 'dipanggil'])
            //                 ->whereDate('tanggal', today())
            //                 ->exists();

            //             if ($exists) {
            //                 Notification::make()
            //                     ->title('Pasien sudah ada antrian aktif hari ini.')
            //                     ->warning()
            //                     ->send();
            //                 return;
            //             }

            //             Antrian::create([
            //                 'patient_id' => $record->id,
            //                 'no_antrian' => \App\Filament\Resources\AntrianResource::generateNoAntrian(),
            //                 'status' => 'menunggu',
            //                 'tanggal' => now(),
            //             ]);

            //             Notification::make()
            //                 ->title('Pasien berhasil ditambahkan ke antrian.')
            //                 ->success()
            //                 ->send();

            //             $livewire->dispatch('$refresh');
            //         }),

            //     // Tables\Actions\DeleteAction::make(),
            // ])