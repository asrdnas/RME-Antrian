<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MonitorGilutController;
use App\Http\Controllers\MonitorUmumController;

// Halaman Form Skrining
Route::get('/pendaftaran-patient-klinik-tirta-amerta', function () {
    return view('pendaftaran.formulir');
})->name('pendaftaran.form');

// Proses Simpan Pasien
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

//  Route Branding Klinik
Route::get('/', function () {return view('landingpage.landingpage');});

// Route Monitor Antrian Gigi dan Mulut
Route::get('/monitor/antrian-gilut', [MonitorGilutController::class, 'index'])
    ->name('monitor.antriangilut');

// Route Monitor Antrian Umum
Route::get('/monitor/antrian-umum', [MonitorUmumController::class, 'index'])
    ->name('monitor.antrianumum');