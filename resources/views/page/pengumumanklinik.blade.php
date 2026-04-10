@extends('template.app')

@section('title', 'Pengumuman - Klinik Tirta Amerta')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/Pengumuman.css') }}">
@endsection

@section('content')
    <section class="ly-section">
        <div class="ly-container">

            <div class="ly-header-box">
                <h2 class="ly-title">
                    Pengumuman Terkini untuk
                    <span class="ly-highlight">Anda</span>
                </h2>
            </div>

            <div class="ly-list-vertical">

                @foreach ($pengumumanKliniks as $pengumuman)
                    <div class="ly-card">

                        <div class="ly-image-wrapper">
                            <img src="{{ asset('storage/' . $pengumuman->gambar) }}" alt="{{ $pengumuman->judul }}">
                        </div>

                        <div class="ly-content">

                            <h3 class="ly-card-title">
                                {{ $pengumuman->judul }}
                            </h3>

                            <span class="ly-card-tag">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $pengumuman->tanggal }}
                            </span>

                            <p class="ly-card-text">
                             {!! $pengumuman->deskripsi !!}
                            </p>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection
