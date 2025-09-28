<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Antrian;

Route::get('/statistik-antrian', function (Request $request) {
    $query = Antrian::query();

    if ($request->pelayanan && $request->pelayanan !== 'all') {
        $query->where('pelayanan', $request->pelayanan);
    }

    return [
        'harian' => $query->whereDate('tanggal', today())->count(),
        'mingguan' => $query->whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        'bulanan' => $query->whereMonth('tanggal', now()->month)->count(),
    ];
});
