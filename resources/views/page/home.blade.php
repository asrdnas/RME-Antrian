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
                    <a href="https://wa.me/6281249340040" class="btn-primary">
                        Mulai Perjalanan Kesehatan
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
        <div class="about-row">
            <div class="about-text">
                <span class="badge-about">Profesionalisme</span>
                <h2>
                    Didukung oleh <br /><span class="highlight">Tim Dokter Terbaik</span>
                </h2>
                <p>
                    Kesehatan Anda ditangani oleh para tenaga medis profesional yang
                    ahli di bidangnya. Kami menggabungkan keahlian medis dengan
                    pendekatan yang ramah dan empatik untuk memberikan perawatan terbaik
                    bagi setiap pasien.
                </p>
            </div>
            <div class="about-image">
                <div class="img-wrapper">
                    <img src="bersama.jpeg" alt="Tim Dokter Terbaik" />
                </div>
            </div>
        </div>

        <div class="about-row">
            <div class="about-text">
                <span class="badge-about">Kredibilitas</span>
                <h2>
                    Dipercaya Masyarakat <br /><span class="highlight">Sejak Tahun 2011</span>
                </h2>
                <p>
                    Lebih dari satu dekade kami telah melayani ribuan pasien dengan
                    dedikasi penuh. Pengalaman panjang ini membentuk kami menjadi klinik
                    yang matang dalam menangani berbagai kebutuhan kesehatan umum maupun
                    gigi.
                </p>
            </div>
            <div class="about-image">
                <div class="img-wrapper">
                    <img src="poli umum.png" alt="Klinik Tirta Amerta Sejak 2011" />
                </div>
            </div>
        </div>

        <div class="about-row">
            <div class="about-text">
                <span class="badge-about">Visi & Misi</span>
                <h2>
                    Misi Kami Untuk <br /><span class="highlight">Kesehatan Anda</span>
                </h2>
                <p>
                    Misi kami adalah menyediakan layanan kesehatan yang terjangkau,
                    berkualitas, dan mengedepankan keamanan pasien melalui teknologi
                    medis modern serta sterilisasi yang terjamin.
                </p>
            </div>
            <div class="about-image">
                <div class="img-wrapper">
                    <img src="team.jpeg" alt="Misi Klinik" />
                </div>
            </div>
        </div>
    </section>

    <!-- layanan -->
    <section id="layanan" class="services">
        <div class="services-header">
            <h1 class="subtitle">Layanan Kami</h1>
            <h2>
                Kami menyediakan berbagai layanan kesehatan<span class="highlight">
                    untuk memenuhi kebutuhan Anda</span>
            </h2>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-image">
                    <img src="poli umum.png" alt="Layanan Poli Umum" />
                </div>
                <h3>Poli Umum</h3>
                <p>
                    Pemeriksaan kesehatan rutin, konsultasi dokter, dan pengobatan
                    penyakit umum untuk dewasa dan anak-anak.
                </p>
            </div>

            <div class="service-card">
                <div class="service-image">
                    <img src="images.jpeg" alt="Layanan Poli Gigi" />
                </div>
                <h3>Poli Gigi</h3>
                <p>
                    Perawatan gigi komprehensif mulai dari scaling, cabut gigi, tambal,
                    hingga estetika gigi (veneer/behel).
                </p>
            </div>

            <div class="service-card">
                <div class="service-image">
                    <img src="download.jpeg" alt="Layanan Laboratorium" />
                </div>
                <h3>Laboratorium</h3>
                <p>
                    Cek darah, gula darah, kolesterol, dan asam urat dengan hasil yang
                    cepat dan akurat.
                </p>
            </div>
        </div>
        <div class="services-footer">
            <a href="../layanan/layanan.html" class="view-all-btn">
                Lihat Semua Layanan <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- team kita -->
    <section class="team-section">
        <div class="team">
            <div class="team-split">
                <div class="team-text-content">
                    <h2>
                        Meet our <br /><span class="highlight-yellow">Amazing Team!</span>
                    </h2>
                    <p>
                        Kami percaya bahwa pelayanan kesehatan terbaik lahir dari
                        kerjasama tim yang solid. Tenaga medis di Tirta Amerta adalah para
                        profesional yang berdedikasi tinggi untuk kenyamanan dan
                        kesembuhan Anda.
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
                        <img src="team.jpeg" alt="Tirta Amerta Team" class="main-team-img" />
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
                    <div class="slide-card">
                        <div class="doc-arch">
                            <img src="1769058777281.png" alt="drg. Priska" />
                        </div>
                        <h3>drg. Priska Tania Goenardi</h3>
                        <p>Dokter Gigi</p>
                    </div>

                    <div class="slide-card">
                        <div class="doc-arch">
                            <img src="1769231708611.png" alt="drg. Giacinta" />
                        </div>
                        <h3>drg. Giacinta Celine Susanto</h3>
                        <p>Dokter Gigi</p>
                    </div>

                    <div class="slide-card">
                        <div class="doc-arch">
                            <img src="1769243110864.png" alt="drg. Kim" />
                        </div>
                        <h3>drg. Kim Henadi</h3>
                        <p>Dokter Gigi</p>
                    </div>

                    <div class="slide-card">
                        <div class="doc-arch">
                            <img src="bersama.jpeg" alt="drg. Wilda" />
                        </div>
                        <h3>drg. Wilda Safira</h3>
                        <p>Dokter Gigi</p>
                    </div>

                    <div class="slide-card">
                        <div class="doc-arch">
                            <img src="drg.firdaus.jpg" alt="drg. Claudia" />
                        </div>
                        <h3>drg. anas</h3>
                        <p>Dokter Gigi</p>
                    </div>

                    <div class="slide-card">
                        <div class="doc-arch">
                            <img src="1769231708611.png" alt="drg. Giacinta" />
                        </div>
                        <h3>drg. Giacinta Celine Susanto</h3>
                        <p>Dokter Gigi</p>
                    </div>

                    <div class="slide-card">
                        <div class="doc-arch">
                            <img src="1769243110864.png" alt="drg. Kim" />
                        </div>
                        <h3>drg. Kim Henadi</h3>
                        <p>Dokter Gigi</p>
                    </div>

                    <div class="slide-card">
                        <div class="doc-arch">
                            <img src="bersama.jpeg" alt="drg. Wilda" />
                        </div>
                        <h3>drg. Wilda Safira</h3>
                        <p>Dokter Gigi</p>
                    </div>

                    <div class="slide-card">
                        <div class="doc-arch">
                            <img src="drg.firdaus.jpg" alt="drg. Claudia" />
                        </div>
                        <h3>drg. anas</h3>
                        <p>Dokter Gigi</p>
                    </div>
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
                <div class="facility-card">
                    <a href="../layanan/Layanan.html">
                        <div class="facility-img">
                            <img src="../Fasilitas/IMG_20260126_163138.jpg.jpeg" alt="Ruang Dokter Umum" />
                        </div>
                        <div class="facility-info">
                            <h3>Ruang Dokter Umum</h3>
                        </div>
                    </a>
                </div>

                <div class="facility-card">
                    <div class="facility-img">
                        <img src="../Fasilitas/IMG_20260126_163424.jpg.jpeg" alt="Gigi" />
                    </div>
                    <div class="facility-info">
                        <h3>Ruangan Gigi Modern</h3>
                    </div>
                </div>

                <div class="facility-card">
                    <div class="facility-img">
                        <img src="../Fasilitas/IMG_20260126_163332.jpg.jpeg" alt="Tunggu" />
                    </div>
                    <div class="facility-info">
                        <h3>Ruang Tunggu Nyaman</h3>
                    </div>
                </div>

                <div class="facility-card">
                    <div class="facility-img">
                        <img src="../Fasilitas/IMG_20260126_163332.jpg.jpeg" alt="Cafe" />
                    </div>
                    <div class="facility-info">
                        <h3>Amerta Cafe</h3>
                    </div>
                </div>
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
