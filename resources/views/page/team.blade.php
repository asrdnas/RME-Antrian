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
                    <img src="{{ asset('storage/'.$teamKlinik->image) }}" alt="Tim Dokter Kami" />
                    <div class="photo-overlay">
                        <h3>{{ $teamKlinik->hero_title }}</h3>
                        <p>
                           {{ $teamKlinik->hero_description }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="filter-container" style="text-align: center; margin-bottom: 30px">
                <button class="btn-filter" onclick="filterSelection('umum')">
                    Dokter Umum
                </button>
                <button class="btn-filter" onclick="filterSelection('gigi')">
                    Dokter Gigi
                </button>
            </div>

            <div class="team-grid">

                @foreach ($dokters as $dokter)
                    <article class="team-item {{ strtolower($dokter->jenis_dokter) }} gradasi-cyan">
                        <div class="team-inner-card">

                            <div class="team-image">
                                <img src="{{ asset('storage/' . $dokter->photo) }}" alt="{{ $dokter->name }}">
                            </div>

                            <div class="team-info">

                                <h3 class="doctor-name">
                                    {{ $dokter->name }}
                                </h3>

                                <span class="specialty">
                                    Dokter {{ $dokter->jenis_dokter }}
                                </span>

                                <button class="btn-schedule" onclick="showSchedule('{{ $dokter->slug }}')">
                                    Lihat Jadwal
                                </button>

                            </div>

                        </div>
                    </article>
                @endforeach

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

                    @foreach ($dokters as $dokter)
                        @foreach ($dokter->JadwalDokter as $jadwal)
                            <tr data-doctor="{{ $dokter->slug }}">
                                <td class="doc-name">
                                    {{ $dokter->name }}
                                </td>

                                <td>
                                    {{ $jadwal->hari }}
                                </td>

                                <td>
                                    {{ date('H.i', strtotime($jadwal->jam_mulai)) }} -
                                    {{ date('H.i', strtotime($jadwal->jam_selesai)) }} WIB
                                </td>

                            </tr>
                        @endforeach
                    @endforeach

                </tbody>
            </table>

            <div class="schedule-footer">
                <p>*Jadwal dapat berubah sewaktu-waktu.</p>
                <a href="https://wa.me/6281249340040" class="btn-whatsapp">
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
