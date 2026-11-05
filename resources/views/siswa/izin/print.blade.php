<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Izin Keluar - {{ $izin->siswa->nama_lengkap }}</title>
    <style>
        @page { margin: 1cm 1.5cm; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            color: #333;
            line-height: 1.4;
        }
        
        /* Kop Surat */
        .kop-surat {
            border-bottom: 3px double #000; /* Garis ganda khas surat resmi */
            padding-bottom: 10px;
            margin-bottom: 20px;
            width: 100%;
        }
        .logo-container {
            width: 17%; /* Ruang untuk logo */
            float: left;
            text-align: center;
        }
        .logo {
            width: 80px; /* Sesuaikan ukuran logo */
            height: auto;
        }
        .instansi-container {
            width: 85%; /* Ruang untuk teks */
            float: left;
            text-align: center;
            margin-left: -7%; /* Sedikit tumpang tindih untuk kesan lebih rapat */
        }
        .instansi-container h1 { 
            margin: 0; 
            font-size: 22px; 
            color: #000;
        }
        .instansi-container h2 { 
            margin: 0; 
            font-size: 16px; 
            text-transform: uppercase;
        }
        .instansi-container p { 
            margin: 2px 0; 
            font-size: 11px; 
            font-style: italic;
        }
        .clearfix { clear: both; }

        .container { width: 100%; }
        
        .title { 
            text-align: center; 
            font-size: 15px; 
            text-decoration: underline;
            margin-bottom: 25px; 
            font-weight: bold;
            text-transform: uppercase;
        }

        .content-table { width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        .content-table td { padding: 6px 5px; vertical-align: top; font-size: 13px; }
        .label { width: 30%; }
        .separator { width: 10px; }
        .value { width: 65%; font-weight: bold; border-bottom: 1px dotted #999; }

        .footer-table { width: 100%; margin-top: 30px; }
        .ttd-box { text-align: center; width: 50%; font-size: 13px; }
        .space { height: 70px; }
        .name-tag { font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <div class="kop-surat">
        <div class="logo-container">
            <img src="{{ public_path('images/logo.png') }}" style="width: 100%;">
        </div>
        <div class="instansi-container">
            <h2>LEMBAGA PELATIHAN KERJA</h2>
            <h1>SHIROKUMA</h1>
            <p>Jl. Cipicung, RT.05/Rw08, Tugujaya, Kec. Cihideung, Kab. Tasikmalaya, Jawa Barat</p>
            <p>Email: lpkshirokuma@gmail.com | Telp: 0812-2407-4427</p>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="title">SURAT IZIN KELUAR KARANTINA</div>

    <p style="font-size: 13px;">Diberikan izin kepada siswa di bawah ini untuk meninggalkan area karantina:</p>

    <table class="content-table">
        <tr>
            <td class="label">Nama Siswa</td>
            <td class="separator">:</td>
            <td class="value">{{ $izin->siswa->nama_lengkap }}</td>
        </tr>
        <tr>
            <td class="label">Alasan Izin</td>
            <td class="separator">:</td>
            <td class="value">{{ $izin->alasan }}</td>
        </tr>
        <tr>
            <td class="label">Alamat Tujuan</td>
            <td class="separator">:</td>
            <td class="value">{{ $izin->alamat_tujuan }}</td>
        </tr>
        <tr>
            <td class="label">Waktu Keluar</td>
            <td class="separator">:</td>
            <td class="value">
                {{ \Carbon\Carbon::parse($izin->tanggal_keluar)->locale('id')->translatedFormat('d F Y') }}
                pukul {{ $izin->jam_keluar }}
            </td>
        </tr>
        <tr>
            <td class="label">Waktu Kembali</td>
            <td class="separator">:</td>
            <td class="value">
                {{ \Carbon\Carbon::parse($izin->tanggal_kembali)->locale('id')->translatedFormat('d F Y') }}
                pukul {{ $izin->jam_kembali }}
            </td>
        </tr>
        <tr>
            <td class="label">Pendamping</td>
            <td class="separator">:</td>
            <td class="value">{{ $izin->yang_menemani ?? '-' }}</td>
        </tr>
    </table>

    <p style="font-size: 11px; font-style: italic; border: 1px solid #ccc; padding: 10px;">
        <strong>PENTING:</strong> Siswa wajib melapor kembali ke Pembina/Satpam karantina saat kembali. 
        Keterlambatan tanpa alasan mendesak akan dikenakan sanksi disiplin.
    </p>

    <table class="footer-table">
        <tr>
            <td class="ttd-box">
                <p>Siswa Yang Bersangkutan,</p>
                <div class="space"></div>
                <p class="name-tag">{{ $izin->siswa->nama_lengkap }}</p>
            </td>
            <td class="ttd-box">
                <p>Tasikmalaya, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}<br>Pembina Karantina,</p>
                <div class="space"></div>
                <p class="name-tag">( ________________________ )</p>
            </td>
        </tr>
    </table>
</div>

</body>
</html>