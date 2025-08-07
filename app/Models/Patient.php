<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'nama_pasien',
        'nik',
        'no_rme',
        'tempat_lahir',
        'tanggal_lahir',
        'umur_pasien',
        'jenis_kelamin',
        'alamat_pasien',
        'no_tlp_pasien',
        'status_perkawinan_pasien',
        'agama_pasien',
        'pekerjaan_pasien',
        'pendidikan_pasien',
        'status_pasien',
        'nama_penanggung_jawab',
        'umur_penanggung_jawab',
        'pekerjaan_penanggung_jawab',
        'hubungan_dengan_pasien',
        'edukasi_diberikan',
        'penerima_edukasi',
        'bicara',
        'serangan_awal_gangguan_bicara',
        'bahasa_sehari_hari',
        'perlu_penerjemah',
        'bahasa_isyarat',
    ];

    public function antrians()
    {
        return $this->hasMany(Antrian::class);
    }

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class);
    }
}
