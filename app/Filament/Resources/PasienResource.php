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

class PasienResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Manajemen Klinik';

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
            ->columns([
                Tables\Columns\TextColumn::make('nama_pasien')
                    ->label('Nama Pasien')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_rme')
                    ->label('No RME')
                    ->sortable(),
                Tables\Columns\TextColumn::make('alamat_pasien')
                    ->label('Alamat')
                    ->limit(30),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin'),
                Tables\Columns\TextColumn::make('no_tlp_pasien')
                    ->label('No Telepon'),
                Tables\Columns\TextColumn::make('total_kunjungan')
                    ->label('Total Kunjungan')
                    ->sortable(),

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

            ->actions([
                Tables\Actions\EditAction::make(),

                Action::make('tambahKeAntrian')
                    ->label('Tambah ke Antrian')
                    ->icon('heroicon-o-plus-circle')
                    ->requiresConfirmation()
                    ->action(function ($record, $livewire) {
                        $exists = Antrian::where('patient_id', $record->id)
                            ->whereIn('status', ['menunggu', 'dipanggil'])
                            ->whereDate('tanggal', today())
                            ->exists();

                        if ($exists) {
                            Notification::make()
                                ->title('Pasien sudah ada antrian aktif hari ini.')
                                ->warning()
                                ->send();
                            return;
                        }

                        Antrian::create([
                            'patient_id' => $record->id,
                            'no_antrian' => \App\Filament\Resources\AntrianResource::generateNoAntrian(),
                            'status' => 'menunggu',
                            'tanggal' => now(),
                        ]);

                        Notification::make()
                            ->title('Pasien berhasil ditambahkan ke antrian.')
                            ->success()
                            ->send();

                        $livewire->dispatch('$refresh');
                    }),

                Tables\Actions\DeleteAction::make(),
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