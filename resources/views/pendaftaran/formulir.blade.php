<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulir Pendaftaran Pasien - Klinik Tirta Amerta</title>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}" />
    <link rel="icon" type="image/png" href="{{ asset('asset/logo TA/LOGO KLINIK PRATAMA TIRTA AMERTA NEW.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('asset/logo TA/LOGO KLINIK PRATAMA TIRTA AMERTA NEW.png') }}"
                alt="Logo Klinik Tirta Amerta" />
            <h1>Klinik Tirta Amerta</h1>
        </div>

        <h1>Formulir Pendaftaran Pasien</h1>
        <p class="form-subtitle">Mohon isi semua bagian formulir di bawah ini dengan teliti.</p>

        <form id="screeningForm" method="POST" action="{{ route('patients.store') }}">
            @csrf

            {{-- 1. Data Pribadi Pasien --}}
            <h2>1. Data Pribadi Pasien</h2>
            <div class="form-group">
                <label for="nama_pasien" class="required">Nama Lengkap</label>
                <input type="text" id="nama_pasien" name="nama_pasien" required />
            </div>
            <div class="form-group">
                <label for="nik" class="required">Nomor KTP</label>
                <input type="text" id="nik" name="nik" pattern="\d{16}" title="Harap masukkan 16 digit angka"
                    required />
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
                <div class="form-group">
                    <label for="umur_pasien" class="required">Umur</label>
                    <input type="number" id="umur_pasien" name="umur_pasien" required />
                </div>
            </div>

            <div class="form-row">
                <div class="form-group form-group-alamat">
                    <label for="alamat_pasien">Alamat</label>
                    <textarea id="alamat_pasien" name="alamat_pasien" rows="3"></textarea>
                </div>
                <div class="form-group form-group-telepon">
                    <label for="no_tlp_pasien">Nomor Telepon</label>
                    <input type="number" id="no_tlp_pasien" name="no_tlp_pasien" />
                </div>
            </div>

            <div class="form-group">
                <label class="required">Jenis Kelamin</label>
                <div class="radio-group">
                    <label><input type="radio" name="jenis_kelamin" value="laki-laki" required /> Laki-Laki</label>
                    <label><input type="radio" name="jenis_kelamin" value="perempuan" /> Perempuan</label>
                </div>
            </div>

            <div class="form-group">
                <label class="required">Status Perkawinan</label>
                <div class="radio-group">
                    <label><input type="radio" name="status_perkawinan_pasien" value="menikah" required />
                        Menikah</label>
                    <label><input type="radio" name="status_perkawinan_pasien" value="belum_menikah" /> Belum
                        Menikah</label>
                    <label><input type="radio" name="status_perkawinan_pasien" value="janda" /> Janda</label>
                    <label><input type="radio" name="status_perkawinan_pasien" value="duda" /> Duda</label>
                </div>
            </div>

            {{-- Pekerjaan --}}
            <div class="form-group">
                <label class="required">Pekerjaan</label>
                <div class="radio-group" id="pekerjaan-radio-group">
                    <label><input type="radio" name="pekerjaan_pasien" value="pns" required /> PNS</label>
                    <label><input type="radio" name="pekerjaan_pasien" value="tni" /> TNI</label>
                    <label><input type="radio" name="pekerjaan_pasien" value="polisi" /> Polisi</label>
                    <label><input type="radio" name="pekerjaan_pasien" value="bumn" /> BUMN</label>
                    <label><input type="radio" name="pekerjaan_pasien" value="bumd" /> BUMD</label>
                    <label><input type="radio" name="pekerjaan_pasien" value="karyawan_swasta" /> Karyawan
                        Swasta</label>
                    <label><input type="radio" name="pekerjaan_pasien" value="petani" /> Petani</label>
                    <label><input type="radio" name="pekerjaan_pasien" value="pedagang" /> Pedagang</label>
                    <label><input type="radio" name="pekerjaan_pasien" value="lain-lain" /> Lain-lain</label>
                </div>
                <input type="text" id="pekerjaan_pasien_lain" name="pekerjaan_pasien_lain"
                    placeholder="Sebutkan pekerjaan lain..." style="display:none;margin-top:10px;" />
            </div>

            {{-- Pendidikan --}}
            <div class="form-group">
                <label class="required">Pendidikan</label>
                <div class="radio-group" id="pendidikan-radio-group">
                    <label><input type="radio" name="pendidikan_pasien" value="tidak_lulus" required /> Tidak
                        Lulus</label>
                    <label><input type="radio" name="pendidikan_pasien" value="sd" /> SD</label>
                    <label><input type="radio" name="pendidikan_pasien" value="smp" /> SMP</label>
                    <label><input type="radio" name="pendidikan_pasien" value="sma" /> SMA</label>
                    <label><input type="radio" name="pendidikan_pasien" value="slta" /> SLTA</label>
                    <label><input type="radio" name="pendidikan_pasien" value="s1" /> Sarjana S1</label>
                    <label><input type="radio" name="pendidikan_pasien" value="s2" /> S2</label>
                    <label><input type="radio" name="pendidikan_pasien" value="s3" /> S3</label>
                    <label><input type="radio" name="pendidikan_pasien" value="lain-lain" /> Lain-lain</label>
                </div>
                <input type="text" id="pendidikan_pasien_lain" name="pendidikan_pasien_lain"
                    placeholder="Sebutkan pendidikan lain..." style="display:none;margin-top:10px;" />
            </div>

            <hr>

            {{-- 2. Data Penanggung Jawab --}}
            <h2>2. Data Penanggung Jawab</h2>
            <div class="form-group">
                <label for="nama_penanggung_jawab" class="required">Nama Penanggung Jawab</label>
                <input type="text" id="nama_penanggung_jawab" name="nama_penanggung_jawab" required />
            </div>
            <div class="form-group">
                <label for="umur_penanggung_jawab" class="required">Umur Penanggung Jawab</label>
                <input type="number" id="umur_penanggung_jawab" name="umur_penanggung_jawab" required />
            </div>
            <div class="form-group">
                <label class="required">Pekerjaan Penanggung Jawab</label>
                <div class="radio-group" id="pekerjaan-pj-radio-group">
                    <label><input type="radio" name="pekerjaan_penanggung_jawab" value="pns" required /> PNS</label>
                    <label><input type="radio" name="pekerjaan_penanggung_jawab" value="tni" /> TNI</label>
                    <label><input type="radio" name="pekerjaan_penanggung_jawab" value="polisi" /> Polisi</label>
                    <label><input type="radio" name="pekerjaan_penanggung_jawab" value="bumn" /> BUMN</label>
                    <label><input type="radio" name="pekerjaan_penanggung_jawab" value="bumd" /> BUMD</label>
                    <label><input type="radio" name="pekerjaan_penanggung_jawab" value="karyawan_swasta" /> Karyawan
                        Swasta</label>
                    <label><input type="radio" name="pekerjaan_penanggung_jawab" value="petani" /> Petani</label>
                    <label><input type="radio" name="pekerjaan_penanggung_jawab" value="pedagang" /> Pedagang</label>
                    <label><input type="radio" name="pekerjaan_penanggung_jawab" value="lain-lain" /> Lain-lain</label>
                </div>
                <input type="text" id="pekerjaan_pj_lain" name="pekerjaan_pj_lain"
                    placeholder="Sebutkan pekerjaan lain..." style="display:none;margin-top:10px;" />
            </div>

            <div class="form-group">
                <label class="required">Hubungan Dengan Pasien</label>
                <div class="radio-group" id="hubungan-radio-group">
                    <label><input type="radio" name="hubungan_dengan_pasien" value="suami" required /> Suami</label>
                    <label><input type="radio" name="hubungan_dengan_pasien" value="istri" /> Istri</label>
                    <label><input type="radio" name="hubungan_dengan_pasien" value="ibu" /> Ibu</label>
                    <label><input type="radio" name="hubungan_dengan_pasien" value="ayah" /> Ayah</label>
                    <label><input type="radio" name="hubungan_dengan_pasien" value="lain-lain" /> Lain-lain</label>
                </div>
                <input type="text" id="hubungan_pasien_lain" name="hubungan_pasien_lain"
                    placeholder="Sebutkan hubungan lain..." style="display:none;margin-top:10px;" />
            </div>

            <hr>

            {{-- 3. Persetujuan --}}
            <h2>3. Persetujuan</h2>
            <div class="form-group">
                <p>
                    Saya menyatakan data yang saya berikan benar dan memberikan persetujuan
                    untuk penyimpanan serta penggunaan permanen oleh Klinik Tirta Amerta
                    dalam keperluan rekam medis dan administrasi.
                </p>

                <div class="checkbox-group">
                    <label><input type="checkbox" name="persetujuan" required /> Saya menyetujui</label>
                </div>
            </div>

            <button type="submit" class="btn-submit">Kirim Formulir</button>
        </form>
    </div>

    {{-- Pop-up sukses yang terikat dengan session Laravel --}}
    @if(session('success'))
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
        document.addEventListener('DOMContentLoaded', function () {
            // Fungsi untuk mengelola input 'lain-lain' pada radio button
            const setupOtherInput = (radioGroupName, otherInputId) => {
                const radios = document.querySelectorAll(`input[name="${radioGroupName}"]`);
                const otherInput = document.getElementById(otherInputId);

                radios.forEach(radio => {
                    radio.addEventListener('change', () => {
                        if (radio.value === 'lain-lain') {
                            otherInput.style.display = 'block';
                            otherInput.focus();
                        } else {
                            otherInput.style.display = 'none';
                            otherInput.value = '';
                        }
                    });
                });
            };

            // Menerapkan fungsi ke semua grup radio yang membutuhkan input 'lain-lain'
            setupOtherInput('pekerjaan_pasien', 'pekerjaan_pasien_lain');
            setupOtherInput('pendidikan_pasien', 'pendidikan_pasien_lain');
            setupOtherInput('pekerjaan_penanggung_jawab', 'pekerjaan_pj_lain');
            setupOtherInput('hubungan_dengan_pasien', 'hubungan_pasien_lain');

            // Pop-up hanya ada jika session 'success' ada, jadi kita tambahkan listener di sini
            const overlay = document.getElementById('successOverlay');
            if (overlay) {
                // Atur timer untuk menyembunyikan pop-up setelah 5 detik
                setTimeout(() => {
                    overlay.style.display = 'none';
                }, 5000);

                // Event listener untuk tombol 'Oke' di dalam pop-up
                document.getElementById('closePopup').addEventListener('click', function () {
                    overlay.style.display = 'none';
                });
            }
        });
    </script>
</body>

</html>