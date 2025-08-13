<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{

    protected $fillable = [
        'patient_id',
        'dokter_id',
        'admin_id',
        'tanggal',
        'tindakan',
        'diagnosa',
        'patient_id',
        'dokter_id',
        'admin_id',
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
        'kode_icd10',        // ✅ tambahkan ini
        'deskripsi_icd10',  
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class); // foreign key default: patient_id
    }

    public function dokter()
    {
        return $this->belongsTo(TenagaMedis::class, 'dokter_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');  // foreign key default: admin_id
    }
}
