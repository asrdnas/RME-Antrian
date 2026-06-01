<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Konfirmasi Pasien</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:-apple-system,BlinkMacSystemFont,
    "SF Pro Display","Segoe UI",sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;

    background:
    linear-gradient(
        135deg,
        #10b981 0%,
        #22c55e 35%,
        #34d399 70%,
        #6ee7b7 100%
    );
}

.card{
    width:100%;
    max-width:650px;

    background:rgba(255,255,255,.95);
    backdrop-filter:blur(20px);

    border-radius:32px;

    box-shadow:
    0 25px 60px rgba(0,0,0,.15);

    overflow:hidden;
}

.header{
    text-align:center;
    padding:40px 30px;
}

.logo{
    width:100px;
    height:100px;

    margin:0 auto 20px;

    border-radius:50%;

    background:
    linear-gradient(
        135deg,
        #10b981,
        #22c55e
    );

    display:flex;
    justify-content:center;
    align-items:center;

    color:white;
    font-size:42px;

    box-shadow:
    0 10px 30px rgba(16,185,129,.35);
}

.header h1{
    color:#0f172a;
    font-size:32px;
    font-weight:700;
}

.header p{
    color:#64748b;
    margin-top:10px;
    line-height:1.7;
}

.patient-box{
    margin:0 25px 25px;

    background:#f8fafc;

    border-radius:24px;

    padding:25px;
}

.row{
    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:15px 0;

    border-bottom:1px solid #e2e8f0;
}

.row:last-child{
    border-bottom:none;
}

.label{
    color:#64748b;
    font-weight:500;
}

.value{
    color:#0f172a;
    font-weight:700;
}

.status{
    color:#16a34a;
    font-weight:700;
}

.btn{
    width:calc(100% - 50px);

    margin:0 25px 25px;

    border:none;
    cursor:pointer;

    padding:18px;

    border-radius:18px;

    background:
    linear-gradient(
        135deg,
        #10b981,
        #22c55e
    );

    color:white;

    font-size:16px;
    font-weight:600;

    transition:.3s;
}

.btn:hover{
    transform:translateY(-2px);

    box-shadow:
    0 10px 25px rgba(16,185,129,.35);
}

.note{
    text-align:center;

    color:#64748b;

    font-size:14px;

    padding:0 30px 30px;

    line-height:1.7;
}

@media(max-width:768px){

    .card{
        border-radius:25px;
    }

    .header h1{
        font-size:26px;
    }

    .row{
        flex-direction:column;
        align-items:flex-start;
        gap:5px;
    }

}

</style>
</head>
<body>

<div class="card">

    <div class="header">

        <div class="logo">
            <i class="fas fa-user-check"></i>
        </div>

        <h1>Data Pasien Ditemukan</h1>

        <p>
            Data pasien berhasil diverifikasi.<br>
            Silakan lanjut mengambil nomor antrean
            Poli Gigi dan Mulut.
        </p>

    </div>

    <div class="patient-box">

        <div class="row">
            <span class="label">
                <i class="fas fa-user"></i>
                Nama Pasien
            </span>

            <span class="value">
                {{ $patient->nama_pasien }}
            </span>
        </div>

        <div class="row">
            <span class="label">
                <i class="fas fa-id-card"></i>
                No RME
            </span>

            <span class="value">
                {{ $patient->no_rme }}
            </span>
        </div>

        <div class="row">
            <span class="label">
                <i class="fas fa-circle-check"></i>
                Status
            </span>

            <span class="status">
                Terverifikasi
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

    </div>

    <form method="POST" action="{{ route('antrian.simpan') }}">
        @csrf

        <input
            type="hidden"
            name="patient_id"
            value="{{ $patient->id }}">

        <button class="btn">
            <i class="fas fa-ticket"></i>
            Ambil Nomor Antrian Sekarang
        </button>
    </form>

    <div class="note">
        Pastikan data pasien sudah benar sebelum
        melanjutkan pengambilan nomor antrean.
    </div>

</div>

</body>
</html>