@extends('template.app')

@section('title', 'Layanan - Klinik Tirta Amerta')

@section('styles')
<link rel="stylesheet" href="{{ asset('asset/css/Fasilitas.css') }}">
@endsection

@section('content')
 <section class="ly-section">
    <div class="ly-container">
        
        <div class="ly-header-box">
            <h2 class="ly-title">Fasilitas Klinik <span class="ly-highlight">Tirta Amerta</span></h2>
        </div>

        <div class="ly-list-vertical">
            
            <div class="ly-card">
                <div class="ly-image-wrapper">
                    <img src="r4.jpeg" alt="Poli Umum">
                </div>
                <div class="ly-content">
                    <span class="ly-card-tag">
                        <i class="fa-solid fa-stethoscope"></i> LAYANAN PRIORITAS
                    </span>
                    <h3 class="ly-card-title">Poli Umum Terpadu</h3>
                    <p class="ly-card-text">
                        Pemeriksaan kesehatan rutin dan konsultasi dokter dengan hasil yang terintegrasi, memberikan kepastian diagnosis bagi kesehatan keluarga Anda.
                    </p>
                </div>
            </div>

            <div class="ly-card">
                <div class="ly-image-wrapper">
                    <img src="r1.jpeg" alt="Poli Gigi">
                </div>
                <div class="ly-content">
                    <span class="ly-card-tag">
                        <i class="fa-solid fa-tooth"></i> ESTETIKA & MEDIS
                    </span>
                    <h3 class="ly-card-title">Pilihan Utama Sejak 2011</h3>
                    <p class="ly-card-text">
                        Klinik gigi dengan dokter spesialis profesional. Mulai dari pembersihan karang gigi hingga tindakan bedah mulut yang menggunakan teknologi modern.
                    </p>
                </div>
            </div>

            <div class="ly-card">
                <div class="ly-image-wrapper">
                    <img src="r2.jpeg" alt="Laboratorium">
                </div>
                <div class="ly-content">
                    <span class="ly-card-tag">
                        <i class="fa-solid fa-flask-vial"></i> HASIL AKURAT
                    </span>
                    <h3 class="ly-card-title">Laboratorium Klinis</h3>
                    <p class="ly-card-text">
                        Pengecekan darah lengkap dengan standar laboratorium internasional untuk memastikan data kesehatan Anda akurat dan tepat waktu.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection