<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $fillable = [
        'patient_id',
        'status',
        'no_antrian',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    protected static function booted()
    {
        static::updating(function ($antrian) {
            // Kalau status berubah jadi dipanggil & waktu_mulai masih kosong
            if ($antrian->isDirty('status') && $antrian->status === 'dipanggil' && !$antrian->waktu_mulai) {
                $antrian->waktu_mulai = now();
            }

            // Kalau status berubah jadi selesai & waktu_selesai masih kosong
            if ($antrian->isDirty('status') && $antrian->status === 'selesai' && !$antrian->waktu_selesai) {
                $antrian->waktu_selesai = now();

            }
        });
    }
}
