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
            margin-bottom: 10px;
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
            padding-bottom: 3px;
            height: 23px;
        }

        .heading-cell {
            border: 1px solid #000;
            vertical-align: middle;
            text-align: center;
            font-size: 14px;
            line-height: 1;
        }

        .biodata-cell {
            text-align: center !important;
            font-size: 9px;
            color: #333;
        }

        .biodata-cell-heading {
            background-image: url('{{ $bgBase64 ?? "" }}');
            width: 14%;
            vertical-align: middle;
            text-align: center !important;
            line-height: 1;
            font-size: 9px;
            color: #333;
            font-weight: bold;
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

        .main-table th, .main-table td {
            border: 1px solid #000;
            padding: 0 5px;
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
        'Kanan' => '右', 'Kiri' => '左',
        'Belum Menikah' => '未婚', 'Menikah' => '既婚', 'Cerai' => '離婚',
    ];
    
    $mappingGinou = [
        'Tokutei Ginou' => '特定技能履歴書',
        'Ginojisshusei' => '技能実習生履歴書',
    ];
    
    $mapPekerjaanJP = [
        'Bekesting' => '型枠施工', 'Pemasangan Scaffolding' => '足場組立',
        'Pengecoran Beton' => 'コンクリート打ち', 'Pemasangan Baja Tulangan' => '鉄筋組立て',
        'Pekerjaan Tanah' => '土工', 'Pemasangan Keramik' => 'タイル張り',
        'Pengecatan Bangunan' => '建築塗装', 'Interior Finisher' => '表装',
        'Pengolahan Makanan' => '飲食料品製造業', 'Pembuatan Roti' => 'パン製造',
        'Pengolahan Daging' => '食肉加工業', 'Pembuatan Bento' => '惣菜製造業',
        'Pengolahan Produk Perikanan' => '水産加工業', 'Pengelasan' => '溶接',
        'Pengepresan Logam' => '金属プレス加工', 'Permesinan' => '機械加工',
        'Pengecoran Logam' => '鋳造', 'Perakitan Elektronik' => '電子機器組立て',
        'Pencetakan Plastik' => 'プラスチック成形', 'Pengecatan Logam' => '金属塗装',
        'Pertanian Tanaman' => '耕種農業', 'Peternakan Ayam' => '養鶏業',
        'Peternakan Babi' => '養豚業', 'Peternakan Sapi' => '酪農',
        'Perawat / Kaigo' => '介護', 'Pembersihan Gedung' => 'ビルクリーニング',
        'Perhotelan' => '宿泊', 'Restoran' => '外食業',
        'Laundry' => 'リネンサプライ', 'Pengemasan Barang' => '荷札・梱包',
    ];
    
    $agamaJepang = [
        'Islam' => 'イスラム教', 'Kristen' => 'キリスト教', 'Katolik' => 'カトリック',
        'Hindu' => 'ヒンドゥー教', 'Buddha' => '仏教', 'Konghucu' => '儒教',
    ];
    
    $penyakitJP = [
        'Tidak Ada Riwayat Penyakit' => '無', 'Asma' => '喘息', 'Diabetes' => '糖尿病',
        'Hipertensi' => '高血圧', 'Tipes' => 'チフス', 'Maag' => '胃炎', 'Alergi Obat' => '薬物アレルギー',
    ];
    
    $hobiJP = [
        'Membaca' => '読書', 'Olahraga' => 'スポーツ', 'Memasak' => '料理',
        'Traveling' => '旅行', 'Musik' => '音楽', 'Gaming' => 'ゲーム', 'Coding' => 'コーディング',
    ];
    
    $pekerjaanJP = [
        'Ibu Rumah Tangga' => '主婦', 'Petani' => '農家', 'Buruh Harian Lepas' => '日雇い労働者',
        'Karyawan Swasta' => '会社員', 'Pegawai Negeri' => '公務員', 'Wiraswasta' => '自営業',
        'Guru' => '教師', 'Pelajar/Mahasiswa' => '学生', 'Tenaga Medis' => '医療関係者',
        'Sopir' => '運転手', 'Tidak Bekerja' => '無職', 'Pensiunan' => '年金受給者',
    ];
    
    $hubunganJP = [
        'Ayah Kandung' => '父', 'Ibu Kandung' => '母', 'Ayah Tiri' => '継父', 'Ibu Tiri' => '継母',
        'Ayah Angkat' => '養父 ', 'Ibu Angkat' => '養母', 'Kakak Kandung' => '兄/姉',
        'Adik Kandung' => '弟/妹', 'Kakak Tiri' => '義兄/義姉', 'Adik Tiri' => '義弟/義妹',
        'Suami' => '夫', 'Istri' => '妻', 'Anak' => '子', 'Kakek' => '祖父',
        'Nenek' => '祖母', 'Paman' => '叔父', 'Bibi' => '叔母', 'Sepupu' => 'いとこ',
        'Keponakan' => '甥/姪', 'Mertua' => '義父/義母', 'Wali' => '保護者',
    ];
    
    $jenjangJP = [
        'SD' => '小学校を卒業', 'SMP' => '中学校を卒業', 'SMK' => '専門高校を卒業',
        'SMA' => '高等学校を卒業', 'Diploma 1' => '専門学校（1年課程）を卒業',
        'Diploma 2' => '専門学校（2年課程）を卒業', 'Akademi/Diploma 3/Sarjana Muda' => '短期大学を卒業',
        'Sarjana/Diploma 4' => '大学を卒業', 'Strata II / Magister' => '大学院修士課程を修了',
        'Strata III / Doktor' => '大学院博士課程を修了', 'KULIAH' => '大学を卒業した'
    ];
    
    $jurusanJP = [
        'IPA' => '理科系', 'IPS' => '社会系', 'Bahasa' => '言語系',
        'Teknik Kendaraan Ringan' => '自動車整備科', 'Teknik Sepeda Motor' => '二輪車整備科',
        'Teknik Komputer Jaringan' => 'コンピュータネットワーク科', 'Rekayasa Perangkat Lunak' => 'ソフトウェア工学科',
        'Teknik Pemesinan' => '機械工学科', 'Teknik Pengelasan' => '溶接科', 'Akuntansi' => '会計科',
        'Perkantoran' => '事務管理科', 'Keperawatan' => '看護科', 'Tata Boga' => '調理科',
        'Tata Busana' => 'ファッションデザイン科', 'Hukum' => '法学', 'Ekonomi' => '経済学',
        'Kedokteran' => '医学', 'Teknik Informatika' => '情報工学', 'Sistem Informasi' => '情報システム学',
        'Psikologi' => '心理学', 'Sastra Jepang' => '日本文学', 'Manajemen' => '経営学',
        'Pendidikan Guru' => '教育学', 'Pertanian' => '農学', 'Umum' => 'ー', 'Tidak Ada' => 'ー',
    ];
    
    $monthMap = [
        'Januari' => '1', 'Februari' => '2', 'Maret' => '3', 'April' => '4',
        'Mei' => '5', 'Juni' => '6', 'Juli' => '7', 'Agustus' => '8',
        'September' => '9', 'Oktober' => '10', 'November' => '11', 'Desember' => '12',
        'January' => '1', 'February' => '2', 'March' => '3', 'May' => '5', 
        'June' => '6', 'July' => '7', 'August' => '8', 'October' => '10', 'December' => '12'
    ];
@endphp

    <!-- HEADER -->
    <table class="header-container">
        <tr>
            <td class="logo-cell">
                @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" style="width: 100%; max-width: 100px; display: block; margin: 0 auto;" onerror="this.style.display='none';">
                @else
                    <div style="width: 100%; min-height: 60px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; background-color: #f9f9f9;">
                        <span style="color: #999;">LOGO</span>
                    </div>
                @endif
            </td>
            <td class="header-tables-cell">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 58%; padding-right: 4px; vertical-align: top;">
                            <table class="info-table">
                                <tr>
                                    <td class="label-cell">受け入れ企業</td>
                                    <td class="value-cell">{{ $company ? ($company->nama_jepang ?: $company->nama_perusahaan) : '' }}</td>
                                    <td class="suffix-cell">様</td>
                                </tr>
                                <tr>
                                    <td class="label-cell">監理団体</td>
                                    <td class="value-cell">{{ $company ? ($company->nama_pic_jepang ?: $company->nama_pic) : '' }}</td>
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

    <!-- BIODATA & FOTO -->
    <table class="header-container" style="margin-bottom: 6px;">
        <tr>
            <td style="width: 80%; vertical-align: top; padding-right: 7px;">
                <table class="info-table" style="table-layout: fixed;">
                    <tr>
                        <td class="bg-grey text-center" style="width: 15%;">氏名</td>
                        <td class="biodata-cell" colspan="4" style="font-weight: bold; width: 50%;">{{ $siswa->nama_lengkap ?? '-' }}</td>
                        <td class="bg-grey text-center" style="width: 15%;">性別 <br/> Jenis Kelamin</td>
                        <td class="biodata-cell" style="width: 20%;">{{ isset($siswa->jenis_kelamin) ? ($siswa->jenis_kelamin == 'L' ? '男' : '女') : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">カタカナ</td>
                        <td class="biodata-cell" colspan="4">{{ $siswa->nama_lengkap_katakana ?? '-' }}</td>
                        <td class="bg-grey text-center">年齢 <br/> Umur</td>
                        <td class="biodata-cell">{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->age : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">生年月日 <br/> Tanggal Lahir</td>
                        <td class="biodata-cell" colspan="2">{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y年 m月 d日') : '-' }}</td>
                        <td class="bg-grey text-center">宗教 <br/>Agama</td>
                        <td class="biodata-cell">{{ $agamaJepang[$siswa->agama] ?? ($siswa->agama ?? '-') }}</td>
                        <td class="bg-grey text-center">婚姻状況 <br/>Status Pernikahan</td>
                        <td class="biodata-cell">
                            @if($biodata && $biodata->status_perkawinan)
                                {{ $mapJepang[$biodata->status_perkawinan] ?? $biodata->status_perkawinan }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">現住所</td>
                        <td class="biodata-cell" colspan="6" style="font-size: 9px; text-align: center !important; text-transform:uppercase; padding:5px 60px; line-height:1;">
                            {{ $siswa->alamat ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">家族の住所</td>
                        <td class="biodata-cell" colspan="6" style="font-size: 9px; text-align: center !important; text-transform:uppercase; padding:5px 60px; line-height:1;">
                            Alamat Keluarga
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">電話番号</td>
                        <td class="biodata-cell" style="font-size: 9px; text-align: center !important; text-transform:uppercase; padding:5px 60px; line-height:1;">
                            {{ $siswa->no_hp ?? '-' }}
                        </td>
                        <td class="bg-grey text-center">メール</td>
                        <td class="biodata-cell" style="font-size: 9px; text-align: center !important; text-transform:uppercase; padding:5px 60px; line-height:1;">
                            Email
                        </td>
                        <td class="bg-grey text-center">家族の電話番号</td>
                        <td class="biodata-cell" style="font-size: 9px; text-align: center !important; text-transform:uppercase; padding:5px 60px; line-height:1;">
                            Telp Keluarga
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 20%; vertical-align: center;">
                @if(!empty($fotoBase64))
                    <div style="width: 100%; height: 150px; background-image: url('{{ $fotoBase64 }}'); background-size: cover; background-position: center; background-repeat: no-repeat; border: 1px solid #000;"></div>
                @else
                    <div style="width: 100%; height: 150px; border: 1px solid #000; display: flex; align-items: center; justify-content: center; color: #ccc;">FOTO 3x4</div>
                @endif
            </td>
        </tr>
    </table>

    <!-- DATA FISIK (Mata, Tinggi, Berat, Darah, Tangan) -->
    
        <!-- RIWAYAT KESEHATAN (Sesuai Gambar) -->
    <table class="info-table" style="width:100%; margin-bottom: 6px; table-layout: fixed;">
        <!-- BARIS 1: Header Judul -->
        <tr>
            <td class="bg-grey text-center" colspan="8" style="font-weight: bold; font-size: 11px; padding: 4px;">
                ⑬ 病歴 Riwayat Kesehatan
            </td>
        </tr>
        
        <!-- BARIS 2: Header Kolom Atas -->
        <tr>
            <td class="bg-grey text-center" style="width: 12.5%;">血液型 <br/> Golongan Darah</td>
            <td class="bg-grey text-center" style="width: 12.5%;">利き腕 <br/> Tangan Dominan</td>
            <td class="bg-grey text-center" colspan="2" style="width: 25%;">視力 Mata</td>
            <td class="bg-grey text-center" style="width: 12.5%;">体重 <br/> Berat Badan</td>
            <td class="bg-grey text-center" style="width: 12.5%;">身長 <br/> Tinggi Badan</td>
            <td class="bg-grey text-center" style="width: 12.5%;">骨折 <br/> Patah Tulang</td>
            <td class="bg-grey text-center" style="width: 12.5%;">靴サイズ <br/> Ukuran Sepatu (CM)</td>
        </tr>

        <!-- BARIS 3: Sub-header & Data Atas -->
        <tr>
            <td class="biodata-cell" rowspan="2" style="vertical-align: middle;">
                {{ isset($biodata->golongan_darah) ? $biodata->golongan_darah . '型' : '-' }}
            </td>
            <td class="biodata-cell" rowspan="2" style="vertical-align: middle;">
                @php $tanganDominan = $biodata->tangan_dominan ?? '-'; @endphp
                {{ $mapJepang[$tanganDominan] ?? $tanganDominan }}
            </td>
            <!-- Sub Header Mata -->
            <td class="bg-grey text-center" style="width: 12.5%;">左 Kiri</td>
            <td class="bg-grey text-center" style="width: 12.5%;">右 Kanan</td>
            <!-- Data Kanan -->
            <td class="biodata-cell" rowspan="2" style="vertical-align: middle;">
                {{ isset($biodata->berat_badan) ? $biodata->berat_badan : '-' }}
            </td>
            <td class="biodata-cell" rowspan="2" style="vertical-align: middle;">
                {{ isset($biodata->tinggi_badan) ? $biodata->tinggi_badan : '-' }}
            </td>
            <td class="biodata-cell" rowspan="2" style="vertical-align: middle;">
                {{ ($biodata->patah_tulang ?? '') == 'Ya' ? '有り' : (($biodata->patah_tulang ?? '') == 'Tidak' ? '無し' : ($biodata->patah_tulang ?: '無')) }}
            </td>
            <td class="biodata-cell" rowspan="2" style="vertical-align: middle;">
                @php $ukuranSepatu = $biodata->ukuran_sepatu ?? ''; @endphp
                {{ (!empty($ukuranSepatu) && is_numeric($ukuranSepatu)) ? mb_convert_kana($ukuranSepatu, "R") : ($ukuranSepatu ?: 'ー') }}
            </td>
        </tr>

        <!-- BARIS 4: Data Mata -->
        <tr>
            <td class="biodata-cell">{{ $biodata->kondisi_mata_kiri ?? '-' }}</td>
            <td class="biodata-cell">{{ $biodata->kondisi_mata_kanan ?? '-' }}</td>
        </tr>

        <!-- BARIS 5: Merokok & Alkohol -->
        <tr>
            <td class="bg-grey text-center" style="width: 12.5%;">タバコ喫う <br/> Merokok :</td>
            <td class="biodata-cell" colspan="3">
                {{ ($biodata->merokok ?? '') == 'Ya' ? '吸う' : '吸わない' }}・{{ ($biodata->merokok ?? '') == 'Ya' ? 'MEROKOK' : 'TIDAK MEROKOK' }}
            </td>
            <td class="bg-grey text-center" style="width: 12.5%;">飲酒 <br/> Minuman Keras :</td>
            <td class="biodata-cell" colspan="3">
                {{ ($biodata->peminum_alkohol ?? '') == 'Ya' ? '飲む' : '飲まない' }}・{{ ($biodata->peminum_alkohol ?? '') == 'Ya' ? 'MINUM' : 'TIDAK' }}
            </td>
        </tr>
    </table>


    <!-- PRA-CEK KESEHATAN & FISIK (Semua digabung di sini) -->
    <table class="header-container" style="margin-bottom: 6px;">
        <tr>
            <td style="width: 100%; vertical-align: top;">
                <table class="info-table" style="table-layout: fixed;">
                    <tr>
                        <td class="biodata-cell-heading" rowspan="7">事前確認 情報</td>
                        <td class="bg-grey text-center" style="width:4%;">1</td>
                        
                        <td class="bg-grey text-center" style="width:4%;">8</td>
                        <td class="bg-grey text-center" style="width:19%;">何年間働きたい？ <br/>Rencana Lama di Jepang</td>
                        <td class="bg-grey text-center" style="width:19%;">{{ $biodata->rencana_lama_di_jepang ?? '-' }}年間</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">2</td>
                        <td class="bg-grey text-center">9</td>
                        
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">3</td>
                        <td class="bg-grey text-center">10</td>
                        
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">4</td>
                        
                        <td class="bg-grey text-center">11</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">5</td>
                        
                        <td class="bg-grey text-center">12</td>
                        
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">6</td>
                        <td class="bg-grey text-center">趣味 <br/>Hobi</td>
                        <td class="bg-grey text-center">
                            @php
                                $hobiData = $biodata->hobi ?? [];
                                $hobiArray = is_string($hobiData) ? (json_decode($hobiData, true) ?: explode(',', $hobiData)) : (array) $hobiData;
                                $translatedHobi = array_map(fn($item) => $hobiJP[trim($item)] ?? trim($item), $hobiArray);
                            @endphp
                            {{ !empty($translatedHobi) ? implode(', ', $translatedHobi) : '-' }}
                        </td>
                        <td class="bg-grey text-center">13</td>
                        
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">7</td>
                        
                        <td class="bg-grey text-center"></td>
                        <td class="bg-grey text-center"></td>
                        <td class="bg-grey text-center"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- PENDIDIKAN -->
    <table class="header-container" style="margin-bottom: 6px;">
        <tr>
            <td style="width: 100%; vertical-align: top;">
                <table class="info-table" style="table-layout: fixed;">
                    <tr>
                        <td class="bg-grey text-center" style="width:25%;">期間</td>
                        <td class="bg-grey text-center" style="width:45%;">学校名</td>
                        <td class="bg-grey text-center" style="width:16%;">学部・専攻</td>
                    </tr>
                    @forelse($siswa->pendidikans as $edu)
                        <tr>
                            <td class="bg-grey text-center">
                                @php
                                    $rawBulanMasuk = $edu->bulan_masuk ?? '';
                                    $angkaBulanMasuk = $monthMap[$rawBulanMasuk] ?? (is_numeric($rawBulanMasuk) ? $rawBulanMasuk : null);
                                    $tampilanBulanMasuk = $angkaBulanMasuk ? $angkaBulanMasuk . '月' : '-';
                                    $tampilanLulus = '-';
                                    if ($edu->tanggal_lulus) {
                                        $dateLulus = \Carbon\Carbon::parse($edu->tanggal_lulus);
                                        $tampilanLulus = $dateLulus->format('Y') . '年' . $dateLulus->format('n') . '月';
                                    }
                                @endphp
                                {{ $edu->tahun_masuk ?? '-' }}年{{ $tampilanBulanMasuk }} ～ {{ $tampilanLulus }}
                            </td>
                            <td class="bg-grey text-center" style="text-transform:uppercase;">
                                {{ $edu->nama_sekolah ?? '-' }} <br> {{ $jenjangJP[$edu->jenjang_pendidikan] ?? $edu->jenjang_pendidikan }}
                            </td>
                            <td class="bg-grey text-center">
                                {{ $jurusanJP[$edu->jurusan] ?? ($edu->jurusan ?? '-') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="bg-grey text-center">-</td>
                            <td class="bg-grey text-center">-</td>
                            <td class="bg-grey text-center">-</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td class="bg-grey text-center">
                            @php
                                $periodeRaw = $biodata->periode_mulai ?? '-';
                                $tampilanJepang = $periodeRaw;
                                if ($periodeRaw !== '-') {
                                    $parts = explode(' ', $periodeRaw);
                                    if (count($parts) >= 2) {
                                        $tampilanJepang = $parts[1] . '年' . ($monthMap[$parts[0]] ?? $parts[0]) . '月';
                                    }
                                }
                            @endphp
                            {{ $tampilanJepang }} ～ 現在
                        </td>
                        <td class="bg-grey text-center">LPK SHIROKUMA</td>
                        <td class="bg-grey text-center">日本語能力: {{ $biodata->level_bahasa_jepang ?? '-' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- RIWAYAT PEKERJAAN -->
    <table class="header-container" style="margin-bottom: 6px;">
        <tr>
            <td style="width: 100%; vertical-align: top;">
                <table class="info-table" style="table-layout: fixed;">
                    <tr>
                        <td class="biodata-cell-heading" rowspan="{{ max(1, $siswa->riwayatPekerjaans->count()) + 1 }}">職 歴</td>
                        <td class="bg-grey text-center" style="width:25%;">期間</td>
                        <td class="bg-grey text-center" style="width:20%;">会社名</td>
                        <td class="bg-grey text-center" style="width:18%;">職種</td>
                        <td class="bg-grey text-center" style="width:9%;">在留資格</td>
                        <td class="bg-grey text-center" style="width:14%;">月給</td>
                    </tr>
                    @forelse($siswa->riwayatPekerjaans as $work)
                        <tr>
                            <td class="bg-grey text-center">
                                @php
                                    $formatBulan = function($bulan) use ($monthMap) {
                                        if (empty($bulan)) return '-';
                                        $angkaBulan = $monthMap[$bulan] ?? (is_numeric($bulan) ? $bulan : null);
                                        return $angkaBulan ? $angkaBulan . '月' : $bulan;
                                    };
                                    $bulanMulai = $formatBulan($work->bulan_mulai ?? '');
                                    $bulanSelesai = $formatBulan($work->bulan_selesai ?? '');
                                @endphp
                                {{ $work->tahun_mulai ?? '-' }}年{{ $bulanMulai }} ～ 
                                @if(empty($work->tahun_selesai) || $work->tahun_selesai == 'Sekarang' || $work->tahun_selesai == '-')
                                    現在
                                @else
                                    {{ $work->tahun_selesai }}年{{ $bulanSelesai }}
                                @endif
                            </td>
                            <td class="bg-grey text-center" style="text-transform:uppercase;">{{ $work->nama_perusahaan ?? '-' }}</td>
                            <td class="bg-grey text-center" style="text-transform:uppercase;">{{ $work->nama_pekerjaan_katakana ?? '-' }}</td>
                            <td class="bg-grey text-center">{{ $work->pengalaman_jepang ?? '-' }}</td>
                            <td class="bg-grey text-center">
                                @php
                                    $gajiRupiah = $work->gaji_perbulan ?? null;
                                    $tampilanGaji = $gajiRupiah ? '¥ ' . number_format(round($gajiRupiah / 105), 0, '.', ',') : '-';
                                @endphp
                                {{ $tampilanGaji }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="bg-grey text-center">-</td>
                            <td class="bg-grey text-center">-</td>
                            <td class="bg-grey text-center">-</td>
                            <td class="bg-grey text-center">-</td>
                            <td class="bg-grey text-center">-</td>
                        </tr>
                    @endforelse
                </table>
            </td>
        </tr>
    </table>

    <!-- JIKO PIARU -->
    <table class="header-container" style="margin-bottom: 6px;">
        <tr>
            <td style="width: 100%; vertical-align: top;">
                <table class="info-table" style="table-layout: fixed;">
                    <tr>
                        <td class="biodata-cell-heading">自己PR</td>
                        <td class="bg-grey" style="padding:6px 8px; font-size:10px; line-height:1.35; text-align:justify; text-indent:10px; word-break:break-word;">
                            @php
                                $contentJp = $siswa->jikoPiaru->content_jp ?? '-';
                                $contentJp = trim(preg_replace("/\n{2,}/", "\n", $contentJp));
                            @endphp
                            {!! nl2br(e($contentJp)) !!}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- SERTIFIKAT -->
    <table class="header-container" style="margin-bottom: 6px;">
        <tr>
            <td style="width: 100%; vertical-align: top;">
                <table class="info-table" style="table-layout: fixed;">
                    <tr>
                        <td class="biodata-cell-heading" rowspan="{{ max(1, $siswa->sertifikats->count()) + 1 }}">資格取得</td>
                        <td class="bg-grey text-center" style="width:40%;">証明書名</td>
                        <td class="bg-grey text-center" style="width:32%;">発行日</td>
                        <td class="bg-grey text-center" style="width:14%;">レベル</td>
                    </tr>
                    @forelse($siswa->sertifikats as $cert)
                        <tr>
                            <td class="text-center" style="text-transform:uppercase;">{{ $cert->nama_sertifikat ?? '-' }}</td>
                            <td class="text-center">{{ $cert->tanggal_diterbitkan ? \Carbon\Carbon::parse($cert->tanggal_diterbitkan)->format('Y年m月d日') : '-' }}</td>
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

    <!-- KELUARGA -->
    <table class="header-container" style="margin-bottom: 6px;">
        <tr>
            <td style="width: 100%; vertical-align: top;">
                <table class="info-table" style="table-layout: fixed;">
                    <tr>
                        <td class="biodata-cell-heading" rowspan="{{ max(1, $siswa->keluargas->count()) + 1 }}">家族構成</td>
                        <td class="bg-grey text-center" style="width:14%;">続柄</td>
                        <td class="bg-grey text-center" style="width:27%;">氏名</td>
                        <td class="bg-grey text-center" style="width:6%;">年齢</td>
                        <td class="bg-grey text-center" style="width:15%;">業職</td>
                        <td class="bg-grey text-center" style="width:12%;">同居</td>
                        <td class="bg-grey text-center" style="width:12%;">別居</td>
                    </tr>
                    @forelse($siswa->keluargas as $fam)
                    <tr>
                        <td class="bg-grey text-center">{{ $hubunganJP[$fam->hubungan_keluarga] ?? ($fam->hubungan_keluarga ?? '-') }}</td>
                        <td class="bg-grey text-center" style="text-transform:uppercase;">{{ $fam->nama ?? '-' }}</td>
                        <td class="bg-grey text-center">{{ $fam->tanggal_lahir ? \Carbon\Carbon::parse($fam->tanggal_lahir)->age : '-' }}</td>
                        <td class="bg-grey text-center">{{ $pekerjaanJP[$fam->pekerjaan] ?? ($fam->pekerjaan ?? '-') }}</td>
                        <td class="bg-grey text-center">
                            <div style="width:6px; height:6px; border-radius:100%; background-color:{{ ($fam->alamat_tinggal ?? '') == 'Satu Rumah' ? 'black' : 'transparent' }}; border:1px solid {{ ($fam->alamat_tinggal ?? '') == 'Satu Rumah' ? 'transparent' : 'black' }}; margin:auto;"></div>
                        </td>
                        <td class="bg-grey text-center">
                            <div style="width:6px; height:6px; border-radius:100%; background-color:{{ ($fam->alamat_tinggal ?? '') != 'Satu Rumah' ? 'black' : 'transparent' }}; border:1px solid {{ ($fam->alamat_tinggal ?? '') != 'Satu Rumah' ? 'transparent' : 'black' }}; margin:auto;"></div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td class="bg-grey text-center">-</td>
                            <td class="bg-grey text-center">-</td>
                            <td class="bg-grey text-center">-</td>
                            <td class="bg-grey text-center">-</td>
                            <td class="bg-grey text-center">-</td>
                            <td class="bg-grey text-center">-</td>
                        </tr>
                    @endforelse
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