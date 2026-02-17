<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    // protected $guarded = [];
    protected $appends = ['total_kunjungan'];
    protected $fillable = [
        'nama_kk',
        'nama_pasien',
        'jenis_kelamin',
        'alamat_pasien',
        'no_tlp_pasien',
        'pekerjaan_pasien',
        'nik',
        'no_rme',
        'status_validasi',
    ];

    public function antrians()
    {
        return $this->hasMany(Antrian::class);
    }

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'patient_id', 'id');
    }

    public function getTotalKunjunganAttribute()
    {
        return $this->rekamMedis()->count();
    }

    // Accessor untuk alamat_pasien -> kapital
    public function getAlamatPasienAttribute($value)
    {
        return strtoupper($value);
    }


    public static function generateNoRme()
    {
        $year = now()->format('Y');

        // cari no_rme terbesar di tahun ini
        $lastPatient = self::whereYear('created_at', now()->year)
            ->orderBy('no_rme', 'desc')
            ->first();

        if ($lastPatient) {
            // ambil angka setelah tahun, contoh: 20250001 -> ambil 0001
            $lastNumber = intval(substr($lastPatient->no_rme, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // format jadi misalnya: 20250001
        return $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

}
