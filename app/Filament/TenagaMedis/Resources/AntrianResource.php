<?php

namespace App\Filament\TenagaMedis\Resources;

use App\Filament\TenagaMedis\Resources\AntrianResource\Pages;
use App\Filament\TenagaMedis\Resources\AntrianResource\RelationManagers;
use App\Models\Antrian;
use App\Models\RekamMedis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;


class AntrianResource extends Resource
{
    protected static ?string $model = Antrian::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationLabel = 'Antrian';

    protected static ?string $pluralModelLabel = 'List Antrian Pasien';

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
            ->recordUrl(null) // row tidak bisa diklik
            ->poll('2s')
            ->striped()
            ->heading('📋 Daftar Antrian Pasien')
            ->defaultSort('tanggal', 'desc')
            ->paginated([10, 25, 50])
            ->searchPlaceholder('Cari nama, RME, atau no antrian...')
            ->columns([

                // Nomor Antrian
                Tables\Columns\TextColumn::make('no_antrian')
                    ->label('No Antrian')
                    ->sortable()
                    ->weight('bold')
                    ->alignCenter()
                    ->color('primary'),

                // No RME
                Tables\Columns\TextColumn::make('patient.no_rme')
                    ->label('No RME')
                    ->color('info')
                    ->alignCenter(),

                // Nama Pasien
                Tables\Columns\TextColumn::make('patient.nama_pasien')
                    ->label('Nama Pasien')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                // Alamat Pasien
                Tables\Columns\TextColumn::make('patient.alamat_pasien')
                    ->label('Alamat Pasien')
                    ->limit(20)
                    ->tooltip(fn($record) => $record->patient->alamat_pasien),

                // Pelayanan
                Tables\Columns\TextColumn::make('pelayanan')
                    ->label('Pelayanan')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->alignCenter(),

                // Ruangan
                Tables\Columns\TextColumn::make('ruangan')
                    ->label('Ruangan')
                    ->badge()
                    ->color('success')
                    ->alignCenter(),

                // Status
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->icon(fn($state) => match ($state) {
                        'menunggu' => 'heroicon-o-clock',
                        'dipanggil' => 'heroicon-o-megaphone',
                        'selesai' => 'heroicon-o-check-circle',
                        default => 'heroicon-o-minus-circle',
                    })
                    ->colors([
                        'warning' => 'menunggu',
                        'info' => 'dipanggil',
                        'success' => 'selesai',
                    ])
                    ->extraAttributes(fn($state) => $state === 'menunggu'
                        ? ['class' => 'animate-pulse']
                        : []),

                // Tanggal
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->color('gray')
                    ->alignCenter(),
            ])

            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'dipanggil' => 'Dipanggil',
                        'selesai' => 'Selesai',
                    ])
                    ->native(false),

                Tables\Filters\SelectFilter::make('pelayanan')
                    ->options([
                        'Umum' => 'Umum',
                        'Gilut' => 'Gilut',
                    ])
                    ->native(false),
            ])

            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('panggilPasien')
                        ->label('Panggil')
                        ->icon('heroicon-o-megaphone')
                        ->color('warning')
                        ->visible(fn($record) => $record->status === 'menunggu')
                        ->requiresConfirmation()
                        ->action(function ($record, $livewire) {
                            $record->update(['status' => 'dipanggil']);

                            Notification::make()
                                ->title('Pasien ' . $record->patient->nama_pasien . ' dipanggil.')
                                ->success()
                                ->send();

                            $livewire->js(<<<JS
                                let text = `Atas nama {$record->patient->nama_pasien}, dengan nomor antrian {$record->no_antrian}, silakan masuk ruangan {$record->ruangan}.`;
                                text = text.replace(/kluster/gi, "cluster");

                                const utterance = new SpeechSynthesisUtterance(text);
                                utterance.lang = "id-ID";

                                const voices = window.speechSynthesis.getVoices();
                                const femaleVoice = voices.find(v =>
                                    v.lang.startsWith("id") &&
                                    (v.name.toLowerCase().includes("female") ||
                                    v.name.toLowerCase().includes("woman") ||
                                    v.name.toLowerCase().includes("google"))
                                );
                                if (femaleVoice) utterance.voice = femaleVoice;

                                utterance.rate   = 0.95;
                                utterance.pitch  = 1.1;
                                utterance.volume = 1;

                                window.speechSynthesis.cancel();
                                window.speechSynthesis.speak(utterance);
                            JS);
                        }),

                    Tables\Actions\Action::make('ulangPanggilan')
                        ->label('Ulang')
                        ->icon('heroicon-o-speaker-wave')
                        ->color('secondary')
                        ->visible(fn($record) => $record->status === 'dipanggil')
                        ->action(function ($record, $livewire) {
                            $livewire->js(<<<JS
                                let text = `Satu kali lagi. Atas nama {$record->patient->nama_pasien}, dengan nomor antrian {$record->no_antrian}, silakan masuk ruangan {$record->ruangan}.`;
                                text = text.replace(/kluster/gi, "cluster");

                                const utterance = new SpeechSynthesisUtterance(text);
                                utterance.lang = "id-ID";

                                const voices = window.speechSynthesis.getVoices();
                                const femaleVoice = voices.find(v =>
                                    v.lang.startsWith("id") &&
                                    (v.name.toLowerCase().includes("female") ||
                                    v.name.toLowerCase().includes("woman") ||
                                    v.name.toLowerCase().includes("google"))
                                );
                                if (femaleVoice) utterance.voice = femaleVoice;

                                utterance.rate   = 0.95;
                                utterance.pitch  = 1.1;
                                utterance.volume = 1;

                                window.speechSynthesis.cancel();
                                window.speechSynthesis.speak(utterance);
                            JS);
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

                            RekamMedis::create([
                                'tanggal' => $record->tanggal,
                                'patient_id' => $record->patient_id,
                                'pelayanan' => $record->pelayanan,
                                'waktu_kedatangan' => $record->created_at,
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
                ])
                    ->label('Aksi')
                    ->icon('heroicon-o-ellipsis-horizontal')
                    ->color('primary')
            ])

            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])

            // Styling baris
            ->recordClasses(fn($record) => match ($record->status) {
                'menunggu' => 'bg-yellow-50 dark:bg-yellow-900/20 hover:bg-yellow-100 transition',
                'dipanggil' => 'bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 transition',
                'selesai' => 'bg-green-50 dark:bg-green-900/20 hover:bg-green-100 transition',
                default => 'hover:bg-gray-100 dark:hover:bg-gray-800 transition',
            });
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
            'index' => Pages\ListAntrians::route('/'),
            'create' => Pages\CreateAntrian::route('/create'),
            'edit' => Pages\EditAntrian::route('/{record}/edit'),
        ];
    }
}



