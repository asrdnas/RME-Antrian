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
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    protected static function booted()
    {
        static::updated(function ($antrian) {
            // Cek kalau status berubah menjadi 'selesai'
            if ($antrian->isDirty('status') && $antrian->status === 'selesai') {
                $antrian->patient?->increment('total_kunjungan');
            }
        });
    }
}
