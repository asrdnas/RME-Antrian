<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MonitorGilutController;
use App\Http\Controllers\MonitorUmumController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PengumumanController;
use App\Models\Navbar;

Route::get('/tes', function () {
    return 'OK';
});

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

// Route Fasilitas Klinik
Route::get('/fasilitas', [FasilitasController::class, 'fasilitas'])->name('fasilitas');

// Route Team Klinik
Route::get('/team', [TeamController::class, 'team'])->name('team');

// Route Pengumuman Klinik
Route::get('/pengumuman', [PengumumanController::class, 'pengumuman'])->name('pengumuman');


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
