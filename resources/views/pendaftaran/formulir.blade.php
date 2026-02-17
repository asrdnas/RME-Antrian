<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulir Pendaftaran Pasien - drg. Donny Marita Istata</title>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}" />
    <link rel="icon" type="image/png" href="{{ asset('asset/logo TA/LOGO KLINIK PRATAMA TIRTA AMERTA NEW.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Formulir Pendaftaran Pasien</h1>
        </div>

        <h1>drg. Donny Marita Istata</h1>
        <p class="form-subtitle">Mohon isi semua bagian formulir di bawah ini dengan teliti.</p>

        <form method="POST" action="{{ route('patients.store') }}">
            @csrf

            <h2>Formulir Pendaftaran Pasien</h2>

            <!-- Nama KK -->
            <div class="form-group">
                <label class="required">Nama Kepala Keluarga (KK)</label>
                <input type="text" name="nama_kk" required>
            </div>

            <!-- Nama Pasien -->
            <div class="form-group">
                <label class="required">Nama Pasien</label>
                <input type="text" name="nama_pasien" required>
            </div>

            <!-- Jenis Kelamin -->
            <div class="form-group">
                <label class="required">Jenis Kelamin</label>
                <div class="radio-group">
                    <label><input type="radio" name="jenis_kelamin" value="laki-laki" required> Laki-Laki</label>
                    <label><input type="radio" name="jenis_kelamin" value="perempuan"> Perempuan</label>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="tempat_lahir" class="required">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" required />
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir" class="required">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" required />
                </div>
            </div>
            <!-- Alamat -->
            <div class="form-group">
                <label class="required">Alamat</label>
                <textarea name="alamat_pasien" rows="3" required></textarea>
            </div>

            <!-- No Telp -->
            <div class="form-group">
                <label class="required">No Telepon</label>
                <input type="text" name="no_tlp_pasien" required>
            </div>

            <!-- Pekerjaan -->
            <div class="form-group">
                <label class="required">Pekerjaan</label>
                <div class="radio-group">
                    <label><input type="radio" name="pekerjaan_pasien" value="dibawah_umur"> Di Bawah Umur</label>
                    <label><input type="radio" name="pekerjaan_pasien" value="pelajar"> Pelajar</label>
                    <label><input type="radio" name="pekerjaan_pasien" value="mahasiswa"> Mahasiswa</label>
                    <label><input type="radio" name="pekerjaan_pasien" value="pns"> PNS</label>
                    <label><input type="radio" name="pekerjaan_pasien" value="swasta"> Swasta</label>
                    <label><input type="radio" name="pekerjaan_pasien" value="lain-lain"> Lain-lain</label>
                </div>

                <input type="text" id="pekerjaan_lain" name="pekerjaan_pasien_lain"
                    placeholder="Sebutkan pekerjaan lain..." style="display:none; margin-top:10px;">
            </div>

            <button type="submit" class="btn-submit">Kirim</button>
        </form>

    </div>

    {{-- Pop-up sukses yang terikat dengan session Laravel --}}
    @if (session('success'))
        <div class="overlay" id="successOverlay" style="display: flex;">
            <div class="popup">
                <i class="fas fa-check-circle popup-icon"></i>
                <h3>Data berhasil dikirim</h3>
                <h3>Silahkan konfirmasi Admin</h3>
                <p>{{ session('success') }}</p>
                <button class="btn-ok" id="closePopup">Oke</button>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const radios = document.querySelectorAll('input[name="pekerjaan_pasien"]');
            const inputLain = document.getElementById("pekerjaan_lain");

            radios.forEach(radio => {
                radio.addEventListener("change", function() {
                    if (this.value === "lain-lain") {
                        inputLain.style.display = "block";
                        inputLain.focus();
                    } else {
                        inputLain.style.display = "none";
                        inputLain.value = "";
                    }
                });
            });
        });

        const closeBtn = document.getElementById("closePopup");
        const overlay = document.getElementById("successOverlay");

        if (closeBtn) {
            closeBtn.addEventListener("click", function() {
                overlay.style.display = "none";
            });
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const form = document.querySelector("form");

            form.addEventListener("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                }
            });

        });
    </script>

</body>

</html>
