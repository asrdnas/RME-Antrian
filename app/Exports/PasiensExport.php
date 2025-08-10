<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PasiensExport implements FromQuery, WithHeadings
{
    public function query()
    {
        return Patient::query()->select([
            'nama_pasien',
            'nik',
            'no_rme',
            'alamat_pasien',
            'tanggal_lahir',
            'jenis_kelamin',
            'no_tlp_pasien',
        ]);
    }

    public function headings(): array
    {
        return [
            'Nama Pasien',
            'NIK',
            'No RME',
            'Alamat',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'No Telepon',
        ];
    }
}
