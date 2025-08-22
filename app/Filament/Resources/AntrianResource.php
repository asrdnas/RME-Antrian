<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AntrianResource\Pages;
use App\Models\Antrian;
use App\Models\Patient;
use App\Models\RiwayatAntrian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Carbon\Carbon;

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
                ->visible(fn($livewire) => $livewire instanceof Pages\CreateAntrian),

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
                }),

            Forms\Components\Hidden::make('patient_id'),

            Forms\Components\TextInput::make('no_antrian')
                ->label('Nomor Antrian')
                ->required()
                ->numeric()
                ->default(fn() => self::generateNoAntrian()),

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

    public static function table(Table $table): Table
    {
        return $table
        ->recordUrl(null) // <- ini bikin row tidak bisa diklik
        ->poll('3s')
        ->query(Antrian::whereDate('tanggal', today()))
        ->columns([
            Tables\Columns\TextColumn::make('no_antrian')
                ->label('No Antrian')
                ->sortable()
                ->alignCenter()
                ->badge()
                ->color('primary')
                ->alignCenter(),

            Tables\Columns\TextColumn::make('patient.no_rme')
                ->label('No RME')
                ->copyable()
                ->copyMessage('No RME berhasil disalin')
                ->icon('heroicon-o-identification')
                ->color('info')
                ->alignCenter(),

            Tables\Columns\TextColumn::make('patient.nama_pasien')
                ->label('Nama Pasien')
                ->sortable()
                ->searchable()
                ->weight('bold')
                ->alignCenter(),

            Tables\Columns\TextColumn::make('patient.alamat_pasien')
                ->label('Alamat Pasien')
                ->limit(20)
                ->tooltip(fn($record) => $record->patient->alamat_pasien)
                ->alignCenter(),

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

            Tables\Columns\TextColumn::make('tanggal')
                ->label('Tanggal')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->icon('heroicon-o-calendar')
                ->alignCenter(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->label('Filter Status')
                ->options([
                    'menunggu' => 'Menunggu',
                    'dipanggil' => 'Dipanggil',
                    'selesai' => 'Selesai',
                ])
                ->native(false),
        ])
        ->headerActions([
            Tables\Actions\Action::make('resetAntrian')
                ->label('Reset & Backup Antrian Hari Ini')
                ->icon('heroicon-o-archive-box')
                ->color('success')
                ->outlined()
                ->button()
                ->requiresConfirmation()
                ->disabled(fn() => Antrian::whereDate('tanggal', today())
                    ->where('status', '!=', 'selesai')
                    ->exists())
                ->tooltip(fn() => Antrian::whereDate('tanggal', today())
                    ->where('status', '!=', 'selesai')
                    ->exists()
                    ? 'Tidak bisa reset, ada pasien yang belum selesai'
                    : null)
                ->action(function () {
                    $now = Carbon::now();
                    $antrians = Antrian::whereDate('tanggal', today())->get();

                    foreach ($antrians as $antrian) {
                        RiwayatAntrian::create([
                            'no_antrian' => $antrian->no_antrian,
                            'no_rme' => $antrian->patient->no_rme ?? null,
                            'nama_pasien' => $antrian->patient->nama_pasien ?? null,
                            'alamat_pasien' => $antrian->patient->alamat_pasien ?? null,
                            'status' => $antrian->status,
                            'tanggal' => $antrian->tanggal,
                            'tanggal_reset' => $now,
                        ]);
                    }

                    Antrian::whereDate('tanggal', today())->delete();

                    Notification::make()
                        ->title('Antrian hari ini berhasil di-backup dan di-reset.')
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
                    $record->update(['status' => 'dipanggil']);
                    Notification::make()
                        ->title('Pasien ' . $record->patient->nama_pasien . ' dipanggil.')
                        ->success()
                        ->send();
                }),

            Tables\Actions\Action::make('tandaiSelesai')
                ->label('Selesai')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->outlined()
                ->visible(fn($record) => $record->status === 'dipanggil')
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
