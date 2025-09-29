<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Antrian;

class MonitorUmum extends Component
{
     public $current;
    public $sisa;
    public $antrianUmum;
    public function render()
    {
        $this->current = Antrian::where('pelayanan', 'Umum')
            ->where('status', 'dipanggil')
            ->latest()
            ->first();

        $this->sisa = Antrian::where('pelayanan', 'Umum')
            ->where('status', 'menunggu')
            ->count();

        $this->antrianUmum = Antrian::with('patient')
            ->where('pelayanan', 'Umum')
            ->whereDate('tanggal', today())
            ->where('status', '!=', 'selesai')
            ->orderBy('created_at')
            ->get();
        return view('livewire.monitor-umum');
    }
}
