<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Patient extends Model
{
    // protected $guarded = [];
    protected $appends = ['total_kunjungan'];

    protected $fillable = [
        'nama_kk',
        'nama_pasien',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
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

    // Accessor untuk tempat_lahir -> kapital
    public function getTempatLahirAttribute($value)
    {
        return strtoupper($value);
    }

    // Accessor untuk alamat_pasien -> kapital
    public function getAlamatPasienAttribute($value)
    {
        return strtoupper($value);
    }

    public static function generateNoRme()
    {
        return DB::transaction(function () {

            // Kunci baris terakhir supaya tidak dibaca user lain
            $lastPatient = self::lockForUpdate()
                ->orderBy('no_rme', 'desc')
                ->first();

            $newNumber = $lastPatient ? $lastPatient->no_rme + 1 : 1;

            return $newNumber;
        });
    }
}
