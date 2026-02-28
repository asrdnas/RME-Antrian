@extends('template.app')

@section('title', 'Team - Klinik Tirta Amerta')

@section('styles')
<link rel="stylesheet" href="{{ asset('asset/css/Team.css') }}">
@endsection

@section('content')
        
    <section class="team-section" id="team">
      <div class="container">
        <div class="section-header">
          <h2>Team <span>Profesional</span> Kami</h2>
          <p>
            Komitmen kami adalah memberikan perawatan terbaik dengan standar
            internasional bagi Anda dan keluarga.
          </p>
        </div>
        <div class="team-hero">
          <div class="group-photo-wrapper">
            <img src="team.jpeg" alt="Tim Dokter Kami" />
            <div class="photo-overlay">
              <h3>Dedikasi Untuk Kesehatan Anda</h3>
              <p>
                Kami bekerja sebagai satu kesatuan untuk memberikan pelayanan
                terbaik.
              </p>
            </div>
          </div>
        </div>

        <div
          class="filter-container"
          style="text-align: center; margin-bottom: 30px"
        >
          <button class="btn-filter" onclick="filterSelection('umum')">
            Dokter Umum
          </button>
          <button class="btn-filter" onclick="filterSelection('gigi')">
            Dokter Gigi
          </button>
        </div>

        <div class="team-grid">
          <article class="team-item gigi gradasi-cyan"></article>

          <article class="team-item umum gradasi-putih"></article>
        </div>

        <div class="team-grid">
          <article class="team-item gigi gradasi-cyan">
            <div class="team-inner-card">
              <div class="team-image">
                <img src="1769243110864.png" alt="drg. Novia" />
              </div>
              <div class="team-info">
                <p class="slogan">Mendesain senyum terbaik Anda</p>
                <h3 class="doctor-name">drg. Novia Sri Wahyuni M.Kes</h3>
                <span class="specialty">Dokter Gigi</span>
                <button class="btn-schedule" onclick="showSchedule('drg-novi')">
                  Lihat Jadwal
                </button>
              </div>
            </div>
          </article>

          <article class="team-item gigi gradasi-cyan">
            <div class="team-inner-card">
              <div class="team-image">
                <img src="1769058777281.png" alt="drg. Novia" />
              </div>
              <div class="team-info">
                <p class="slogan">Mendesain senyum terbaik Anda</p>
                <h3 class="doctor-name">drg. Kholisa</h3>
                <span class="specialty">Dokter Gigi</span>
                <button
                  class="btn-schedule"
                  onclick="showSchedule('drg-kholisa')"
                >
                  Lihat Jadwal
                </button>
              </div>
            </div>
          </article>

          <article class="team-item gigi gradasi-cyan">
            <div class="team-inner-card">
              <div class="team-image">
                <img src="drg.firdaus.jpg" alt="drg. Novia" />
              </div>
              <div class="team-info">
                <p class="slogan">Mendesain senyum terbaik Anda</p>
                <h3 class="doctor-name">drg. Firdaus</h3>
                <span class="specialty">Dokter Gigi</span>
                <button
                  class="btn-schedule"
                  onclick="showSchedule('drg-firdaus')"
                >
                  Lihat Jadwal
                </button>
              </div>
            </div>
          </article>

          <article class="team-item umum gradasi-cyan">
            <div class="team-inner-card">
              <div class="team-image">
                <img src="dr.niken.png" alt="drg. Novia" />
              </div>
              <div class="team-info">
                <p class="slogan">Mendesain senyum terbaik Anda</p>
                <h3 class="doctor-name">dr. niken</h3>
                <span class="specialty">Dokter Gigi</span>
                <button class="btn-schedule" onclick="showSchedule('dr.niken')">
                  Lihat Jadwal
                </button>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="schedule-theme-cyan" id="jadwal">
      <div class="container">
        <div class="section-header">
          <div class="header-badge">Informasi Kunjungan</div>
          <h2>Jadwal <span>Praktek</span> Dokter</h2>
          <p>Pilih dokter untuk melihat jadwal praktik.</p>
        </div>

        <!-- TABLE -->
        <table class="schedule-table">
          <thead>
            <tr>
              <th>Dokter</th>
              <th>Hari</th>
              <th>Jam Praktek</th>
            </tr>
          </thead>
          <tbody>
            <!-- drg. Novia -->
            <tr data-doctor="drg-novi">
              <td rowspan="3" class="doc-name">
                drg. Novia Sri Wahyuni, M.Kes
              </td>
              <td>Senin - Kamis</td>
              <td>18:00 - 20:00</td>
            </tr>
            <tr data-doctor="drg-novi">
              <td>Jumat</td>
              <td>18:00 - 20:00</td>
            </tr>
            <tr data-doctor="drg-novi">
              <td>Sabtu</td>
              <td><em>Janji Temu</em></td>
            </tr>

            <!-- drg. Kholisa -->
            <tr data-doctor="drg-kholisa">
              <td rowspan="3" class="doc-name">drg. Kholisa</td>
              <td>Senin - Kamis</td>
              <td>09:00 - 15:00</td>
            </tr>
            <tr data-doctor="drg-kholisa">
              <td>Jumat</td>
              <td>09:00 - 14:00</td>
            </tr>
            <tr data-doctor="drg-kholisa">
              <td>Sabtu</td>
              <td><em>Janji Temu</em></td>
            </tr>

            <!-- dr. Niken -->
            <tr data-doctor="dr.niken">
              <td rowspan="3" class="doc-name">dr. Niken</td>
              <td>Rabu</td>
              <td>18:00 - 20:00</td>
            </tr>
            <tr data-doctor="dr.niken">
              <td>Kamis</td>
              <td>18:00 - 20:00</td>
            </tr>
            <tr data-doctor="dr.niken">
              <td>Jumat</td>
              <td>18:00 - 20:00</td>
            </tr>
          </tbody>
        </table>

        <div class="schedule-footer">
          <p>*Jadwal dapat berubah sewaktu-waktu.</p>
          <a href="https://wa.me/yournumber" class="btn-whatsapp">
            Reservasi via WhatsApp
          </a>
        </div>
      </div>
    </section>

@endsection

@section('scripts')
  <script>
      function showSchedule(doctorId) {
        const table = document.querySelector(".schedule-table");
        const rows = document.querySelectorAll(".schedule-table tbody tr");

        table.classList.add("show");

        rows.forEach((row) => {
          row.style.display = "none";
        });

        rows.forEach((row) => {
          if (row.dataset.doctor === doctorId) {
            row.style.display = "";
          }
        });

        document.getElementById("jadwal").scrollIntoView({
          behavior: "smooth",
        });
      }
    </script>
<script src="{{ asset('asset/js/team.js') }}"></script>
@endsection