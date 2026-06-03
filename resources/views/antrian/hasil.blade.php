<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nomor Antrian Anda</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont,
                "SF Pro Display", "Segoe UI", sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;

            background:
                linear-gradient(135deg,
                    #10b981 0%,
                    #22c55e 35%,
                    #34d399 70%,
                    #6ee7b7 100%);
        }

        .ticket {
            width: 100%;
            max-width: 750px;

            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(20px);

            border-radius: 35px;

            overflow: hidden;

            box-shadow:
                0 25px 60px rgba(0, 0, 0, .15);
        }

        .header {
            text-align: center;
            padding: 40px 30px;
        }

        /* .logo-box {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo-box img {
            width: 110px;
            height: 110px;
            object-fit: contain;

            background: white;

            border-radius: 50%;

            padding: 10px;

            box-shadow:
                0 15px 35px rgba(0, 0, 0, .12);
        } */

        .header h2 {
            margin-top: 20px;
            color: #0f172a;
            font-size: 28px;
        }

        .subtitle {
            margin-top: 10px;
            color: #64748b;
        }

        .nomor {
            margin-top: 30px;

            background:
                linear-gradient(135deg,
                    #10b981,
                    #22c55e);

            color: white;

            border-radius: 24px;

            padding: 25px;

            font-size: 90px;
            font-weight: 800;

            box-shadow:
                0 15px 35px rgba(16, 185, 129, .25);
        }

        .info {
            padding: 0 30px 30px;
        }

        .card-info {
            background: #f8fafc;
            border-radius: 24px;
            padding: 25px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 16px 0;

            border-bottom: 1px solid #e2e8f0;
        }

        .row:last-child {
            border-bottom: none;
        }

        .label {
            color: #64748b;
            font-weight: 500;
        }

        .value {
            color: #0f172a;
            font-weight: 700;
        }

        .status {
            color: #16a34a;
            font-weight: 700;
        }

        .footer {
            padding: 0 30px 30px;
        }

        .btn {
            width: 100%;

            border: none;
            cursor: pointer;

            padding: 18px;

            border-radius: 18px;

            margin-bottom: 15px;

            font-size: 15px;
            font-weight: 600;

            transition: .3s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background:
                linear-gradient(135deg,
                    #10b981,
                    #22c55e);

            color: white;

            box-shadow:
                0 10px 25px rgba(16, 185, 129, .25);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #0f172a;
        }

        .note {
            margin-top: 10px;

            text-align: center;

            color: #64748b;

            font-size: 14px;
            line-height: 1.8;
        }

        .note i {
            color: #10b981;
            margin-right: 5px;
        }

        @media(max-width:768px) {

            .nomor {
                font-size: 60px;
                padding: 20px;
            }

            .row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .header h2 {
                font-size: 24px;
            }

        }
    </style>
</head>

<body>

    <div class="ticket" id="ticketCard">

        <div class="header">

            {{-- <div class="logo-box">
                <img src="{{ asset('asset/logo TA/LOGO KLINIK PRATAMA TIRTA AMERTA NEW.png') }}"
                    alt="Logo Klinik Tirta Amerta">
            </div> --}}

            <h2>{{ $pesan }}</h2>

            @if ($antrian->payment_status == 'unpaid')
                <div
                    style="
        margin: 18px auto;
        padding: 16px 18px;
        border-radius: 16px;
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        text-align: center;
        max-width: 420px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    ">
                    <i class="fas fa-circle-exclamation" style="font-size: 20px;"></i>

                    <div>
                        <div style="font-size: 15px;">
                            Status pembayaran: BELUM BAYAR
                        </div>
                        <div style="font-size: 13px; font-weight: 500; opacity: 0.9;">
                            Silakan melakukan pembayaran di admin klinik terlebih dahulu.
                        </div>
                    </div>
                </div>
            @endif

            <p class="subtitle">
                Nomor antrean Anda berhasil dibuat
            </p>

            <div class="nomor">
                {{ $antrian->no_antrian }}
            </div>

        </div>

        <div class="info">

            <div class="card-info">

                <div class="row">
                    <span class="label">
                        <i class="fas fa-user"></i>
                        Nama Pasien
                    </span>

                    <span class="value">
                        {{ $antrian->patient->nama_pasien }}
                    </span>
                </div>

                <div class="row">
                    <span class="label">
                        <i class="fas fa-tooth"></i>
                        Pelayanan
                    </span>

                    <span class="value">
                        Poli Gigi dan Mulut
                    </span>
                </div>

                <div class="row">
                    <span class="label">
                        <i class="fas fa-circle-check"></i>
                        Status
                    </span>

                    <span class="status">
                        {{ strtoupper($antrian->status) }}
                    </span>
                </div>

                <div class="row">
                    <span class="label">
                        <i class="fas fa-wallet"></i>
                        Pembayaran
                    </span>

                    <span class="value"
                        style="
                        color: {{ $antrian->payment_status == 'sudah_bayar' ? '#16a34a' : '#dc2626' }};
                        font-weight:700;
                    ">
                        {{ strtoupper(str_replace('_', ' ', $antrian->payment_status)) }}
                    </span>
                </div>

                <div class="row">
                    <span class="label">
                        <i class="fas fa-calendar"></i>
                        Tanggal
                    </span>

                    <span class="value">
                        {{ \Carbon\Carbon::parse($antrian->tanggal)->format('d M Y H:i') }}
                    </span>
                </div>

            </div>

        </div>

        <div class="footer">

            <button onclick="downloadCard()" class="btn btn-primary">

                <i class="fas fa-image"></i>
                Simpan Sebagai Gambar

            </button>

            <a href="{{ route('monitor.antriangilut') }}">

                <button type="button" class="btn btn-secondary">

                    <i class="fas fa-tv"></i>
                    Monitor Antrian

                </button>

            </a>

            <div class="note">

                <i class="fas fa-circle-info"></i>

                Simpan atau screenshot nomor antrean ini,
                kemudian tunjukkan kepada petugas saat datang ke klinik.

            </div>

        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        function downloadCard() {

            const card = document.getElementById('ticketCard');

            html2canvas(card, {
                scale: 2
            }).then(canvas => {

                const link = document.createElement('a');

                link.download = 'antrian-{{ $antrian->no_antrian }}.png';

                link.href = canvas.toDataURL('image/png');

                link.click();

            });

        }
    </script>

</body>

</html>
