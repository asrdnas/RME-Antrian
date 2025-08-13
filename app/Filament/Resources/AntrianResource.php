<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AntrianResource\Pages;
use App\Models\Antrian;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class AntrianResource extends Resource
{
    protected static ?string $model = Antrian::class;
    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationLabel = 'Antrian';
    protected static ?string $navigationGroup = 'Manajemen Klinik';

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Field nik hanya tampil di create page
            Forms\Components\TextInput::make('nik')
                ->label('NIK Pasien')
                ->required()
                ->length(16)
                ->numeric()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('patient_id', null);
                    $set('nama_pasien', null);
                    if ($state && strlen($state) === 16) {
                        $patient = Patient::where('nik', $state)->first();
                        if ($patient) {
                            $set('patient_id', $patient->id);
                            $set('nama_pasien', $patient->nama_pasien);
                        }
                    }
                })
                ->visible(fn ($livewire) => $livewire instanceof Pages\CreateAntrian),

            Forms\Components\TextInput::make('nama_pasien')
                ->label('Nama Pasien')
                ->disabled()
                ->reactive()
                ->afterStateHydrated(function ($state, callable $set, $get) {
                    if (empty($state)) {
                        $patient_id = $get('patient_id');
                        if ($patient_id) {
                            $patient = Patient::find($patient_id);
                            if ($patient) {
                                $set('nama_pasien', $patient->nama_pasien);
                            }
                        }
                    }
                })
                ->visible(),

            Forms\Components\Hidden::make('patient_id'),

            Forms\Components\TextInput::make('no_antrian')
                ->label('Nomor Antrian')
                ->required()
                ->numeric()
                ->default(fn () => self::generateNoAntrian()),

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
        ]);
    }

    // Supaya patient_id terisi dari nik sebelum simpan
    public static function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['nik'])) {
            $patient = Patient::where('nik', $data['nik'])->first();
            if ($patient) {
                $data['patient_id'] = $patient->id;
            }
        }
        return $data;
    }

    public static function mutateFormDataBeforeSave(array $data, $record): array
    {
        if (!empty($data['nik'])) {
            $patient = Patient::where('nik', $data['nik'])->first();
            if ($patient) {
                $data['patient_id'] = $patient->id;
            }
        }
        return $data;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('5s') // Refresh otomatis setiap 5 detik
            ->columns([
                Tables\Columns\TextColumn::make('no_antrian')->label('No Antrian')->sortable(),
                Tables\Columns\TextColumn::make('patient.no_rme')->label('No RME'),
                Tables\Columns\TextColumn::make('patient.nama_pasien')->label('Nama Pasien')->sortable(),
                Tables\Columns\TextColumn::make('patient.alamat_pasien')->label('Alamat Pasien')->limit(20),
                Tables\Columns\TextColumn::make('status')->label('Status'),
                Tables\Columns\TextColumn::make('tanggal')->label('Tanggal')->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'dipanggil' => 'Dipanggil',
                        'selesai' => 'Selesai',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('resetAntrianHarian')
                    ->label('Reset Antrian Hari Ini')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(function () {
                        Antrian::whereDate('tanggal', today())->delete();

                        Notification::make()
                            ->title('Antrian hari ini berhasil direset.')
                            ->success()
                            ->send();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('panggilPasien')
                    ->label('Panggil Pasien')
                    ->icon('heroicon-o-megaphone')
                    ->color('warning')
                    ->visible(fn ($record) => $record->status === 'menunggu')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['status' => 'dipanggil']);
                        Notification::make()
                            ->title('Pasien ' . $record->patient->nama_pasien . ' dipanggil.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('tandaiSelesai')
                    ->label('Tandai Selesai')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === 'dipanggil')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['status' => 'selesai']);
                        Notification::make()
                            ->title('Pasien ' . $record->patient->nama_pasien . ' ditandai selesai.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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

    public static function generateNoAntrian()
    {
        $lastNumber = Antrian::whereDate('tanggal', today())->max('no_antrian');
        return $lastNumber ? $lastNumber + 1 : 1;
    }
}
