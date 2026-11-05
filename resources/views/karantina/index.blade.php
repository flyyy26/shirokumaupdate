@extends('layouts.app')

@section('content')
<div class="container mx-auto w-full">
    <!-- Header with Glassmorphism Effect -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <iconify-icon icon="mdi:medical-bag" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Data Kelas Karantina</h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola kelas dan absensi karantina</p>
                </div>
            </div>
            
            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">

                <!-- Rekap Absensi Button -->
                <a href="{{ route('rekap.absensi') }}"
                    class="flex-1 sm:flex-none bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-4 py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl text-sm">
                    <iconify-icon icon="mdi:file-document" width="18" height="18"></iconify-icon>
                    <span class="hidden sm:inline">Rekap Absensi</span>
                    <span class="sm:hidden">Rekap</span>
                </a>

                <!-- Buat Kelas Button -->
                <button onclick="openModal()" 
                    class="flex-1 sm:flex-none bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl text-sm">
                    <iconify-icon icon="mdi:plus" width="18" height="18"></iconify-icon>
                    <span class="hidden sm:inline">Buat Kelas</span>
                    <span class="sm:hidden">Buat</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Flash Notification -->
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

    @if($kelas->isEmpty())
    <!-- Empty State -->
    <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-2xl p-8 sm:p-12 text-center backdrop-blur-sm">
        <div class="relative inline-block">
            <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full"></div>
            <div class="relative bg-gray-800 w-20 h-20 sm:w-24 sm:h-24 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                <iconify-icon icon="mdi:medical-bag" width="32" height="32" class="text-gray-600 sm:w-10 sm:h-10"></iconify-icon>
            </div>
        </div>
        <h3 class="text-lg sm:text-xl font-bold text-white mb-2">Belum Ada Kelas Karantina</h3>
        <p class="text-gray-500 text-sm sm:text-base max-w-md mx-auto mb-4">
            Anda belum membuat kelas karantina. Silakan buat kelas baru untuk memulai.
        </p>
        <button onclick="openModal()" 
                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300">
            <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
            Buat Kelas Baru
        </button>
    </div>
    @else

     <div class="w-full block md:hidden mb-4 bg-[#111827]/50 rounded-xl border border-gray-700/50 overflow-hidden">
        <div class="flex flex-nowrap items-center gap-2 p-3 overflow-x-auto scrollbar-hide">
            @foreach($kelas as $index => $item)
            <button onclick="openTab(event, 'kelas-{{ $item->id }}')"
                class="tab-btn px-4 sm:px-6 py-3 font-semibold text-sm sm:text-base text-gray-400 hover:text-white whitespace-nowrap transition-all duration-300 border-b-2 border-transparent flex items-center gap-2 {{ $index === 0 ? 'active border-blue-500 text-blue-500' : '' }}">
                <iconify-icon icon="mdi:medical-bag" width="16" height="16" class="{{ $index === 0 ? 'text-blue-500' : 'text-gray-500' }}"></iconify-icon>
                {{ $item->nama_kelas }}
                <span class="bg-blue-500/20 text-blue-400 text-xs px-2 py-0.5 rounded-full">{{ $item->siswas->count() }}</span>
            </button>
            @endforeach
        </div>
    </div>
    <!-- Tabs Navigation - Grid Layout -->
    <div class="w-full hidden md:block mb-6 border-b border-gray-700/50">
        <div class="flex flex-wrap items-center gap-2 pb-2">
            @foreach($kelas as $index => $item)
            <button onclick="openTab(event, 'kelas-{{ $item->id }}')"
                class="tab-btn px-4 py-3 font-semibold text-sm text-gray-400 hover:text-white transition-all duration-300 border-b-2 border-transparent flex items-center gap-2 {{ $index === 0 ? 'active border-blue-500 text-blue-500' : '' }} rounded-t-lg">
                <iconify-icon icon="mdi:medical-bag" width="16" height="16" class="{{ $index === 0 ? 'text-blue-500' : 'text-gray-500' }}"></iconify-icon>
                <span class="truncate max-w-[150px]">{{ $item->nama_kelas }}</span>
                <span class="bg-blue-500/20 text-blue-400 text-xs px-2 py-0.5 rounded-full">{{ $item->siswas->count() }}</span>
            </button>
            @endforeach
        </div>
    </div>

    <!-- Tabs Content -->
    @foreach($kelas as $index => $item)
    <div id="kelas-{{ $item->id }}" class="tab-content {{ $index === 0 ? '' : 'hidden' }} space-y-6">
        
        <!-- Detail Kelas Card -->
        <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
            <div class="p-4 sm:p-6 border-b border-gray-700/50 bg-gray-900/30">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-500/10 rounded-lg">
                            <iconify-icon icon="mdi:information" width="20" height="20" class="text-blue-400"></iconify-icon>
                        </div>
                        <div>
                            <h2 class="text-lg sm:text-xl font-bold text-white">{{ $item->nama_kelas }}</h2>
                            <p class="text-blue-400 text-xs sm:text-sm">{{ $item->periode_bulan }} {{ $item->periode_tahun }}</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('kelas.destroy', $item->id) }}" 
                          onsubmit="return confirm('Yakin ingin menghapus kelas ini? Data siswa tidak akan terhapus, hanya dilepas dari kelas.')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-400 hover:text-red-300 hover:bg-red-500/10 px-4 py-2 rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2">
                            <iconify-icon icon="mdi:delete" width="16" height="16"></iconify-icon>
                            <span class="hidden sm:inline">Hapus Kelas</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-gray-700/20 p-4 rounded-xl border border-gray-700/30">
                        <p class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                            <iconify-icon icon="mdi:teach" width="12" height="12"></iconify-icon>
                            Wali Kelas
                        </p>
                        <p class="text-white font-medium">{{ $item->guru->nama_lengkap ?? '-' }}</p>
                    </div>
                    
                    <div class="bg-gray-700/20 p-4 rounded-xl border border-gray-700/30">
                        <p class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                            <iconify-icon icon="mdi:office-building" width="12" height="12"></iconify-icon>
                            Perusahaan
                        </p>
                        <p class="text-white font-medium">{{ $item->company->nama_perusahaan }}</p>
                    </div>
                    
                    <div class="bg-gray-700/20 p-4 rounded-xl border border-gray-700/30">
                        <p class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                            <iconify-icon icon="mdi:briefcase" width="12" height="12"></iconify-icon>
                            Pekerjaan
                        </p>
                        <p class="text-white font-medium">{{ $item->job->jenis_pekerjaan }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jadwal & Absensi Section -->
        <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
            <div class="p-4 sm:p-6 border-b border-gray-700/50 bg-gray-900/30">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div class="flex items-center gap-2">
                        <div class="p-2 bg-yellow-500/10 rounded-lg">
                            <iconify-icon icon="mdi:calendar-clock" width="20" height="20" class="text-yellow-400"></iconify-icon>
                        </div>
                        <h3 class="text-white font-semibold">Jadwal & Absensi Hari Ini</h3>
                        <span class="text-gray-500 text-xs bg-gray-800/50 px-2 py-1 rounded-full">
                            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                        </span>
                    </div>
                    
                    <button onclick="toggleSesiForm('form-sesi-{{ $item->id }}')" 
                            class="text-blue-400 hover:text-blue-300 text-xs font-medium flex items-center gap-1 bg-blue-500/10 px-3 py-1.5 rounded-lg transition-all">
                        <iconify-icon icon="mdi:cog" width="14" height="14"></iconify-icon>
                        <span>Atur Jadwal Sesi</span>
                    </button>
                </div>
            </div>

            <!-- Form Tambah Sesi (Hidden by default) -->
            <form id="form-sesi-{{ $item->id }}" method="POST" action="{{ route('kelas.sesi.store', $item->id) }}" 
                  class="hidden p-4 bg-gray-900/50 border-b border-gray-700">
                @csrf
                <div class="flex flex-wrap gap-3 items-end">
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-xs text-gray-400 mb-1">Nama Sesi</label>
                        <input type="text" name="nama_sesi" placeholder="Contoh: Sesi 1"
                               class="w-full p-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg text-sm focus:outline-none focus:border-blue-500" required>
                    </div>
                    <div class="w-32">
                        <label class="block text-xs text-gray-400 mb-1">Jam Mulai</label>
                        <input type="time" name="jam_mulai"
                               class="w-full p-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg text-sm focus:outline-none focus:border-blue-500" required>
                    </div>
                    <div class="w-32">
                        <label class="block text-xs text-gray-400 mb-1">Jam Selesai</label>
                        <input type="time" name="jam_selesai"
                               class="w-full p-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg text-sm focus:outline-none focus:border-blue-500" required>
                    </div>
                    <div>
                        <button class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition-all">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>

            <div class="p-4 sm:p-6 space-y-3">
                @forelse($item->sesi as $sesi)
                <div class="bg-gray-700/30 border border-gray-700/50 p-4 rounded-xl text-sm text-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 hover:bg-gray-700/50 transition-all group">
                    <div class="flex items-start sm:items-center gap-3 w-full sm:w-auto">
                        <div class="p-2 bg-blue-500/10 rounded-lg">
                            <iconify-icon icon="mdi:clock-outline" width="16" height="16" class="text-blue-400"></iconify-icon>
                        </div>
                        <div>
                            <span class="font-bold text-blue-400">{{ $sesi->nama_sesi }}</span>
                            <span class="text-gray-400 text-sm ml-2">
                                {{ \Carbon\Carbon::parse($sesi->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->jam_selesai)->format('H:i') }}
                            </span>
                            @if($sesi->sudah_absen)
                            <span class="inline-flex items-center gap-1 ml-3 bg-green-500/10 text-green-400 text-xs px-2 py-0.5 rounded-full border border-green-500/20">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                Sudah Absen
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                        <!-- Tombol Hapus Sesi -->
                        <form action="{{ route('kelas.sesi.destroy', $sesi->id) }}"
                              method="POST"
                              class="opacity-0 group-hover:opacity-100 transition-opacity"
                              onsubmit="return confirm('Yakin ingin menghapus sesi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-400 hover:text-red-300 p-2 hover:bg-red-500/10 rounded-lg" title="Hapus Jadwal Sesi">
                                <iconify-icon icon="mdi:delete" width="16" height="16"></iconify-icon>
                            </button>
                        </form>

                        <!-- Tombol Absensi / Edit -->
                        @if($sesi->sudah_absen)
                        <a href="{{ route('kelas.absensi', [$item->id, $sesi->id, 'tanggal' => $tanggal]) }}"
                           class="bg-green-600/20 text-green-400 border border-green-600/30 px-4 py-2 text-xs rounded-lg hover:bg-green-600 hover:text-white transition-all font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:pencil" width="14" height="14"></iconify-icon>
                            Edit Absensi
                        </a>
                        @else
                        <a href="{{ route('kelas.absensi', [$item->id, $sesi->id, 'tanggal' => $tanggal]) }}"
                           class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 text-xs rounded-lg font-medium flex items-center gap-1 shadow-lg shadow-blue-900/20">
                            <iconify-icon icon="mdi:clipboard-check" width="14" height="14"></iconify-icon>
                            Mulai Absensi
                        </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <iconify-icon icon="mdi:clock-off" width="32" height="32" class="mx-auto mb-2 text-gray-600"></iconify-icon>
                    <p>Belum ada jadwal sesi untuk hari ini.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Daftar Siswa Section -->
        <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
            <div class="p-4 sm:p-6 border-b border-gray-700/50 bg-gray-900/30">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <div class="p-2 bg-green-500/10 rounded-lg">
                            <iconify-icon icon="mdi:account-group" width="20" height="20" class="text-green-400"></iconify-icon>
                        </div>
                        <h3 class="text-white font-semibold">Daftar Siswa</h3>
                    </div>
                    <span class="bg-blue-500/20 text-blue-400 text-xs px-3 py-1.5 rounded-full font-medium">
                        {{ $item->siswas->count() }} Siswa
                    </span>
                </div>
            </div>

            <!-- Desktop Table View (hidden on mobile) -->
            <div class="hidden md:block">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-900/50 text-gray-400 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-bold">Nama Siswa</th>
                                <th class="px-6 py-4 font-bold">Jenis Kelamin</th>
                                <th class="px-6 py-4 font-bold">No HP</th>
                                <th class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700/50">
                            @forelse($item->siswas as $siswa)
                            <tr class="hover:bg-gray-700/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-1 h-8 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        @if($siswa->foto)
                                            <img src="{{ asset('storage/' . $siswa->foto) }}" class="w-8 h-8 rounded-full object-cover border border-gray-600">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs">
                                                {{ substr($siswa->nama_lengkap, 0, 1) }}
                                            </div>
                                        @endif
                                        <span class="text-white font-medium">{{ $siswa->nama_lengkap }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($siswa->jenis_kelamin == 'L')
                                        <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-xs">Laki-laki</span>
                                    @else
                                        <span class="bg-pink-500/20 text-pink-400 px-3 py-1 rounded-full text-xs">Perempuan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $siswa->no_hp ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Lulus -->
                                        <form method="POST" action="{{ route('kelas.lulus-karantina', [$item->id, $siswa->id]) }}">
                                            @csrf
                                            <button type="submit"
                                                    onclick="return confirm('Yakin siswa ini LULUS karantina?')"
                                                    class="bg-green-600/20 hover:bg-green-600/40 text-green-400 p-2 rounded-lg transition-all duration-300 group"
                                                    title="Lulus">
                                                <iconify-icon icon="mdi:check" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                            </button>
                                        </form>

                                        <!-- Tidak Lulus -->
                                        <form method="POST" action="{{ route('kelas.tidak-lulus-karantina', [$item->id, $siswa->id]) }}">
                                            @csrf
                                            <button type="submit"
                                                    onclick="return confirm('Yakin siswa ini TIDAK LULUS karantina?')"
                                                    class="bg-red-600/20 hover:bg-red-600/40 text-red-400 p-2 rounded-lg transition-all duration-300 group"
                                                    title="Tidak Lulus">
                                                <iconify-icon icon="mdi:close" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <iconify-icon icon="mdi:account-group" width="32" height="32" class="text-gray-600"></iconify-icon>
                                        <p class="text-gray-500">Belum ada siswa di kelas ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View (visible only on mobile) -->
            <div class="md:hidden p-4 space-y-3">
                @forelse($item->siswas as $siswa)
                <div class="bg-gray-700/30 rounded-xl p-4 border border-gray-700/50 hover:border-blue-500/30 transition-all">
                    <div class="flex items-start gap-3">
                        @if($siswa->foto)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" class="w-12 h-12 rounded-full object-cover border border-gray-600">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                                {{ substr($siswa->nama_lengkap, 0, 1) }}
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <h4 class="text-white font-medium">{{ $siswa->nama_lengkap }}</h4>
                            <div class="flex flex-wrap items-center gap-2 mt-1">
                                @if($siswa->jenis_kelamin == 'L')
                                    <span class="bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded-full text-xs">Laki-laki</span>
                                @else
                                    <span class="bg-pink-500/20 text-pink-400 px-2 py-0.5 rounded-full text-xs">Perempuan</span>
                                @endif
                                
                                @if($siswa->no_hp)
                                <span class="text-gray-400 text-xs flex items-center gap-1">
                                    <iconify-icon icon="mdi:phone" width="10" height="10"></iconify-icon>
                                    {{ $siswa->no_hp }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2 mt-3 pt-3 border-t border-gray-700/50">
                        <!-- Lulus -->
                        <form method="POST" action="{{ route('kelas.lulus-karantina', [$item->id, $siswa->id]) }}" class="flex-1">
                            @csrf
                            <button type="submit"
                                    onclick="return confirm('Yakin siswa ini LULUS karantina?')"
                                    class="w-full flex items-center justify-center gap-1 bg-green-600/20 hover:bg-green-600/40 text-green-400 px-3 py-2 rounded-lg transition-all text-xs">
                                <iconify-icon icon="mdi:check" width="14" height="14"></iconify-icon>
                                Lulus
                            </button>
                        </form>

                        <!-- Tidak Lulus -->
                        <form method="POST" action="{{ route('kelas.tidak-lulus-karantina', [$item->id, $siswa->id]) }}" class="flex-1">
                            @csrf
                            <button type="submit"
                                    onclick="return confirm('Yakin siswa ini TIDAK LULUS karantina?')"
                                    class="w-full flex items-center justify-center gap-1 bg-red-600/20 hover:bg-red-600/40 text-red-400 px-3 py-2 rounded-lg transition-all text-xs">
                                <iconify-icon icon="mdi:close" width="14" height="14"></iconify-icon>
                                Tidak Lulus
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <iconify-icon icon="mdi:account-group" width="32" height="32" class="mx-auto mb-2 text-gray-600"></iconify-icon>
                    <p>Belum ada siswa di kelas ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>

<!-- Modal Buat Kelas -->
<div id="kelasModal" class="fixed inset-0 bg-black/90 hidden items-start justify-center z-50 backdrop-blur-md overflow-y-auto py-10 px-4">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-lg rounded-2xl border border-gray-700/50 shadow-2xl transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500/10 rounded-lg">
                    <iconify-icon icon="mdi:medical-bag-plus" width="24" height="24" class="text-blue-400"></iconify-icon>
                </div>
                <h2 class="text-lg font-bold text-white">Buat Kelas Karantina</h2>
            </div>
            <button onclick="closeModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <!-- Modal Body -->
        <form method="POST" action="{{ route('kelas.store') }}" class="p-6">
            @csrf

            <div class="space-y-4">
                <!-- Lokasi & Nama Kelas -->
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-1">Lokasi</label>
                        <input type="text" name="lokasi" placeholder="Contoh: Gedung A, Ruang 101"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                               required>
                    </div>

                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-1">Nama Kelas</label>
                        <input type="text" name="nama_kelas" placeholder="Contoh: Karantina Angkatan 1"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                               required>
                    </div>
                </div>

                <!-- Periode -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-1">Bulan</label>
                        <input type="text" name="periode_bulan" placeholder="Contoh: Januari"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                               required>
                    </div>

                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-1">Tahun</label>
                        <input type="number" name="periode_tahun" placeholder="2024"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                               required>
                    </div>
                </div>

                <!-- Wali Kelas -->
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-1">Wali Kelas</label>
                    <select name="guru_id" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm" required>
                        <option value="">Pilih Wali Kelas</option>
                        @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Perusahaan -->
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-1">Perusahaan</label>
                    <select name="company_id" id="companySelect" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm" required>
                        <option value="">Pilih Perusahaan</option>
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pekerjaan -->
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-1">Pekerjaan</label>
                    <select name="job_id" id="jobSelect" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm" required>
                        <option value="">Pilih Pekerjaan</option>
                    </select>
                </div>

                <!-- Informasi Tambahan -->
                <div class="bg-blue-500/5 border border-blue-500/20 rounded-lg p-3 flex items-start gap-2">
                    <iconify-icon icon="mdi:information" width="16" height="16" class="text-blue-400 flex-shrink-0 mt-0.5"></iconify-icon>
                    <p class="text-gray-400 text-xs">
                        Kelas karantina akan digunakan untuk mencatat absensi siswa selama masa pelatihan.
                    </p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-700/50">
                <button type="button" onclick="closeModal()" 
                        class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                    Batal
                </button>
                <button type="submit" 
                        class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-blue-900/20">
                    <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                    Simpan Kelas
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

<style>
    /* Modal animation */
    .modal-show {
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #1f2937;
    }

    ::-webkit-scrollbar-thumb {
        background: #4b5563;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #6b7280;
    }

    /* Hide scrollbar for tabs */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    /* Animation */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slideDown {
        animation: slideDown 0.3s ease-out;
    }

    /* Tab styles */
    .tab-btn.active {
        color: #3b82f6;
        border-bottom-color: #3b82f6;
    }

    .tab-btn.active iconify-icon {
        color: #3b82f6;
    }

    .tab-btn:not(.active):hover {
        color: #e5e7eb;
    }

    /* Card hover effects */
    .bg-gradient-to-br {
        transition: all 0.3s ease;
    }

    .bg-gradient-to-br:hover {
        transform: translateY(-2px);
    }

</style>

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
// Toggle form sesi
function toggleSesiForm(id) {
    const form = document.getElementById(id);
    form.classList.toggle('hidden');
    form.classList.toggle('flex');
}

// Tab Logic
function openTab(evt, tabId) {
    // Hide all tab content
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(content => content.classList.add('hidden'));

    // Remove active class from all buttons
    const buttons = document.querySelectorAll('.tab-btn');
    buttons.forEach(btn => btn.classList.remove('active', 'border-blue-500', 'text-blue-500'));

    // Show current tab and activate button
    document.getElementById(tabId).classList.remove('hidden');
    evt.currentTarget.classList.add('active', 'border-blue-500', 'text-blue-500');
}

// Modal Logic
function openModal() {
    const modal = document.getElementById('kelasModal');
    const modalContent = modal.querySelector('.modal-show');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('kelasModal');
    const modalContent = modal.querySelector('.modal-show');
    
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }, 300);
}

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});

// Close modal when clicking outside
document.getElementById('kelasModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Dynamic job select based on company
document.getElementById('companySelect').addEventListener('change', function() {
    let companyId = this.value;

    fetch('/get-jobs/' + companyId)
        .then(res => res.json())
        .then(data => {
            let jobSelect = document.getElementById('jobSelect');
            jobSelect.innerHTML = '<option value="">Pilih Pekerjaan</option>';
            data.forEach(job => {
                jobSelect.innerHTML += `<option value="${job.id}">${job.jenis_pekerjaan}</option>`;
            });
        });
});
</script>

@endsection