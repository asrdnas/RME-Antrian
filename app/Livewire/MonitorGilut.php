<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Antrian;

class MonitorGilut extends Component
{
    public $current;
    public $sisa;
    public $antrianGilut;

    public function render()
    {
        $this->current = Antrian::where('pelayanan', 'Gilut')
            ->where('status', 'dipanggil')
            ->latest()
            ->first();

        $this->sisa = Antrian::where('pelayanan', 'Gilut')
            ->where('status', 'menunggu')
            ->count();

        $this->antrianGilut = Antrian::with('patient')
            ->where('pelayanan', 'Gilut')
            ->whereDate('tanggal', today())
            ->where('status', '!=', 'selesai')
            ->orderBy('created_at')
            ->get();

        return view('livewire.monitor-gilut');
    }
}
