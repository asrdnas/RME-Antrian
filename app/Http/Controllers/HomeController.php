<?php

namespace App\Http\Controllers;

use App\Models\SettingInfo;
use App\Models\StatsKlinik;

class HomeController extends Controller
{
    public function home()
    {
        $setting = SettingInfo::first();
        $stats = StatsKlinik::all();

        return view('page.home', compact('setting', 'stats'));
    }
}