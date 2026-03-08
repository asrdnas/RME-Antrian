<?php

namespace App\Http\Controllers;

use App\Models\SettingInfo;
use App\Models\StatsKlinik;
use App\Models\AboutKlinik;

class HomeController extends Controller
{
    public function home()
    {
        $setting = SettingInfo::first();
        $stats = StatsKlinik::all();
        $aboutKlinik = AboutKlinik::all();

        return view('page.home', compact('setting', 'stats', 'aboutKlinik'));
    }
}