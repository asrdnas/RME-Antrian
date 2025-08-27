<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $fillable = [
        'patient_id',
        'pelayanan',
        'dokter_id',
        'tanggal',
        'waktu_kedatangan',
        'waktu_mulai',
        'waktu_selesai',
        'anamnesa',
        'pemeriksaan',
        'kesadaran',
        'tinggi_badan',
        'berat_badan',
        'sistole',
        'diastole',
        'resep',
        'catatan',
        'respiratory_rate',
        'heart_rate',
        'tenaga_medis',
        'status_pulang',
        'terapi',
        'kasus_lama_baru',
        'kode_icd10',       
        'deskripsi_icd10',
        'status_rekam_medis',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class); // foreign key default: patient_id
    }

    public function dokter()
    {
        return $this->belongsTo(TenagaMedis::class, 'dokter_id');
    }

    protected static function booted()
    {
        static::saving(function ($rekamMedis) {
            // daftar field yang dianggap wajib
            $requiredFields = [
                'pelayanan',
                'dokter_id',
                'tanggal',
                'waktu_kedatangan',
                'waktu_mulai',
                'waktu_selesai',
                'anamnesa',
                'pemeriksaan',
                'kesadaran',
                'tinggi_badan',
                'berat_badan',
                'sistole',
                'diastole',
                'respiratory_rate',
                'heart_rate',
                'kasus_lama_baru',
                'status_pulang',
                'terapi',
                'resep',
                'kode_icd10',
                'deskripsi_icd10',
            ];

            // cek apakah semua field sudah terisi
            $isComplete = collect($requiredFields)
                ->every(fn ($field) => !empty($rekamMedis->$field));

            // update otomatis status
            $rekamMedis->status_rekam_medis = $isComplete ? 'approved' : 'pending';
        });

        static::created(function ($rekamMedis) {
            // Setiap kali rekam medis baru dibuat, tambah total kunjungan
            $rekamMedis->patient?->increment('total_kunjungan');
        });
    }
}
