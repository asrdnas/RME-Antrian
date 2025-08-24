<?php

namespace App\Filament\Resources\AntrianResource\Pages;

use App\Filament\Resources\AntrianResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use App\Models\Patient;
use App\Models\Antrian;

class CreateAntrian extends CreateRecord
{
    protected static string $resource = AntrianResource::class;

    protected function beforeValidate(): void
    {
        $data = $this->form->getState();

        if (empty($data['nik'])) {
            throw ValidationException::withMessages([
                'nik' => 'NIK Pasien harus diisi.',
            ]);
        }

        $patient = Patient::where('nik', $data['nik'])->first();

        if (!$patient) {
            throw ValidationException::withMessages([
                'nik' => 'Pasien dengan NIK ini tidak ditemukan.',
            ]);
        }

        $exists = Antrian::where('patient_id', $patient->id)
            ->whereIn('status', ['menunggu', 'dipanggil'])
            ->whereDate('tanggal', today())
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'nik' => 'Pasien ini sudah memiliki antrian aktif hari ini.',
            ]);
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $patient = Patient::where('nik', $data['nik'])->first();
        if ($patient) {
            $data['patient_id'] = $patient->id;
        }
        return $data;
    }

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Antrian berhasil ditambahkan!')
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
