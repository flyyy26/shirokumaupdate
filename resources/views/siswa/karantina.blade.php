@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded:0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex items-center space-x-3 sm:space-x-4">
            <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                <iconify-icon icon="mdi:medical-bag" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Informasi Karantina</h1>
                <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Detail kelas dan riwayat kehadiran Anda selama masa pelatihan</p>
            </div>
        </div>
    </div>

    @if(!$kelas)
        <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-0 md:rounded-2xl p-8 sm:p-12 text-center backdrop-blur-sm">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full"></div>
                <div class="relative bg-gray-800 w-20 h-20 sm:w-24 sm:h-24 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                    <iconify-icon icon="mdi:school-off" width="32" height="32" class="text-gray-600 sm:w-10 sm:h-10"></iconify-icon>
                </div>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-white mb-2">Belum Masuk Kelas Karantina</h3>
            <p class="text-gray-500 text-sm sm:text-base max-w-md mx-auto">
                Anda belum terdaftar di kelas karantina manapun saat ini. Silakan hubungi admin untuk informasi lebih lanjut.
            </p>
        </div>
    @else
        <!-- Grid Layout untuk Detail dan Statistik -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8 mb-6 sm:mb-8">
            <!-- Detail Kelas -->
            <div class="lg:col-span-2 bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-0 md:rounded-2xl p-5 sm:p-6 border border-gray-700/50 shadow-xl backdrop-blur-sm hover:border-blue-500/50 transition-all duration-300 group">
                <div class="flex items-center gap-2 mb-4 sm:mb-6">
                    <div class="p-2 bg-blue-500/10 rounded-lg">
                        <iconify-icon icon="mdi:information" width="20" height="20" class="text-blue-400 sm:w-5 sm:h-5"></iconify-icon>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-white">Detail Pelatihan</h2>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="space-y-3 sm:space-y-4">
                        <div class="bg-gray-700/20 p-3 sm:p-4 rounded-xl border border-gray-700/30">
                            <span class="text-gray-500 text-xs uppercase font-semibold tracking-wider flex items-center gap-1 mb-1">
                                <iconify-icon icon="mdi:tag" width="12" height="12"></iconify-icon>
                                Nama Kelas
                            </span>
                            <p class="text-white font-semibold text-base sm:text-lg break-words">{{ $kelas->nama_kelas }}</p>
                        </div>
                        
                        <div class="bg-gray-700/20 p-3 sm:p-4 rounded-xl border border-gray-700/30">
                            <span class="text-gray-500 text-xs uppercase font-semibold tracking-wider flex items-center gap-1 mb-1">
                                <iconify-icon icon="mdi:map-marker" width="12" height="12"></iconify-icon>
                                Lokasi
                            </span>
                            <p class="text-white text-sm sm:text-base break-words">{{ $kelas->lokasi }}</p>
                        </div>
                        
                        <div class="bg-gray-700/20 p-3 sm:p-4 rounded-xl border border-gray-700/30">
                            <span class="text-gray-500 text-xs uppercase font-semibold tracking-wider flex items-center gap-1 mb-1">
                                <iconify-icon icon="mdi:calendar" width="12" height="12"></iconify-icon>
                                Periode
                            </span>
                            <p class="text-white text-sm sm:text-base">{{ $kelas->periode_bulan }} {{ $kelas->periode_tahun }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 sm:space-y-4">
                        <div class="bg-gray-700/20 p-3 sm:p-4 rounded-xl border border-gray-700/30">
                            <span class="text-gray-500 text-xs uppercase font-semibold tracking-wider flex items-center gap-1 mb-1">
                                <iconify-icon icon="mdi:teach" width="12" height="12"></iconify-icon>
                                Guru / Wali Kelas
                            </span>
                            <p class="text-white text-sm sm:text-base break-words">{{ $kelas->guru->nama_lengkap ?? '-' }}</p>
                        </div>
                        
                        <div class="bg-gray-700/20 p-3 sm:p-4 rounded-xl border border-gray-700/30">
                            <span class="text-gray-500 text-xs uppercase font-semibold tracking-wider flex items-center gap-1 mb-1">
                                <iconify-icon icon="mdi:office-building" width="12" height="12"></iconify-icon>
                                Perusahaan
                            </span>
                            <p class="text-white text-sm sm:text-base break-words">{{ $kelas->company->nama_perusahaan ?? '-' }}</p>
                        </div>
                        
                        <div class="bg-gray-700/20 p-3 sm:p-4 rounded-xl border border-gray-700/30">
                            <span class="text-gray-500 text-xs uppercase font-semibold tracking-wider flex items-center gap-1 mb-1">
                                <iconify-icon icon="mdi:briefcase" width="12" height="12"></iconify-icon>
                                Pekerjaan
                            </span>
                            <p class="text-blue-400 font-medium text-sm sm:text-base break-words">{{ $kelas->job->jenis_pekerjaan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 p-4 bg-blue-500/5 border border-blue-500/20 rounded-xl">
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-blue-500/10 rounded-lg flex-shrink-0">
                            <iconify-icon icon="mdi:lightbulb" width="18" height="18" class="text-blue-400"></iconify-icon>
                        </div>
                        <div>
                            <h4 class="text-white text-sm font-semibold mb-1">Tips Kehadiran</h4>
                            <p class="text-gray-400 text-xs sm:text-sm">
                                Kehadiran 100% sangat penting untuk kelulusan karantina. Pastikan Anda hadir tepat waktu setiap sesi.
                                Jika berhalangan, segera ajukan izin melalui form yang tersedia.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Kehadiran dengan Statistik Card -->
            <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-0 md:rounded-2xl p-5 sm:p-6 border border-gray-700/50 shadow-xl backdrop-blur-sm hover:border-green-500/50 transition-all duration-300">
                <div class="flex items-center gap-2 mb-4 sm:mb-6">
                    <div class="p-2 bg-green-500/10 rounded-lg">
                        <iconify-icon icon="mdi:chart-pie" width="20" height="20" class="text-green-400 sm:w-5 sm:h-5"></iconify-icon>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-white">Statistik Kehadiran</h2>
                </div>
                
                @php
                    $allAbsensi = $absensis->flatten();
                    $hadir = $allAbsensi->where('status', 'hadir')->count();
                    $izin = $allAbsensi->where('status', 'izin')->count();
                    $sakit = $allAbsensi->where('status', 'sakit')->count();
                    $alfa = $allAbsensi->where('status', 'alfa')->count();
                    $total = $hadir + $izin + $sakit + $alfa;
                    $persentaseHadir = $total > 0 ? round(($hadir / $total) * 100) : 0;
                @endphp

                <!-- Circular Progress untuk Kehadiran -->
                <div class="flex justify-center mb-6">
                    <div class="relative w-28 h-28 sm:w-32 sm:h-32">
                        <svg class="w-full h-full" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="16" fill="none" stroke="#374151" stroke-width="2"></circle>
                            <circle cx="18" cy="18" r="16" fill="none" stroke="#10b981" stroke-width="2" 
                                    stroke-dasharray="100" stroke-dashoffset="{{ 100 - $persentaseHadir }}" 
                                    stroke-linecap="round" transform="rotate(-90 18 18)"
                                    class="transition-all duration-1000 ease-out"></circle>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-2xl sm:text-3xl font-bold text-white">{{ $persentaseHadir }}%</span>
                            <span class="text-xs text-gray-500">Kehadiran</span>
                        </div>
                    </div>
                </div>

                <!-- Statistik Cards -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gradient-to-br from-green-500/10 to-green-600/5 rounded-xl p-3 border border-green-500/20">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span class="text-xs text-gray-400">Hadir</span>
                        </div>
                        <p class="text-xl sm:text-2xl font-bold text-white">{{ $hadir }}</p>
                        <span class="text-xs text-gray-500">{{ $total > 0 ? round(($hadir/$total)*100) : 0 }}%</span>
                    </div>
                    
                    <div class="bg-gradient-to-br from-yellow-500/10 to-yellow-600/5 rounded-xl p-3 border border-yellow-500/20">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                            <span class="text-xs text-gray-400">Izin</span>
                        </div>
                        <p class="text-xl sm:text-2xl font-bold text-white">{{ $izin }}</p>
                        <span class="text-xs text-gray-500">{{ $total > 0 ? round(($izin/$total)*100) : 0 }}%</span>
                    </div>
                    
                    <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/5 rounded-xl p-3 border border-blue-500/20">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <span class="text-xs text-gray-400">Sakit</span>
                        </div>
                        <p class="text-xl sm:text-2xl font-bold text-white">{{ $sakit }}</p>
                        <span class="text-xs text-gray-500">{{ $total > 0 ? round(($sakit/$total)*100) : 0 }}%</span>
                    </div>
                    
                    <div class="bg-gradient-to-br from-red-500/10 to-red-600/5 rounded-xl p-3 border border-red-500/20">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                            <span class="text-xs text-gray-400">Alfa</span>
                        </div>
                        <p class="text-xl sm:text-2xl font-bold text-white">{{ $alfa }}</p>
                        <span class="text-xs text-gray-500">{{ $total > 0 ? round(($alfa/$total)*100) : 0 }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Absensi dengan Desain Modern -->
        <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-0 md:rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
            <div class="p-4 sm:p-6 border-b border-gray-700/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-purple-500/10 rounded-lg">
                        <iconify-icon icon="mdi:calendar-check" width="20" height="20" class="text-purple-400"></iconify-icon>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-white">Riwayat Absensi Harian</h2>
                </div>
                
                <!-- Legend - Tetap sama -->
                <div class="flex flex-wrap gap-2 sm:gap-3 text-xs">
                    <span class="flex items-center gap-1">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        <span class="text-gray-400">Hadir</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                        <span class="text-gray-400">Izin</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                        <span class="text-gray-400">Sakit</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        <span class="text-gray-400">Alfa</span>
                    </span>
                </div>
            </div>
            
            <!-- Desktop View - Table (hidden on mobile) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[800px] lg:min-w-full">
                    <thead>
                        <tr class="bg-gray-900/50 text-gray-400 text-xs uppercase tracking-wider">
                            <th class="px-4 sm:px-6 py-4 font-bold border-b border-gray-700/50 sticky left-0 bg-gray-900/50">
                                <div class="flex items-center gap-2">
                                    <iconify-icon icon="mdi:calendar" width="14" height="14"></iconify-icon>
                                    Tanggal
                                </div>
                            </th>
                            @foreach($kelas->sesi as $sesi)
                                <th class="px-4 sm:px-6 py-4 font-bold border-b border-gray-700/50 text-center">
                                    {{ $sesi->nama_sesi }}
                                    <div class="flex items-center justify-center gap-1 mt-1 text-[10px] font-normal text-gray-500">
                                        <iconify-icon icon="mdi:clock-outline" width="10" height="10"></iconify-icon>
                                        <span>{{ \Carbon\Carbon::parse($sesi->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->jam_selesai)->format('H:i') }}</span>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @forelse($absensis as $tanggal => $items)
                            <tr class="hover:bg-gray-700/30 transition-colors group">
                                <td class="px-4 sm:px-6 py-4 text-white font-medium whitespace-nowrap sticky left-0 bg-gray-800 group-hover:bg-gray-700/30 transition-colors">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1 h-8 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        <span>{{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('d F Y') }}</span>
                                    </div>
                                </td>
                                @foreach($kelas->sesi as $sesi)
                                    @php
                                        $record = $items->firstWhere('kelas_sesi_id', $sesi->id);
                                        $status = $record->status ?? null;
                                    @endphp
                                    <td class="px-4 sm:px-6 py-4 text-center">
                                        @if($status === 'hadir')
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20">
                                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                                Hadir
                                            </div>
                                        @elseif($status === 'izin')
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                                                <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>
                                                Izin
                                            </div>
                                        @elseif($status === 'sakit')
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-500 border border-blue-500/20">
                                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                                Sakit
                                            </div>
                                        @elseif($status === 'alfa')
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-red-500/10 text-red-500 border border-red-500/20">
                                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                                Alfa
                                            </div>
                                        @else
                                            <span class="text-gray-600 text-sm">—</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $kelas->sesi->count() + 1 }}" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <iconify-icon icon="mdi:calendar-blank" width="40" height="40" class="text-gray-600"></iconify-icon>
                                        <p class="text-gray-500 text-sm">Belum ada data absensi yang tercatat</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile View - Card List (visible only on mobile) -->
            <div class="md:hidden divide-y divide-gray-700/50">
                @forelse($absensis as $tanggal => $items)
                    <div class="p-4 hover:bg-gray-700/30 transition-colors">
                        <!-- Tanggal -->
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-1 h-6 bg-blue-500 rounded-full"></div>
                            <span class="text-white font-medium text-sm">{{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('d F Y') }}</span>
                        </div>
                        
                        <!-- List Sesi -->
                        <div class="grid grid-cols-1 gap-2 pl-3">
                            @foreach($kelas->sesi as $sesi)
                                @php
                                    $record = $items->firstWhere('kelas_sesi_id', $sesi->id);
                                    $status = $record->status ?? null;
                                @endphp
                                <div class="flex items-center justify-between py-2 border-b border-gray-700/30 last:border-0">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <iconify-icon icon="mdi:clock-outline" width="14" height="14" class="text-gray-500"></iconify-icon>
                                            <span class="text-gray-300 text-sm font-medium">{{ $sesi->nama_sesi }}</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-0.5 ml-6">
                                            {{ \Carbon\Carbon::parse($sesi->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->jam_selesai)->format('H:i') }}
                                        </div>
                                    </div>
                                    <div class="ml-2">
                                        @if($status === 'hadir')
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20">
                                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                                Hadir
                                            </div>
                                        @elseif($status === 'izin')
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                                                <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>
                                                Izin
                                            </div>
                                        @elseif($status === 'sakit')
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-500 border border-blue-500/20">
                                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                                Sakit
                                            </div>
                                        @elseif($status === 'alfa')
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-red-500/10 text-red-500 border border-red-500/20">
                                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                                Alfa
                                            </div>
                                        @else
                                            <span class="text-gray-600 text-xs bg-gray-800/50 px-3 py-1.5 rounded-full border border-gray-700">—</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <iconify-icon icon="mdi:calendar-blank" width="40" height="40" class="text-gray-600"></iconify-icon>
                            <p class="text-gray-500 text-sm">Belum ada data absensi yang tercatat</p>
                        </div>
                    </div>
                @endforelse
            </div>
            
            @if($absensis->isNotEmpty())
            <div class="p-4 sm:p-6 border-t border-gray-700/50 bg-gray-900/30">
                <div class="flex flex-wrap items-center justify-between gap-4 text-xs sm:text-sm">
                    <div class="flex items-center gap-2 text-gray-400">
                        <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
                        <span>Total {{ $absensis->count() }} hari tercatat</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            <span class="text-gray-400">Hadir: {{ $hadir }}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                            <span class="text-gray-400">Izin: {{ $izin }}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                            <span class="text-gray-400">Sakit: {{ $sakit }}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            <span class="text-gray-400">Alfa: {{ $alfa }}</span>
                        </span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    @endif
</div>

<style>
    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .group:hover .absolute {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 0.5;
        }
        50% {
            opacity: 1;
        }
    }
    
    /* Progress circle animation */
    circle {
        transition: stroke-dashoffset 1s ease-in-out;
    }
    
    /* Table sticky column */
    .sticky {
        z-index: 10;
    }
    
    /* Responsive table */
    @media (max-width: 1023px) {
        .min-w-\[800px\] {
            min-width: 800px;
        }
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
    
    /* Hover effects */
    .hover\:border-blue-500\/50:hover {
        border-color: rgba(59, 130, 246, 0.5);
        box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2);
    }
    
    /* Card hover animations */
    .bg-gradient-to-br {
        transition: all 0.3s ease;
    }
    
    .bg-gradient-to-br:hover {
        transform: translateY(-2px);
    }
    
    /* Progress circle styling */
    circle {
        transition: stroke-dashoffset 1s ease-in-out;
    }
    
    /* Table row hover effect */
    tbody tr {
        transition: background-color 0.2s ease;
    }
    
    /* Status badge animations */
    .inline-flex {
        transition: all 0.2s ease;
    }
    
    .inline-flex:hover {
        transform: scale(1.05);
    }
    
    /* Gradient animation */
    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }
    
    .bg-gradient-to-br {
        background-size: 200% 200%;
        animation: gradient 15s ease infinite;
    }
</style>
@endsection