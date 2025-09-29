<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MonitorGilutController;

// Halaman Form Skrining
Route::get('/pendaftaran-patient-klinik-tirta-amerta', function () {
    return view('pendaftaran.formulir');
})->name('pendaftaran.form');

// Proses Simpan Pasien
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

Route::get('/', function () {return view('landingpage.landingpage');});

Route::get('/monitor/antrian-gilut', [MonitorGilutController::class, 'index'])
    ->name('monitor.antriangilut');