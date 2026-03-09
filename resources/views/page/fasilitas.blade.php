@extends('template.app')

@section('title', 'Fasilitas - Klinik Tirta Amerta')

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

                @foreach ($fasilitasKliniks as $fasilitas)
                    <div class="ly-card">

                        <div class="ly-image-wrapper">
                            <img src="{{ asset('storage/' . $fasilitas->gambar) }}" alt="{{ $fasilitas->nama }}">
                        </div>

                        <div class="ly-content">
                            <h3 class="ly-card-title">{{ $fasilitas->nama }}</h3>

                            <p class="ly-card-text">
                                {{ $fasilitas->deskripsi }}
                            </p>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection
