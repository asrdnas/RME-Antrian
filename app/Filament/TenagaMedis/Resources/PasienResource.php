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
        ->columns([
            Tables\Columns\TextColumn::make('nama_pasien')
                ->label('Nama Pasien')
                ->sortable()
                ->searchable()
                ->color('secondary')
                ->alignCenter(), // rata tengah

            Tables\Columns\TextColumn::make('nik')
                ->label('NIK')
                ->sortable()
                ->searchable()
                ->color('info')
                ->alignCenter(),

            Tables\Columns\TextColumn::make('no_rme')
                ->label('No RME')
                ->sortable()
                ->color('success')
                ->alignCenter(),

            Tables\Columns\TextColumn::make('alamat_pasien')
                ->label('Alamat')
                ->limit(30)
                ->color('secondary')
                ->alignCenter(),

            Tables\Columns\TextColumn::make('tanggal_lahir')
                ->label('Tanggal Lahir')
                ->date('d M Y')
                ->color('secondary')
                ->alignCenter(),

            Tables\Columns\TextColumn::make('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->color('secondary')
                ->alignCenter(),

            Tables\Columns\TextColumn::make('no_tlp_pasien')
                ->label('No Telepon')
                ->color('secondary')
                ->alignCenter(),

            Tables\Columns\TextColumn::make('total_kunjungan')
                ->label('Total Kunjungan')
                ->badge()
                ->color(fn ($state) => match (true) {
                    $state == 0 => 'danger',
                    $state > 0 && $state < 3 => 'warning',
                    $state >= 3 => 'success',
                })
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
                ]),
        ])
        ->headerActions([
            Action::make('exportExcel')
                ->label('Export to Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    return Excel::download(new PasiensExport, 'pasiens.xlsx');
                }),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ])
        ->recordClasses(fn ($record) => 'bg-white hover:bg-gray-100 dark:bg-gray-900 dark:hover:bg-gray-800');
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