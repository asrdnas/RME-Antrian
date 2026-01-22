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
        <img src="{{ asset('asset/logo TA/foto_bersama.jpg') }}" alt="Background" class="hero-bg">

        <div class="overlay"></div>

        <div class="container">
            <h1>Klinik Tirta Amerta: <span>Kesehatan Anda Prioritas Kami</span></h1>
            <p>Didukung oleh tim dokter ahli dan teknologi terkini untuk Anda dan keluarga.</p>
            <div class="hero-buttons">
                </div>
        </div>
    </section>


    <section id="layanan" class="services-section section">
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
                <div class="service-item">
                    <i class="fas fa-flask"></i>
                    <h3>Laboratorium Sederhana</h3>
                    <p>Fasilitas tes darah dan pemeriksaan dasar untuk diagnosis cepat.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="dokter" class="doctors-section section">
            <div class="container">
            <h2 class="section-title">Dokter Kami</h2>
            <p class="section-subtitle">Didukung oleh tim dokter berpengalaman dan profesional.</p>
            <div class="doctor-list">
                <div class="doctor-card">
                    <div>
                        <img src="{{ asset('asset/logo TA/dr.niken.jpg') }}" alt="Foto Dokter Andi" class="doctor-photo">
                        <h3>dr. Niken Tri Utami</h3>
                        <p class="specialization">Dokter Umum</p>
                    </div>
                </div>
                <div class="doctor-card">
                    <div>
                        <img src="{{ asset('asset/logo TA/drg.firdaus.jpg') }}" alt="Foto Dokter Andi" class="doctor-photo">
                        <h3>Drg. firdaus fatahillah</h3>
                        <p class="specialization">Dokter Gigi</p>
                    </div>
                </div>
                <div class="doctor-card">
                    <div>
                        <img src="{{ asset('asset/logo TA/drg.kholisa.jpg') }}" alt="Foto Dokter Andi" class="doctor-photo">
                        <h3>drg. Kholisa</h3>
                        <p class="specialization">Dokter Gigi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="kontak" class="contact-section section">
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
                    <p>+62 812 4934 0040</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <h4>Email</h4>
                    <p>tirtaamerta4@gmail.com</p>
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
            <!-- Navigasi Footer -->
            <div class="footer-section">
                <h3>Navigasi</h3>
                <nav class="footer-nav">
                    <ul>
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="#layanan">Layanan</a></li>
                        <li><a href="#dokter">Dokter</a></li>
                        <li><a href="#kontak">Kontak</a></li>
                        <li><a href="#Lokasi">Lokasi</a></li>
                    </ul>
                </nav>
            </div>

            <!-- Kontak Footer -->
            <div class="footer-section">
                <h3>Hubungi Kami</h3>
                <p style="color: rgba(255,255,255,0.7); margin-bottom: 10px;">
                    <i class="fas fa-phone-alt"></i> +62 812 4934 0040
                </p>
                <p style="color: rgba(255,255,255,0.7); margin-bottom: 15px;">
                    <i class="fas fa-envelope"></i> tirtaamerta4@gmail.com
                </p>
                <a href="https://wa.me/6281249340040?text=Halo%20Klinik%20Tirta%20Amerta,%20saya%20ingin%20bertanya%20mengenai%20layanan%20Anda." target="_blank" class="footer-wa">
                    Hubungi via WhatsApp
                </a>
            </div>

            <!-- Jam Operasional -->
            <div class="footer-section">
                <h3>Jam Operasional</h3>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.8;">
                    Senin - Sabtu<br>
                    <strong style="color: #ffc107;">08:00 - 20:00 WIB</strong><br><br>
                    Minggu & Hari Libur<br>
                    <strong style="color: #dc3545;">Tutup</strong>
                </p>
            </div>

            <!-- Social Media -->
            <div class="footer-section">
                <h3>Ikuti Kami</h3>
                <div class="footer-social">
                    <a href="#" class="social-icon" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-icon" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-icon" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://wa.me/6281249340040" class="social-icon" title="WhatsApp" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>© 2025 Klinik Tirta Amerta. Hak Cipta Dilindungi</p>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const menuToggle = document.querySelector(".menu-toggle");
            const mainNav = document.querySelector(".main-nav");

            if (menuToggle && mainNav) {
                menuToggle.addEventListener("click", function () {
                    mainNav.classList.toggle("active");
                });

                document.querySelectorAll('.main-nav a').forEach(link => {
                    link.addEventListener('click', () => {
                        if (window.innerWidth <= 768) {
                            mainNav.classList.remove('active');
                        }
                    });
                });
            }
            const elementsToAnimate = document.querySelectorAll('.service-item, .doctor-card, .contact-item');
            elementsToAnimate.forEach((element, index) => {
                element.classList.add('reveal-hidden');
                element.style.transitionDelay = `${index % 3 * 150}ms`;
            });
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -100px 0px',
                threshold: 0.1
            };

            const scrollObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-show');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            elementsToAnimate.forEach(element => {
                scrollObserver.observe(element);
            });
        });
    </script>
</body>
</html>