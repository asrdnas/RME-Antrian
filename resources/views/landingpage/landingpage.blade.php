<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Klinik Tirta Amerta - Klinik Gigi dan Umum</title>
  <link rel="stylesheet" href="{{ asset('asset/css/klinik tirta amerta.css') }}">
<link rel="icon" type="image/png" href="{{ asset('asset/logo TA/LOGO KLINIK PRATAMA TIRTA AMERTA NEW.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

  <header class="main-header">
    <div class="header-container">
      <a href="#" class="logo-link">
        <img src="{{ asset('asset/logo TA/LOGO KLINIK PRATAMA TIRTA AMERTA NEW.png') }}" alt="Logo Klinik Tirta Amerta" class="logo-img">
        <span class="logo-text">Klinik Tirta Amerta</span>
      </a>
      <nav class="main-nav">
        <ul>
          <li><a href="#beranda">Beranda</a></li>
          <li><a href="#layanan">Layanan</a></li>
          <li><a href="#dokter">Dokter</a></li>
          <li><a href="#kontak">Kontak</a></li>
          <li><a href="#Lokasi">Lokasi</a></li>
          <li><a href="/pendaftaran-patient-klinik-tirta-amerta" class="btn-primary">Daftar Pasien</a></li>
        </ul>
      </nav>
      <button class="menu-toggle"><i class="fas fa-bars"></i></button>
    </div>
  </header>

  <section id="beranda" class="hero-section">
  <!-- Background image -->
  <img src="{{ asset('asset/logo TA/bg.jpg') }}" alt="Background" class="hero-bg">

  <!-- Overlay -->
  <div class="overlay"></div>

  <!-- Content -->
  <div class="container">
    <h1>Klinik Tirta Amerta: <span>Kesehatan Anda Prioritas Kami</span></h1>
    <p>Didukung oleh tim dokter ahli dan teknologi terkini untuk Anda dan keluarga.</p>
    <div class="hero-buttons">
      <a href="#layanan" class="btn btn-secondary">Lihat Layanan Kami</a>
      <a href="/pendaftaran-patient-klinik-tirta-amerta" class="btn btn-cta">Daftar Pasien Sekarang</a>
    </div>
  </div>
</section>



  <section id="layanan" class="services-section">
    <div class="container">
      <h2 class="section-title">Layanan Kami</h2>
      <p class="section-subtitle">Kami menyediakan berbagai layanan kesehatan untuk memenuhi kebutuhan Anda.</p>
      <div class="service-list">
        <div class="service-item">
          <i class="fas fa-stethoscope"></i>
          <h3>Pemeriksaan Umum</h3>
          <p>Layanan konsultasi dan pemeriksaan untuk berbagai keluhan penyakit umum.</p>
        </div>
        <div class="service-item">
          <i class="fas fa-tooth"></i>
          <h3>Poli Gigi</h3>
          <p>Perawatan gigi lengkap mulai dari pembersihan, penambalan, hingga pencabutan.</p>
        </div>
      </div>
    </div>
  </section>

  <section id="dokter" class="doctors-section">
    <div class="container">
      <h2 class="section-title">Dokter Kami</h2>
      <p class="section-subtitle">Didukung oleh tim dokter berpengalaman dan profesional.</p>
      <div class="doctor-list">
        <div class="doctor-card">
          <img src="{{ asset('asset/logo TA/default-avatar-icon-of-social-media-user-vector.jpg') }}" alt="Foto Dokter Andi" class="doctor-photo">
          <h3>dr. Andi Pratama</h3>
        </div>
        <div class="doctor-card">
          <img src="{{ asset('asset/logo TA/default-avatar-icon-of-social-media-user-vector.jpg') }}" alt="Foto Dokter Rina" class="doctor-photo">
          <h3>drg. Rina Lestari</h3>
        </div>
        <div class="doctor-card">
          <img src="{{ asset('asset/logo TA/default-avatar-icon-of-social-media-user-vector.jpg') }}" alt="Foto Dokter Budi" class="doctor-photo">
          <h3>dr. Budi Santoso</h3>
        </div>
      </div>
    </div>
  </section>

  <section id="kontak" class="contact-section">
    <div class="container">
      <h2 class="section-title">Hubungi Kami</h2>
      <p class="section-subtitle">Silakan hubungi kami untuk pertanyaan atau membuat janji temu.</p>
      <div class="contact-info">
        <div class="contact-item">
          <i class="fas fa-map-marker-alt"></i>
          <h4>Alamat</h4>
          <p>Jl. Adirasa No.15, Kothe, Kolor, Kec. Kota Sumenep, Kabupaten Sumenep, Jawa Timur 69417, Indonesia</p>
        </div>
        <div class="contact-item">
          <i class="fas fa-phone-alt"></i>
          <h4>Telepon</h4>
          <p>+62 812 3456 7890</p>
        </div>
        <div class="contact-item">
          <i class="fas fa-envelope"></i>
          <h4>Email</h4>
          <p>info@kliniktirtaamerta.com</p>
        </div>
      </div>
    </div>
  </section>

    <section class="map-section" id="Lokasi">
    <div class="container">
      <h2 class="section-title">Lokasi Kami</h2>
      <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.8789702994354!2d113.8702668!3d-7.023509999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd9e5f3e264765f%3A0x5543b950859f0f3a!2sKlinik%20TIRTA%20AMERTA!5e0!3m2!1sid!2sid!4v1758011331935!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </section>

  <footer class="main-footer">
    <div class="container">
      <div class="footer-nav">
        <ul>
          <li><a href="#beranda">Beranda</a></li>
          <li><a href="#layanan">Layanan</a></li>
          <li><a href="#dokter">Dokter</a></li>
          <li><a href="#kontak">Kontak</a></li>
          <li><a href="#Lokasi">Lokasi</a></li>
          <li><a href="https://wa.me/6282335389877?text=Halo%20Klinik%20Tirta%20Amerta,%20saya%20ingin%20bertanya%20mengenai%20layanan%20Anda." target="_blank" class="footer-wa">Hubungi via WhatsApp</a></li>
        </ul>
      </div>
      <p>© 2025 Klinik Tirta Amerta. Hak Cipta Dilindungi.</p>
    </div>
  </footer>

</body>
</html>