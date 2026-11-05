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
            background-color: #D8E8FF;
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
            background-color: #D8E8FF; /* Light blue sesuai screenshot */
            width: 50%;
        }

        .suffix-cell {
            background-color: #D8E8FF;
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

    <table class="header-container">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('images/logo.png') }}" style="width: 100%;">
            </td>
            <td class="header-tables-cell">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 58%; padding-right: 4px; vertical-align: center;">
                            <table class="info-table">
                                <tr>
                                    <td class="label-cell">受け入れ企業</td>
                                    <td class="value-cell">
                                        @php
                                            $job = $siswa->jobs->first();
                                            $company = $job ? $job->company : null;
                                        @endphp
                                        {{ $company ? ($company->nama_jepang ?: $company->nama_perusahaan) : '' }}
                                    </td>
                                    <td class="suffix-cell">様</td>
                                </tr>
                                <tr>
                                    <td class="label-cell">監理団体</td>
                                    <td class="value-cell"></td>
                                    <td class="suffix-cell">様</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 42%; padding-left: 4px; vertical-align: top;">
                            <table class="info-table">
                                <tr>
                                    <td class="label-cell" style="width: 22%;">類種</td>
                                    <td class="value-cell" style="width: 78%;">
                                        {{ $job->jenis_ginou ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-cell">分野</td>
                                    <td class="value-cell">
                                        {{ $job->jenis_pekerjaan ?? '' }}
                                    </td>
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
                        <td class="heading-cell" style="width:23%;"></td>
                        <td class="heading-cell" style="width:63%;">技能実習履歴書</td>
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
                        <td class="biodata-cell" colspan="5" style="width: 65%;">{{ $siswa->nama_lengkap_katakana }}</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">ローマ字</td>
                        <td class="biodata-cell" colspan="5" style="font-weight: bold;">{{ $siswa->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">呼び名</td>
                        <td class="biodata-cell" colspan="5">{{ $siswa->nama_panggilan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">生年月日</td>
                        <td class="biodata-cell" colspan="2">{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y年 m月 d日') }}</td>
                        <td class="bg-grey text-center" style="width: 10%;">年齢</td>
                        <td class="biodata-cell" style="width: 10%;">{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->age }}</td>
                        <td class="bg-grey text-center" style="width: 10%;">性別</td>
                        <td class="biodata-cell" style="width: 15%;">{{ $siswa->jenis_kelamin == 'L' ? '男' : '女' }}</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">現住所</td>
                        <td class="biodata-cell" colspan="6" style="font-size: 9px; text-align: center !important;">
                            {{ $siswa->alamat }}
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">婚姻状況</td>
                        <td class="biodata-cell">{{ $siswa->status_nikah }} 未婚</td>
                        <td class="bg-grey text-center">裸眼</td>
                        <td class="bg-grey text-center">左</td>
                        <td class="biodata-cell">{{ $siswa->mata_kiri ?? '-' }}</td>
                        <td class="bg-grey text-center">右</td>
                        <td class="biodata-cell">{{ $siswa->mata_kanan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">身長</td>
                        <td class="biodata-cell">{{ $siswa->tinggi_badan }} cm</td>
                        <td class="bg-grey text-center">矯正視力</td>
                        <td class="bg-grey text-center">左</td>
                        <td class="biodata-cell">-</td>
                        <td class="bg-grey text-center">右</td>
                        <td class="biodata-cell">-</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">体重</td>
                        <td class="biodata-cell">{{ $siswa->berat_badan }} kg</td>
                        <td class="bg-grey text-center" colspan="2">血液型</td>
                        <td class="biodata-cell" colspan="3">{{ $siswa->golongan_darah }} 型</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center">利き手</td>
                        <td class="biodata-cell">{{ $siswa->tangan_dominan }}</td>
                        <td class="bg-grey text-center" colspan="2">宗教</td>
                        <td class="biodata-cell" colspan="3">{{ $siswa->agama }}</td>
                    </tr>
                </table>
            </td>

            <td style="width: 23%; vertical-align: center;">
                @if($siswa->foto)
                    <div style="
                        width: 100%;
                        height: 254px;
                        background-image: url('{{ public_path('storage/' . $siswa->foto) }}');
                        background-size: cover;
                        background-position: center;
                        background-repeat: no-repeat;
                        border: 1px solid #000;
                    ">
                    </div>
                @else
                    <div style="padding-top: 100px; color: #ccc;">FOTO 3x4</div>
                @endif
            </td>
        </tr>
    </table>
    <table class="header-container" style="margin-bottom: 6px;">
        <tr>
            <td style="width: 100%; vertical-align: top;">
                <table class="info-table" style="table-layout: fixed;">
                    <tr>
                        <td class="biodata-cell-heading" rowspan="4" style="width: 14%;">学歴</td>
                        <td class="bg-grey text-center" style="width:25%;">期間 </td>
                        <td class="bg-grey text-center" style="width:45%;">学校名</td>
                        <td class="bg-grey text-center" style="width:16%;">学部・専攻</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:25%;">2013年07月 ~ 2019年06月  </td>
                        <td class="bg-grey text-center" style="width:45%;">SD ISLAM TERPADU AL-MUSLIMIN 小学校卒業</td>
                        <td class="bg-grey text-center" style="width:16%;">-</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:25%;">2019年07月 ~ 2022年06月</td>
                        <td class="bg-grey text-center" style="width:45%;">SMP TERPADU RIYADLUL ULUM 中学校卒業 </td>
                        <td class="bg-grey text-center" style="width:16%;">-</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:25%;">2022年07月 ~ 2025年05月</td>
                        <td class="bg-grey text-center" style="width:45%;">SMK NEGERI 2 TASIKMALAYA 専門高校卒業 </td>
                        <td class="bg-grey text-center" style="width:16%;">建築学科</td>
                    </tr>
                    <tr>
                        <td class="biodata-cell-heading" style="width:25%;">日本語学校</td>
                        <td class="bg-grey text-center" style="width:25%;">2025年08月 ~ 現在</td>
                        <td class="bg-grey text-center" style="width:45%;">LPK SHIROKUMA</td>
                        <td class="bg-grey text-center" style="width:16%;">日本語能力: N5勉強中</td>
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
                        <td class="biodata-cell-heading" style="width:14%;" rowspan="2">職 歴</td>
                        <td class="bg-grey text-center" style="width:25%;">期間 </td>
                        <td class="bg-grey text-center" style="width:20%;">会社名</td>
                        <td class="bg-grey text-center" style="width:18%;">職種</td>
                        <td class="bg-grey text-center" style="width:9%;">在留資格 </td>
                        <td class="bg-grey text-center" style="width:14%">月給 </td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:25%;">2024年10月~2025年01月 </td>
                        <td class="bg-grey text-center" style="width:20%;">CV ZAHRA RANCANG BANGUN</td>
                        <td class="bg-grey text-center" style="width:18%;">デザイナーアシスタント<br/>インターンシップ）</td>
                        <td class="bg-grey text-center" style="width:9%;">-</td>
                        <td class="bg-grey text-center" style="width:14%;">¥ 10.000</td>
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
                        <td class="biodata-cell-heading" style="width:14%;" rowspan="2">資格取得</td>
                        <td class="bg-grey text-center" style="width:25%;">取得日 </td>
                        <td class="bg-grey text-center" style="width:61%;">資格・免許</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:25%;">-</td>
                        <td class="bg-grey text-center" style="width:61%;">-</td>
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
                        <td class="biodata-cell-heading" style="width:14%;" rowspan="6">家族構成</td>
                        <td class="bg-grey text-center" style="width:14%;">続柄</td>
                        <td class="bg-grey text-center" style="width:27%;">氏名</td>
                        <td class="bg-grey text-center" style="width:6%;">年齢</td>
                        <td class="bg-grey text-center" style="width:15%;">業職</td>
                        <td class="bg-grey text-center" style="width:12%;">同居</td>
                        <td class="bg-grey text-center" style="width:12%;">別居</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:14%;">父 </td>
                        <td class="bg-grey text-center" style="width:27%;">SUNARKO TARIGAN</td>
                        <td class="bg-grey text-center" style="width:6%;">66</td>
                        <td class="bg-grey text-center" style="width:15%;">会社員</td>
                        <td class="bg-grey text-center" style="width:12%;"><div style="width:6px; height:6px; border-radius:100%; background-color:black; border:1px solid transparent; margin:auto;"></div></td>
                        <td class="bg-grey text-center" style="width:12%;"><div style="width:6px; height:6px; border-radius:100%; background-color:transparent; border:1px solid black; margin:auto;"></div></td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:14%;">母  </td>
                        <td class="bg-grey text-center" style="width:27%;">ETI SUMIATI</td>
                        <td class="bg-grey text-center" style="width:6%;">55</td>
                        <td class="bg-grey text-center" style="width:15%;">会社員</td>
                        <td class="bg-grey text-center" style="width:12%;"><div style="width:6px; height:6px; border-radius:100%; background-color:black; border:1px solid transparent; margin:auto;"></div></td>
                        <td class="bg-grey text-center" style="width:12%;"><div style="width:6px; height:6px; border-radius:100%; background-color:transparent; border:1px solid black; margin:auto;"></div></td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:14%;">母  </td>
                        <td class="bg-grey text-center" style="width:27%;">IKO GUSTIN IMERDA</td>
                        <td class="bg-grey text-center" style="width:6%;">55</td>
                        <td class="bg-grey text-center" style="width:15%;">会社員</td>
                        <td class="bg-grey text-center" style="width:12%;"><div style="width:6px; height:6px; border-radius:100%; background-color:black; border:1px solid transparent; margin:auto;"></div></td>
                        <td class="bg-grey text-center" style="width:12%;"><div style="width:6px; height:6px; border-radius:100%; background-color:transparent; border:1px solid black; margin:auto;"></div></td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:14%;">母  </td>
                        <td class="bg-grey text-center" style="width:27%;">WIDYA LURIA LISTIANA</td>
                        <td class="bg-grey text-center" style="width:6%;">55</td>
                        <td class="bg-grey text-center" style="width:15%;">会社員</td>
                        <td class="bg-grey text-center" style="width:12%;"><div style="width:6px; height:6px; border-radius:100%; background-color:black; border:1px solid transparent; margin:auto;"></div></td>
                        <td class="bg-grey text-center" style="width:12%;"><div style="width:6px; height:6px; border-radius:100%; background-color:transparent; border:1px solid black; margin:auto;"></div></td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:14%;">母  </td>
                        <td class="bg-grey text-center" style="width:27%;">NANDA TRISNA RAFITA</td>
                        <td class="bg-grey text-center" style="width:6%;">55</td>
                        <td class="bg-grey text-center" style="width:15%;">会社員</td>
                        <td class="bg-grey text-center" style="width:12%;"><div style="width:6px; height:6px; border-radius:100%; background-color:black; border:1px solid transparent; margin:auto;"></div></td>
                        <td class="bg-grey text-center" style="width:12%;"><div style="width:6px; height:6px; border-radius:100%; background-color:transparent; border:1px solid black; margin:auto;"></div></td>
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
                        <td class="biodata-cell-heading" style="width:14%;" rowspan="6">事前確認 情報</td>
                        <td class="bg-grey text-center" style="width:4%;">1</td>
                        <td class="bg-grey text-center" style="width:23%;">入れ墨</td>
                        <td class="bg-grey text-center" style="width:23%;">無</td>
                        <td class="bg-grey text-center" style="width:4%;">7</td>
                        <td class="bg-grey text-center" style="width:16%;">何年間働きたい？ </td>
                        <td class="bg-grey text-center" style="width:16%;">10年間</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:4%;">2 </td>
                        <td class="bg-grey text-center" style="width:23%;">喫煙</td>
                        <td class="bg-grey text-center" style="width:23%;">吸わない </td>
                        <td class="bg-grey text-center" style="width:4%;">8</td>
                        <td class="bg-grey text-center" style="width:16%;">大きな病気やケガ、手術 </td>
                        <td class="bg-grey text-center" style="width:16%;">無</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:4%;">3</td>
                        <td class="bg-grey text-center" style="width:23%;">飲酒</td>
                        <td class="bg-grey text-center" style="width:23%;">飲まない </td>
                        <td class="bg-grey text-center" style="width:4%;">9</td>
                        <td class="bg-grey text-center" style="width:16%;">アレルギー </td>
                        <td class="bg-grey text-center" style="width:16%;">無</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:4%;">4</td>
                        <td class="bg-grey text-center" style="width:23%;">色覚異常 </td>
                        <td class="bg-grey text-center" style="width:23%;">無 </td>
                        <td class="bg-grey text-center" style="width:4%;">10</td>
                        <td class="bg-grey text-center" style="width:16%;">電話番号 </td>
                        <td class="bg-grey text-center" style="width:16%;">082216944079</td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:4%;">5</td>
                        <td class="bg-grey text-center" style="width:23%;">虫歯 </td>
                        <td class="bg-grey text-center" style="width:23%;">有 </td>
                        <td class="bg-grey text-center" style="width:4%;"></td>
                        <td class="bg-grey text-center" style="width:16%;"> </td>
                        <td class="bg-grey text-center" style="width:16%;"></td>
                    </tr>
                    <tr>
                        <td class="bg-grey text-center" style="width:4%;">6</td>
                        <td class="bg-grey text-center" style="width:23%;">趣味  </td>
                        <td class="bg-grey text-center" style="width:23%;">絵画  </td>
                        <td class="bg-grey text-center" style="width:4%;"></td>
                        <td class="bg-grey text-center" style="width:16%;"> </td>
                        <td class="bg-grey text-center" style="width:16%;"></td>
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