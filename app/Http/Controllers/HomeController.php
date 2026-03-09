<?php

namespace App\Http\Controllers;

use App\Models\SettingInfo;
use App\Models\StatsKlinik;
use App\Models\AboutKlinik;
use App\Models\LayananKlinik;
use App\Models\FasilitasKlinik;

class HomeController extends Controller
{
    public function home()
    {
        $setting = SettingInfo::first();
        $stats = StatsKlinik::all();
        $aboutKlinik = AboutKlinik::all();
        $layananKliniks = LayananKlinik::with('navbar')
            ->where('is_featured', true)
            ->get();
        $fasilitasKliniks = FasilitasKlinik::with('navbar')
            ->where('is_featured', true)
            ->get();

        return view('page.home', compact('setting', 'stats', 'aboutKlinik', 'layananKliniks', 'fasilitasKliniks'));
    }
}