@extends('template.app')

@section('title', 'Layanan - Klinik Tirta Amerta')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/Layanan.css') }}">
@endsection

@section('content')
    <section class="ly-section">
        <div class="ly-container">

            <div class="ly-header-box">
                <h2 class="ly-title">
                    Solusi Kesehatan Terpadu untuk
                    <span class="ly-highlight">Keluarga Anda</span>
                </h2>
            </div>

            <div class="ly-list-vertical">

                @foreach ($layananKliniks as $layanan)
                    <div class="ly-card">

                        <div class="ly-image-wrapper">
                            <img src="{{ asset('storage/' . $layanan->gambar) }}" alt="{{ $layanan->nama }}">
                        </div>

                        <div class="ly-content">
                            <span class="ly-card-tag">
                                {{ $layanan->tag }}
                            </span>

                            <h3 class="ly-card-title">
                                {{ $layanan->nama }}
                            </h3>

                            <p class="ly-card-text">
                                {{ $layanan->deskripsi }}
                            </p>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection
