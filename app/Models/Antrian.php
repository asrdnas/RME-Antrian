<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $fillable = [
        'patient_id',
        'pelayanan',
        'ruangan',
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
        static::creating(function ($antrian) {
            // Mapping ruangan otomatis
            $ruanganMapping = [
                'Dokter Umum' => 'Cluster 1',
                'Dokter Gigi' => 'Cluster 2',
            ];

            if (!empty($antrian->pelayanan)) {
                $antrian->ruangan = $ruanganMapping[$antrian->pelayanan] ?? null;
                $antrian->no_antrian = self::generateNoAntrian($antrian->pelayanan);
            }

            // default tanggal
            if (!$antrian->tanggal) {
                $antrian->tanggal = now();
            }

            // default status
            if (!$antrian->status) {
                $antrian->status = 'menunggu';
            }
        });

        // Update waktu mulai/selesai otomatis
        static::updating(function ($antrian) {
            if ($antrian->isDirty('status') && $antrian->status === 'dipanggil' && !$antrian->waktu_mulai) {
                $antrian->waktu_mulai = now();
            }

            if ($antrian->isDirty('status') && $antrian->status === 'selesai' && !$antrian->waktu_selesai) {
                $antrian->waktu_selesai = now();
            }
        });
    }

    /**
     * Generate nomor antrian otomatis berdasarkan pelayanan
     * Dokter Umum = A01, A02..., Dokter Gigi = B01, B02...
     */
    public static function generateNoAntrian(string $pelayanan): string
    {
        $prefix = $pelayanan === 'Dokter Gigi' ? 'B' : 'A';

        $lastNumber = self::whereDate('tanggal', today())
            ->where('pelayanan', $pelayanan)
            ->orderByDesc('id')
            ->value('no_antrian');

        if ($lastNumber) {
            $number = (int) substr($lastNumber, 1); // ambil angka setelah prefix
            $newNumber = $number + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
    }
}
