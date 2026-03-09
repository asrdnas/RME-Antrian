<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LayananKlinik;

class LayananController extends Controller
{
    public function layanan()
    {
        $layananKliniks = LayananKlinik::with('navbar')->get();
        return view('page.layanan', compact('layananKliniks'));
    }
}
