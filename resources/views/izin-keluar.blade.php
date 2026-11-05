@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header with Glassmorphism Effect -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex items-center space-x-3 sm:space-x-4">
            <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                <iconify-icon icon="mdi:exit-to-app" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Data Izin Keluar Siswa</h1>
                <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Monitor dan kelola izin keluar siswa</p>
            </div>
        </div>
    </div>

    <!-- Flash Notification -->
    @if(session('success'))
    <div class="mb-4 bg-green-500/10 border-l-4 border-green-500 text-green-400 p-4 rounded-lg flex items-center gap-3 animate-slideDown">
        <iconify-icon icon="mdi:check-circle" width="20" height="20" class="text-green-500"></iconify-icon>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 bg-red-500/10 border-l-4 border-red-500 text-red-400 p-4 rounded-lg flex items-center gap-3 animate-slideDown">
        <iconify-icon icon="mdi:alert-circle" width="20" height="20" class="text-red-500"></iconify-icon>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Desktop Table View (hidden on mobile) -->
    <div class="hidden md:block bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
        <div class="p-4 sm:p-6 border-b border-gray-700/50">
            <h2 class="text-lg sm:text-xl font-bold text-white flex items-center gap-2">
                <iconify-icon icon="mdi:format-list-bulleted" width="20" height="20" class="text-blue-400"></iconify-icon>
                Daftar Izin Keluar
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 text-gray-400 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Nama Siswa</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Tanggal Keluar</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Tanggal Kembali</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Alamat Tujuan</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($izin as $item)
                    <tr class="hover:bg-gray-700/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-8 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                @if($item->siswa->foto)
                                    <img src="{{ asset('storage/' . $item->siswa->foto) }}" 
                                         class="w-8 h-8 rounded-full object-cover border border-gray-600">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs">
                                        {{ substr($item->siswa->nama_lengkap, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-white font-medium">{{ $item->siswa->nama_lengkap }}</div>
                                    <div class="text-gray-400 text-xs">{{ $item->siswa->no_hp ?? 'No HP tidak tersedia' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-white">{{ \Carbon\Carbon::parse($item->tanggal_keluar)->translatedFormat('d M Y') }}</div>
                            <div class="text-gray-400 text-xs flex items-center gap-1 mt-0.5">
                                <iconify-icon icon="mdi:clock-outline" width="12" height="12"></iconify-icon>
                                {{ $item->jam_keluar }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-white">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->translatedFormat('d M Y') }}</div>
                            <div class="text-gray-400 text-xs flex items-center gap-1 mt-0.5">
                                <iconify-icon icon="mdi:clock-outline" width="12" height="12"></iconify-icon>
                                {{ $item->jam_kembali }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-w-xs">
                                <p class="text-gray-300 text-sm">{{ $item->alamat_tujuan }}</p>
                                @if($item->alasan)
                                <p class="text-gray-500 text-xs flex items-center gap-1 mt-1">
                                    <iconify-icon icon="mdi:note-text" width="10" height="10"></iconify-icon>
                                    {{ $item->alasan }}
                                </p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('siswa.izin.print', $item->id) }}" target="_blank"
                               class="inline-flex items-center gap-2 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-4 py-2 rounded-lg transition-all duration-300 group"
                               title="Cetak Izin">
                                <iconify-icon icon="mdi:printer" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                <span class="text-xs font-medium">Cetak</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="bg-gray-700/30 p-4 rounded-full">
                                    <iconify-icon icon="mdi:exit-to-app" width="40" height="40" class="text-gray-600"></iconify-icon>
                                </div>
                                <p class="text-gray-500 text-sm">Belum ada data izin keluar</p>
                                <p class="text-gray-600 text-xs">Siswa belum mengajukan izin keluar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($izin->count() > 0)
        <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
            <div class="flex items-center gap-2 text-gray-400 text-sm">
                <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
                <span>Total {{ $izin->count() }} pengajuan izin keluar</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Mobile Card View (visible only on mobile) -->
    <div class="md:hidden space-y-4">
        @forelse($izin as $item)
        <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
            <!-- Card Header - Siswa Info -->
            <div class="p-4 border-b border-gray-700/50 bg-gray-900/30">
                <div class="flex items-center gap-3">
                    @if($item->siswa->foto)
                        <img src="{{ asset('storage/' . $item->siswa->foto) }}" 
                             class="w-12 h-12 rounded-full object-cover border border-gray-600">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                            {{ substr($item->siswa->nama_lengkap, 0, 1) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <h3 class="text-white font-semibold">{{ $item->siswa->nama_lengkap }}</h3>
                        <p class="text-gray-400 text-xs flex items-center gap-1">
                            <iconify-icon icon="mdi:phone" width="10" height="10"></iconify-icon>
                            {{ $item->siswa->no_hp ?? 'No HP tidak tersedia' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card Body - Izin Details -->
            <div class="p-4 space-y-3">
                <!-- Tanggal Keluar -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-blue-500/10 rounded-lg">
                        <iconify-icon icon="mdi:calendar-export" width="16" height="16" class="text-blue-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Tanggal Keluar</p>
                        <p class="text-white font-medium text-sm">{{ \Carbon\Carbon::parse($item->tanggal_keluar)->translatedFormat('d F Y') }}</p>
                        <p class="text-gray-500 text-xs flex items-center gap-1 mt-0.5">
                            <iconify-icon icon="mdi:clock-outline" width="10" height="10"></iconify-icon>
                            {{ $item->jam_keluar }}
                        </p>
                    </div>
                </div>

                <!-- Tanggal Kembali -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-green-500/10 rounded-lg">
                        <iconify-icon icon="mdi:calendar-import" width="16" height="16" class="text-green-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Tanggal Kembali</p>
                        <p class="text-white font-medium text-sm">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->translatedFormat('d F Y') }}</p>
                        <p class="text-gray-500 text-xs flex items-center gap-1 mt-0.5">
                            <iconify-icon icon="mdi:clock-outline" width="10" height="10"></iconify-icon>
                            {{ $item->jam_kembali }}
                        </p>
                    </div>
                </div>

                <!-- Alamat Tujuan -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-purple-500/10 rounded-lg">
                        <iconify-icon icon="mdi:map-marker" width="16" height="16" class="text-purple-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Alamat Tujuan</p>
                        <p class="text-white text-sm">{{ $item->alamat_tujuan }}</p>
                    </div>
                </div>

                <!-- Alasan (jika ada) -->
                @if($item->alasan)
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-yellow-500/10 rounded-lg">
                        <iconify-icon icon="mdi:note-text" width="16" height="16" class="text-yellow-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Alasan</p>
                        <p class="text-gray-300 text-sm">{{ $item->alasan }}</p>
                    </div>
                </div>
                @endif

                <!-- Yang Menemani (jika ada) -->
                @if($item->yang_menemani)
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-orange-500/10 rounded-lg">
                        <iconify-icon icon="mdi:account-group" width="16" height="16" class="text-orange-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Yang Menemani</p>
                        <p class="text-gray-300 text-sm">{{ $item->yang_menemani }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Card Footer - Actions -->
            <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
                <div class="flex justify-center">
                    <a href="{{ route('siswa.izin.print', $item->id) }}" target="_blank"
                       class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-3 rounded-lg transition-all duration-300 text-sm font-medium shadow-lg shadow-blue-900/20">
                        <iconify-icon icon="mdi:printer" width="18" height="18"></iconify-icon>
                        <span>Cetak Izin Keluar</span>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-2xl p-8 text-center backdrop-blur-sm">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full"></div>
                <div class="relative bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                    <iconify-icon icon="mdi:exit-to-app" width="32" height="32" class="text-gray-600"></iconify-icon>
                </div>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Belum Ada Data Izin Keluar</h3>
            <p class="text-gray-500 text-sm max-w-xs mx-auto">
                Belum ada siswa yang mengajukan izin keluar.
            </p>
        </div>
        @endforelse
    </div>
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

    /* Table row hover effect */
    tbody tr {
        transition: all 0.2s ease;
    }

    tbody tr:hover .w-1 {
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

    /* Summary card animations */
    .grid-cols-2 > div {
        transition: all 0.3s ease;
    }

    .grid-cols-2 > div:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px -10px rgba(59, 130, 246, 0.3);
    }

    /* Mobile card spacing */
    .md\:hidden .space-y-4 > * {
        animation: fadeInUp 0.5s ease-out;
        animation-fill-mode: both;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Stagger animation for mobile cards */
    .md\:hidden .space-y-4 > *:nth-child(1) { animation-delay: 0.1s; }
    .md\:hidden .space-y-4 > *:nth-child(2) { animation-delay: 0.2s; }
    .md\:hidden .space-y-4 > *:nth-child(3) { animation-delay: 0.3s; }
    .md\:hidden .space-y-4 > *:nth-child(4) { animation-delay: 0.4s; }
    .md\:hidden .space-y-4 > *:nth-child(5) { animation-delay: 0.5s; }
    .md\:hidden .space-y-4 > *:nth-child(6) { animation-delay: 0.6s; }
    .md\:hidden .space-y-4 > *:nth-child(7) { animation-delay: 0.7s; }
    .md\:hidden .space-y-4 > *:nth-child(8) { animation-delay: 0.8s; }
    .md\:hidden .space-y-4 > *:nth-child(9) { animation-delay: 0.9s; }
    .md\:hidden .space-y-4 > *:nth-child(10) { animation-delay: 1s; }
</style>
@endsection