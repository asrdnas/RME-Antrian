<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambil Antrian Online</title>

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
            max-width:550px;

            background:rgba(255,255,255,0.95);
            backdrop-filter:blur(20px);

            border-radius:32px;

            box-shadow:
                0 25px 60px rgba(0,0,0,.15);

            overflow:hidden;
        }

        .header{
            padding:40px 30px;
            text-align:center;
        }

        .logo{
            width:90px;
            height:90px;

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
            font-size:38px;

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
            line-height:1.6;
        }

        .content{
            padding:0 30px 35px;
        }

        .form-group{
            margin-bottom:20px;
        }

        label{
            display:block;
            margin-bottom:8px;
            color:#334155;
            font-weight:600;
        }

        .input-wrapper{
            position:relative;
        }

        .input-wrapper i{
            position:absolute;
            left:15px;
            top:50%;
            transform:translateY(-50%);
            color:#10b981;
        }

        input{
            width:100%;
            padding:14px 14px 14px 45px;

            border:2px solid #e2e8f0;
            border-radius:16px;

            outline:none;

            transition:.3s;
            font-size:15px;
        }

        input:focus{
            border-color:#10b981;

            box-shadow:
            0 0 0 4px rgba(16,185,129,.15);
        }

        .btn{
            width:100%;

            padding:16px;

            border:none;
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

            cursor:pointer;

            transition:.3s;
        }

        .btn:hover{
            transform:translateY(-2px);

            box-shadow:
            0 10px 25px rgba(16,185,129,.35);
        }

        .alert{
            margin-bottom:20px;

            background:#fee2e2;
            color:#b91c1c;

            padding:15px;
            border-radius:14px;
        }

        .footer-note{
            margin-top:20px;

            text-align:center;

            color:#64748b;
            font-size:14px;
            line-height:1.6;
        }

        @media(max-width:768px){

            .card{
                border-radius:25px;
            }

            .header h1{
                font-size:26px;
            }

        }
    </style>
</head>
<body>

<div class="card">

    <div class="header">

        <div class="logo">
            <i class="fas fa-tooth"></i>
        </div>

        <h1>Ambil Antrian Online</h1>

        <p>
            drg. Marita Dony Istata, M.Kes
        </p>

    </div>

    <div class="content">

        @if(session('error'))
            <div class="alert">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('antrian.cek') }}">
            @csrf

            <div class="form-group">

                <label>No RME</label>

                <div class="input-wrapper">
                    <i class="fas fa-id-card"></i>

                    <input
                        type="text"
                        name="no_rme"
                        placeholder="Masukkan Nomor Rekam Medis"
                        required>
                </div>

            </div>

            <div class="form-group">

                <label>Tanggal Lahir</label>

                <div class="input-wrapper">
                    <i class="fas fa-calendar"></i>

                    <input
                        type="date"
                        name="tanggal_lahir"
                        required>
                </div>

            </div>

            <button type="submit" class="btn">

                <i class="fas fa-magnifying-glass"></i>
                Cari Data Pasien

            </button>

        </form>

        <div class="footer-note">
            Masukkan Nomor Rekam Medis (RME) dan tanggal lahir
            sesuai data yang terdaftar di klinik.
        </div>

    </div>

</div>

</body>
</html>