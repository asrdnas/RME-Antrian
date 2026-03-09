<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MonitorGilutController;
use App\Http\Controllers\MonitorUmumController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LayananController;
use App\Models\Navbar;

// Halaman Form Skrining
Route::get('/pendaftaran-patient-dokter-donny', function () {
    return view('pendaftaran.formulir');
})->name('pendaftaran.form');

// Proses Simpan Pasien
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

//  Route Branding Klinik
Route::get('/', [HomeController::class, 'home'])->name('home');

// Route Layanan Klinik
Route::get('/layanan', [LayananController::class, 'layanan'])->name('layanan');

// Route Monitor Antrian Gigi dan Mulut
Route::get('/monitor/antrian-gilut', [MonitorGilutController::class, 'index'])
    ->name('monitor.antriangilut');

// Route Monitor Antrian Umum
Route::get('/monitor/antrian-umum', [MonitorUmumController::class, 'index'])
    ->name('monitor.antrianumum');

Route::get('/{slug}', function ($slug) {

    $navbar = Navbar::where('slug', $slug)->firstOrFail();

    return view('page.' . $slug);

});