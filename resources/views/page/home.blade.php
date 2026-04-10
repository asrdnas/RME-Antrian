@extends('template.app')

@section('title', 'Beranda - Klinik Tirta Amerta')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/Home.css') }}">
@endsection

@section('content')
    <!-- home -->
    <section class="hero">
        <div class="hero-grid">
            <div class="hero-content">

                <h1>
                    {{ $setting->judul_klinik1 }}
                    <span class="highlight">{{ $setting->judul_highlight1 }}</span>
                </h1>

                <h1>
                    {{ $setting->judul_klinik2 }}
                    <span class="highlight">{{ $setting->judul_highlight2 }}</span>
                </h1>

                <p>
                    {{ $setting->deskripsi_klinik }}
                </p>

                <div class="hero-actions">
                    <a href="{{ route('pengumuman') }}" class="btn-primary">
                        Lihat Pengumuman Terkini
                    </a>
                </div>

            </div>
        </div>

        <div class="hero-image">
            <div class="circle-bg">
                <img src="{{ asset('storage/' . $setting->foto_founder) }}" alt="{{ $setting->nama_founder }}"
                    class="hero-img" />
            </div>

            <div class="badge badge-1">
                <i class="fas fa-user-md"></i>

                <div class="badge-text">
                    <span class="name">
                        {{ $setting->nama_founder }}
                    </span>

                    <span class="title">
                        {{ $setting->jabatan_founder }}
                    </span>
                </div>

            </div>
        </div>
    </section>

    <!-- stats -->
    <section class="stats">
        <div class="stats-grid">

            @foreach ($stats as $stat)
                <div class="stat-card {{ $stat->highlight ? 'highlight-card' : '' }}">

                    <div class="stat-icon">
                        <i class="{{ $stat->icon }}"></i>
                    </div>

                    <div class="stat-info">
                        <h3>{{ $stat->title }}</h3>
                        <p>{{ $stat->description }}</p>
                    </div>

                </div>
            @endforeach

        </div>
    </section>

    <!-- tentang kami -->
    <section class="about-section">

        @foreach ($aboutKlinik as $about)
            <div class="about-row">
                <div class="about-text">
                    <span class="badge-about">{{ $about->badge }}</span>
                    <h2>
                        {{ $about->title }} <br />
                        <span class="highlight">{{ $about->highlight }}</span>
                    </h2>
                    <p>
                        {{ $about->description }}
                    </p>
                </div>

                <div class="about-image">
                    <div class="img-wrapper">
                        <img src="{{ asset('storage/' . $about->image) }}" alt="{{ $about->highlight }}" />
                    </div>
                </div>
            </div>
        @endforeach

    </section>

    <!-- layanan -->
    <section id="layanan" class="services">
        <div class="services-header">
            <h1 class="subtitle">Layanan Kami</h1>
            <h2>
                Kami menyediakan berbagai layanan kesehatan
                <span class="highlight">untuk memenuhi kebutuhan Anda</span>
            </h2>
        </div>

        <div class="services-grid">

            @foreach ($layananKliniks as $layanan)
                <div class="service-card">
                    <a href="{{ url('/' . $layanan->navbar->slug) }}" style="text-decoration: none; color: inherit;">
                        <div class="service-image">
                            <img src="{{ asset('storage/' . $layanan->gambar) }}" alt="{{ $layanan->nama }}">
                        </div>
                        <h3>{{ $layanan->nama }}</h3>
                        <p>{{ $layanan->deskripsi }}</p>
                    </a>
                </div>
            @endforeach

        </div>

        <div class="services-footer">
            <a href="{{ url('/layanan') }}" class="view-all-btn">
                Lihat Semua Layanan <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- team kita -->
    <section class="team-section">
        <div class="team">
            <div class="team-split">
                <div class="team-text-content">
                    <a href="{{ url('/team') }}" style="text-decoration: none; color: inherit;">
                        <h2>
                            Meet our <br /><span class="highlight-yellow">Amazing Team!</span>
                        </h2>
                    </a>
                    <p>
                         {{ $teamKlinik->description }}
                    </p>
                    <div class="team-features">
                        <div class="feat-item">
                            <i class="fas fa-check-circle"></i> Berpengalaman
                        </div>
                        <div class="feat-item">
                            <i class="fas fa-check-circle"></i> Ramah & Empati
                        </div>
                        <div class="feat-item">
                            <i class="fas fa-check-circle"></i> Terus Berinovasi
                        </div>
                    </div>
                </div>

                <div class="team-visual">
                    <div class="decorative-shape"></div>
                    <div class="team-image-wrapper">
                        <img src="{{ asset('storage/'.$teamKlinik->image) }}" alt="Tirta Amerta Team" class="main-team-img" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- tenaga medis -->
    <section class="tenaga-medis">
        <div class="medis-header">
            <h2>Meet our Doctor! <span class="line"></span></h2>
        </div>

        <div class="slider-wrapper">
            <div id="sliderContainer">
                <div id="sliderTrack">

                    @foreach ($dokters as $dokter)
                        <a href="{{ route('team') }}" class="slide-card" style="text-decoration:none; color:inherit; display:block;">

                            <div class="doc-arch">
                                <img src="{{ asset('storage/' . $dokter->photo) }}" alt="{{ $dokter->name }}">
                            </div>

                            <h3>{{ $dokter->name }}</h3>

                            <p>
                                {{ $dokter->jenis_dokter == 'Gigi' ? 'Dokter Gigi' : 'Dokter Umum' }}
                            </p>

                        </a>
                    @endforeach

                </div>
            </div>
            <div class="slider-nav">
                <button class="nav-btn prev" onclick="moveSlide(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="nav-btn next" onclick="moveSlide(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- fasilitas kami -->
    <section class="facility-section">
        <div class="facility-header">
            <span class="badge-alt">Fasilitas Klinik</span>
            <h2>Kenyamanan Pasien <span class="highlight">Prioritas Kami</span></h2>
        </div>

        <div class="facility-slider">
            <div class="facility-grid" id="facilityGrid">

                @foreach ($fasilitasKliniks as $fasilitas)
                    <div class="facility-card">
                        <a href="{{ url('/' . $fasilitas->navbar->slug) }}">
                            <div class="facility-img">
                                <img src="{{ asset('storage/' . $fasilitas->gambar) }}" alt="{{ $fasilitas->nama }}">
                            </div>
                            <div class="facility-info">
                                <h3>{{ $fasilitas->nama }}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
        </div>

        <div class="slider-controls">
            <button class="control-btn" id="prevBtn">❮</button>
            <button class="control-btn" id="nextBtn">❯</button>
        </div>
    </section>

    <!-- konsultasi sekarang -->
    <section class="consult-cta">
        <div class="consult-wrapper">
            <div class="consult-content">
                <span class="badge-alt">Hubungi Kami</span>
                <h2>
                    Siap Untuk Berkonsultasi <br /><span class="highlight">Mengenai Kesehatan Anda?</span>
                </h2>
            </div>

            <div class="consult-action">
                <a href="https://wa.me/6281249340040" class="btn-consult">
                    <div class="btn-flex">
                        <i class="fab fa-whatsapp"></i>
                        <div class="btn-text">
                            <span>Konsultasi Sekarang</span>
                            <small>Tersedia via WhatsApp</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- alamat kami -->
    <section class="location-section">
        <div class="location-wrapper">
            <div class="location-info">
                <span class="badge-alt">Lokasi Kami</span>
                <h2>Kunjungi <span class="highlight">Klinik Kami</span></h2>
                <p>
                    Akses mudah menuju layanan kesehatan berkualitas untuk Anda dan
                    keluarga.
                </p>

                <div class="contact-details">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div class="text-group">
                            <strong>Alamat Utama</strong>
                            <p>
                                {{ $setting->alamat }}
                            </p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <div class="text-group">
                            <strong>Jam Operasional</strong>
                            <p>{{ $setting->hari_operasional }}: {{ $setting->jam_operasional }}</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <a href="https://wa.me/6281249340040" target="_blank" class="contact-item whatsapp-link">
                            <i class="fas fa-phone-alt"></i>
                            <div class="text-group">
                                <strong>Hubungi Kami</strong>
                                <p>{{ $setting->nomor_whatsapp }}</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="location-map">
                <div class="map-box">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.8789702994354!2d113.8702668!3d-7.023509999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd9e5f3e264765f%3A0x5543b950859f0f3a!2sKlinik%20TIRTA%20AMERTA!5e0!3m2!1sid!2sid!4v1758011331935!5m2!1sid!2sid"
                        width="100%" height="100%" style="border: 0" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </section>
@endsection
