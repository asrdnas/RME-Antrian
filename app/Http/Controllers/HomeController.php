<?php

namespace App\Http\Controllers;

use App\Models\SettingInfo;
use App\Models\StatsKlinik;
use App\Models\AboutKlinik;
use App\Models\LayananKlinik;
use App\Models\FasilitasKlinik;
use App\Models\TenagaMedis;
use App\Models\TeamKlinik;

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
        $teamKlinik = TeamKlinik::first();
        $dokters = TenagaMedis::all();

        return view('page.home', compact('setting', 'stats', 'aboutKlinik', 'layananKliniks', 'fasilitasKliniks', 'teamKlinik', 'dokters'));
    }
}