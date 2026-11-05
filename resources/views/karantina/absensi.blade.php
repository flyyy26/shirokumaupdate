@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Flash Notification -->
    @if(session('success'))
    <div class="mb-4 bg-green-500/10 border-l-4 border-green-500 text-green-400 p-4 rounded-lg flex items-center gap-3 animate-slideDown">
        <iconify-icon icon="mdi:check-circle" width="20" height="20" class="text-green-500"></iconify-icon>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Header with Glassmorphism Effect -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <iconify-icon icon="mdi:clipboard-check" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Absensi Kelas</h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Catat kehadiran siswa</p>
                </div>
            </div>
            
            <div class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/20">
                <p class="text-xs text-blue-200">Tanggal Absensi</p>
                <p class="font-semibold">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Info Kelas Card -->
    <div class="mb-6 bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
        <div class="p-4 sm:p-6 border-b border-gray-700/50 bg-gray-900/30">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-blue-500/10 rounded-lg">
                        <iconify-icon icon="mdi:information" width="20" height="20" class="text-blue-400"></iconify-icon>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-white">Informasi Kelas</h2>
                </div>
                <span class="bg-blue-500/20 text-blue-400 text-xs px-3 py-1.5 rounded-full font-medium">
                    {{ $kelas->siswas->count() }} Siswa
                </span>
            </div>
        </div>
        
        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-gray-700/20 p-4 rounded-xl border border-gray-700/30">
                    <p class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                        <iconify-icon icon="mdi:medical-bag" width="12" height="12"></iconify-icon>
                        Kelas
                    </p>
                    <p class="text-white font-medium">{{ $kelas->nama_kelas }}</p>
                </div>
                
                <div class="bg-gray-700/20 p-4 rounded-xl border border-gray-700/30">
                    <p class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                        <iconify-icon icon="mdi:clock-outline" width="12" height="12"></iconify-icon>
                        Sesi
                    </p>
                    <p class="text-white font-medium">{{ $sesi->nama_sesi }}</p>
                    <p class="text-gray-500 text-xs mt-1">
                        {{ \Carbon\Carbon::parse($sesi->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->jam_selesai)->format('H:i') }}
                    </p>
                </div>
                
                <div class="bg-gray-700/20 p-4 rounded-xl border border-gray-700/30">
                    <p class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                        <iconify-icon icon="mdi:calendar" width="12" height="12"></iconify-icon>
                        Tanggal
                    </p>
                    <p class="text-white font-medium">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Absensi -->
    <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
        <div class="p-4 sm:p-6 border-b border-gray-700/50 bg-gray-900/30">
            <div class="flex items-center gap-2">
                <div class="p-2 bg-green-500/10 rounded-lg">
                    <iconify-icon icon="mdi:clipboard-list" width="20" height="20" class="text-green-400"></iconify-icon>
                </div>
                <h2 class="text-lg sm:text-xl font-bold text-white">Form Absensi Siswa</h2>
            </div>
        </div>

        <form method="POST" action="{{ route('kelas.absensi.store', [$kelas->id, $sesi->id]) }}" class="p-4 sm:p-6">
            @csrf
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">

            <!-- Legend Status -->
            <div class="flex flex-wrap gap-4 mb-6 p-3 bg-gray-700/20 rounded-xl">
                <span class="flex items-center gap-2 text-xs">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    <span class="text-gray-300">Hadir</span>
                </span>
                <span class="flex items-center gap-2 text-xs">
                    <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                    <span class="text-gray-300">Izin</span>
                </span>
                <span class="flex items-center gap-2 text-xs">
                    <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                    <span class="text-gray-300">Sakit</span>
                </span>
                <span class="flex items-center gap-2 text-xs">
                    <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                    <span class="text-gray-300">Alfa</span>
                </span>
            </div>

            <!-- Desktop Table View (hidden on mobile) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-900/50 text-gray-400 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-bold border-b border-gray-700/50">Nama Siswa</th>
                            <th class="px-6 py-4 font-bold text-center border-b border-gray-700/50">Hadir</th>
                            <th class="px-6 py-4 font-bold text-center border-b border-gray-700/50">Izin</th>
                            <th class="px-6 py-4 font-bold text-center border-b border-gray-700/50">Sakit</th>
                            <th class="px-6 py-4 font-bold text-center border-b border-gray-700/50">Alfa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @foreach($kelas->siswas as $siswa)
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
                            
                            @foreach(['hadir', 'izin', 'sakit', 'alfa'] as $st)
                            <td class="px-6 py-4 text-center">
                                <label class="relative inline-flex items-center cursor-pointer group">
                                    <input type="radio"
                                        name="status[{{ $siswa->id }}]"
                                        value="{{ $st }}"
                                        {{ isset($absensi[$siswa->id]) && $absensi[$siswa->id]->status == $st ? 'checked' : '' }}
                                        class="hidden peer"
                                        required>
                                    <div class="w-5 h-5 rounded-full border-2 
                                                {{ $st == 'hadir' ? 'border-green-500 peer-checked:bg-green-500 peer-checked:border-green-500' : '' }}
                                                {{ $st == 'izin' ? 'border-yellow-500 peer-checked:bg-yellow-500 peer-checked:border-yellow-500' : '' }}
                                                {{ $st == 'sakit' ? 'border-blue-500 peer-checked:bg-blue-500 peer-checked:border-blue-500' : '' }}
                                                {{ $st == 'alfa' ? 'border-red-500 peer-checked:bg-red-500 peer-checked:border-red-500' : '' }}
                                                bg-transparent transition-all duration-200 group-hover:scale-110
                                                peer-checked:border-0">
                                    </div>
                                    <span class="ml-2 text-xs text-gray-400 peer-checked:text-white hidden sm:inline">
                                        {{ ucfirst($st) }}
                                    </span>
                                </label>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View (visible only on mobile) -->
            <div class="md:hidden space-y-4">
                @foreach($kelas->siswas as $siswa)
                <div class="bg-gray-700/30 rounded-xl p-4 border border-gray-700/50 hover:border-blue-500/30 transition-all">
                    <!-- Header Siswa -->
                    <div class="flex items-center gap-3 mb-4">
                        @if($siswa->foto)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" class="w-12 h-12 rounded-full object-cover border border-gray-600">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                                {{ substr($siswa->nama_lengkap, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="text-white font-semibold">{{ $siswa->nama_lengkap }}</h3>
                            <p class="text-gray-400 text-xs">{{ $siswa->no_hp ?? 'No HP tidak tersedia' }}</p>
                        </div>
                    </div>

                    <!-- Status Options -->
                    <div class="grid grid-cols-4 gap-2">
                        <!-- Hadir -->
                        <label class="relative flex flex-col items-center cursor-pointer group">
                            <input type="radio"
                                name="status[{{ $siswa->id }}]"
                                value="hadir"
                                {{ isset($absensi[$siswa->id]) && $absensi[$siswa->id]->status == 'hadir' ? 'checked' : '' }}
                                class="hidden peer"
                                required>
                            <div class="w-10 h-10 rounded-full border-2 border-green-500 bg-transparent 
                                        peer-checked:bg-green-500 peer-checked:border-green-500 
                                        transition-all duration-200 group-hover:scale-110
                                        flex items-center justify-center">
                                <iconify-icon icon="mdi:check" width="20" height="20" 
                                            class="text-green-500 peer-checked:text-white"></iconify-icon>
                            </div>
                            <span class="text-xs mt-1 text-gray-400 peer-checked:text-green-400">Hadir</span>
                        </label>

                        <!-- Izin -->
                        <label class="relative flex flex-col items-center cursor-pointer group">
                            <input type="radio"
                                name="status[{{ $siswa->id }}]"
                                value="izin"
                                {{ isset($absensi[$siswa->id]) && $absensi[$siswa->id]->status == 'izin' ? 'checked' : '' }}
                                class="hidden peer"
                                required>
                            <div class="w-10 h-10 rounded-full border-2 border-yellow-500 bg-transparent 
                                        peer-checked:bg-yellow-500 peer-checked:border-yellow-500 
                                        transition-all duration-200 group-hover:scale-110
                                        flex items-center justify-center">
                                <iconify-icon icon="mdi:clock" width="20" height="20" 
                                            class="text-yellow-500 peer-checked:text-white"></iconify-icon>
                            </div>
                            <span class="text-xs mt-1 text-gray-400 peer-checked:text-yellow-400">Izin</span>
                        </label>

                        <!-- Sakit -->
                        <label class="relative flex flex-col items-center cursor-pointer group">
                            <input type="radio"
                                name="status[{{ $siswa->id }}]"
                                value="sakit"
                                {{ isset($absensi[$siswa->id]) && $absensi[$siswa->id]->status == 'sakit' ? 'checked' : '' }}
                                class="hidden peer"
                                required>
                            <div class="w-10 h-10 rounded-full border-2 border-blue-500 bg-transparent 
                                        peer-checked:bg-blue-500 peer-checked:border-blue-500 
                                        transition-all duration-200 group-hover:scale-110
                                        flex items-center justify-center">
                                <iconify-icon icon="mdi:medical-bag" width="20" height="20" 
                                            class="text-blue-500 peer-checked:text-white"></iconify-icon>
                            </div>
                            <span class="text-xs mt-1 text-gray-400 peer-checked:text-blue-400">Sakit</span>
                        </label>

                        <!-- Alfa -->
                        <label class="relative flex flex-col items-center cursor-pointer group">
                            <input type="radio"
                                name="status[{{ $siswa->id }}]"
                                value="alfa"
                                {{ isset($absensi[$siswa->id]) && $absensi[$siswa->id]->status == 'alfa' ? 'checked' : '' }}
                                class="hidden peer"
                                required>
                            <div class="w-10 h-10 rounded-full border-2 border-red-500 bg-transparent 
                                        peer-checked:bg-red-500 peer-checked:border-red-500 
                                        transition-all duration-200 group-hover:scale-110
                                        flex items-center justify-center">
                                <iconify-icon icon="mdi:close" width="20" height="20" 
                                            class="text-red-500 peer-checked:text-white"></iconify-icon>
                            </div>
                            <span class="text-xs mt-1 text-gray-400 peer-checked:text-red-400">Alfa</span>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Tombol Simpan -->
            <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-gray-700/50">
                <a href="/karantina" 
                   class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-xl transition-all duration-300 text-sm font-medium text-center">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg shadow-green-900/20">
                    <iconify-icon icon="mdi:content-save" width="18" height="18"></iconify-icon>
                    <span>Simpan Absensi</span>
                </button>
            </div>

            <!-- Informasi Tambahan -->
            <div class="mt-4 bg-blue-500/5 border border-blue-500/20 rounded-lg p-3 flex items-start gap-2">
                <iconify-icon icon="mdi:information" width="16" height="16" class="text-blue-400 flex-shrink-0 mt-0.5"></iconify-icon>
                <p class="text-gray-400 text-xs">
                    Pastikan memilih status untuk setiap siswa. Data absensi yang sudah disimpan dapat diubah melalui menu edit.
                </p>
            </div>
        </form>
    </div>

    <!-- Ringkasan Absensi (opsional) -->
    @if(isset($absensi) && count($absensi) > 0)
    <div class="mt-6 bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden">
        <div class="p-4 border-b border-gray-700/50 bg-gray-900/30">
            <h3 class="text-white font-semibold flex items-center gap-2">
                <iconify-icon icon="mdi:chart-pie" width="18" height="18" class="text-purple-400"></iconify-icon>
                Ringkasan Absensi Hari Ini
            </h3>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @php
                    $hadir = collect($absensi)->where('status', 'hadir')->count();
                    $izin = collect($absensi)->where('status', 'izin')->count();
                    $sakit = collect($absensi)->where('status', 'sakit')->count();
                    $alfa = collect($absensi)->where('status', 'alfa')->count();
                @endphp
                
                <div class="bg-green-500/10 p-3 rounded-lg text-center">
                    <span class="text-green-400 text-xl font-bold">{{ $hadir }}</span>
                    <p class="text-gray-400 text-xs">Hadir</p>
                </div>
                <div class="bg-yellow-500/10 p-3 rounded-lg text-center">
                    <span class="text-yellow-400 text-xl font-bold">{{ $izin }}</span>
                    <p class="text-gray-400 text-xs">Izin</p>
                </div>
                <div class="bg-blue-500/10 p-3 rounded-lg text-center">
                    <span class="text-blue-400 text-xl font-bold">{{ $sakit }}</span>
                    <p class="text-gray-400 text-xs">Sakit</p>
                </div>
                <div class="bg-red-500/10 p-3 rounded-lg text-center">
                    <span class="text-red-400 text-xl font-bold">{{ $alfa }}</span>
                    <p class="text-gray-400 text-xs">Alfa</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Scripts -->
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

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

    /* Radio button animations */
    .peer:checked ~ div {
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

    /* Hover effects */
    .group:hover .w-1 {
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-5px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Mobile card transitions */
    .md\:hidden .bg-gray-700\/30 {
        transition: all 0.3s ease;
    }

    .md\:hidden .bg-gray-700\/30:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.3);
    }

    /* Focus states */
    input:focus {
        outline: none;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .text-xs {
            font-size: 0.7rem;
        }
    }

    /* Gradient animation for header */
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

<script>
    // Optional: Auto-select based on previous data
    document.addEventListener('DOMContentLoaded', function() {
        // Add confirmation before leaving if form is dirty
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input[type="radio"]');
        let formDirty = false;
        
        inputs.forEach(input => {
            input.addEventListener('change', () => {
                formDirty = true;
            });
        });
        
        window.addEventListener('beforeunload', function(e) {
            if (formDirty) {
                e.preventDefault();
                e.returnValue = 'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
            }
        });
        
        form.addEventListener('submit', function() {
            formDirty = false;
        });
    });

    // Function to mark all as hadir (optional)
    function markAllHadir() {
        if (confirm('Tandai semua siswa sebagai HADIR?')) {
            document.querySelectorAll('input[type="radio"][value="hadir"]').forEach(radio => {
                radio.checked = true;
            });
        }
    }

    // Function to mark all as alfa (optional)
    function markAllAlfa() {
        if (confirm('Tandai semua siswa sebagai ALFA?')) {
            document.querySelectorAll('input[type="radio"][value="alfa"]').forEach(radio => {
                radio.checked = true;
            });
        }
    }
</script>
@endsection