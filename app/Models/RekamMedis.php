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
