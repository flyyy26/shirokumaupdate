@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header with Glassmorphism Effect -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex items-center space-x-3 sm:space-x-4">
            <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                <iconify-icon icon="mdi:file-document" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Rekap Absensi</h1>
                <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Lihat rekap absensi siswa berdasarkan kelas dan periode</p>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
        <div class="p-4 sm:p-6 border-b border-gray-700/50 bg-gray-900/30">
            <h2 class="text-lg sm:text-xl font-bold text-white flex items-center gap-2">
                <iconify-icon icon="mdi:filter" width="20" height="20" class="text-blue-400"></iconify-icon>
                Filter Data Absensi
            </h2>
        </div>
        
        <form method="GET" class="p-4 sm:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Pilih Kelas -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:medical-bag" width="14" height="14"></iconify-icon>
                        Pilih Kelas
                    </label>
                    <div class="relative">
                        <select name="kelas_id" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white appearance-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        <iconify-icon icon="mdi:chevron-down" width="18" height="18" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></iconify-icon>
                    </div>
                </div>

                <!-- Filter Tanggal -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:calendar" width="14" height="14"></iconify-icon>
                        Filter Tanggal
                    </label>
                    <div class="relative">
                        <input type="text" 
                            id="tanggalPicker"
                            name="tanggal"
                            value="{{ $tanggal }}"
                            placeholder="Pilih tanggal"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg pl-4 pr-10 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                        <iconify-icon icon="mdi:calendar" width="18" height="18" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></iconify-icon>
                    </div>
                </div>

                <!-- Filter Perbulan -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:calendar-month" width="14" height="14"></iconify-icon>
                        Filter Perbulan
                    </label>
                    <div class="relative">
                        <input type="month" 
                            name="bulan" 
                            id="bulanPicker"
                            value="{{ $bulan }}"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg pl-4 pr-10 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm [color-scheme:dark]">
                        <iconify-icon icon="mdi:calendar-month" width="18" height="18" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></iconify-icon>
                    </div>
                </div>

                <!-- Tombol Filter -->
                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-lg font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg shadow-blue-900/20">
                        <iconify-icon icon="mdi:filter" width="18" height="18"></iconify-icon>
                        <span class="text-xs">Terapkan Filter</span>
                    </button>
                </div>
            </div>

            <!-- Informasi Filter Aktif -->
            @if($kelasId || $tanggal || $bulan)
            <div class="mt-4 flex flex-wrap items-center gap-2 text-xs bg-blue-500/10 border border-blue-500/20 rounded-lg p-3">
                <iconify-icon icon="mdi:information" width="16" height="16" class="text-blue-400"></iconify-icon>
                <span class="text-gray-300">Filter aktif:</span>
                @if($kelasId)
                    @php $selectedKelas = $kelasList->firstWhere('id', $kelasId); @endphp
                    <span class="bg-blue-500/20 text-blue-400 px-2 py-1 rounded-full flex items-center gap-1">
                        <iconify-icon icon="mdi:medical-bag" width="12" height="12"></iconify-icon>
                        {{ $selectedKelas->nama_kelas ?? 'Kelas' }}
                    </span>
                @endif
                @if($tanggal)
                    <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full flex items-center gap-1">
                        <iconify-icon icon="mdi:calendar" width="12" height="12"></iconify-icon>
                        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                    </span>
                @endif
                @if($bulan)
                    <span class="bg-purple-500/20 text-purple-400 px-2 py-1 rounded-full flex items-center gap-1">
                        <iconify-icon icon="mdi:calendar-month" width="12" height="12"></iconify-icon>
                        {{ \Carbon\Carbon::parse($bulan . '-01')->translatedFormat('F Y') }}
                    </span>
                @endif
                <a href="{{ route('rekap.absensi') }}" class="text-red-400 hover:text-red-300 ml-auto flex items-center gap-1">
                    <iconify-icon icon="mdi:close" width="14" height="14"></iconify-icon>
                    <span>Hapus filter</span>
                </a>
            </div>
            @endif
        </form>
    </div>

    <!-- Hasil Rekap Absensi -->
    <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
        <div class="p-4 sm:p-6 border-b border-gray-700/50 bg-gray-900/30">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-green-500/10 rounded-lg">
                        <iconify-icon icon="mdi:format-list-bulleted" width="20" height="20" class="text-green-400"></iconify-icon>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-white">Data Absensi</h2>
                </div>
                
                <!-- Statistik Ringkas -->
                <div class="flex flex-wrap gap-2">
                    <span class="bg-green-500/20 text-green-400 px-3 py-1.5 rounded-lg text-xs flex items-center gap-1">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        Hadir: {{ $absensis->where('status', 'hadir')->count() }}
                    </span>
                    <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1.5 rounded-lg text-xs flex items-center gap-1">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                        Izin: {{ $absensis->where('status', 'izin')->count() }}
                    </span>
                    <span class="bg-red-500/20 text-red-400 px-3 py-1.5 rounded-lg text-xs flex items-center gap-1">
                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        Alpa: {{ $absensis->where('status', 'alfa')->count() }}
                    </span>
                    <span class="bg-blue-500/20 text-blue-400 px-3 py-1.5 rounded-lg text-xs flex items-center gap-1">
                        <iconify-icon icon="mdi:counter" width="12" height="12"></iconify-icon>
                        Total: {{ $absensis->count() }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Desktop Table View (hidden on mobile) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 text-gray-400 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Tanggal</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Nama Siswa</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Kelas</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Sesi</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($absensis as $absen)
                    <tr class="hover:bg-gray-700/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-1 h-8 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <div>
                                    <div class="text-white font-medium">{{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d F Y') }}</div>
                                    <div class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($absen->tanggal)->format('l') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($absen->siswa->foto)
                                    <img src="{{ asset('storage/' . $absen->siswa->foto) }}" class="w-8 h-8 rounded-full object-cover border border-gray-600">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs">
                                        {{ substr($absen->siswa->nama_lengkap, 0, 1) }}
                                    </div>
                                @endif
                                <span class="text-white">{{ $absen->siswa->nama_lengkap }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-purple-500/20 text-purple-400 px-3 py-1 rounded-full text-xs">
                                {{ $absen->sesi->kelas->nama_kelas ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-300">{{ $absen->sesi->nama_sesi }}</span>
                            <div class="text-gray-500 text-xs">
                                {{ \Carbon\Carbon::parse($absen->sesi->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($absen->sesi->jam_selesai)->format('H:i') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($absen->status == 'hadir')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    Hadir
                                </span>
                            @elseif($absen->status == 'izin')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>
                                    Izin
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-red-500/10 text-red-500 border border-red-500/20">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                    Alpa
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="bg-gray-700/30 p-4 rounded-full">
                                    <iconify-icon icon="mdi:calendar-blank" width="40" height="40" class="text-gray-600"></iconify-icon>
                                </div>
                                <p class="text-gray-500 text-sm">Tidak ada data absensi</p>
                                <p class="text-gray-600 text-xs">Silakan pilih filter lain atau atur jadwal absensi terlebih dahulu</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View (visible only on mobile) -->
        <div class="md:hidden p-4 space-y-3">
            @forelse($absensis as $absen)
            <div class="bg-gray-700/30 rounded-xl p-4 border border-gray-700/50 hover:border-blue-500/30 transition-all">
                <!-- Header Card -->
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-blue-500/10 rounded-lg">
                            <iconify-icon icon="mdi:calendar" width="14" height="14" class="text-blue-400"></iconify-icon>
                        </div>
                        <div>
                            <p class="text-white font-medium text-sm">{{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d F Y') }}</p>
                            <p class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($absen->tanggal)->format('l') }}</p>
                        </div>
                    </div>
                    
                    @if($absen->status == 'hadir')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                            Hadir
                        </span>
                    @elseif($absen->status == 'izin')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                            <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>
                            Izin
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-red-500/10 text-red-500 border border-red-500/20">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                            Alpa
                        </span>
                    @endif
                </div>

                <!-- Siswa Info -->
                <div class="flex items-center gap-3 mb-3">
                    @if($absen->siswa->foto)
                        <img src="{{ asset('storage/' . $absen->siswa->foto) }}" class="w-10 h-10 rounded-full object-cover border border-gray-600">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                            {{ substr($absen->siswa->nama_lengkap, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <p class="text-white font-medium">{{ $absen->siswa->nama_lengkap }}</p>
                        <p class="text-gray-400 text-xs">{{ $absen->siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                </div>

                <!-- Kelas & Sesi Info -->
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div class="bg-gray-800/50 p-2 rounded-lg">
                        <p class="text-gray-400 mb-1 flex items-center gap-1">
                            <iconify-icon icon="mdi:medical-bag" width="10" height="10"></iconify-icon>
                            Kelas
                        </p>
                        <p class="text-white">{{ $absen->sesi->kelas->nama_kelas ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-800/50 p-2 rounded-lg">
                        <p class="text-gray-400 mb-1 flex items-center gap-1">
                            <iconify-icon icon="mdi:clock-outline" width="10" height="10"></iconify-icon>
                            Sesi
                        </p>
                        <p class="text-white">{{ $absen->sesi->nama_sesi }}</p>
                        <p class="text-gray-500 text-[10px] mt-1">
                            {{ \Carbon\Carbon::parse($absen->sesi->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($absen->sesi->jam_selesai)->format('H:i') }}
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-gray-700/30 rounded-xl p-8 text-center">
                <div class="relative inline-block">
                    <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full"></div>
                    <div class="relative bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                        <iconify-icon icon="mdi:calendar-blank" width="32" height="32" class="text-gray-600"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-white font-semibold mb-1">Tidak Ada Data</h3>
                <p class="text-gray-500 text-sm">Belum ada data absensi untuk filter yang dipilih.</p>
            </div>
            @endforelse

            <!-- Ringkasan Mobile -->
            @if($absensis->count() > 0)
            <div class="mt-4 pt-4 border-t border-gray-700/50">
                <div class="flex flex-wrap justify-between gap-2 text-xs">
                    <span class="bg-green-500/20 text-green-400 px-3 py-2 rounded-lg flex items-center gap-1">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        Hadir: {{ $absensis->where('status', 'hadir')->count() }}
                    </span>
                    <span class="bg-yellow-500/20 text-yellow-400 px-3 py-2 rounded-lg flex items-center gap-1">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                        Izin: {{ $absensis->where('status', 'izin')->count() }}
                    </span>
                    <span class="bg-red-500/20 text-red-400 px-3 py-2 rounded-lg flex items-center gap-1">
                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        Alpa: {{ $absensis->where('status', 'alfa')->count() }}
                    </span>
                    <span class="bg-blue-500/20 text-blue-400 px-3 py-2 rounded-lg flex items-center gap-1">
                        <iconify-icon icon="mdi:counter" width="12" height="12"></iconify-icon>
                        Total: {{ $absensis->count() }}
                    </span>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Export Button (optional) -->
    <div class="mt-6 flex justify-end">
        <button onclick="exportData()" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-2.5 rounded-xl font-semibold flex items-center gap-2 transition-all duration-300 shadow-lg shadow-green-900/20">
            <iconify-icon icon="mdi:download" width="18" height="18"></iconify-icon>
            <span>Export Data</span>
        </button>
    </div>
</div>

<!-- Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/monthSelect.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/monthSelect.css">

<style>
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

    /* Card hover effects */
    .bg-gradient-to-br {
        transition: all 0.3s ease;
    }

    .bg-gradient-to-br:hover {
        transform: translateY(-2px);
    }

    /* Focus states */
    input:focus, select:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
    }

    /* Flatpickr custom theme */
    .flatpickr-calendar {
        background: #1f2937 !important;
        border: 1px solid #374151 !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
    }

    .flatpickr-months {
        background: #111827 !important;
        border-bottom: 1px solid #374151 !important;
    }

    .flatpickr-weekday {
        color: #9ca3af !important;
    }

    .flatpickr-day {
        color: #e5e7eb !important;
    }

    .flatpickr-day.selected {
        background: #3b82f6 !important;
        border-color: #2563eb !important;
    }

    .flatpickr-day.today {
        border-color: #60a5fa !important;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .text-xs {
            font-size: 0.7rem;
        }
    }

    /* Export button hover */
    .bg-gradient-to-r {
        background-size: 200% 200%;
        animation: gradientShift 5s ease infinite;
    }

    @keyframes gradientShift {
        0%, 100% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
    }
</style>

<style>
/* Flatpickr Month Select Plugin - Dark Theme */
.flatpickr-calendar {
    background-color: #1f2937 !important;
    border: 1px solid #4b5563 !important;
    border-radius: 0.5rem !important;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
}

.flatpickr-months {
    background-color: #374151 !important;
    border-radius: 0.5rem 0.5rem 0 0 !important;
    color: white !important;
}

.flatpickr-month {
    color: white !important;
    fill: white !important;
}

.flatpickr-current-month {
    color: white !important;
}

.flatpickr-current-month .cur-month {
    color: white !important;
}

.flatpickr-current-month input.cur-year {
    color: white !important;
    background-color: transparent !important;
}

.flatpickr-weekday {
    color: #9ca3af !important;
    background-color: #1f2937 !important;
}

/* Month Selector Specific */
.flatpickr-monthSelect-months {
    background-color: #1f2937 !important;
    padding: 10px !important;
    gap: 8px !important;
}

.flatpickr-monthSelect-month {
    background-color: #374151 !important;
    color: #e5e7eb !important;
    border: 1px solid #4b5563 !important;
    border-radius: 0.375rem !important;
    padding: 8px !important;
    font-size: 14px !important;
    transition: all 0.2s ease !important;
}

.flatpickr-monthSelect-month:hover {
    background-color: #3b82f6 !important;
    color: white !important;
    border-color: #3b82f6 !important;
}

.flatpickr-monthSelect-month.selected {
    background-color: #3b82f6 !important;
    color: white !important;
    border-color: #3b82f6 !important;
    font-weight: 500 !important;
}

.flatpickr-monthSelect-month.today {
    border-color: #3b82f6 !important;
    background-color: #374151 !important;
}

/* Navigation Arrows */
.flatpickr-prev-month,
.flatpickr-next-month {
    color: #9ca3af !important;
    fill: #9ca3af !important;
}

.flatpickr-prev-month:hover,
.flatpickr-next-month:hover {
    color: white !important;
    fill: white !important;
}

/* Time Picker (if any) */
.flatpickr-time {
    background-color: #1f2937 !important;
    border-top: 1px solid #4b5563 !important;
}

.flatpickr-time input {
    color: white !important;
    background-color: #374151 !important;
}

.flatpickr-time .flatpickr-am-pm {
    color: white !important;
    background-color: #374151 !important;
}

.flatpickr-time .flatpickr-am-pm:hover {
    background-color: #3b82f6 !important;
}

/* Dropdown Arrows */
.flatpickr-calendar.arrowTop:before,
.flatpickr-calendar.arrowTop:after {
    border-bottom-color: #1f2937 !important;
}

.flatpickr-calendar.arrowBottom:before,
.flatpickr-calendar.arrowBottom:after {
    border-top-color: #1f2937 !important;
}

/* Year Input */
.numInputWrapper span {
    border-color: #4b5563 !important;
}

.numInputWrapper span:hover {
    background-color: #4b5563 !important;
}

.numInputWrapper span.arrowUp,
.numInputWrapper span.arrowDown {
    color: #9ca3af !important;
}

.numInputWrapper span.arrowUp:hover,
.numInputWrapper span.arrowDown:hover {
    color: white !important;
}
</style>

<script>
    // Initialize Flatpickr for date picker
    flatpickr("#tanggalPicker", {
        dateFormat: "Y-m-d",
        locale: "id",
        theme: "dark",
        onChange: function(selectedDates, dateStr) {
            if(dateStr){
                document.getElementById('bulanPicker').value = '';
            }
        }
    });

    // Initialize Flatpickr for month picker
    flatpickr("#bulanPicker", {
        plugins: [
            new monthSelectPlugin({
                shorthand: true,
                dateFormat: "Y-m",
                altFormat: "F Y",
                theme: "dark"
            })
        ],
        locale: "id",
        theme: "dark", // Flatpickr global theme
        allowInput: true,
        disableMobile: true,
        onChange: function(selectedDates, dateStr) {
            if(dateStr){
                document.getElementById('tanggalPicker').value = '';
            }
        }
    });
    

    // Export function (placeholder)
    function exportData() {
        alert('Fitur export akan segera tersedia!');
    }

    // Auto-submit filter when kelas changes (optional)
    document.querySelector('select[name="kelas_id"]')?.addEventListener('change', function() {
        this.form.submit();
    });
</script>
@endsection