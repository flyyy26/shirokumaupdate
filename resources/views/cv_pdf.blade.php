<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'NotoSansJP';
            src: url("{{ storage_path('fonts/NotoSansJP-Regular.ttf') }}") format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @page {
            margin-left: 1.2cm;
            margin-right: 1.2cm;
            margin-top: 0.6cm;
            margin-bottom: 0.6cm;
        }

        body {
            font-family: 'NotoSansJP', sans-serif;
            font-size: 9px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        /* --- Header Styling --- */
        .header-container {
            width: 100%;
            margin-bottom: 13px;
        }

        .logo-cell {
            width: 12%;
            vertical-align: middle;
        }

        .header-tables-cell {
            width: 85%;
            padding-left: 10px;
        }

        .info-table {
            border: 1px solid #000;
        }

        .info-table td {
            border: 1px solid #000;
            vertical-align: middle;
            padding: 0 8px;
            padding-bottom:3px;
            height: 23px;
        }

        .heading-cell{
            border: 1px solid #000;
            vertical-align: middle;
            text-align: center;
            font-size:14px;
            line-height: 1;
        }

        .biodata-cell{
            text-align: center !important;
            font-size: 9px;
            color: #333;
        }
        .biodata-cell-heading{
            background-image: url('{{ $bgBase64 ?? "" }}');
            width:18.5%;
            vertical-align: middle;
            text-align: center !important;
            line-height: 1;
            font-size: 9px;
            color: #333;
        }

        .biodata-cell-nama{
            width: 15.5%;
            vertical-align: middle;
            text-align: center !important;
            line-height: 1;
            font-size: 9px;
            color: #333;
        }

        .biodata-cell-tgl{
            width:31%;
        }

        .label-cell {
            background-color: #ffffff;
            width: 30%;
            text-align: center;
        }

        .value-cell {
            background-image: url('{{ $bgBase64 ?? "" }}');
            width: 50%;
        }

        .suffix-cell {
            background-image: url('{{ $bgBase64 ?? "" }}');
            width: 20%;
            text-align: center;
        }

        /* --- Content Styling --- */
        .section-title {
            background-color: #d9d9d9;
            font-weight: bold;
            padding: 5px;
            border: 1px solid #000;
            text-align: center;
            margin-top: 10px;
        }

        .main-table {
            border: 1px solid #000;
        }

        .main-table th, .main-table td {
            border: 1px solid #000;
            padding: 0 5px;
            vertical-align: middle;
        }

        .photo-box {
            width: 113px; /* 3x4 ratio approx */
            height: 151px;
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
        }

        .text-center { text-align: center; }
        .text-left { text-align: left; }

    </style>
</head>
<body>

@php
    $biodata = $siswa->biodata ?? null;
    $job = $siswa->jobs->first() ?? null;
    $company = $job ? $job->company : null;
    
    $mapJepang = [
        // Tangan Dominan
        'Kanan'    => '右',
        'Kiri'     => '左',

        // Status Pernikahan
        'Belum Menikah' => '未婚',
        'Menikah'       => '既婚',
        'Cerai'         => '離婚',
    ];
    
    $mappingGinou = [
        'Tokutei Ginou' => '特定技能履歴書',
        'Ginojisshusei' => '技能実習生履歴書',
    ];
    
    $mapPekerjaanJP = [
        // Konstruksi
        'Bekesting' => '型枠施工',
        'Pemasangan Scaffolding' => '足場組立',
        'Pengecoran Beton' => 'コンクリート打ち',
        'Pemasangan Baja Tulangan' => '鉄筋組立て',
        'Pekerjaan Tanah' => '土工',
        'Pemasangan Keramik' => 'タイル張り',
        'Pengecatan Bangunan' => '建築塗装',
        'Interior Finisher' => '表装',
        
        // Makanan
        'Pengolahan Makanan' => '飲食料品製造業',
        'Pembuatan Roti' => 'パン製造',
        'Pengolahan Daging' => '食肉加工業',
        'Pembuatan Bento' => '惣菜製造業',
        'Pengolahan Produk Perikanan' => '水産加工業',

        // Manufaktur
        'Pengelasan' => '溶接',
        'Pengepresan Logam' => '金属プレス加工',
        'Permesinan' => '機械加工',
        'Pengecoran Logam' => '鋳造',
        'Perakitan Elektronik' => '電子機器組立て',
        'Pencetakan Plastik' => 'プラスチック成形',
        'Pengecatan Logam' => '金属塗装',

        // Pertanian
        'Pertanian Tanaman' => '耕種農業',
        'Peternakan Ayam' => '養鶏業',
        'Peternakan Babi' => '養豚業',
        'Peternakan Sapi' => '酪農',

        // Jasa
        'Perawat / Kaigo' => '介護',
        'Pembersihan Gedung' => 'ビルクリーニング',
        'Perhotelan' => '宿泊',
        'Restoran' => '外食業',
        'Laundry' => 'リネンサプライ',
        'Pengemasan Barang' => '荷札・梱包',
    ];
    
    $agamaJepang = [
        'Islam'    => 'イスラム教',
        'Kristen'  => 'キリスト教',
        'Katolik'  => 'カトリック',
        'Hindu'    => 'ヒンドゥー教',
        'Buddha'   => '仏教',
        'Konghucu' => '儒教',
    ];
    
    $penyakitJP = [
        'Tidak Ada Riwayat Penyakit' => '無',
        'Asma'                       => '喘息',
        'Diabetes'                   => '糖尿病',
        'Hipertensi'                 => '高血圧',
        'Tipes'                      => 'チフス',
        'Maag'                       => '胃炎',
        'Alergi Obat'                => '薬物アレルギー',
    ];
    
    $hobiJP = [
        'Membaca'   => '読書',
        'Olahraga'  => 'スポーツ',
        'Memasak'   => '料理',
        'Traveling' => '旅行',
        'Musik'     => '音楽',
        'Gaming'    => 'ゲーム',
        'Coding'    => 'コーディング',
    ];
    
    $pekerjaanJP = [
        'Ibu Rumah Tangga'  => '主婦',
        'Petani'            => '農家',
        'Buruh Harian Lepas'=> '日雇い労働者',
        'Karyawan Swasta'   => '会社員',
        'Pegawai Negeri'    => '公務員',
        'Wiraswasta'        => '自営業',
        'Guru'              => '教師',
        'Pelajar/Mahasiswa' => '学生',
        'Tenaga Medis'      => '医療関係者',
        'Sopir'             => '運転手',
        'Tidak Bekerja'     => '無職',
        'Pensiunan'         => '年金受給者',
    ];
    
    $hubunganJP = [
        'Ayah Kandung'  => '父',
        'Ibu Kandung'   => '母',
        'Ayah Tiri'     => '継父',
        'Ibu Tiri'      => '継母',
        'Ayah Angkat'   => '養父 ',
        'Ibu Angkat'    => '養母',
        'Kakak Kandung' => '兄/姉',
        'Adik Kandung'  => '弟/妹',
        'Kakak Tiri'    => '義兄/義姉',
        'Adik Tiri'     => '義弟/義妹',
        'Suami'         => '夫',
        'Istri'         => '妻',
        'Anak'          => '子',
        'Kakek'         => '祖父',
        'Nenek'         => '祖母',
        'Paman'         => '叔父',
        'Bibi'          => '叔母',
        'Sepupu'        => 'いとこ',
        'Keponakan'     => '甥/姪',
        'Mertua'        => '義父/義母',
        'Wali'          => '保護者',
    ];
    
    $jenjangJP = [
        'SD' => '小学校を卒業',
        'SMP' => '中学校を卒業',
        'SMK' => '専門高校を卒業',
        'SMA' => '高等学校を卒業',
        'Diploma 1' => '専門学校（1年課程）を卒業',
        'Diploma 2' => '専門学校（2年課程）を卒業',
        'Akademi/Diploma 3/Sarjana Muda' => '短期大学を卒業',
        'Sarjana/Diploma 4' => '大学を卒業',
        'Strata II / Magister' => '大学院修士課程を修了',
        'Strata III / Doktor' => '大学院博士課程を修了',
        'KULIAH' => '大学を卒業した'
    ];
    
    $jurusanJP = [
        // SMA
        'IPA' => '理科系',
        'IPS' => '社会系',
        'Bahasa' => '言語系',
        
        // SMK
        'Teknik Kendaraan Ringan' => '自動車整備科',
        'Teknik Sepeda Motor' => '二輪車整備科',
        'Teknik Komputer Jaringan' => 'コンピュータネットワーク科',
        'Rekayasa Perangkat Lunak' => 'ソフトウェア工学科',
        'Teknik Pemesinan' => '機械工学科',
        'Teknik Pengelasan' => '溶接科',
        'Akuntansi' => '会計科',
        'Perkantoran' => '事務管理科',
        'Keperawatan' => '看護科',
        'Tata Boga' => '調理科',
        'Tata Busana' => 'ファッションデザイン科',
        
        // KULIAH
        'Hukum' => '法学',
        'Ekonomi' => '経済学',
        'Kedokteran' => '医学',
        'Teknik Informatika' => '情報工学',
        'Sistem Informasi' => '情報システム学',
        'Psikologi' => '心理学',
        'Sastra Jepang' => '日本文学',
        'Manajemen' => '経営学',
        'Pendidikan Guru' => '教育学',
        'Pertanian' => '農学',
        
        // Umum (SD/SMP)
        'Umum' => 'ー',
        'Tidak Ada' => 'ー',
    ];
    
    $monthMap = [
        'Januari' => '1', 'Februari' => '2', 'Maret' => '3', 'April' => '4',
        'Mei' => '5', 'Juni' => '6', 'Juli' => '7', 'Agustus' => '8',
        'September' => '9', 'Oktober' => '10', 'November' => '11', 'Desember' => '12',
        'January' => '1', 'February' => '2', 'March' => '3', 'May' => '5', 
        'June' => '6', 'July' => '7', 'August' => '8', 'October' => '10', 'December' => '12'
    ];
@endphp

    <table class="header-container">
        <tr>
            <td class="logo-cell">
                @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" style="width: 100%; max-width: 100px; display: block; margin: 0 auto;" 
                         onerror="this.style.display='none'; console.log('Logo error');">
                @else
                    <div style="width: 100%; min-height: 60px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; background-color: #f9f9f9;">
                        <span style="color: #999;">LOGO</span>
                    </div>
                @endif
            </td>
            <td class="header-tables-cell">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 58%; padding-right: 4px; vertical-align: center;">
                            <table class="info-table">
                                <tr>
                                    <td class="label-cell">受け入れ企業</td>
                                    <td class="value-cell">
                                        {{ $company ? ($company->nama_jepang ?: $company->nama_perusahaan) : '' }}
                                    </td>
                                    <td class="suffix-cell">様</td>
                                </tr>
                                <tr>
                                    <td class="label-cell">監理団体</td>
                                    <td class="value-cell">
                                        {{ $company ? ($company->nama_pic_jepang ?: $company->nama_pic) : '' }}
                                    </td>
                                    <td class="suffix-cell">様</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 42%; padding-left: 4px; vertical-align: top;">
                            <table class="info-table">
                                <tr>
                                    <td class="label-cell" style="width: 22%;">類種</td>
                                    <td class="value-cell" style="width: 78%;">
                                        @php
                                            $valueRaw = $job->jenis_ginou ?? '';
                                            $tampilanJepang = $mappingGinou[$valueRaw] ?? $valueRaw;
                                        @endphp
                                        {{ $tampilanJepang }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-cell">分野</td>
                                    @php
                                        $pekerjaanDb = $job->jenis_pekerjaan ?? '';
                                        $tampilanPdf = $mapPekerjaanJP[$pekerjaanDb] ?? $pekerjaanDb;
                                    @endphp
                                    <td class="value-cell">{{ $tampilanPdf }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table style="width: 100%; margin-bottom:5px;">
        <tr>
            <td style="width: 100%; vertical-align: center;">
                <table class="info-table">
                    <tr>
                        <td class="heading-cell" style="width:14%;">番号 </td>
                        <td class="heading-cell" style="width:23%;">{{ $urutanSiswa }}</td>
                        <td class="heading-cell" style="width:63%;">
                            @php
                                $valueRaw = $job->jenis_ginou ?? '';
                                $tampilanJepang = $mappingGinou[$valueRaw] ?? $valueRaw;
                            @endphp
                            {{ $tampilanJepang }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="header-container" style="padding-right:2px; margin-bottom: 6px;">
        <tr>
            <td style="width: 77%; vertical-align: top; padding-right: 7px;">
                <table class="info-table" style="table-layout: fixed;">
                    <tr>
                        <td class="biodata-cell-heading" rowspan="9" style="width: 18.5%;">本人</td>
                        <td class="bg-grey text-center" rowspan="3" style="width: 15%;">氏名</td>
                        <td class="bg-grey text-center" style="width: 15%;">カタカナ</td>
                        <td class="biodata-cell" colspan="5" style="width: 65%;">{{ $siswa->nama_lengkap_katakana ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">ローマ字</td>
                        <td class="biodata-cell" colspan="5" style="font-weight: bold;">{{ $siswa->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">呼び名</td>
                        <td class="biodata-cell" colspan="5">{{ $siswa->nama_panggilan_katakana ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">生年月日</td>
                        <td class="biodata-cell" colspan="2">{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y年 m月 d日') : '-' }}</td>
                        <td class="bg-grey text-center" style="width: 10%;">年齢</td>
                        <td class="biodata-cell" style="width: 10%;">{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->age : '-' }}</td>
                        <td class="bg-grey text-center" style="width: 10%;">性別</td>
                        <td class="biodata-cell" style="width: 15%;">{{ isset($siswa->jenis_kelamin) ? ($siswa->jenis_kelamin == 'L' ? '男' : '女') : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">現住所</td>
                        <td class="biodata-cell" colspan="6" style="font-size: 9px; text-align: center !important; text-transform:uppercase; padding:5px 60px; line-height:1;">
                            {{ $siswa->alamat ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">婚姻状況</td>
                        <td class="biodata-cell">
                            @if($biodata && $biodata->status_perkawinan)
                                {{ $mapJepang[$biodata->status_perkawinan] ?? $biodata->status_perkawinan }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="bg-grey text-center">裸眼</td>
                        <td class="bg-grey text-center">左</td>
                        <td class="biodata-cell">{{ $biodata->kondisi_mata_kiri ?? '-' }}</td>
                        <td class="bg-grey text-center">右</td>
                        <td class="biodata-cell">{{ $biodata->kondisi_mata_kanan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">身長</td>
                        <td class="biodata-cell">{{ isset($biodata->tinggi_badan) ? $biodata->tinggi_badan . ' cm' : '-' }}</td>
                        <td class="bg-grey text-center">矯正視力</td>
                        <td class="bg-grey text-center">左</td>
                        <td class="biodata-cell">{{ ($biodata->kacamata ?? '') == 'Ya' ? '有' : '-' }}</td>
                        <td class="bg-grey text-center">右</td>
                        <td class="biodata-cell">{{ ($biodata->kacamata ?? '') == 'Ya' ? '有' : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">体重</td>
                        <td class="biodata-cell">{{ isset($biodata->berat_badan) ? $biodata->berat_badan . ' kg' : '-' }}</td>
                        <td class="bg-grey text-center" colspan="2">血液型</td>
                        <td class="biodata-cell" colspan="3">{{ isset($biodata->golongan_darah) ? $biodata->golongan_darah . ' 型' : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">利き手</td>
                        <td class="biodata-cell">
                            @php
                                $tanganDominan = $biodata->tangan_dominan ?? '-';
                            @endphp
                            {{ $mapJepang[$tanganDominan] ?? $tanganDominan }}
                        </td>
                        <td class="bg-grey text-center" colspan="2">宗教</td>
                        <td class="biodata-cell" colspan="3">
                            {{ $agamaJepang[$siswa->agama] ?? ($siswa->agama ?? '-') }}
                        </td>
                    </tr>
                </table>
            </td>

            <td style="width: 23%; vertical-align: center;">
                @if(!empty($fotoBase64))
                    <div style="
                        width: 100%;
                        height: 258px;
                        background-image: url('{{ $fotoBase64 }}');
                        background-size: cover;
                        background-position: center;
                        background-repeat: no-repeat;
                        border: 1px solid #000;
                    ">
                    </div>
                @else
                    <div style="width: 100%; height: 254px; border: 1px solid #000; display: flex; align-items: center; justify-content: center; color: #ccc;">FOTO 3x4</div>
                @endif
            </td>
        </tr>
    </table>

    <table class="header-container" style="margin-bottom: 6px;">
        <tr>
            <td style="width: 100%; vertical-align: top;">
                <table class="info-table" style="table-layout: fixed;">
                    <tr>
                        <td class="biodata-cell-heading" rowspan="{{ max(1, $siswa->pendidikans->count()) + 1 }}" style="width: 14%;">学歴</td>
                        <td class="bg-grey text-center" style="width:25%;">期間 </td>
                        <td class="bg-grey text-center" style="width:45%;">学校名</td>
                        <td class="bg-grey text-center" style="width:16%;">学部・専攻</td>
                    </tr>
                    @forelse($siswa->pendidikans as $edu)
                        <tr>
                            <td class="bg-grey text-center" style="width:25%;">
                                @php
                                    // Konversi bulan masuk
                                    $rawBulanMasuk = $edu->bulan_masuk ?? '';
                                    $angkaBulanMasuk = $monthMap[$rawBulanMasuk] ?? (is_numeric($rawBulanMasuk) ? $rawBulanMasuk : null);
                                    $tampilanBulanMasuk = $angkaBulanMasuk ? $angkaBulanMasuk . '月' : '-';

                                    // Format tanggal lulus
                                    $tampilanLulus = '-';
                                    if ($edu->tanggal_lulus) {
                                        $dateLulus = \Carbon\Carbon::parse($edu->tanggal_lulus);
                                        $tampilanLulus = $dateLulus->format('Y') . '年' . $dateLulus->format('n') . '月';
                                    }

                                    $tahunMasuk = $edu->tahun_masuk ?? '-';
                                @endphp
                                {{ $tahunMasuk }}年{{ $tampilanBulanMasuk }} ～ {{ $tampilanLulus }}
                            </td>
                            <td class="bg-grey text-center" style="width:45%; text-transform:uppercase;">
                                @php
                                    $namaSekolah = $edu->nama_sekolah ?? '-';
                                    $jenjangRaw = $edu->jenjang_pendidikan ?? '';
                                    $terjemahan = $jenjangJP[$jenjangRaw] ?? $jenjangRaw;
                                @endphp
                                {{ $namaSekolah }} <br> {{ $terjemahan }}
                            </td>
                            <td class="bg-grey text-center" style="width:16%;">
                                @php
                                    $jurusanRaw = $edu->jurusan ?? '';
                                    $tampilanJurusan = $jurusanJP[$jurusanRaw] ?? ($jurusanRaw ?? '-');
                                @endphp
                                {{ $tampilanJurusan }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="bg-grey text-center" style="width:25%;">-</td>
                            <td class="bg-grey text-center" style="width:45%;">-</td>
                            <td class="bg-grey text-center" style="width:16%;">-</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td class="biodata-cell-heading" style="width:25%;">日本語学校</td>
                        <td class="bg-grey text-center" style="width:25%;">
                            @php
                                $periodeRaw = $biodata->periode_mulai ?? '-';
                                $tampilanJepang = $periodeRaw;

                                if ($periodeRaw !== '-') {
                                    $parts = explode(' ', $periodeRaw);
                                    if (count($parts) >= 2) {
                                        $namaBulan = $parts[0];
                                        $tahun = $parts[1];
                                        $angkaBulan = $monthMap[$namaBulan] ?? $namaBulan;
                                        $tampilanJepang = $tahun . '年' . $angkaBulan . '月';
                                    }
                                }
                            @endphp
                            {{ $tampilanJepang }} ～ 現在
                        </td>
                        <td class="bg-grey text-center" style="width:45%;">LPK SHIROKUMA</td>
                        <td class="bg-grey text-center" style="width:16%;">日本語能力: {{ $biodata->level_bahasa_jepang ?? '-' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="header-container" style="margin-bottom: 6px;">
        <tr>
            <td style="width: 100%; vertical-align: top;">
                <table class="info-table" style="table-layout: fixed;">
                    <tr>
                        <td class="biodata-cell-heading" style="width:14%;" rowspan="{{ max(1, $siswa->riwayatPekerjaans->count()) + 1 }}">職 歴</td>
                        <td class="bg-grey text-center" style="width:25%;">期間 </td>
                        <td class="bg-grey text-center" style="width:20%;">会社名</td>
                        <td class="bg-grey text-center" style="width:18%;">職種</td>
                        <td class="bg-grey text-center" style="width:9%;">在留資格 </td>
                        <td class="bg-grey text-center" style="width:14%">月給 </td>
                    </tr>
                    @forelse($siswa->riwayatPekerjaans as $work)
                        <tr>
                            <td class="bg-grey text-center" style="width:25%;">
                                @php
                                    $formatBulan = function($bulan) use ($monthMap) {
                                        if (empty($bulan)) return '-';
                                        $angkaBulan = $monthMap[$bulan] ?? (is_numeric($bulan) ? $bulan : null);
                                        return $angkaBulan ? $angkaBulan . '月' : $bulan;
                                    };

                                    $bulanMulai = $formatBulan($work->bulan_mulai ?? '');
                                    $bulanSelesai = $formatBulan($work->bulan_selesai ?? '');
                                    
                                    $tahunMulai = $work->tahun_mulai ?? '-';
                                    $tahunSelesai = $work->tahun_selesai ?? '-';
                                @endphp

                                @if($tahunMulai == '-' && $bulanMulai == '-')
                                    -
                                @else
                                    {{ $tahunMulai }}年{{ $bulanMulai }} ～ 
                                    @if(empty($tahunSelesai) || $tahunSelesai == 'Sekarang' || $tahunSelesai == '-')
                                        現在
                                    @else
                                        {{ $tahunSelesai }}年{{ $bulanSelesai }}
                                    @endif
                                @endif
                            </td>
                            <td class="bg-grey text-center" style="width:20%; text-transform:uppercase;">{{ $work->nama_perusahaan ?? '-' }}</td>
                            <td class="bg-grey text-center" style="width:18%; text-transform:uppercase;">{{ $work->nama_pekerjaan_katakana ?? '-' }}</td>
                            <td class="bg-grey text-center" style="width:9%;">{{ $work->pengalaman_jepang ?? '-' }}</td>
                            <td class="bg-grey text-center" style="width:14%;">
                                @php
                                    $gajiRupiah = $work->gaji_perbulan ?? null;
                                    $kursYen = 105;
                                    
                                    if ($gajiRupiah) {
                                        $gajiYen = round($gajiRupiah / $kursYen);
                                        $tampilanGaji = '¥ ' . number_format($gajiYen, 0, '.', ',');
                                    } else {
                                        $tampilanGaji = '-';
                                    }
                                @endphp
                                {{ $tampilanGaji }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="bg-grey text-center" style="width:25%;">-</td>
                            <td class="bg-grey text-center" style="width:20%;">-</td>
                            <td class="bg-grey text-center" style="width:18%;">-</td>
                            <td class="bg-grey text-center" style="width:9%;">-</td>
                            <td class="bg-grey text-center" style="width:14%;">-</td>
                        </tr>
                    @endforelse
                </table>
            </td>
        </tr>
    </table>

    <table class="header-container" style="margin-bottom: 6px;">
        <tr>
            <td style="width: 100%; vertical-align: top;">
                <table class="info-table" style="table-layout: fixed;">
                    <tr>
                        <td class="biodata-cell-heading" style="width:14%;">自己PR</td>
                        <td class="bg-grey" style="
                            padding:6px 8px;
                            font-size:10px;
                            line-height:1.35;
                            text-align:justify;
                            text-indent:10px;
                            word-break:break-word;
                        ">
                            @php
                                $jikoPiaru = $siswa->jikoPiaru ?? null;
                                $contentJp = $jikoPiaru->content_jp ?? '-';
                                $contentJp = trim(preg_replace("/\n{2,}/", "\n", $contentJp));
                            @endphp
                            {!! nl2br(e($contentJp)) !!}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="header-container" style="margin-bottom: 6px;">
        <tr>
            <td style="width: 100%; vertical-align: top;">
                <table class="info-table" style="table-layout: fixed;">
                    @php
                        $certCount = $siswa->sertifikats->count();
                        $rowspanCount = ($certCount > 0 ? $certCount : 1) + 1;
                    @endphp

                    <tr>
                        <td class="biodata-cell-heading" style="width:14%;" rowspan="{{ $rowspanCount }}">資格取得</td>
                        <td class="bg-grey text-center" style="width:40%;">証明書名</td>
                        <td class="bg-grey text-center" style="width:32%;">発行日</td>
                        <td class="bg-grey text-center" style="width:14%;">レベル</td>
                    </tr>

                    @forelse($siswa->sertifikats as $cert)
                        <tr>
                            <td class="text-center" style="text-transform:uppercase;">{{ $cert->nama_sertifikat ?? '-' }}</td>
                            <td class="text-center">
                                {{ $cert->tanggal_diterbitkan ? \Carbon\Carbon::parse($cert->tanggal_diterbitkan)->format('Y年m月d日') : '-' }}
                            </td>
                            <td class="text-center">{{ $cert->level_jlpt ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                        </tr>
                    @endforelse
                </table>
            </td>
        </tr>
    </table>

    <table class="header-container" style="margin-bottom: 6px;">
        <tr>
            <td style="width: 100%; vertical-align: top;">
                <table class="info-table" style="table-layout: fixed;">
                    <tr>
                        <td class="biodata-cell-heading" style="width:14%;" rowspan="{{ max(1, $siswa->keluargas->count()) + 1 }}">家族構成</td>
                        <td class="bg-grey text-center" style="width:14%;">続柄</td>
                        <td class="bg-grey text-center" style="width:27%;">氏名</td>
                        <td class="bg-grey text-center" style="width:6%;">年齢</td>
                        <td class="bg-grey text-center" style="width:15%;">業職</td>
                        <td class="bg-grey text-center" style="width:12%;">同居</td>
                        <td class="bg-grey text-center" style="width:12%;">別居</td>
                    </tr>
                    @forelse($siswa->keluargas as $fam)
                    <tr>
                        <td class="bg-grey text-center" style="width:14%;">
                            @php
                                $val = $fam->hubungan_keluarga ?? '';
                            @endphp
                            {{ $hubunganJP[$val] ?? ($val ?? '-') }}
                        </td>
                        <td class="bg-grey text-center" style="width:27%; text-transform:uppercase;">{{ $fam->nama ?? '-' }}</td>
                        <td class="bg-grey text-center" style="width:6%;">{{ $fam->tanggal_lahir ? \Carbon\Carbon::parse($fam->tanggal_lahir)->age : '-' }}</td>
                        <td class="bg-grey text-center">
                            @php
                                $work = $fam->pekerjaan ?? '';
                            @endphp
                            {{ $pekerjaanJP[$work] ?? ($work ?? '-') }}
                        </td>
                        <td class="bg-grey text-center" style="width:12%;">
                            <div style="width:6px; height:6px; border-radius:100%; background-color:{{ ($fam->alamat_tinggal ?? '') == 'Satu Rumah' ? 'black' : 'transparent' }}; border:1px solid {{ ($fam->alamat_tinggal ?? '') == 'Satu Rumah' ? 'transparent' : 'black' }}; margin:auto;"></div>
                        </td>
                        <td class="bg-grey text-center" style="width:12%;">
                            <div style="width:6px; height:6px; border-radius:100%; background-color:{{ ($fam->alamat_tinggal ?? '') != 'Satu Rumah' ? 'black' : 'transparent' }}; border:1px solid {{ ($fam->alamat_tinggal ?? '') != 'Satu Rumah' ? 'transparent' : 'black' }}; margin:auto;"></div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td class="bg-grey text-center" style="width:14%;">-</td>
                            <td class="bg-grey text-center" style="width:27%;">-</td>
                            <td class="bg-grey text-center" style="width:6%;">-</td>
                            <td class="bg-grey text-center" style="width:15%;">-</td>
                            <td class="bg-grey text-center" style="width:12%;">-</td>
                            <td class="bg-grey text-center" style="width:12%;">-</td>
                        </tr>
                    @endforelse
                </table>
            </td>
        </tr>
    </table>

    <table class="header-container" style="margin-bottom: 6px;">
        <tr>
            <td style="width: 100%; vertical-align: top;">
                <table class="info-table" style="table-layout: fixed;">
                    <tr>
                        <td class="biodata-cell-heading" style="width:14%;" rowspan="7">事前確認 情報</td>
                        <td class="bg-grey text-center" style="width:4%; background-image: url('{{ $bgBase64 ?? "" }}');">1</td>
                        <td class="bg-grey text-center" style="width:20%; background-image: url('{{ $bgBase64 ?? "" }}');">入れ墨</td>
                        <td class="bg-grey text-center" style="width:20%;">{{ ($biodata->tatto ?? '') == 'Ya' ? '有' : '無' }}</td>
                        <td class="bg-grey text-center" style="width:4%; background-image: url('{{ $bgBase64 ?? "" }}');">8</td>
                        <td class="bg-grey text-center" style="width:19%; background-image: url('{{ $bgBase64 ?? "" }}');">何年間働きたい？ </td>
                        <td class="bg-grey text-center" style="width:19%;">{{ $biodata->rencana_lama_di_jepang ?? '-' }}年間</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:4%; background-image: url('{{ $bgBase64 ?? "" }}');">2 </td>
                        <td class="bg-grey text-center" style="width:20%; background-image: url('{{ $bgBase64 ?? "" }}');">喫煙</td>
                        <td class="bg-grey text-center" style="width:20%;">{{ ($biodata->merokok ?? '') == 'Ya' ? '吸う' : '吸わない' }} </td>
                        <td class="bg-grey text-center" style="width:4%; background-image: url('{{ $bgBase64 ?? "" }}');">9</td>
                        <td class="bg-grey text-center" style="width:19%; background-image: url('{{ $bgBase64 ?? "" }}');">大きな病気やケガ、手術 </td>
                        <td class="bg-grey text-center" style="width:19%;">
                            @php
                                $val = $biodata->riwayat_penyakit ?? '';
                            @endphp
                            {{ $penyakitJP[$val] ?? ($val ?: '無') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:4%; background-image: url('{{ $bgBase64 ?? "" }}');">3</td>
                        <td class="bg-grey text-center" style="width:20%; background-image: url('{{ $bgBase64 ?? "" }}');">飲酒</td>
                        <td class="bg-grey text-center" style="width:20%;">{{ ($biodata->peminum_alkohol ?? '') == 'Ya' ? '飲む' : '飲まない' }} </td>
                        <td class="bg-grey text-center" style="width:4%; background-image: url('{{ $bgBase64 ?? "" }}');">10</td>
                        <td class="bg-grey text-center" style="width:19%; background-image: url('{{ $bgBase64 ?? "" }}');">アレルギー </td>
                        <td class="bg-grey text-center" style="width:19%;">
                            @php
                                $statusAlergi = $biodata->alergi ?? '';
                            @endphp
                            @if($statusAlergi == 'Ya')
                                あり
                            @elseif($statusAlergi == 'Tidak')
                                なし
                            @else
                                {{ $statusAlergi ?: '無' }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:4%; background-image: url('{{ $bgBase64 ?? "" }}');">4</td>
                        <td class="bg-grey text-center" style="width:20%; background-image: url('{{ $bgBase64 ?? "" }}');">色覚異常 </td>
                        <td class="bg-grey text-center" style="width:20%;">{{ ($biodata->buta_warna ?? '') == 'Ya' ? '有' : '無' }} </td>
                        <td class="bg-grey text-center" style="width:4%; background-image: url('{{ $bgBase64 ?? "" }}');">11</td>
                        <td class="bg-grey text-center" style="width:19%; background-image: url('{{ $bgBase64 ?? "" }}');">電話番号 </td>
                        <td class="bg-grey text-center" style="width:19%;">{{ $siswa->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:4%; background-image: url('{{ $bgBase64 ?? "" }}');">5</td>
                        <td class="bg-grey text-center" style="width:20%; background-image: url('{{ $bgBase64 ?? "" }}');">虫歯 </td>
                        <td class="bg-grey text-center" style="width:20%;">{{ ($biodata->gigi_berlubang ?? '') == 'Ya' ? '有' : '無' }} </td>
                        <td class="bg-grey text-center" style="width:4%; background-image: url('{{ $bgBase64 ?? "" }}');">12</td>
                        <td class="bg-grey text-center" style="width:19%; background-image: url('{{ $bgBase64 ?? "" }}');">骨折</td>
                        <td class="bg-grey text-center" style="width:19%;">
                            @php
                                $statusPatahTulang = $biodata->patah_tulang ?? '';
                            @endphp
                            @if($statusPatahTulang == 'Ya')
                                あり
                            @elseif($statusPatahTulang == 'Tidak')
                                なし
                            @else
                                {{ $statusPatahTulang ?: '無' }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:4%; background-image: url('{{ $bgBase64 ?? "" }}');">6</td>
                        <td class="bg-grey text-center" style="width:20%; background-image: url('{{ $bgBase64 ?? "" }}');">趣味  </td>
                        <td class="bg-grey text-center" style="width:20%;">
                            @php
                                $hobiData = $biodata->hobi ?? [];
                                if (is_string($hobiData)) {
                                    $hobiArray = json_decode($hobiData, true) ?: explode(',', $hobiData);
                                } else {
                                    $hobiArray = (array) $hobiData;
                                }

                                $translatedHobi = array_map(function($item) use ($hobiJP) {
                                    $trimmedItem = trim($item);
                                    return $hobiJP[$trimmedItem] ?? $trimmedItem;
                                }, $hobiArray);
                            @endphp
                            {{ !empty($translatedHobi) ? implode(', ', $translatedHobi) : '-' }}
                        </td>
                        <td class="bg-grey text-center" style="width:4%; background-image: url('{{ $bgBase64 ?? "" }}');">13</td>
                        <td class="bg-grey text-center" style="width:19%; background-image: url('{{ $bgBase64 ?? "" }}');">ウエストライン</td>
                        <td class="bg-grey text-center" style="width:19%;">
                            @php
                                $ukuranPinggang = $biodata->ukuran_pinggang ?? '';
                            @endphp
                            @if(!empty($ukuranPinggang) && is_numeric($ukuranPinggang))
                                {{ mb_convert_kana($ukuranPinggang, "R") }} cm
                            @elseif(!empty($ukuranPinggang))
                                {{ $ukuranPinggang }}
                            @else
                                ー
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:4%; background-image: url('{{ $bgBase64 ?? "" }}');">7</td>
                        <td class="bg-grey text-center" style="width:20%; background-image: url('{{ $bgBase64 ?? "" }}');">靴のサイズ</td>
                        <td class="bg-grey text-center" style="width:20%;">
                            @php
                                $ukuranSepatu = $biodata->ukuran_sepatu ?? '';
                            @endphp
                            @if(!empty($ukuranSepatu) && is_numeric($ukuranSepatu))
                                {{ mb_convert_kana($ukuranSepatu, "R") }} cm
                            @elseif(!empty($ukuranSepatu))
                                {{ $ukuranSepatu }}
                            @else
                                ー
                            @endif
                        </td>
                        <td class="bg-grey text-center" style="width:4%; background-image: url('{{ $bgBase64 ?? "" }}');"></td>
                        <td class="bg-grey text-center" style="width:19%; background-image: url('{{ $bgBase64 ?? "" }}');"> </td>
                        <td class="bg-grey text-center" style="width:19%;"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table style="width:100%;">
        <tr>
            <td style="text-align:right; font-size:14px;">LPK SHIROKUMA</td>
        </tr>
    </table>

</body>
</html>