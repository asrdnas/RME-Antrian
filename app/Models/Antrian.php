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
}
