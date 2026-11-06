@extends('layouts.app')

@section('content')

@php
    $tabOrder  = ['biodata', 'keluarga', 'pendidikan', 'jiko-piaru', 'pekerjaan', 'sertifikat'];
    $tabLabels = [
        'biodata'    => 'Biodata',
        'keluarga'   => 'Keluarga',
        'pendidikan' => 'Pendidikan',
        'jiko-piaru' => 'Jiko Piaru',
        'pekerjaan'  => 'Pekerjaan',
        'sertifikat' => 'Sertifikat',
    ];
    $tabUnlocked = [];
    $cumulativeOk = true;
    foreach ($tabOrder as $key) {
        $tabUnlocked[$key] = $cumulativeOk;
        if ($cumulativeOk && empty($tabStatus[$key])) {
            $cumulativeOk = false;
        }
    }


    $err = function ($field) use ($errors) {
        return $errors->has($field)
            ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
            : 'border-gray-600 focus:border-blue-500 focus:ring-blue-500';
    };
    $errMsg = function ($field) use ($errors) {
        return $errors->has($field)
            ? '<p class="text-xs text-red-400 mt-1">' . e($errors->first($field)) . '</p>'
            : '';
    };
@endphp

<div id="global-tooltip" class="fixed z-[9999] px-3 py-1.5 text-xs font-medium text-white bg-gray-900 border border-gray-600 rounded-lg shadow-xl opacity-0 pointer-events-none transition-opacity duration-200" style="display: none; white-space: nowrap;">
    Isi data tab sebelumnya terlebih dahulu
</div>

<div class="container mx-auto">
    <!-- Header with Glassmorphism Effect -->
    <div class="mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-0 md:rounded-2xl shadow-xl p-4 md:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <iconify-icon icon="mdi:school" width="32" height="32"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold">Biodata Siswa</h1>
                    <p class="text-blue-100 mt-1">Kelola informasi lengkap siswa</p>
                </div>
            </div>
            <a href="{{ route('biodata.print') }}" 
               target="_blank"
               class="w-full sm:w-auto flex items-center justify-center gap-2 bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <iconify-icon icon="mdi:printer" width="20" height="20"></iconify-icon>
                Cetak CV
            </a>
        </div>
    </div>

    <div id="notification-container" class="fixed top-5 right-5 z-50 space-y-3 w-96 max-w-full pointer-events-none">
        @if(session('success'))
            <div class="notification success-notification pointer-events-auto transform transition-all duration-500 translate-x-0 opacity-100" role="alert">
                <div class="bg-gradient-to-r from-green-500/95 to-green-600/95 backdrop-blur-sm text-white p-4 rounded-xl shadow-2xl border border-green-400/30 flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="mdi:check-circle" width="20" height="20" class="text-white"></iconify-icon>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-white">Berhasil!</p>
                        <p class="text-sm text-white/90 mt-0.5">{{ session('success') }}</p>
                    </div>
                    <button onclick="dismissNotification(this)" class="flex-shrink-0 text-white/70 hover:text-white transition-colors">
                        <iconify-icon icon="mdi:close" width="18" height="18"></iconify-icon>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="notification error-notification pointer-events-auto transform transition-all duration-500 translate-x-0 opacity-100" role="alert">
                <div class="bg-gradient-to-r from-red-500/95 to-red-600/95 backdrop-blur-sm text-white p-4 rounded-xl shadow-2xl border border-red-400/30 flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <iconify-icon icon="mdi:alert-circle" width="20" height="20" class="text-white"></iconify-icon>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-white">Error!</p>
                        <p class="text-sm text-white/90 mt-0.5">{{ session('error') }}</p>
                    </div>
                    <button onclick="dismissNotification(this)" class="flex-shrink-0 text-white/70 hover:text-white transition-colors">
                        <iconify-icon icon="mdi:close" width="18" height="18"></iconify-icon>
                    </button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="notification error-notification pointer-events-auto transform transition-all duration-500 translate-x-0 opacity-100" role="alert">
                <div class="bg-gradient-to-r from-red-500/95 to-red-600/95 backdrop-blur-sm text-white p-4 rounded-xl shadow-2xl border border-red-400/30">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <iconify-icon icon="mdi:alert" width="20" height="20" class="text-white"></iconify-icon>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-white">Terdapat {{ $errors->count() }} kesalahan</p>
                            <p class="text-sm text-white/90 mt-1">Silakan periksa kembali form Anda</p>
                        </div>
                        <button onclick="dismissNotification(this)" class="flex-shrink-0 text-white/70 hover:text-white transition-colors">
                            <iconify-icon icon="mdi:close" width="18" height="18"></iconify-icon>
                        </button>
                    </div>
                    
                    <!-- Detail errors (collapsible) -->
                    <div class="mt-3 pt-3 border-t border-white/20">
                        <button onclick="toggleErrorDetails(this)" class="flex items-center gap-1 text-white/80 hover:text-white text-sm mb-2">
                            <iconify-icon icon="mdi:chevron-down" width="16" height="16" class="transform transition-transform"></iconify-icon>
                            <span>Lihat detail kesalahan</span>
                        </button>
                        <div class="error-details hidden space-y-1">
                            @foreach ($errors->all() as $error)
                                <div class="text-sm text-white/90 bg-red-500/20 p-2 rounded-lg flex items-start gap-2">
                                    <iconify-icon icon="mdi:circle-small" width="16" height="16" class="flex-shrink-0 mt-0.5"></iconify-icon>
                                    <span>{{ $error }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Hidden notifications container untuk JavaScript -->
    <div id="notification-template-success" class="hidden">
        <div class="bg-gradient-to-r from-green-500/95 to-green-600/95 backdrop-blur-sm text-white p-4 rounded-xl shadow-2xl border border-green-400/30 flex items-start gap-3">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <iconify-icon icon="mdi:check-circle" width="20" height="20" class="text-white"></iconify-icon>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-white">Berhasil!</p>
                <p class="text-sm text-white/90 mt-0.5 message-placeholder"></p>
            </div>
            <button onclick="dismissNotification(this)" class="flex-shrink-0 text-white/70 hover:text-white transition-colors">
                <iconify-icon icon="mdi:close" width="18" height="18"></iconify-icon>
            </button>
        </div>
    </div>

    <div id="notification-template-error" class="hidden">
        <div class="bg-gradient-to-r from-red-500/95 to-red-600/95 backdrop-blur-sm text-white p-4 rounded-xl shadow-2xl border border-red-400/30 flex items-start gap-3">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <iconify-icon icon="mdi:alert-circle" width="20" height="20" class="text-white"></iconify-icon>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-white">Error!</p>
                <p class="text-sm text-white/90 mt-0.5 message-placeholder"></p>
            </div>
            <button onclick="dismissNotification(this)" class="flex-shrink-0 text-white/70 hover:text-white transition-colors">
                <iconify-icon icon="mdi:close" width="18" height="18"></iconify-icon>
            </button>
        </div>
    </div>

    <!-- Profile Card with Glass Effect -->
    <div class="bg-gray-800/50 backdrop-blur-sm rounded-0 md:rounded-2xl shadow-xl border border-gray-700/50 p-6 mb-8">
        <div class="flex flex-col md:flex-row gap-8">
            <div class="md:w-1/4">
                <div class="sticky top-4 group">
                    @if($siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}" class="rounded-xl w-full object-cover h-64 shadow-lg group-hover:shadow-xl transition-all duration-300">
                    @else
                        <div class="bg-gradient-to-br from-gray-700 to-gray-900 rounded-xl w-full h-64 flex items-center justify-center">
                            <iconify-icon icon="mdi:account" width="64" height="64" class="text-gray-500"></iconify-icon>
                        </div>
                    @endif
                </div>
            </div>

            <div class="md:w-3/4">
                <div class="flex flex-col gap-4">
                    <button onclick="toggleModal('modalEdit')" 
        class="flex items-center gap-2 bg-transparent hover:bg-indigo-600 text-indigo-400 hover:text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 border border-indigo-500/50 hover:border-indigo-400 hover:shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 active:translate-y-0">
    <iconify-icon icon="mdi:account-edit-outline" width="18" class="group-hover:rotate-12 transition-transform"></iconify-icon>
    <span>Edit Profil Saya</span>
</button>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-700/30 p-4 rounded-xl">
                            <span class="text-gray-400 text-sm flex items-center gap-2">
                                <iconify-icon icon="mdi:account" width="16" height="16"></iconify-icon>
                                Nama Lengkap
                            </span>
                            <p class="text-white font-semibold text-lg">{{ $siswa->nama_lengkap }}</p>
                        </div>
                        
                        <div class="bg-gray-700/30 p-4 rounded-xl">
                            <span class="text-gray-400 text-sm flex items-center gap-2">
                                <iconify-icon icon="mdi:account-details" width="16" height="16"></iconify-icon>
                                Nama Panggilan
                            </span>
                            <p class="text-white font-semibold">{{ $siswa->nama_panggilan ?? '-' }}</p>
                        </div>
                        
                        <div class="bg-gray-700/30 p-4 rounded-xl">
                            <span class="text-gray-400 text-sm flex items-center gap-2">
                                <iconify-icon icon="mdi:calendar" width="16" height="16"></iconify-icon>
                                Tempat, Tanggal Lahir
                            </span>
                            <p class="text-white font-semibold">{{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') }}</p>
                        </div>
                        
                        <div class="bg-gray-700/30 p-4 rounded-xl">
                            <span class="text-gray-400 text-sm flex items-center gap-2">
                                <iconify-icon icon="mdi:clock" width="16" height="16"></iconify-icon>
                                Usia
                            </span>
                            <p class="text-white font-semibold">{{ $siswa->usia }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gray-700/30 p-4 rounded-xl">
                            <span class="text-gray-400 text-sm flex items-center gap-2">
                                <iconify-icon icon="mdi:gender-{{ $siswa->jenis_kelamin === 'L' ? 'male' : 'female' }}" width="16" height="16"></iconify-icon>
                                Jenis Kelamin
                            </span>
                            <p class="text-white font-semibold">{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : ($siswa->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</p>
                        </div>
                        
                        <div class="bg-gray-700/30 p-4 rounded-xl">
                            <span class="text-gray-400 text-sm flex items-center gap-2">
                                <iconify-icon icon="mdi:church" width="16" height="16"></iconify-icon>
                                Agama
                            </span>
                            <p class="text-white font-semibold">{{ $siswa->agama }}</p>
                        </div>

                        <div class="bg-gray-700/30 p-4 rounded-xl">
                            <span class="text-gray-400 text-sm flex items-center gap-2">
                                <iconify-icon icon="mdi:phone" width="16" height="16"></iconify-icon>
                                Telepon
                            </span>
                            <p class="text-white font-semibold">{{ $siswa->no_hp ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-700/30 p-4 rounded-xl md:col-span-2">
                        <span class="text-gray-400 text-sm flex items-center gap-2">
                            <iconify-icon icon="mdi:map-marker" width="16" height="16"></iconify-icon>
                            Alamat
                        </span>
                        <p class="text-white font-semibold" style="text-transform:uppercase;">{{ $siswa->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-screen md-wfull overflow-x-hidden block md:hidden mb-1 bg-[#111827]/50">
        <div class="flex flex-nowrap items-center gap-2 p-5 md:p-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory" id="tabContainer">
            @foreach($tabOrder as $key)
                @php $isUnlocked = $tabUnlocked[$key]; @endphp
                <button
                    class="tab-btn snap-center flex-none px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 whitespace-nowrap border border-transparent 
                        {{ $isUnlocked ? '' : 'opacity-50 cursor-not-allowed' }}"
                    data-tab="{{ $key }}"
                    data-unlocked="{{ $isUnlocked ? '1' : '0' }}"
                    @if(!$isUnlocked) 
                        disabled
                    @endif>
                    @if(!$isUnlocked)
                        <iconify-icon icon="mdi:lock" width="14" height="14" class="mr-1 inline-block"></iconify-icon>
                    @endif
                    {{ $tabLabels[$key] }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Modern Tabs Design -->
    <div class="bg-gray-800/50 backdrop-blur-sm w-full rounded-0 md:rounded-2xl shadow-xl border border-gray-700/50 overflow-hidden">
        <div class="border-b w-full border-gray-700/50 mb-10 bg-[#111827]/50 hidden md:block">
            <div class="flex flex-nowrap items-center gap-1 md:gap-2 p-2 md:p-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory" id="tabContainer">
                @foreach($tabOrder as $key)
                    @php $isUnlocked = $tabUnlocked[$key]; @endphp
                    <button
                        class="tab-btn snap-center flex-none px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 whitespace-nowrap border border-transparent 
                            {{ $isUnlocked ? '' : 'opacity-50 cursor-not-allowed' }}"
                        data-tab="{{ $key }}"
                        data-unlocked="{{ $isUnlocked ? '1' : '0' }}"
                        @if(!$isUnlocked) 
                            disabled 
                        @endif>
                        @if(!$isUnlocked)
                            <iconify-icon icon="mdi:lock" width="14" height="14" class="mr-1 inline-block"></iconify-icon>
                        @endif
                        {{ $tabLabels[$key] }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Tab Contents -->
        <div class="p-5 pt-8 md:pt-0">
            <!-- Tab Biodata -->
            <div class="tab-content" id="biodata">
                <form action="{{ route('biodata.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="active_tab" value="biodata">

                    @php
                        $status = $biodata->status_siswa_sebelumnya ?? '';
                        $isLPK = $status && $status !== 'Mandiri';
                        $namaLPK = $isLPK ? $status : '';
                    @endphp

                    <div class="sticky top-0 z-10 pb-4 -mt-5 border-b border-gray-700/50 mb-6 rounded-t-xl">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <iconify-icon icon="mdi:account-details" width="24" height="24" class="text-blue-400"></iconify-icon>
                                <h2 class="text-xl font-semibold text-white">Edit Biodata</h2>
                            </div>
                            <div class="flex items-center gap-3 w-full sm:w-auto">
                                <button type="submit" class="w-full sm:w-auto justify-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2.5 rounded-xl font-semibold flex items-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <iconify-icon icon="mdi:content-save" width="20" height="20"></iconify-icon>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-blue-600 to-blue-400" id="saveProgress" style="width: 0%;"></div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-gray-700/30 rounded-xl p-6">
                            <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
                                <iconify-icon icon="mdi:account-check" width="20" height="20" class="text-blue-400"></iconify-icon>
                                Status Siswa
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="md:col-span-1">
                                    <label class="text-gray-400">Status Siswa Sebelumnya</label>
                                </div>
                                <div class="md:col-span-2 space-y-3">
                                    <select name="status_siswa_sebelumnya" id="status_siswa_sebelumnya" class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                                        <option value="">Pilih Status</option>
                                        <option value="LPK" {{ $biodata->status_siswa_sebelumnya == 'LPK' ? 'selected' : '' }}>LPK</option>
                                        <option value="Mandiri" {{ $biodata->status_siswa_sebelumnya == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                    </select>
                                    
                                    <!-- Field LPK muncul jika status LPK -->
                                    <div id="field_lpk" class="transition-all duration-300" style="{{ $biodata->status_siswa_sebelumnya == 'LPK' ? '' : 'display:none;' }}">
                                        <input type="text" name="nama_lpk" value="{{ $biodata->nama_lpk ?? '' }}" 
                                               placeholder="Masukkan nama LPK" 
                                               class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        @if($biodata->status_siswa_sebelumnya == 'LPK' && !$biodata->nama_lpk)
                                            <p class="text-xs text-yellow-400 mt-1">⚠️ Nama LPK belum diisi</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @php
                            $textFields = [
                                'level_bahasa_jepang' => 'Level Bahasa Jepang',
                                'periode_mulai' => 'Periode Mulai',
                                'nik' => 'NIK',
                                'wilayah_alamat' => 'Wilayah Alamat',
                                'golongan_darah' => 'Golongan Darah',
                                'kondisi_mata_kiri' => 'Kondisi Mata Kiri',
                                'kondisi_mata_kanan' => 'Kondisi Mata Kanan',
                            ];

                            $customSelects = [
                                'tangan_dominan' => ['label' => 'Tangan Dominan', 'options' => ['Kanan', 'Kiri']],
                                'status_perkawinan' => ['label' => 'Status Perkawinan', 'options' => ['Belum Menikah', 'Menikah', 'Cerai']],
                                'alergi' => ['label' => 'Alergi', 'options' => ['Ya', 'Tidak']],
                            ];

                            $numberFields = [
                                'tinggi_badan' => 'Tinggi Badan (Cm)',
                                'berat_badan' => 'Berat Badan (Kg)',
                                'jumlah_anak' => 'Jumlah Anak',
                                'rencana_lama_di_jepang' => 'Rencana Lama di Jepang',
                                'ukuran_sepatu' => 'Ukuran Sepatu',
                                'ukuran_pinggang' => 'Ukuran Pinggang',
                            ];

                            $yesNoFields = [
                                'buta_warna' => 'Buta Warna',
                                'merokok' => 'Merokok',
                                'peminum_alkohol' => 'Peminum Alkohol',
                                'tatto' => 'Tatto',
                                'gigi_berlubang' => 'Gigi Berlubang',
                                'kacamata' => 'Kacamata',
                                'patah_tulang' => 'Patah Tulang',
                            ];

                            $textareaFields = [
                                'keunggulan_diri' => 'Keunggulan Diri',
                                'kekurangan_diri' => 'Kekurangan Diri',
                            ];

                            $daftarPenyakit = ['Tidak Ada Riwayat Penyakit', 'Asma', 'Diabetes', 'Hipertensi', 'Tipes', 'Maag', 'Alergi Obat'];
                            $daftarHobi = ['Membaca', 'Olahraga', 'Memasak', 'Traveling', 'Musik', 'Gaming', 'Coding'];
                        @endphp

                        <div class="grid grid-cols-1 gap-6">
                            <div class="bg-gray-700/30 rounded-xl p-6">
                                <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
                                    <iconify-icon icon="mdi:information" width="20" height="20" class="text-blue-400"></iconify-icon>
                                    Informasi Pribadi
                                </h3>
                                @foreach($textFields as $name => $label)
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 items-start">
                                    <div class="text-gray-400 pt-2.5">{{ $label }} <span class="text-red-400">*</span></div>
                                    <div class="md:col-span-2">
                                        <input type="text" name="{{ $name }}" value="{{ old($name, $biodata->$name ?? '') }}"
                                            class="w-full bg-gray-800 border {{ $err($name) }} rounded-lg px-4 py-2.5 text-white focus:ring-1 transition">
                                        {!! $errMsg($name) !!}
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="bg-gray-700/30 rounded-xl p-6">
                                <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
                                    <iconify-icon icon="mdi:human" width="20" height="20" class="text-blue-400"></iconify-icon>
                                    Informasi Fisik
                                </h3>
                                @foreach($customSelects as $name => $data)
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 items-center">
                                    <div class="text-gray-400">{{ $data['label'] }}</div>
                                    <div class="md:col-span-2">
                                        <select name="{{ $name }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            <option value="">Pilih {{ $data['label'] }}</option>
                                            @foreach($data['options'] as $opt)
                                                <option value="{{ $opt }}" {{ old($name, $biodata->$name ?? '') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endforeach

                                @foreach($numberFields as $name => $label)
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 items-center">
                                    <div class="text-gray-400">{{ $label }}</div>
                                    <div class="md:col-span-2">
                                        <input type="number" name="{{ $name }}" value="{{ old($name, $biodata->$name ?? '') }}"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="bg-gray-700/30 rounded-xl p-6">
                                <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
                                    <iconify-icon icon="mdi:medical-bag" width="20" height="20" class="text-blue-400"></iconify-icon>
                                    Informasi Kesehatan
                                </h3>
                                @foreach($yesNoFields as $name => $label)
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 items-center">
                                    <div class="text-gray-400">{{ $label }}</div>
                                    <div class="md:col-span-2">
                                        <select name="{{ $name }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            <option value="">Pilih</option>
                                            <option value="Ya" {{ old($name, $biodata->$name ?? '') == 'Ya' ? 'selected' : '' }}>Ya</option>
                                            <option value="Tidak" {{ old($name, $biodata->$name ?? '') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                @endforeach

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 items-center">
                                    <div class="text-gray-400">Riwayat Penyakit</div>
                                    <div class="md:col-span-2">
                                        <select name="riwayat_penyakit" class="select2-basic w-full">
                                            @foreach($daftarPenyakit as $penyakit)
                                                <option value="{{ $penyakit }}" {{ old('riwayat_penyakit', $biodata->riwayat_penyakit ?? '') == $penyakit ? 'selected' : '' }}>{{ $penyakit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-700/30 rounded-xl p-6">
                                <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
                                    <iconify-icon icon="mdi:heart" width="20" height="20" class="text-blue-400"></iconify-icon>
                                    Hobi & Lainnya
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 items-center">
                                    <div class="text-gray-400">Hobi</div>
                                    <div class="md:col-span-2">
                                        <select name="hobi[]" class="select2-multiple w-full" multiple>
                                            @foreach($daftarHobi as $hobi)
                                                @php
                                                    $savedHobi = is_array($biodata->hobi) ? $biodata->hobi : json_decode($biodata->hobi ?? '[]', true);
                                                @endphp
                                                <option value="{{ $hobi }}" {{ in_array($hobi, (array)old('hobi', $savedHobi)) ? 'selected' : '' }}>{{ $hobi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-700/30 rounded-xl p-6">
                                <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
                                    <iconify-icon icon="mdi:pen" width="20" height="20" class="text-blue-400"></iconify-icon>
                                    Deskripsi Diri
                                </h3>
                                @foreach($textareaFields as $name => $label)
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div class="text-gray-400">{{ $label }}</div>
                                    <div class="md:col-span-2">
                                        <textarea name="{{ $name }}" rows="3"
                                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ old($name, $biodata->$name ?? '') }}</textarea>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="sticky bottom-6 z-10 mt-8">
                            <div class="flex justify-end">
                                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-3 rounded-xl font-semibold flex items-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <iconify-icon icon="mdi:content-save" width="20" height="20"></iconify-icon>
                                    <span>Simpan Perubahan</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tab Keluarga -->
            <div class="tab-content hidden" id="keluarga">
                <div class="sticky top-0 z-10 pb-4 -mt-5 border-b border-gray-700/50 mb-6 rounded-t-xl">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h2 class="text-xl font-semibold text-white flex items-center gap-2">
                            <iconify-icon icon="mdi:family-tree" width="24" height="24" class="text-blue-400"></iconify-icon>
                            Data Keluarga
                        </h2>
                        <div class="flex flex-col md:flex-row md:flex-wrap gap-3 w-full sm:w-auto">
                            <button onclick="openCreateModal()" class="flex-1 sm:flex-none justify-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all duration-300 shadow-lg">
                                <iconify-icon icon="mdi:plus" width="18" height="18"></iconify-icon>
                                Keluarga Lokal
                            </button>
                            <button onclick="openJapanModal()" class="flex-1 sm:flex-none justify-center bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all duration-300 shadow-lg">
                                <iconify-icon icon="mdi:plus" width="18" height="18"></iconify-icon>
                                Keluarga di Jepang
                            </button>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-blue-600 to-blue-400" id="saveProgressKeluarga" style="width: 0%;"></div>
                </div>

                <div class="space-y-4">
                    @forelse($siswa->keluargas as $item)
                        <div class="bg-gray-700/30 rounded-xl p-5 border border-gray-600/50 hover:border-blue-500/50 transition-all duration-300">
                            <div class="flex justify-between flex-col gap-5 md:gap-0 md:flex-row items-start">
                                <div class="space-y-2">
                                    @if($item->jenis_keluarga == 'jepang')
                                        <div class="inline-flex items-center gap-1 bg-red-500/20 text-red-400 px-2 py-1 rounded-lg text-xs">
                                            <iconify-icon icon="mdi:map-marker" width="12" height="12"></iconify-icon>
                                            Jepang - {{ $item->alamat_jepang }}
                                        </div>
                                    @endif
                                    <div class="flex flex-col md:flex-row items-start md:items-center gap-1 md:gap-2">
                                        <span class="text-white font-semibold">{{ $item->hubungan_keluarga }}</span>
                                        <span class="text-gray-400 hidden md:block">•</span>
                                        <span class="text-gray-300">{{ $item->nama }}</span>
                                    </div>
                                    <div class="flex flex-wrap gap-4 text-sm text-gray-400">
                                        @if($item->tempat_lahir && $item->tanggal_lahir)
                                            <span class="flex items-center gap-1">
                                                <iconify-icon icon="mdi:calendar" width="14" height="14"></iconify-icon>
                                                {{ $item->tempat_lahir }}, {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}
                                            </span>
                                        @endif
                                        @if($item->pekerjaan)
                                            <span class="flex items-center gap-1">
                                                <iconify-icon icon="mdi:briefcase" width="14" height="14"></iconify-icon>
                                                {{ $item->pekerjaan }}
                                            </span>
                                        @endif
                                        @if($item->no_telepon)
                                            <span class="flex items-center gap-1">
                                                <iconify-icon icon="mdi:phone" width="14" height="14"></iconify-icon>
                                                {{ $item->no_telepon }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button onclick="openEditModal(
                                        {{ $item->id }},
                                        '{{ $item->hubungan_keluarga }}',
                                        '{{ $item->nama }}',
                                        '{{ $item->tempat_lahir }}',
                                        '{{ $item->tanggal_lahir }}',
                                        '{{ $item->alamat_tinggal }}',
                                        '{{ $item->pekerjaan }}',
                                        '{{ $item->no_telepon }}'
                                    )" class="bg-yellow-600/20 hover:bg-yellow-600/40 text-yellow-400 p-2 rounded-lg transition-all duration-300 flex items-center" title="Edit">
                                        <iconify-icon icon="mdi:pencil" width="18" height="18"></iconify-icon>
                                    </button>
                                    <form action="{{ route('keluarga.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600/20 hover:bg-red-600/40 text-red-400 p-2 rounded-lg transition-all duration-300 flex items-center" title="Hapus">
                                            <iconify-icon icon="mdi:delete" width="18" height="18"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-gray-700/30 rounded-xl p-8 text-center">
                            <iconify-icon icon="mdi:family-tree-off" width="48" height="48" class="text-gray-500 mb-3"></iconify-icon>
                            <p class="text-gray-400">Belum ada data keluarga.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Tab Pendidikan -->
            <div class="tab-content hidden" id="pendidikan">
                <div class="sticky top-0 z-10 pb-4 -mt-5 border-b border-gray-700/50 mb-6 rounded-t-xl">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h2 class="text-xl font-semibold text-white flex items-center gap-2">
                            <iconify-icon icon="mdi:school" width="24" height="24" class="text-blue-400"></iconify-icon>
                            Data Pendidikan
                        </h2>
                        <button onclick="openPendidikanModal()" class="w-full sm:w-auto justify-center bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all duration-300 shadow-lg">
                            <iconify-icon icon="mdi:plus" width="18" height="18"></iconify-icon>
                            Tambah Pendidikan
                        </button>
                    </div>
                    <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-blue-600 to-blue-400" id="saveProgressPendidikan" style="width: 0%;"></div>
                </div>

                <div class="space-y-4">
                    @forelse($siswa->pendidikans as $item)
                        <div class="bg-gray-700/30 rounded-xl p-5 border border-gray-600/50 hover:border-green-500/50 transition-all duration-300">
                            <div class="flex flex-col md:flex-row gap-5 md:gap-0 justify-between items-start">
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2">
                                        <span class="bg-blue-500/20 text-blue-400 px-2 py-1 rounded-lg text-xs font-semibold">{{ $item->jenjang_pendidikan }}</span>
                                    </div>
                                    <div class="font-semibold text-white">{{ $item->nama_sekolah }}</div>
                                    @if($item->jurusan)
                                        <div class="text-gray-300 text-sm">Jurusan: {{ $item->jurusan }}</div>
                                    @endif
                                    <div class="flex gap-4 text-sm text-gray-400">
                                        <span class="flex items-center gap-1">
                                            <iconify-icon icon="mdi:calendar-start" width="14" height="14"></iconify-icon>
                                            {{ $item->bulan_masuk }} {{ $item->tahun_masuk }}
                                        </span>
                                        @if($item->tanggal_lulus)
                                        <span class="flex items-center gap-1">
                                            <iconify-icon icon="mdi:calendar-end" width="14" height="14"></iconify-icon>
                                            {{ \Carbon\Carbon::parse($item->tanggal_lulus)->format('d M Y') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    @if($item->dokumen_ijazah)
                                        <a href="{{ asset('storage/'.$item->dokumen_ijazah) }}" target="_blank" class="bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 flex items-center p-2 rounded-lg transition-all duration-300" title="Lihat Ijazah">
                                            <iconify-icon icon="mdi:file" width="18" height="18"></iconify-icon>
                                        </a>
                                    @endif
                                    <button onclick="openEditPendidikan(
                                        {{ $item->id }},
                                        '{{ $item->jenjang_pendidikan }}',
                                        '{{ $item->nama_sekolah }}',
                                        '{{ $item->jurusan }}',
                                        '{{ $item->tahun_masuk }}',
                                        '{{ $item->bulan_masuk }}',
                                        '{{ $item->tanggal_lulus }}'
                                    )" class="bg-yellow-600/20 hover:bg-yellow-600/40 text-yellow-400 p-2 rounded-lg transition-all duration-300 flex items-center" title="Edit">
                                        <iconify-icon icon="mdi:pencil" width="18" height="18"></iconify-icon>
                                    </button>
                                    <form action="{{ route('pendidikan.destroy',$item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600/20 hover:bg-red-600/40 text-red-400 p-2 rounded-lg transition-all duration-300 flex items-center" title="Hapus">
                                            <iconify-icon icon="mdi:delete" width="18" height="18"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-gray-700/30 rounded-xl p-8 text-center">
                            <iconify-icon icon="mdi:school-off" width="48" height="48" class="text-gray-500 mb-3"></iconify-icon>
                            <p class="text-gray-400">Belum ada data pendidikan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Tab Jiko Piaru -->
            <div class="tab-content hidden" id="jiko-piaru">
                <div class="sticky top-0 z-10 pb-4 -mt-5 border-b border-gray-700/50 mb-6 rounded-t-xl">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-xl font-semibold text-white flex items-center gap-2">
                                <iconify-icon icon="mdi:file-document-edit" width="24" height="24" class="text-blue-400"></iconify-icon>
                                Jiko Piaru 
                                <span class="text-sm bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full">自己PR</span>
                            </h2>
                            <p class="text-gray-400 mt-1">
                                Tulis perkenalan diri Anda dalam bahasa Jepang
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <div class="bg-gray-800/80 px-4 py-2 rounded-lg border border-gray-700">
                                <div class="text-xs text-gray-400">Total Karakter</div>
                                <div class="text-xl font-bold text-white" id="charCount">0</div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-blue-600 to-blue-400" id="saveProgressJiko" style="width: 0%;"></div>
                </div>

                @php
                    $jikoPiaru = $siswa->jikoPiaru;
                @endphp

                <form id="jikoPiaruForm" method="POST" action="{{ route('jiko-piaru.update') }}">
                    @csrf
                    <!-- Tidak perlu siswa_id karena sudah diambil dari Auth -->
                    
                    <!-- Textarea dengan style Jepang -->
                    <div class="relative">
                        <textarea name="content_jp" 
                                id="jikoPiaruTextarea"
                                rows="6"
                                placeholder="例：私は〇〇と申します。〇〇県出身です。性格は明るくて、責任感が強いです。日本の文化に興味があって、日本語を勉強しています。よろしくお願いします。"
                                class="w-full bg-gray-800/50 border-2 border-gray-700 rounded-xl px-6 py-5 text-white placeholder-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-japanese text-lg leading-relaxed">{{ old('content_jp', $jikoPiaru->content_jp ?? '') }}</textarea>
                        
                        <!-- Decoration elements -->
                        <div class="absolute top-3 left-3 text-gray-700">
                            <iconify-icon icon="mdi:format-quote-open" width="24" height="24"></iconify-icon>
                        </div>
                        <div class="absolute bottom-3 right-3 text-gray-700">
                            <iconify-icon icon="mdi:format-quote-close" width="24" height="24"></iconify-icon>
                        </div>
                    </div>

                    <!-- Info dan Tombol Simpan -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mt-4 gap-4">
                        <div class="flex items-center gap-3 text-sm">
                            <div class="flex items-center gap-1 text-gray-500">
                                <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
                                <span>Gunakan bahasa Jepang (Hiragana, Katakana, Kanji)</span>
                            </div>
                        </div>
                        
                        <div class="flex gap-3 w-full sm:w-auto">
                            <button type="reset" 
                                    onclick="resetJikoPiaru()" 
                                    class="flex-1 sm:flex-none justify-center px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 flex items-center gap-2">
                                <iconify-icon icon="mdi:refresh" width="18" height="18"></iconify-icon>
                                Reset
                            </button>
                            
                            <button type="submit" 
                                    id="saveButton"
                                    class="flex-1 sm:flex-none justify-center px-8 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg font-semibold flex items-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <iconify-icon icon="mdi:content-save" width="18" height="18"></iconify-icon>
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tab Pekerjaan -->
            <div class="tab-content hidden" id="pekerjaan">
                <div class="sticky top-0 z-10 pb-4 -mt-5 border-b border-gray-700/50 mb-6 rounded-t-xl">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h2 class="text-xl font-semibold text-white flex items-center gap-2">
                            <iconify-icon icon="mdi:briefcase" width="24" height="24" class="text-blue-400"></iconify-icon>
                            Riwayat Pekerjaan
                        </h2>
                        <button onclick="openRiwayatModal()" class="w-full sm:w-auto justify-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all duration-300 shadow-lg">
                            <iconify-icon icon="mdi:plus" width="18" height="18"></iconify-icon>
                            Tambah Riwayat
                        </button>
                    </div>
                    <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-blue-600 to-blue-400" id="saveProgressRiwayatPekerjaan" style="width: 0%;"></div>
                </div>

                <div class="space-y-4">
                    @forelse($siswa->riwayatPekerjaans as $item)
                        <div class="bg-gray-700/30 rounded-xl p-5 border border-gray-600/50 hover:border-blue-500/50 transition-all duration-300">
                            <div class="flex flex-col md:flex-row gap-5 md:gap-0 justify-between items-start">
                                <div class="space-y-2">
                                    <div class="font-semibold text-white text-lg">{{ $item->nama_perusahaan }}</div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-300">{{ $item->nama_pekerjaan }}</span>
                                        @if($item->nama_pekerjaan_katakana)
                                            <span class="text-gray-500 text-sm">({{ $item->nama_pekerjaan_katakana }})</span>
                                        @endif
                                    </div>
                                    <div class="flex flex-wrap gap-4 text-sm">
                                        <span class="flex items-center gap-1 text-gray-400">
                                            <iconify-icon icon="mdi:map-marker" width="14" height="14"></iconify-icon>
                                            {{ $item->tempat_bekerja }}
                                            @if($item->tempat_bekerja == 'Jepang' && $item->pengalaman_jepang)
                                                • {{ $item->pengalaman_jepang }}
                                            @endif
                                        </span>
                                        @if($item->gaji_perbulan)
                                            <span class="flex items-center gap-1 text-gray-400">
                                                <iconify-icon icon="mdi:cash" width="14" height="14"></iconify-icon>
                                                Rp {{ number_format($item->gaji_perbulan, 0, ',', '.') }}
                                            </span>
                                        @endif
                                        <span class="flex items-center gap-1 text-gray-400">
                                            <iconify-icon icon="mdi:calendar-range" width="14" height="14"></iconify-icon>
                                            {{ $item->bulan_mulai }} {{ $item->tahun_mulai }} - 
                                            {{ $item->bulan_selesai }} {{ $item->tahun_selesai }}
                                        </span>
                                    </div>
                                    @if($item->deskripsi_pekerjaan)
                                        <p class="text-gray-400 text-sm mt-2">{{ $item->deskripsi_pekerjaan }}</p>
                                    @endif
                                </div>
                                <div class="flex gap-2">
                                    <button onclick="openEditModalRiwayat(
                                        {{ $item->id }},
                                        `{{ $item->nama_perusahaan }}`,
                                        `{{ $item->nama_pekerjaan }}`,
                                        `{{ $item->nama_pekerjaan_katakana }}`,
                                        `{{ $item->tempat_bekerja }}`,
                                        `{{ $item->pengalaman_jepang }}`,
                                        `{{ $item->gaji_perbulan }}`,
                                        `{{ $item->tahun_mulai }}`,
                                        `{{ $item->bulan_mulai }}`,
                                        `{{ $item->tahun_selesai }}`,
                                        `{{ $item->bulan_selesai }}`,
                                        `{{ $item->deskripsi_pekerjaan }}`
                                    )" class="bg-yellow-600/20 hover:bg-yellow-600/40 text-yellow-400 p-2 flex items-center rounded-lg transition-all duration-300" title="Edit">
                                        <iconify-icon icon="mdi:pencil" width="18" height="18"></iconify-icon>
                                    </button>
                                    <form action="{{ route('riwayat-pekerjaan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600/20 hover:bg-red-600/40 text-red-400 flex items-center p-2 rounded-lg transition-all duration-300" title="Hapus">
                                            <iconify-icon icon="mdi:delete" width="18" height="18"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-gray-700/30 rounded-xl p-8 text-center">
                            <iconify-icon icon="mdi:briefcase-off" width="48" height="48" class="text-gray-500 mb-3"></iconify-icon>
                            <p class="text-gray-400">Belum ada riwayat pekerjaan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Tab Sertifikat -->
            <div class="tab-content hidden" id="sertifikat">
                <div class="sticky top-0 z-10 pb-4 -mt-5 border-b border-gray-700/50 mb-6 rounded-t-xl">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h2 class="text-xl font-semibold text-white flex items-center gap-2">
                            <iconify-icon icon="mdi:certificate" width="24" height="24" class="text-blue-400"></iconify-icon>
                            Sertifikat
                        </h2>
                        <button onclick="openSertifikatModal()" class="w-full sm:w-auto justify-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all duration-300 shadow-lg">
                            <iconify-icon icon="mdi:plus" width="18" height="18"></iconify-icon>
                            Tambah Sertifikat
                        </button>
                    </div>
                    <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-blue-600 to-blue-400" id="saveSertifikat" style="width: 0%;"></div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    @forelse($siswa->sertifikats as $item)
                        <div class="bg-gray-700/30 w-full rounded-xl p-5 border border-gray-600/50 hover:border-yellow-500/50 transition-all duration-300">
                            <div class="flex flex-col md:flex-row gap-5 md:gap-0 justify-between">
                                <div class="space-y-2">
                                    <div class="font-semibold text-white">{{ $item->nama_sertifikat }}</div>
                                    <div class="flex items-center gap-3 text-sm">
                                        <span class="flex items-center gap-1 text-gray-400">
                                            <iconify-icon icon="mdi:calendar" width="14" height="14"></iconify-icon>
                                            Terbit: {{ \Carbon\Carbon::parse($item->tanggal_diterbitkan)->format('d M Y') }}
                                        </span>
                                        @if($item->tanggal_expired)
                                        <span class="flex items-center gap-1 text-red-400">
                                            <iconify-icon icon="mdi:calendar-alert" width="14" height="14"></iconify-icon>
                                            Exp: {{ \Carbon\Carbon::parse($item->tanggal_expired)->format('d M Y') }}
                                        </span>
                                        @endif
                                    </div>
                                    @if($item->level_jlpt)
                                        <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded-lg text-xs">JLPT {{ $item->level_jlpt }}</span>
                                    @endif
                                </div>
                                <div class="flex gap-2">
                                    @if($item->dokumen_sertifikat)
                                        <a href="{{ asset('storage/'.$item->dokumen_sertifikat) }}" target="_blank" class="bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 p-2 rounded-lg transition-all duration-300" title="Lihat Dokumen">
                                            <iconify-icon icon="mdi:file" width="18" height="18"></iconify-icon>
                                        </a>
                                    @endif
                                    <div>
                                        <button onclick="openEditSertifikatModal(
                                            {{ $item->id }},
                                            `{{ $item->nama_sertifikat }}`,
                                            `{{ $item->tanggal_diterbitkan }}`,
                                            `{{ $item->tanggal_expired }}`,
                                            `{{ $item->level_jlpt }}`
                                        )" class="bg-yellow-600/20 flex items-center hover:bg-yellow-600/40 text-yellow-400 p-2 rounded-lg transition-all duration-300" title="Edit">
                                            <iconify-icon icon="mdi:pencil" width="18" height="18"></iconify-icon>
                                        </button>
                                    </div>
                                    <form action="{{ route('sertifikat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600/20 hover:bg-red-600/40 text-red-400 p-2 rounded-lg transition-all duration-300 flex items-center" title="Hapus">
                                            <iconify-icon icon="mdi:delete" width="18" height="18"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 bg-gray-700/30 rounded-xl p-8 text-center">
                            <iconify-icon icon="mdi:certificate-off" width="48" height="48" class="text-gray-500 mb-3"></iconify-icon>
                            <p class="text-gray-400">Belum ada sertifikat.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalEdit" class="fixed inset-0 z-[99] hidden overflow-y-auto">
    <div class="fixed t-0 l-0 inset-0 bg-black/60 backdrop-blur-sm" onclick="toggleModal('modalEdit')"></div>
    
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-gray-800 w-full max-w-2xl rounded-2xl shadow-2xl border border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-700 flex justify-between items-center bg-gray-800/50">
                <h3 class="text-xl font-bold text-white">Perbarui Biodata</h3>
                <button onclick="toggleModal('modalEdit')" class="text-gray-400 hover:text-white transition-colors">
                    <iconify-icon icon="mdi:close" width="24"></iconify-icon>
                </button>
            </div>

            <form action="{{ route('siswa.updateMyBiodata') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-gray-400 text-xs uppercase tracking-wider font-semibold">Ganti Foto Profil</label>
                        <input type="file" name="foto" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor:pointer">
                    </div>

                    <div class="space-y-1">
                        <label class="text-gray-400 text-xs uppercase font-semibold">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ $siswa->nama_lengkap }}" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all" required>
                    </div>

                    <div class="space-y-1">
                        <label class="text-gray-400 text-xs uppercase font-semibold">Nama Panggilan</label>
                        <input type="text" name="nama_panggilan" value="{{ $siswa->nama_panggilan }}" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>
                    
                    <div class="space-y-1">
                        <label class="text-gray-400 text-xs uppercase font-semibold">Nama Lengkap (Katakana)</label>
                        <input type="text" name="nama_panggilan" value="{{ $siswa->nama_lengkap_katakana }}" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>
                    
                    <div class="space-y-1">
                        <label class="text-gray-400 text-xs uppercase font-semibold">Nama Panggilan (Katakana)</label>
                        <input type="text" name="nama_panggilan" value="{{ $siswa->nama_panggilan_katakana }}" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>

                    <div class="space-y-1">
                        <label class="text-gray-400 text-xs uppercase font-semibold">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ $siswa->tempat_lahir }}" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all" required>
                    </div>

                    <div class="space-y-1">
                        <label class="text-gray-400 text-xs uppercase font-semibold">Tanggal Lahir (DD/MM/YYYY)</label>
                        <input type="text" name="tanggal_lahir" value="{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y') }}" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="31/12/1995" required>
                    </div>

                    <div class="space-y-1">
                        <label class="text-gray-400 text-xs uppercase font-semibold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                            <option value="L" {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-gray-400 text-xs uppercase font-semibold">Agama</label>
                        <input type="text" name="agama" value="{{ $siswa->agama }}" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all" required>
                    </div>

                    <div class="md:col-span-2 space-y-1">
                        <label class="text-gray-400 text-xs uppercase font-semibold">Nomor HP</label>
                        <input type="text" name="no_hp" value="{{ $siswa->no_hp }}" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>

                    <div class="md:col-span-2 space-y-1">
                        <label class="text-gray-400 text-xs uppercase font-semibold">Alamat</label>
                        <textarea name="alamat" rows="3" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">{{ $siswa->alamat }}</textarea>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" onclick="toggleModal('modalEdit')" class="px-6 py-2.5 text-gray-400 hover:text-white font-medium transition-colors">Batal</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-indigo-500/20 transition-all active:scale-95">
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div id="createModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-start justify-center z-50">
    <div class="bg-gray-800 w-full max-w-lg rounded-2xl shadow-2xl border border-gray-700 overflow-y-auto ">
        <div class="p-6 border-b border-gray-700">
            <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                <iconify-icon icon="mdi:family-tree" width="24" height="24" class="text-blue-400"></iconify-icon>
                Tambah Data Keluarga
            </h3>
        </div>
        <form action="{{ route('keluarga.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Hubungan Keluarga</label>
                    <select name="hubungan_keluarga" class="select-hubungan w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        <option value="">Pilih Hubungan</option>
                        <option value="Ayah Kandung">Ayah Kandung</option>
                        <option value="Ibu Kandung">Ibu Kandung</option>
                        <option value="Ayah Tiri">Ayah Tiri</option>
                        <option value="Ibu Tiri">Ibu Tiri</option>
                        <option value="Ayah Angkat">Ayah Angkat</option>
                        <option value="Ibu Angkat">Ibu Angkat</option>
                        <option value="Kakak Kandung">Kakak Kandung</option>
                        <option value="Adik Kandung">Adik Kandung</option>
                        <option value="Kakak Tiri">Kakak Tiri</option>
                        <option value="Adik Tiri">Adik Tiri</option>
                        <option value="Suami">Suami</option>
                        <option value="Istri">Istri</option>
                        <option value="Anak">Anak</option>
                        <option value="Kakek">Kakek</option>
                        <option value="Nenek">Nenek</option>
                        <option value="Paman">Paman</option>
                        <option value="Bibi">Bibi</option>
                        <option value="Sepupu">Sepupu</option>
                        <option value="Keponakan">Keponakan</option>
                        <option value="Mertua">Mertua</option>
                        <option value="Wali">Wali</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Nama</label>
                    <input type="text" name="nama" placeholder="Masukkan nama" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" placeholder="Tempat lahir" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2 flex items-center gap-2">
                        Tanggal Lahir
                    </label>
                    <div class="relative">
                        <input type="text" 
                            name="tanggal_lahir" 
                            id="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $item->tanggal_lahir ?? '') }}"
                            class="flatpickr w-full bg-gray-700 border border-gray-600 rounded-lg pl-4 pr-10 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition cursor-pointer"
                            placeholder="Pilih Tanggal Lahir"
                            data-input>
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <iconify-icon icon="mdi:calendar-month" width="18" height="18" class="group-hover:text-blue-400 transition"></iconify-icon>
                        </span>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-3">Alamat Tinggal</label>
                    <div class="flex flex-wrap gap-6">
                        <!-- Satu Rumah Option -->
                        <label class="relative flex items-center cursor-pointer group">
                            <input type="radio" name="alamat_tinggal" value="Satu Rumah" class="hidden peer">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-blue-500 peer-checked:border-6 transition-all duration-200 group-hover:border-blue-400"></div>
                            <div class="ml-3 flex items-center gap-2">
                                <div class="p-1.5 bg-blue-500/10 rounded-lg group-hover:bg-blue-500/20 transition-colors flex items-center">
                                    <iconify-icon icon="mdi:home" width="18" height="18" class="text-gray-400 group-hover:text-blue-400 peer-checked:text-blue-400"></iconify-icon>
                                </div>
                                <span class="text-white group-hover:text-blue-400 transition-colors">Satu Rumah</span>
                            </div>
                        </label>

                        <!-- Beda Rumah Option -->
                        <label class="relative flex items-center cursor-pointer group">
                            <input type="radio" name="alamat_tinggal" value="Beda Rumah" class="hidden peer">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-blue-500 peer-checked:border-6 transition-all duration-200 group-hover:border-blue-400"></div>
                            <div class="ml-3 flex items-center gap-2">
                                <div class="p-1.5 bg-purple-500/10 rounded-lg group-hover:bg-purple-500/20 transition-colors flex items-center">
                                    <iconify-icon icon="mdi:home-export-outline" width="18" height="18" class="text-gray-400 group-hover:text-purple-400 peer-checked:text-purple-400"></iconify-icon>
                                </div>
                                <span class="text-white group-hover:text-purple-400 transition-colors">Beda Rumah</span>
                            </div>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-3">Pekerjaan</label>
                    <select name="pekerjaan" id="select-pekerjaan" class="select2-pekerjaan w-full">
                        <option value="">Pilih Pekerjaan</option>
                        <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                        <option value="Petani">Petani</option>
                        <option value="Buruh Harian Lepas">Buruh Harian Lepas</option>
                        <option value="Karyawan Swasta">Karyawan Swasta</option>
                        <option value="Pegawai Negeri">Pegawai Negeri</option>
                        <option value="Wiraswasta">Wiraswasta</option>
                        <option value="Guru">Guru</option>
                        <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                        <option value="Tenaga Medis">Tenaga Medis</option>
                        <option value="Sopir">Sopir</option>
                        <option value="Tidak Bekerja">Tidak Bekerja</option>
                        <option value="Pensiunan">Pensiunan</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">No Telepon</label>
                    <input type="text" name="no_telepon" placeholder="Nomor telepon" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
            </div>
            <div class="p-6 border-t border-gray-700 flex justify-end gap-3">
                <button type="button" onclick="closeCreateModal()" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg transition-all duration-300">
                    Batal
                </button>
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 transition-all duration-300">
                    <iconify-icon icon="mdi:content-save" width="18" height="18"></iconify-icon>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-gray-800 w-full max-w-lg rounded-2xl shadow-2xl border border-gray-700">
        <div class="p-6 border-b border-gray-700">
            <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                <iconify-icon icon="mdi:pencil" width="24" height="24" class="text-yellow-400"></iconify-icon>
                Edit Data Keluarga
            </h3>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <!-- Same fields as create modal -->
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Hubungan Keluarga</label>
                    <select name="hubungan_keluarga" class="select-hubungan w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                        <option value="">Pilih Hubungan</option>
                        <option value="Ayah Kandung">Ayah Kandung</option>
                        <option value="Ibu Kandung">Ibu Kandung</option>
                        <option value="Ayah Tiri">Ayah Tiri</option>
                        <option value="Ibu Tiri">Ibu Tiri</option>
                        <option value="Ayah Angkat">Ayah Angkat</option>
                        <option value="Ibu Angkat">Ibu Angkat</option>
                        <option value="Kakak Kandung">Kakak Kandung</option>
                        <option value="Adik Kandung">Adik Kandung</option>
                        <option value="Kakak Tiri">Kakak Tiri</option>
                        <option value="Adik Tiri">Adik Tiri</option>
                        <option value="Suami">Suami</option>
                        <option value="Istri">Istri</option>
                        <option value="Anak">Anak</option>
                        <option value="Kakek">Kakek</option>
                        <option value="Nenek">Nenek</option>
                        <option value="Paman">Paman</option>
                        <option value="Bibi">Bibi</option>
                        <option value="Sepupu">Sepupu</option>
                        <option value="Keponakan">Keponakan</option>
                        <option value="Mertua">Mertua</option>
                        <option value="Wali">Wali</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Nama</label>
                    <input type="text" name="nama" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2 flex items-center gap-2">
                        Tanggal Lahir
                    </label>
                    <div class="relative">
                        <input type="text" 
                            name="tanggal_lahir" 
                            id="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $item->tanggal_lahir ?? '') }}"
                            class="flatpickr w-full bg-gray-700 border border-gray-600 rounded-lg pl-4 pr-10 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition cursor-pointer"
                            placeholder="Pilih Tanggal Lahir"
                            data-input>
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <iconify-icon icon="mdi:calendar-month" width="18" height="18" class="group-hover:text-blue-400 transition"></iconify-icon>
                        </span>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-3">Alamat Tinggal</label>
                    <div class="flex flex-wrap gap-6">
                        <!-- Satu Rumah Option -->
                        <label class="relative flex items-center cursor-pointer group">
                            <input type="radio" name="alamat_tinggal" value="Satu Rumah" class="hidden peer">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-blue-500 peer-checked:border-6 transition-all duration-200 group-hover:border-blue-400"></div>
                            <div class="ml-3 flex items-center gap-2">
                                <div class="p-1.5 bg-blue-500/10 rounded-lg group-hover:bg-blue-500/20 transition-colors flex items-center">
                                    <iconify-icon icon="mdi:home" width="18" height="18" class="text-gray-400 group-hover:text-blue-400 peer-checked:text-blue-400"></iconify-icon>
                                </div>
                                <span class="text-white group-hover:text-blue-400 transition-colors">Satu Rumah</span>
                            </div>
                        </label>

                        <!-- Beda Rumah Option -->
                        <label class="relative flex items-center cursor-pointer group">
                            <input type="radio" name="alamat_tinggal" value="Beda Rumah" class="hidden peer">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-blue-500 peer-checked:border-6 transition-all duration-200 group-hover:border-blue-400"></div>
                            <div class="ml-3 flex items-center gap-2">
                                <div class="p-1.5 bg-purple-500/10 rounded-lg group-hover:bg-purple-500/20 transition-colors flex items-center">
                                    <iconify-icon icon="mdi:home-export-outline" width="18" height="18" class="text-gray-400 group-hover:text-purple-400 peer-checked:text-purple-400"></iconify-icon>
                                </div>
                                <span class="text-white group-hover:text-purple-400 transition-colors">Beda Rumah</span>
                            </div>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Pekerjaan</label>
                    <select name="pekerjaan" id="select-pekerjaan-edit" class="select2-pekerjaan-edit w-full">
                        <option value="">Pilih Pekerjaan</option>
                        <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                        <option value="Petani">Petani</option>
                        <option value="Buruh Harian Lepas">Buruh Harian Lepas</option>
                        <option value="Karyawan Swasta">Karyawan Swasta</option>
                        <option value="Pegawai Negeri">Pegawai Negeri</option>
                        <option value="Wiraswasta">Wiraswasta</option>
                        <option value="Guru">Guru</option>
                        <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                        <option value="Tenaga Medis">Tenaga Medis</option>
                        <option value="Sopir">Sopir</option>
                        <option value="Tidak Bekerja">Tidak Bekerja</option>
                        <option value="Pensiunan">Pensiunan</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">No Telepon</label>
                    <input type="text" name="no_telepon" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                </div>
            </div>
            <div class="p-6 border-t border-gray-700 flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg transition-all duration-300">
                    Batal
                </button>
                <button type="submit" class="bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 transition-all duration-300">
                    <iconify-icon icon="mdi:content-save" width="18" height="18"></iconify-icon>
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Japan Modal -->
<div id="japanModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-gray-800 w-full max-w-lg rounded-2xl shadow-2xl border border-gray-700">
        <div class="p-6 border-b border-gray-700">
            <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                <iconify-icon icon="mdi:map-marker" width="24" height="24" class="text-red-400"></iconify-icon>
                Tambah Keluarga di Jepang
            </h3>
        </div>
        <form action="{{ route('keluarga.store') }}" method="POST">
            @csrf
            <input type="hidden" name="jenis_keluarga" value="jepang">
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Nama</label>
                    <input type="text" name="nama" placeholder="Nama anggota keluarga" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Hubungan Keluarga</label>
                    <select name="hubungan_keluarga" id="hubungan_jepang" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500">
                        <option value="">Pilih Hubungan</option>
                        <option value="Ayah Kandung">Ayah Kandung</option>
                        <option value="Ibu Kandung">Ibu Kandung</option>
                        <option value="Kakak Kandung">Kakak Kandung</option>
                        <option value="Adik Kandung">Adik Kandung</option>
                        <option value="Suami">Suami</option>
                        <option value="Istri">Istri</option>
                        <option value="Anak">Anak</option>
                        <option value="Paman">Paman</option>
                        <option value="Bibi">Bibi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Prefektur di Jepang</label>
                    <select name="alamat_jepang" id="alamat_jepang" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500">
                        <option value="">Pilih Prefektur</option>
                        <option value="Hokkaido">Hokkaido</option>
                        <option value="Aomori">Aomori</option>
                        <option value="Iwate">Iwate</option>
                        <option value="Miyagi">Miyagi</option>
                        <option value="Akita">Akita</option>
                        <option value="Yamagata">Yamagata</option>
                        <option value="Fukushima">Fukushima</option>
                        <option value="Ibaraki">Ibaraki</option>
                        <option value="Tochigi">Tochigi</option>
                        <option value="Gunma">Gunma</option>
                        <option value="Saitama">Saitama</option>
                        <option value="Chiba">Chiba</option>
                        <option value="Tokyo">Tokyo</option>
                        <option value="Kanagawa">Kanagawa</option>
                        <option value="Niigata">Niigata</option>
                        <option value="Toyama">Toyama</option>
                        <option value="Ishikawa">Ishikawa</option>
                        <option value="Fukui">Fukui</option>
                        <option value="Yamanashi">Yamanashi</option>
                        <option value="Nagano">Nagano</option>
                        <option value="Gifu">Gifu</option>
                        <option value="Shizuoka">Shizuoka</option>
                        <option value="Aichi">Aichi</option>
                        <option value="Mie">Mie</option>
                        <option value="Shiga">Shiga</option>
                        <option value="Kyoto">Kyoto</option>
                        <option value="Osaka">Osaka</option>
                        <option value="Hyogo">Hyogo</option>
                        <option value="Nara">Nara</option>
                        <option value="Wakayama">Wakayama</option>
                        <option value="Tottori">Tottori</option>
                        <option value="Shimane">Shimane</option>
                        <option value="Okayama">Okayama</option>
                        <option value="Hiroshima">Hiroshima</option>
                        <option value="Yamaguchi">Yamaguchi</option>
                        <option value="Tokushima">Tokushima</option>
                        <option value="Kagawa">Kagawa</option>
                        <option value="Ehime">Ehime</option>
                        <option value="Kochi">Kochi</option>
                        <option value="Fukuoka">Fukuoka</option>
                        <option value="Saga">Saga</option>
                        <option value="Nagasaki">Nagasaki</option>
                        <option value="Kumamoto">Kumamoto</option>
                        <option value="Oita">Oita</option>
                        <option value="Miyazaki">Miyazaki</option>
                        <option value="Kagoshima">Kagoshima</option>
                        <option value="Okinawa">Okinawa</option>
                    </select>
                </div>
            </div>
            <div class="p-6 border-t border-gray-700 flex justify-end gap-3">
                <button type="button" onclick="closeJapanModal()" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg transition-all duration-300">
                    Batal
                </button>
                <button type="submit" class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 transition-all duration-300">
                    <iconify-icon icon="mdi:content-save" width="18" height="18"></iconify-icon>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Pendidikan Modal -->
<div id="pendidikanModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-gray-800 w-full max-w-2xl rounded-2xl shadow-2xl border border-gray-700">
        <div class="p-6 border-b border-gray-700">
            <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                <iconify-icon icon="mdi:school" width="24" height="24" class="text-green-400"></iconify-icon>
                Tambah Data Pendidikan
            </h3>
        </div>
        <form action="{{ route('pendidikan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Jenjang Pendidikan</label>
                    <select name="jenjang_pendidikan" id="jenjang_pendidikan" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        <option value="">Pilih Jenjang Pendidikan</option>
                        <option value="SD">SD sederajat</option>
                        <option value="SMP">SMP sederajat</option>
                        <option value="SMK">SMK sederajat</option>
                        <option value="SMA">SMA sederajat</option>
                        <option value="KULIAH">Diploma/Sarjana (D1-S3)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Nama Sekolah</label>
                    <input type="text" name="nama_sekolah" placeholder="Nama Sekolah/Universitas" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-green-500 focus:ring-1 focus:ring-green-500">
                </div>
                <div id="container-jurusan">
                    <label class="block text-gray-400 text-sm mb-2">Jurusan</label>
                    <select name="jurusan" id="jurusan" class="select2-jurusan w-full">
                        <option value="">Pilih Jenjang Terlebih Dahulu</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Tahun Masuk</label>
                        <input type="number" name="tahun_masuk" placeholder="Contoh: 2020" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-green-500 focus:ring-1 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Bulan Masuk</label>
                        <select name="bulan_masuk" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-green-500 focus:ring-1 focus:ring-green-500">
                            <option value="">Bulan Masuk</option>
                            <option>Januari</option>
                            <option>Februari</option>
                            <option>Maret</option>
                            <option>April</option>
                            <option>Mei</option>
                            <option>Juni</option>
                            <option>Juli</option>
                            <option>Agustus</option>
                            <option>September</option>
                            <option>Oktober</option>
                            <option>November</option>
                            <option>Desember</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Tanggal Lulus</label>
                    <input type="text" 
                        name="tanggal_lulus" 
                        id="tanggal_lulus"
                        value="{{ old('tanggal_lulus', $item->tanggal_lulus ?? '') }}"
                        class="flatpickr w-full bg-gray-700 border border-gray-600 rounded-lg pl-4 pr-10 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition cursor-pointer"
                        placeholder="Pilih Tanggal Lulus"
                        data-input>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Upload Ijazah</label>
                    <input type="file" name="dokumen_ijazah" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-600 file:text-white hover:file:bg-green-700">
                </div>
            </div>
            <div class="p-6 border-t border-gray-700 flex justify-end gap-3">
                <button type="button" onclick="closePendidikanModal()" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg transition-all duration-300">
                    Batal
                </button>
                <button type="submit" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 transition-all duration-300">
                    <iconify-icon icon="mdi:content-save" width="18" height="18"></iconify-icon>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Pendidikan Modal -->
<div id="editPendidikanModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-gray-800 w-full max-w-2xl rounded-2xl shadow-2xl border border-gray-700">
        <div class="p-6 border-b border-gray-700">
            <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                <iconify-icon icon="mdi:pencil" width="24" height="24" class="text-yellow-400"></iconify-icon>
                Edit Pendidikan
            </h3>
        </div>
        <form id="editPendidikanForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <!-- Same fields as create modal -->
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Jenjang Pendidikan</label>
                    <select name="jenjang_pendidikan" id="jenjang_pendidikan_edit" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                        <option value="">Pilih Jenjang Pendidikan</option>
                        <option value="SD">SD sederajat</option>
                        <option value="SMP">SMP sederajat</option>
                        <option value="SMK">SMK sederajat</option>
                        <option value="SMA">SMA sederajat</option>
                        <option value="KULIAH">Diploma/Sarjana (D1-S3)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Nama Sekolah</label>
                    <input type="text" name="nama_sekolah" id="nama_sekolah_edit" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Jurusan</label>
                    <select name="jurusan" id="jurusan_edit" class="select2-jurusan-edit w-full">
                        <option value="">Pilih Jurusan</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Tahun Masuk</label>
                        <input type="number" name="tahun_masuk" id="tahun_masuk_edit" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                    </div>
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Bulan Masuk</label>
                        <select name="bulan_masuk" id="bulan_masuk_edit" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                            <option value="">Bulan Masuk</option>
                            <option>Januari</option>
                            <option>Februari</option>
                            <option>Maret</option>
                            <option>April</option>
                            <option>Mei</option>
                            <option>Juni</option>
                            <option>Juli</option>
                            <option>Agustus</option>
                            <option>September</option>
                            <option>Oktober</option>
                            <option>November</option>
                            <option>Desember</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Tanggal Lulus</label>
                    <input type="date" name="tanggal_lulus" id="tanggal_lulus_edit" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Upload Ijazah (Kosongkan jika tidak diganti)</label>
                    <input type="file" name="dokumen_ijazah" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-yellow-600 file:text-white hover:file:bg-yellow-700">
                </div>
            </div>
            <div class="p-6 border-t border-gray-700 flex justify-end gap-3">
                <button type="button" onclick="closeEditPendidikan()" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg transition-all duration-300">
                    Batal
                </button>
                <button type="submit" class="bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 transition-all duration-300">
                    <iconify-icon icon="mdi:content-save" width="18" height="18"></iconify-icon>
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Riwayat Modal -->
<div id="riwayatModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-gray-800 w-full max-w-xl rounded-2xl shadow-2xl border border-gray-700">
        <div class="p-6 border-b border-gray-700">
            <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                <iconify-icon icon="mdi:briefcase-plus" width="24" height="24" class="text-blue-400"></iconify-icon>
                Tambah Riwayat Pekerjaan
            </h3>
        </div>
        <form action="{{ route('riwayat-pekerjaan.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Nama Perusahaan</label>
                    <input type="text" name="nama_perusahaan" placeholder="Nama perusahaan" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Nama Pekerjaan</label>
                    <input type="text" name="nama_pekerjaan" placeholder="Nama pekerjaan" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Nama Pekerjaan (Katakana)</label>
                    <input type="text" name="nama_pekerjaan_katakana" placeholder="Nama pekerjaan dalam katakana" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Tempat Bekerja</label>
                    <select name="tempat_bekerja" id="tempatBekerja" onchange="togglePengalaman()" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        <option value="">Pilih Tempat Bekerja</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Jepang">Jepang</option>
                    </select>
                </div>
                <div id="pengalamanField" class="hidden">
                    <label class="block text-gray-400 text-sm mb-2">Pengalaman di Jepang</label>
                    <select name="pengalaman_jepang" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        <option value="">Pilih Pengalaman</option>
                        <option value="Magang">Magang</option>
                        <option value="Tokuteiginou">Tokuteiginou</option>
                        <option value="Internship">Internship</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Gaji Perbulan</label>
                    <input type="number" name="gaji_perbulan" placeholder="Rp" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Tahun Mulai</label>
                        <input type="number" name="tahun_mulai" placeholder="Contoh: 2020" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Bulan Mulai</label>
                        <select name="bulan_mulai" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <option value="">Pilih Bulan</option>
                            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                                <option value="{{ $bulan }}">{{ $bulan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Tahun Selesai</label>
                        <input type="number" name="tahun_selesai" placeholder="Contoh: 2023" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Bulan Selesai</label>
                        <select name="bulan_selesai" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <option value="">Pilih Bulan</option>
                            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                                <option value="{{ $bulan }}">{{ $bulan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Deskripsi Pekerjaan</label>
                    <textarea name="deskripsi_pekerjaan" rows="3" placeholder="Deskripsi pekerjaan..." class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500"></textarea>
                </div>
            </div>
            <div class="p-6 border-t border-gray-700 flex justify-end gap-3">
                <button type="button" onclick="closeRiwayatModal()" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg transition-all duration-300">
                    Batal
                </button>
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 transition-all duration-300">
                    <iconify-icon icon="mdi:content-save" width="18" height="18"></iconify-icon>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Riwayat Modal -->
<div id="editRiwayatModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-gray-800 w-full max-w-xl rounded-2xl shadow-2xl border border-gray-700">
        <div class="p-6 border-b border-gray-700">
            <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                <iconify-icon icon="mdi:pencil" width="24" height="24" class="text-yellow-400"></iconify-icon>
                Edit Riwayat Pekerjaan
            </h3>
        </div>
        <form id="editFormPekerjaan" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <!-- Same fields as create modal -->
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Nama Perusahaan</label>
                    <input type="text" name="nama_perusahaan" id="edit_perusahaan" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Nama Pekerjaan</label>
                    <input type="text" name="nama_pekerjaan" id="edit_pekerjaan" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Nama Pekerjaan (Katakana)</label>
                    <input type="text" name="nama_pekerjaan_katakana" id="edit_katakana" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Tempat Bekerja</label>
                    <select name="tempat_bekerja" id="edit_tempat" onchange="toggleEditPengalaman()" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                        <option value="Indonesia">Indonesia</option>
                        <option value="Jepang">Jepang</option>
                    </select>
                </div>
                <div id="edit_pengalaman_field" class="hidden">
                    <label class="block text-gray-400 text-sm mb-2">Pengalaman di Jepang</label>
                    <select name="pengalaman_jepang" id="edit_pengalaman" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                        <option value="">Pilih Pengalaman</option>
                        <option value="Magang">Magang</option>
                        <option value="Tokuteiginou">Tokuteiginou</option>
                        <option value="Internship">Internship</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Gaji Perbulan</label>
                    <input type="number" name="gaji_perbulan" id="edit_gaji" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Tahun Mulai</label>
                        <input type="number" name="tahun_mulai" id="edit_tahun_mulai" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                    </div>
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Bulan Mulai</label>
                        <select name="bulan_mulai" id="edit_bulan_mulai" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                            <option value="">Pilih Bulan</option>
                            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                                <option value="{{ $bulan }}">{{ $bulan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Tahun Selesai</label>
                        <input type="number" name="tahun_selesai" id="edit_tahun_selesai" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                    </div>
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Bulan Selesai</label>
                        <select name="bulan_selesai" id="edit_bulan_selesai" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                            <option value="">Pilih Bulan</option>
                            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                                <option value="{{ $bulan }}">{{ $bulan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Deskripsi Pekerjaan</label>
                    <textarea name="deskripsi_pekerjaan" id="edit_deskripsi" rows="3" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500"></textarea>
                </div>
            </div>
            <div class="p-6 border-t border-gray-700 flex justify-end gap-3">
                <button type="button" onclick="closeEditModalRiwayat()" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg transition-all duration-300">
                    Batal
                </button>
                <button type="submit" class="bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 transition-all duration-300">
                    <iconify-icon icon="mdi:content-save" width="18" height="18"></iconify-icon>
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Sertifikat Modal -->
<div id="sertifikatModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-gray-800 w-full max-w-xl rounded-2xl shadow-2xl border border-gray-700">
        <div class="p-6 border-b border-gray-700">
            <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                <iconify-icon icon="mdi:certificate-plus" width="24" height="24" class="text-blue-400"></iconify-icon>
                Tambah Sertifikat
            </h3>
        </div>
        <form action="{{ route('sertifikat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Nama Sertifikat</label>
                    <input type="text" name="nama_sertifikat" placeholder="Nama sertifikat" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Tanggal Diterbitkan</label>
                    <input type="text" 
                        name="tanggal_diterbitkan" 
                        id="tanggal_diterbitkan"
                        value="{{ old('tanggal_diterbitkan', $item->tanggal_diterbitkan ?? '') }}"
                        class="flatpickr w-full bg-gray-700 border border-gray-600 rounded-lg pl-4 pr-10 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition cursor-pointer"
                        placeholder="Pilih Tanggal Diterbitkan"
                        data-input>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Tanggal Expired (Opsional)</label>
                    <input type="text" 
                        name="tanggal_expired" 
                        id="tanggal_expired"
                        value="{{ old('tanggal_expired', $item->tanggal_expired ?? '') }}"
                        class="flatpickr w-full bg-gray-700 border border-gray-600 rounded-lg pl-4 pr-10 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition cursor-pointer"
                        placeholder="Pilih Tanggal Expired"
                        data-input>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Level JLPT (Opsional)</label>
                    <select name="level_jlpt" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        <option value="">Pilih Level</option>
                        <option value="N1">N1</option>
                        <option value="N2">N2</option>
                        <option value="N3">N3</option>
                        <option value="N4">N4</option>
                        <option value="N5">N5</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Upload Dokumen</label>
                    <input type="file" name="dokumen_sertifikat" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    <p class="text-xs text-gray-500 mt-1">Maksimal 5MB (PDF, JPG, PNG)</p>
                </div>
            </div>
            <div class="p-6 border-t border-gray-700 flex justify-end gap-3">
                <button type="button" onclick="closeSertifikatModal()" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg transition-all duration-300">
                    Batal
                </button>
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 transition-all duration-300">
                    <iconify-icon icon="mdi:content-save" width="18" height="18"></iconify-icon>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Sertifikat Modal -->
<div id="editSertifikatModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-gray-800 w-full max-w-xl rounded-2xl shadow-2xl border border-gray-700">
        <div class="p-6 border-b border-gray-700">
            <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                <iconify-icon icon="mdi:pencil" width="24" height="24" class="text-yellow-400"></iconify-icon>
                Edit Sertifikat
            </h3>
        </div>
        <form id="editSertifikatForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Nama Sertifikat</label>
                    <input type="text" name="nama_sertifikat" id="edit_nama_sertifikat" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Tanggal Diterbitkan</label>
                    <input type="date" name="tanggal_diterbitkan" id="edit_tanggal_diterbitkan" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Tanggal Expired</label>
                    <input type="date" name="tanggal_expired" id="edit_tanggal_expired" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Level JLPT</label>
                    <select name="level_jlpt" id="edit_level_jlpt" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                        <option value="">Pilih Level</option>
                        <option value="N1">N1</option>
                        <option value="N2">N2</option>
                        <option value="N3">N3</option>
                        <option value="N4">N4</option>
                        <option value="N5">N5</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Upload Dokumen (Kosongkan jika tidak diganti)</label>
                    <input type="file" name="dokumen_sertifikat" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-yellow-600 file:text-white hover:file:bg-yellow-700">
                </div>
            </div>
            <div class="p-6 border-t border-gray-700 flex justify-end gap-3">
                <button type="button" onclick="closeEditSertifikatModal()" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg transition-all duration-300">
                    Batal
                </button>
                <button type="submit" class="bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 transition-all duration-300">
                    <iconify-icon icon="mdi:content-save" width="18" height="18"></iconify-icon>
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

<style>
    /* Select2 Dark Theme */
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--multiple {
        background-color: #374151 !important;
        border-color: #4B5563 !important;
        min-height: 42px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: white !important;
        line-height: 42px !important;
        padding-left: 12px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #1F2937 !important;
        border-color: #4B5563 !important;
        color: white !important;
    }
    .select2-dropdown {
        background-color: #1F2937 !important;
        border-color: #4B5563 !important;
    }
    .select2-container--default .select2-results__option {
        color: white !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #2563EB !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #374151 !important;
        color: white !important;
        border-color: #4B5563 !important;
    }
    
    /* Tab Styles */
    .tab-btn {
        background-color: #1F2937;
        color: #9CA3AF;
    }
    .tab-btn.active {
        background-color: #2563EB;
        color: white;
    }
        /* Tooltip untuk tab yang terkunci */
    .tab-btn[data-unlocked="0"] {
        position: relative;
    }

    /* Panah atas Tooltip */
    .tab-btn[data-unlocked="0"]::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(-8px);
        border-width: 6px;
        border-style: solid;
        border-color: transparent transparent #1f2937 transparent;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
        pointer-events: none;
        z-index: 9999;
    }

    /* Munculkan tooltip saat di-hover */
    .tab-btn[data-unlocked="0"]:hover::before,
    .tab-btn[data-unlocked="0"]:hover::after {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
    }

    /* Animasi getar (shake) saat tab terkunci diklik */
    .tab-btn.shake {
        animation: shake 0.4s cubic-bezier(.36,.07,.19,.97) both;
    }

    @keyframes shake {
        10%, 90% { transform: translate3d(-1px, 0, 0); }
        20%, 80% { transform: translate3d(2px, 0, 0); }
        30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
        40%, 60% { transform: translate3d(4px, 0, 0); }
    }
    
    /* Scrollbar Styles */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    ::-webkit-scrollbar {
        width: 8px;
    }
    ::-webkit-scrollbar-track {
        background: #1F2937;
    }
    ::-webkit-scrollbar-thumb {
        background: #4B5563;
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #6B7280;
    }
    /* Radio Button Custom Styling */
    .peer:checked ~ div:first-of-type {
        border-color: #3b82f6;
        border-width: 6px;
        background-color: transparent;
    }

    .peer:checked ~ div:first-of-type + div .iconify-icon {
        color: #3b82f6;
    }

    /* Hover effects */
    .group:hover .peer:not(:checked) ~ div:first-of-type {
        border-color: #60a5fa;
    }

    /* Focus state for accessibility */
    .peer:focus-visible ~ div:first-of-type {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }

    /* Animation */
    .peer:checked ~ div:first-of-type {
        animation: radioPulse 0.3s ease-out;
    }
    @keyframes radioPulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
        }
    }

    /* Select2 styling untuk optgroup */
    .select2-container--default .select2-results__group {
        background-color: #1f2937;
        color: #9ca3af;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 8px 12px;
        border-bottom: 1px solid #374151;
        border-top: 1px solid #374151;
    }

    .select2-container--default .select2-results__option {
        padding: 8px 12px 8px 24px;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #3b82f6 !important;
        color: white !important;
    }

    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #2563eb !important;
        color: white !important;
    }

    /* Dark mode scrollbar untuk select2 dropdown */
    .select2-dropdown {
        scrollbar-width: thin;
        scrollbar-color: #4b5563 #1f2937;
    }

    .select2-dropdown::-webkit-scrollbar {
        width: 8px;
    }

    .select2-dropdown::-webkit-scrollbar-track {
        background: #1f2937;
    }

    .select2-dropdown::-webkit-scrollbar-thumb {
        background-color: #4b5563;
        border-radius: 4px;
        border: 2px solid #1f2937;
    }
    /* Custom Flatpickr Dark Theme */
    .flatpickr-calendar {
        background: #1f2937 !important;
        border: 1px solid #374151 !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
        font-family: inherit;
    }

    .flatpickr-months {
        background: #111827 !important;
        border-bottom: 1px solid #374151 !important;
        border-radius: 12px 12px 0 0 !important;
    }

    .flatpickr-months .flatpickr-month {
        color: #e5e7eb !important;
    }

    .flatpickr-weekdays {
        background: #1f2937 !important;
    }

    .flatpickr-weekday {
        color: #9ca3af !important;
        font-weight: 600 !important;
    }

    .flatpickr-days {
        background: #1f2937 !important;
    }

    .flatpickr-day {
        color: #e5e7eb !important;
        border-radius: 8px !important;
        margin: 2px !important;
        transition: all 0.2s ease;
    }

    .flatpickr-day:hover {
        background: #374151 !important;
        border-color: #4b5563 !important;
        transform: scale(1.05);
    }

    .flatpickr-day.selected {
        background: #3b82f6 !important;
        border-color: #2563eb !important;
        color: white !important;
        font-weight: 600 !important;
        box-shadow: 0 2px 10px -2px #3b82f6;
    }

    .flatpickr-day.today {
        border-color: #60a5fa !important;
        background: rgba(59, 130, 246, 0.2) !important;
    }

    .flatpickr-day.today:hover {
        background: #3b82f6 !important;
        border-color: #2563eb !important;
    }

    .flatpickr-day.prevMonthDay,
    .flatpickr-day.nextMonthDay {
        color: #6b7280 !important;
    }

    .flatpickr-day.disabled {
        color: #4b5563 !important;
        background: transparent !important;
        border-color: transparent !important;
    }

    .flatpickr-current-month .flatpickr-monthDropdown-months {
        background: #1f2937 !important;
        color: #e5e7eb !important;
        border-radius: 6px !important;
        padding: 4px 8px !important;
    }

    .flatpickr-current-month input.cur-year {
        color: #e5e7eb !important;
    }

    .numInputWrapper span.arrowUp,
    .numInputWrapper span.arrowDown {
        border-color: #4b5563 !important;
    }

    .numInputWrapper span.arrowUp:hover,
    .numInputWrapper span.arrowDown:hover {
        background: #374151 !important;
    }

    .flatpickr-time {
        background: #1f2937 !important;
        border-top: 1px solid #374151 !important;
        border-radius: 0 0 12px 12px !important;
    }

    .flatpickr-time input {
        color: #e5e7eb !important;
    }

    .flatpickr-time .flatpickr-am-pm {
        color: #e5e7eb !important;
    }

    .flatpickr-time .flatpickr-am-pm:hover {
        background: #374151 !important;
    }

    /* Animation untuk input */
    .flatpickr-input.date-selected {
        animation: pulse 0.3s ease-in-out;
        border-color: #3b82f6;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
        }
        50% {
            transform: scale(1.02);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.3);
        }
        100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
        }
    }

    /* Custom scrollbar untuk dropdown bulan */
    .flatpickr-monthDropdown-months {
        scrollbar-width: thin;
        scrollbar-color: #4b5563 #1f2937;
    }

    .flatpickr-monthDropdown-months::-webkit-scrollbar {
        width: 6px;
    }

    .flatpickr-monthDropdown-months::-webkit-scrollbar-track {
        background: #1f2937;
    }

    .flatpickr-monthDropdown-months::-webkit-scrollbar-thumb {
        background-color: #4b5563;
        border-radius: 3px;
    }

        /* Notification Styles */
    .notification {
        transform: translateX(100%);
        opacity: 0;
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    /* Progress bar untuk auto-dismiss */
    .notification {
        position: relative;
        overflow: hidden;
    }

    .notification::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, rgba(255,255,255,0.5), rgba(255,255,255,0.8));
        animation: progress 5s linear forwards;
    }

    @keyframes progress {
        0% {
            width: 100%;
        }
        100% {
            width: 0%;
        }
    }

    /* Hover effect untuk pause progress */
    .notification:hover::after {
        animation-play-state: paused;
    }

    /* Stack notifications dengan efek */
    .notification + .notification {
        margin-top: 0.75rem;
    }

    /* Mobile responsiveness */
    @media (max-width: 640px) {
        #notification-container {
            width: calc(100% - 2rem);
            right: 1rem;
            left: 1rem;
            top: 1rem;
        }
    }

    /* Entrance animation */
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Exit animation */
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
        /* Di bagian style, tambahkan */
    .font-japanese {
        font-family: 'Hiragino Sans', 'Hiragino Kaku Gothic ProN', 'Noto Sans JP', 'Meiryo', sans-serif;
    }

    /* Styling untuk textarea */
    textarea[name="content_jp"] {
        background-image: linear-gradient(to right, #1f2937 0%, #111827 100%);
        background-attachment: local;
        background-repeat: no-repeat;
        background-size: 100% 2px;
        background-position: bottom;
    }

    /* Placeholder styling */
    textarea[name="content_jp"]::placeholder {
        color: #4b5563;
        font-style: italic;
        font-size: 0.95rem;
    }

    /* Animasi untuk save indicator */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    #saveIndicator:not(.hidden) {
        animation: slideIn 0.3s ease-out;
    }
</style>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
        if (!modal.classList.contains('hidden')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
        }
    }
</script>
<script>
    // Flatpickr untuk tanggal lahir
    flatpickr("#edit_tanggal_lahir", {
        locale: "id",
        dateFormat: "d/m/Y",
        maxDate: "today",
        altInput: true,
        altFormat: "d F Y",
        theme: "dark"
    });

    // Validasi No HP hanya angka
    document.getElementById('edit_no_hp')?.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Validasi file foto
    document.getElementById('edit_foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const errorContainer = document.getElementById('edit_foto_error');
        
        if (file) {
            errorContainer.classList.add('hidden');
            errorContainer.innerHTML = '';
            
            // Check file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                errorContainer.innerHTML = 'Ukuran file maksimal 2MB';
                errorContainer.classList.remove('hidden');
                this.value = '';
                return;
            }
            
            // Check file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                errorContainer.innerHTML = 'Format file harus JPG atau PNG';
                errorContainer.classList.remove('hidden');
                this.value = '';
                return;
            }
        }
    });

    // Form submit with loading
    document.querySelector('form[action="{{ route('siswa.updateMyBiodata') }}"]').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('edit_submit_btn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<iconify-icon icon="mdi:loading" class="animate-spin" width="18" height="18"></iconify-icon> Menyimpan...';
    });
</script>

<script>
        // Character counter
    const textarea = document.getElementById('jikoPiaruTextarea');
    const charCount = document.getElementById('charCount');

    function updateCharCount() {
        if (!textarea || !charCount) return;
        
        const count = textarea.value.length;
        charCount.textContent = count;
        
        // Change color based on length
        if (count > 4000) {
            charCount.className = 'text-xl font-bold text-red-400';
        } else if (count > 3000) {
            charCount.className = 'text-xl font-bold text-yellow-400';
        } else {
            charCount.className = 'text-xl font-bold text-white';
        }
    }

    // Initial count
    if (textarea && charCount) {
        updateCharCount();
        
        // Update on input
        textarea.addEventListener('input', updateCharCount);
    }

    if (textarea) {
        textarea.style.minHeight = "350px";
    }

    // Reset function
    function resetJikoPiaru() {
        if (!textarea) return;
        
        if (confirm('Yakin ingin mereset? Semua perubahan akan hilang.')) {
            @if(isset($jikoPiaru) && $jikoPiaru && $jikoPiaru->content_jp)
                textarea.value = `{{ addslashes($jikoPiaru->content_jp) }}`;
            @else
                textarea.value = '';
            @endif
            updateCharCount();
            
            // Tampilkan notifikasi
            showNotification('Textarea telah direset', 'info');
        }
    }

    // Auto-resize textarea
    function autoResizeTextarea() {
        if (!textarea) return;
        
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
    }

    if (textarea) {
        textarea.addEventListener('input', autoResizeTextarea);
        
        // Trigger initial resize
        setTimeout(autoResizeTextarea, 100);
    }

    // Tab switching - untuk mengaktifkan tab Jiko Piaru
    // Update fungsi activateTab yang sudah ada
    function activateTab(tabName) {
        const tabs = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content');
        
        tabs.forEach(t => {
            if(t.dataset.tab === tabName) {
                t.classList.add('active', 'bg-blue-600', 'text-white', 'shadow-md', 'shadow-blue-500/20');
                t.classList.remove('text-gray-400', 'hover:bg-gray-800');

                t.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'center'
                });
            } else {
                t.classList.remove('active', 'bg-blue-600', 'text-white', 'shadow-md', 'shadow-blue-500/20');
                t.classList.add('text-gray-400', 'hover:bg-gray-800');
            }
        });
        
        contents.forEach(c => {
            if(c.id === tabName) {
                c.classList.remove('hidden');
                c.classList.add('animate-fade-in');
                
                if (tabName === 'jiko-piaru') {
                    setTimeout(autoResizeTextarea, 300);
                }
            } else {
                c.classList.add('hidden');
                c.classList.remove('animate-fade-in');
            }
        });
    }
</script>

<script>
    // Inisialisasi Flatpickr untuk tanggal lahir dengan opsi lengkap
    flatpickr("#tanggal_lahir", {
        dateFormat: "Y-m-d",
        altFormat: "j F Y", // Format alternatif yang lebih readable
        altInput: true, // Menampilkan format yang lebih bagus
        allowInput: true,
        theme: "dark",
        maxDate: "today", // Tidak bisa memilih tanggal masa depan
        defaultDate: "today", // Default ke hari ini jika tidak ada value
        locale: {
            firstDayOfWeek: 1, // Senin sebagai hari pertama
            weekdays: {
                shorthand: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                longhand: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"]
            },
            months: {
                shorthand: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
                longhand: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"]
            }
        },
        // Custom styling untuk tampilan yang lebih menarik
        onReady: function(selectedDates, dateStr, instance) {
            instance.calendarContainer.classList.add('custom-calendar');
        },
        // Animasi saat memilih tanggal
        onChange: function(selectedDates, dateStr, instance) {
            const input = instance.input;
            input.classList.add('date-selected');
            setTimeout(() => {
                input.classList.remove('date-selected');
            }, 300);
        }
    });
    
    flatpickr("#tanggal_lulus", {
        dateFormat: "Y-m-d",
        altFormat: "j F Y", // Format alternatif yang lebih readable
        altInput: true, // Menampilkan format yang lebih bagus
        allowInput: true,
        theme: "dark",
        maxDate: "today", // Tidak bisa memilih tanggal masa depan
        defaultDate: "today", // Default ke hari ini jika tidak ada value
        locale: {
            firstDayOfWeek: 1, // Senin sebagai hari pertama
            weekdays: {
                shorthand: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                longhand: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"]
            },
            months: {
                shorthand: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
                longhand: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"]
            }
        },
        // Custom styling untuk tampilan yang lebih menarik
        onReady: function(selectedDates, dateStr, instance) {
            instance.calendarContainer.classList.add('custom-calendar');
        },
        // Animasi saat memilih tanggal
        onChange: function(selectedDates, dateStr, instance) {
            const input = instance.input;
            input.classList.add('date-selected');
            setTimeout(() => {
                input.classList.remove('date-selected');
            }, 300);
        }
    });

    flatpickr("#tanggal_diterbitkan", {
        dateFormat: "Y-m-d",
        altFormat: "j F Y", // Format alternatif yang lebih readable
        altInput: true, // Menampilkan format yang lebih bagus
        allowInput: true,
        theme: "dark",
        maxDate: "today", // Tidak bisa memilih tanggal masa depan
        defaultDate: "today", // Default ke hari ini jika tidak ada value
        locale: {
            firstDayOfWeek: 1, // Senin sebagai hari pertama
            weekdays: {
                shorthand: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                longhand: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"]
            },
            months: {
                shorthand: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
                longhand: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"]
            }
        },
        // Custom styling untuk tampilan yang lebih menarik
        onReady: function(selectedDates, dateStr, instance) {
            instance.calendarContainer.classList.add('custom-calendar');
        },
        // Animasi saat memilih tanggal
        onChange: function(selectedDates, dateStr, instance) {
            const input = instance.input;
            input.classList.add('date-selected');
            setTimeout(() => {
                input.classList.remove('date-selected');
            }, 300);
        }
    });

    flatpickr("#tanggal_expired", {
        dateFormat: "Y-m-d",
        altFormat: "j F Y", // Format alternatif yang lebih readable
        altInput: true, // Menampilkan format yang lebih bagus
        allowInput: true,
        theme: "dark",
        maxDate: "today", // Tidak bisa memilih tanggal masa depan
        defaultDate: "today", // Default ke hari ini jika tidak ada value
        locale: {
            firstDayOfWeek: 1, // Senin sebagai hari pertama
            weekdays: {
                shorthand: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                longhand: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"]
            },
            months: {
                shorthand: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
                longhand: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"]
            }
        },
        // Custom styling untuk tampilan yang lebih menarik
        onReady: function(selectedDates, dateStr, instance) {
            instance.calendarContainer.classList.add('custom-calendar');
        },
        // Animasi saat memilih tanggal
        onChange: function(selectedDates, dateStr, instance) {
            const input = instance.input;
            input.classList.add('date-selected');
            setTimeout(() => {
                input.classList.remove('date-selected');
            }, 300);
        }
    });
</script>

<script>
        // Notification System
    document.addEventListener('DOMContentLoaded', function() {
        // Auto dismiss notifications after 5 seconds
        const notifications = document.querySelectorAll('.notification');
        notifications.forEach((notification, index) => {
            // Stagger animation for multiple notifications
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
                notification.style.opacity = '1';
            }, index * 100);
            
            // Auto dismiss after 5 seconds
            setTimeout(() => {
                dismissNotification(notification.querySelector('button'));
            }, 5000 + (index * 100));
        });
    });

    // Function to dismiss notification
    function dismissNotification(button) {
        const notification = button.closest('.notification');
        if (notification) {
            notification.style.transform = 'translateX(100%)';
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.remove();
            }, 500);
        }
    }

    // Function to show custom notification (for AJAX calls, etc.)
    function showNotification(message, type = 'success') {
        const container = document.getElementById('notification-container');
        const template = document.getElementById(`notification-template-${type}`);
        
        if (template && container) {
            const notification = template.cloneNode(true);
            notification.id = '';
            notification.classList.remove('hidden');
            notification.classList.add('notification');
            
            // Set message
            const messageEl = notification.querySelector('.message-placeholder');
            if (messageEl) {
                messageEl.textContent = message;
            }
            
            // Add to container
            container.appendChild(notification);
            
            // Trigger animation
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
                notification.style.opacity = '1';
            }, 10);
            
            // Auto dismiss after 5 seconds
            setTimeout(() => {
                dismissNotification(notification.querySelector('button'));
            }, 5000);
        }
    }

    // Function to toggle error details
    function toggleErrorDetails(button) {
        const details = button.closest('.bg-gradient-to-r').querySelector('.error-details');
        const icon = button.querySelector('iconify-icon');
        
        if (details) {
            if (details.classList.contains('hidden')) {
                details.classList.remove('hidden');
                icon.setAttribute('icon', 'mdi:chevron-up');
            } else {
                details.classList.add('hidden');
                icon.setAttribute('icon', 'mdi:chevron-down');
            }
        }
    }

    // Optional: Add keyboard shortcut to dismiss all notifications (ESC key)
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                dismissNotification(notification.querySelector('button'));
            });
        }
    });
</script>

<script>
        // Save button visibility and scroll effect
    window.addEventListener('scroll', function() {
        const topSaveBtn = document.querySelector('.sticky.top-0');
        if (window.scrollY > 100) {
            topSaveBtn.classList.add('shadow-lg');
        } else {
            topSaveBtn.classList.remove('shadow-lg');
        }
    });

    // Progress bar animation on scroll
    window.addEventListener('scroll', function() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        const progressBar = document.getElementById('saveProgress');
        if (progressBar) {
            progressBar.style.width = scrolled + '%';
        }
    });
    window.addEventListener('scroll', function() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        const progressBar = document.getElementById('saveProgressKeluarga');
        if (progressBar) {
            progressBar.style.width = scrolled + '%';
        }
    });
    window.addEventListener('scroll', function() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        const progressBar = document.getElementById('saveProgressJiko');
        if (progressBar) {
            progressBar.style.width = scrolled + '%';
        }
    });
    window.addEventListener('scroll', function() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        const progressBar = document.getElementById('saveProgressSertifikat');
        if (progressBar) {
            progressBar.style.width = scrolled + '%';
        }
    });
    window.addEventListener('scroll', function() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        const progressBar = document.getElementById('saveProgressRiwayatPekerjaan');
        if (progressBar) {
            progressBar.style.width = scrolled + '%';
        }
    });
    window.addEventListener('scroll', function() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        const progressBar = document.getElementById('saveProgressPendidikan');
        if (progressBar) {
            progressBar.style.width = scrolled + '%';
        }
    });
</script>

<script>
// Original JavaScript functions remain exactly the same
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('status_siswa_sebelumnya').addEventListener('change', function () {
        if (this.value === 'LPK') {
            document.getElementById('field_lpk').style.display = 'block';
        } else {
            document.getElementById('field_lpk').style.display = 'none';
        }
    });

    // Tab activation
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');
    const tabContainer = document.getElementById('tabContainer');

    function activateTab(tabName) {
        // ❗ Cegah masuk ke tab yang terkunci
        const targetBtn = Array.from(tabs).find(t => t.dataset.tab === tabName);
        if (targetBtn && targetBtn.dataset.unlocked === '0') {
            if (typeof showNotification === 'function') {
                showNotification('Lengkapi data tab sebelumnya terlebih dahulu.', 'error');
            } else {
                alert('Lengkapi data tab sebelumnya terlebih dahulu.');
            }
            return;
        }

        tabs.forEach(t => {
            const isActive = t.dataset.tab === tabName;

            if (isActive) {
                t.classList.add('active', 'bg-blue-600', 'text-white', 'shadow-lg', 'shadow-blue-900/20');
                t.classList.remove('text-gray-400', 'bg-transparent');

                if (window.innerWidth < 1024) {
                    t.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest',
                        inline: 'center'
                    });
                }
            } else {
                t.classList.remove('active', 'bg-blue-600', 'text-white', 'shadow-lg', 'shadow-blue-900/20');
                t.classList.add('text-gray-400', 'bg-transparent');
            }
        });

        contents.forEach(c => {
            c.classList.toggle('hidden', c.id !== tabName);
        });
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', (e) => {
            if (tab.dataset.unlocked === '0') {
                e.preventDefault();
                if (typeof showNotification === 'function') {
                    showNotification('Lengkapi data tab sebelumnya terlebih dahulu.', 'error');
                } else {
                    alert('Lengkapi data tab sebelumnya terlebih dahulu.');
                }
                return;
            }
            activateTab(tab.dataset.tab);
        });
    });

    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');
    
    // Ambil dari URL, atau session Laravel
    let activeTab = tabParam || "{{ session('active_tab') }}";
    
    // Fallback jika kosong
    if (activeTab === "" || activeTab === "undefined" || !activeTab) {
        activeTab = "biodata";
    }

    // ✅ WAJIB DIPANGGIL: Eksekusi fungsi untuk membuka tabnya
    activateTab(activeTab);
});

// Keluarga Modal Functions
function openCreateModal() {
    document.getElementById('createModal').classList.remove('hidden');
    document.getElementById('createModal').classList.add('flex');
    
    setTimeout(() => {
        $('#createModal .select-hubungan').select2({
            dropdownParent: $('#createModal'),
            width: '100%',
            minimumResultsForSearch: Infinity
        });
    }, 100);
}

function closeCreateModal() {
    document.getElementById('createModal').classList.add('hidden');
}

function openEditModal(id, hubungan, nama, tempat, tanggal, alamat, pekerjaan, telepon) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');

    form.action = `/keluarga/${id}`;

    setTimeout(() => {
        $('#editModal .select-hubungan').select2({
            dropdownParent: $('#editModal'),
            width: '100%',
            minimumResultsForSearch: Infinity
        });
        $('#editModal .select-hubungan').val(hubungan).trigger('change');
    }, 100);

    form.querySelector('[name="nama"]').value = nama;
    form.querySelector('[name="tempat_lahir"]').value = tempat;
    form.querySelector('[name="tanggal_lahir"]').value = tanggal;
    
    setTimeout(() => {
        $('#editModal .select2-pekerjaan-edit').val(pekerjaan).trigger('change');
    }, 100);
    
    form.querySelector('[name="no_telepon"]').value = telepon;

    if (alamat === 'Satu Rumah') {
        form.querySelector('[value="Satu Rumah"]').checked = true;
    } else {
        form.querySelector('[value="Beda Rumah"]').checked = true;
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function openJapanModal() {
    document.getElementById('japanModal').classList.remove('hidden');
    document.getElementById('japanModal').classList.add('flex');
    
    setTimeout(() => {
        $('#hubungan_jepang, #alamat_jepang').select2({
            dropdownParent: $('#japanModal'),
            width: '100%'
        });
    }, 100);
}

function closeJapanModal() {
    document.getElementById('japanModal').classList.add('hidden');
}

// Pendidikan Modal Functions
function openPendidikanModal() {
    document.getElementById('pendidikanModal').classList.remove('hidden');
    document.getElementById('pendidikanModal').classList.add('flex');

    setTimeout(() => {
        $('#jenjang_pendidikan, #bulan_masuk').select2({
            dropdownParent: $('#pendidikanModal'),
            width: '100%'
        });
    }, 100);
}

function closePendidikanModal() {
    document.getElementById('pendidikanModal').classList.add('hidden');
}

const globalDaftarJurusan = {
    SD: ['Umum'],
    SMP: ['Umum'],
    SMA: ['IPA', 'IPS', 'Bahasa'],
    SMK: [
        'Teknik Kendaraan Ringan','Teknik Sepeda Motor','Teknik Komputer Jaringan',
        'Rekayasa Perangkat Lunak','Teknik Pemesinan','Teknik Pengelasan',
        'Akuntansi','Perkantoran','Keperawatan','Tata Boga','Tata Busana'
    ],
    KULIAH: [
        'Hukum','Ekonomi','Kedokteran','Teknik Informatika','Sistem Informasi',
        'Psikologi','Sastra Jepang','Manajemen','Pendidikan Guru','Pertanian'
    ]
};

function updateJurusanOptions(jenjang, target, selected = null) {
    const jurusan = $('#' + target);
    jurusan.empty();
    jurusan.append('<option value="">Pilih Jurusan</option>');

    if(!jenjang) return;

    const data = globalDaftarJurusan[jenjang] || [];

    data.forEach(function(item){
        jurusan.append(new Option(item, item));
    });

    if(selected){
        jurusan.val(selected).trigger('change');
    }
}

function openEditPendidikan(id, jenjang, sekolah, jurusan, tahun, bulan, lulus){
    const modal = document.getElementById('editPendidikanModal');
    const form = document.getElementById('editPendidikanForm');

    form.action = `/pendidikan/${id}`;

    $('#nama_sekolah_edit').val(sekolah);
    $('#tahun_masuk_edit').val(tahun);
    $('#tanggal_lulus_edit').val(lulus);
    $('#bulan_masuk_edit').val(bulan);

    setTimeout(() => {
        if($('#jenjang_pendidikan_edit').hasClass("select2-hidden-accessible")){
            $('#jenjang_pendidikan_edit').select2('destroy');
        }

        if($('#jurusan_edit').hasClass("select2-hidden-accessible")){
            $('#jurusan_edit').select2('destroy');
        }

        $('#jenjang_pendidikan_edit').select2({
            dropdownParent: $('#editPendidikanModal'),
            width: '100%'
        });

        $('#jurusan_edit').select2({
            dropdownParent: $('#editPendidikanModal'),
            width: '100%'
        });

        $('#jenjang_pendidikan_edit').val(jenjang).trigger('change');
        updateJurusanOptions(jenjang, 'jurusan_edit', jurusan);
    }, 100);

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

$(document).on('change', '#jenjang_pendidikan_edit', function(){
    const jenjang = $(this).val();
    updateJurusanOptions(jenjang, 'jurusan_edit');
});

function closeEditPendidikan(){
    document.getElementById('editPendidikanModal').classList.add('hidden');
}

$(document).ready(function() {
    $('#jenjang_pendidikan').on('change', function() {
        updateJurusanOptions($(this).val(), 'jurusan');
    });
});

// Riwayat Pekerjaan Functions
function togglePengalaman() {
    const tempat = document.getElementById('tempatBekerja').value;
    const pengalaman = document.getElementById('pengalamanField');

    if (tempat === 'Jepang') {
        pengalaman.classList.remove('hidden');
    } else {
        pengalaman.classList.add('hidden');
        pengalaman.querySelector('select').value = '';
    }
}

function openRiwayatModal() {
    document.getElementById('riwayatModal').classList.remove('hidden');
    document.getElementById('riwayatModal').classList.add('flex');
}

function closeRiwayatModal() {
    document.getElementById('riwayatModal').classList.add('hidden');
}

function openEditModalRiwayat(
    id, perusahaan, pekerjaan, katakana,
    tempat, pengalaman, gaji,
    tahunMulai, bulanMulai,
    tahunSelesai, bulanSelesai,
    deskripsi
) {
    document.getElementById('editFormPekerjaan').action = '/riwayat-pekerjaan/' + id;

    document.getElementById('edit_perusahaan').value = perusahaan;
    document.getElementById('edit_pekerjaan').value = pekerjaan;
    document.getElementById('edit_katakana').value = katakana;
    document.getElementById('edit_tempat').value = tempat;
    document.getElementById('edit_pengalaman').value = pengalaman;
    document.getElementById('edit_gaji').value = gaji;
    document.getElementById('edit_tahun_mulai').value = tahunMulai;
    document.getElementById('edit_bulan_mulai').value = bulanMulai;
    document.getElementById('edit_tahun_selesai').value = tahunSelesai;
    document.getElementById('edit_bulan_selesai').value = bulanSelesai;
    document.getElementById('edit_deskripsi').value = deskripsi;

    toggleEditPengalaman();

    document.getElementById('editRiwayatModal').classList.remove('hidden');
    document.getElementById('editRiwayatModal').classList.add('flex');
}

function toggleEditPengalaman() {
    const tempat = document.getElementById('edit_tempat').value;
    const pengalamanField = document.getElementById('edit_pengalaman_field');
    const pengalaman = document.getElementById('edit_pengalaman');

    if (tempat === 'Jepang') {
        pengalamanField.classList.remove('hidden');
    } else {
        pengalamanField.classList.add('hidden');
        pengalaman.value = '';
    }
}

function closeEditModalRiwayat() {
    document.getElementById('editRiwayatModal').classList.add('hidden');
}

// Sertifikat Functions
function openSertifikatModal(){
    document.getElementById('sertifikatModal').classList.remove('hidden');
    document.getElementById('sertifikatModal').classList.add('flex');
}

function closeSertifikatModal(){
    document.getElementById('sertifikatModal').classList.add('hidden');
}

function openEditSertifikatModal(id, nama, terbit, expired, levelJlpt) {
    document.getElementById('editSertifikatForm').action = '/sertifikat/' + id;
    document.getElementById('edit_nama_sertifikat').value = nama ?? '';
    document.getElementById('edit_tanggal_diterbitkan').value = terbit ?? '';
    document.getElementById('edit_tanggal_expired').value = expired ?? '';
    document.getElementById('edit_level_jlpt').value = levelJlpt ?? '';

    document.getElementById('editSertifikatModal').classList.remove('hidden');
    document.getElementById('editSertifikatModal').classList.add('flex');
}

function closeEditSertifikatModal() {
    document.getElementById('editSertifikatModal').classList.add('hidden');
}

if (textarea) {
        textarea.addEventListener('keydown', function(e) {
            // Cek apakah yang ditekan adalah tombol Enter
            if (e.key === 'Enter' && !e.shiftKey) { // Shift+Enter tetap diizinkan untuk baris baru paksa
                
                // Dapatkan posisi kursor saat ini
                const cursorPos = this.selectionStart;
                
                // Ambil teks dari awal baris sampai posisi kursor
                const textBeforeCursor = this.value.substring(0, cursorPos);
                const lastNewLine = textBeforeCursor.lastIndexOf('\n');
                const currentLine = textBeforeCursor.substring(lastNewLine + 1);

                // Buat elemen bayangan (hidden) untuk mengukur lebar teks
                const span = document.createElement('span');
                const computedStyle = window.getComputedStyle(this);
                
                // Copy style font dari textarea ke span
                span.style.font = computedStyle.font;
                span.style.letterSpacing = computedStyle.letterSpacing;
                span.style.whiteSpace = 'pre-wrap';
                span.style.visibility = 'hidden';
                span.style.position = 'absolute';
                span.textContent = currentLine;
                
                document.body.appendChild(span);

                // Hitung lebar teks dan lebar maksimal textarea (dikurangi padding)
                const textWidth = span.offsetWidth;
                const paddingLeft = parseFloat(computedStyle.paddingLeft);
                const paddingRight = parseFloat(computedStyle.paddingRight);
                const maxWidth = this.clientWidth - paddingLeft - paddingRight;

                document.body.removeChild(span);

                // Jika teks belum mencapai 90% dari lebar maksimal, blokir Enter
                if (textWidth < maxWidth * 0.9) {
                    e.preventDefault();
                    if (typeof showNotification === 'function') {
                        showNotification('Teks belum mencapai ujung baris. Terus ketik', 'error');
                    }
                }
            }
        });
    }

// Select2 and Flatpickr Initialization
$(document).ready(function() {

    $('.select2-pekerjaan').select2({
        placeholder: "Pilih atau Ketik Pekerjaan",
        allowClear: true,
        tags: true,
        width: '100%'
    });

    $('.select2-pekerjaan-edit').select2({
        placeholder: "Pilih atau Ketik Pekerjaan",
        allowClear: true,
        tags: true,
        width: '100%',
        dropdownParent: $('#modalEdit') // id modal
    });

    $('.select2-basic').select2({
        placeholder: "Pilih Penyakit",
        width: '100%'
    });
    
    $('.select2-multiple').select2({
        placeholder: "Pilih Hobi",
        allowClear: true,
        width: '100%'
    });

    $('.select2-jurusan').select2({
        placeholder: "Pilih Jurusan",
        allowClear: true,
        width: '100%'
    });

    flatpickr(".flatpickr", {
        dateFormat: "Y-m-d",
        theme: "dark"
    });
});
</script>

<script>
    const tooltip = document.getElementById('global-tooltip');
    const lockedTabs = document.querySelectorAll('.tab-btn[data-unlocked="0"]');

    lockedTabs.forEach(tab => {
        // Saat mouse masuk, tampilkan tooltip di atas tombol
        tab.addEventListener('mouseenter', function(e) {
            const rect = this.getBoundingClientRect();
            
            // Hitung posisi tengah tombol
            const left = rect.left + (rect.width / 2);
            const top = rect.top - 35; // 35px di atas tombol

            tooltip.style.left = `${left}px`;
            tooltip.style.top = `${top}px`;
            tooltip.style.transform = 'translateX(-50%)'; // Agar teks di tengah
            tooltip.style.display = 'block';
            
            // Animasi fade in
            setTimeout(() => tooltip.style.opacity = '1', 10);
        });

        // Saat mouse keluar, sembunyikan tooltip
        tab.addEventListener('mouseleave', function() {
            tooltip.style.opacity = '0';
            setTimeout(() => {
                if(tooltip.style.opacity === '0') tooltip.style.display = 'none';
            }, 200);
        });
    });
</script>
@endsection