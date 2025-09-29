<?php

namespace App\Http\Controllers;

use App\Models\Antrian;

class MonitorGilutController extends Controller
{
    public function index()
    {
         return view('monitor.antriangilut');
    }
}
