@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 md:p-0">
    <!-- Header with Glassmorphism Effect -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex items-center space-x-3 sm:space-x-4">
            <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                <iconify-icon icon="mdi:airplane-takeoff" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Data Keberangkatan Siswa</h1>
                <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola data keberangkatan siswa ke Jepang</p>
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
                Daftar Siswa Berangkat
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 text-gray-400 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">No</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Nama Siswa</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">No Paspor</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Status</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @foreach($students as $key => $siswa)
                    <tr class="hover:bg-gray-700/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-1 h-8 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <span class="text-gray-300 text-sm font-mono">{{ $key + 1 }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($siswa->foto)
                                    <img src="{{ asset('storage/' . $siswa->foto) }}" 
                                         class="w-8 h-8 rounded-full object-cover border border-gray-600">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs">
                                        {{ substr($siswa->nama_lengkap, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-white font-medium">{{ $siswa->nama_lengkap }}</div>
                                    <div class="text-gray-400 text-xs">{{ $siswa->email ?? 'Email tidak tersedia' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($siswa->nomor_paspor)
                                <span class="bg-blue-500/20 text-blue-400 px-3 py-1.5 rounded-full text-xs font-medium border border-blue-500/30">
                                    {{ $siswa->nomor_paspor }}
                                </span>
                            @else
                                <span class="text-gray-500 text-sm">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($siswa->keberangkatan)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                    Sudah Berangkat
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>
                                    Belum Berangkat
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($siswa->keberangkatan)
                                <a href="{{ route('keberangkatan.create', $siswa->id) }}" 
                                   class="inline-flex items-center gap-2 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-4 py-2 rounded-lg transition-all duration-300 group">
                                    <iconify-icon icon="mdi:eye" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                    <span class="text-sm">Lihat Data</span>
                                </a>
                            @else
                                <a href="{{ route('keberangkatan.create', $siswa->id) }}" 
                                   class="inline-flex items-center gap-2 bg-green-600/20 hover:bg-green-600/40 text-green-400 px-4 py-2 rounded-lg transition-all duration-300 group">
                                    <iconify-icon icon="mdi:plus" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                    <span class="text-sm">Isi Data</span>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
            <div class="flex items-center gap-2 text-gray-400 text-sm">
                <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
                <span>Total {{ $students->count() }} siswa dalam daftar keberangkatan</span>
            </div>
        </div>
    </div>

    <!-- Mobile Card View (visible only on mobile) -->
    <div class="md:hidden space-y-4">
        @foreach($students as $key => $siswa)
        <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
            <!-- Card Header -->
            <div class="p-4 border-b border-gray-700/50 bg-gray-900/30">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-1.5 bg-blue-500/10 rounded-lg">
                            <span class="text-blue-400 font-mono text-sm">#{{ $key + 1 }}</span>
                        </div>
                        @if($siswa->foto)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" 
                                 class="w-10 h-10 rounded-full object-cover border border-gray-600">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                {{ substr($siswa->nama_lengkap, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="text-white font-semibold">{{ $siswa->nama_lengkap }}</h3>
                            <p class="text-gray-400 text-xs">{{ $siswa->email ?? 'Email tidak tersedia' }}</p>
                        </div>
                    </div>
                    
                    @if($siswa->keberangkatan)
                        <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs border border-green-500/30">
                            Berangkat
                        </span>
                    @else
                        <span class="bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-full text-xs border border-yellow-500/30">
                            Belum
                        </span>
                    @endif
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-4 space-y-3">
                <!-- Nomor Paspor -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-purple-500/10 rounded-lg">
                        <iconify-icon icon="mdi:passport" width="16" height="16" class="text-purple-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Nomor Paspor</p>
                        @if($siswa->nomor_paspor)
                            <p class="text-white text-sm font-medium">{{ $siswa->nomor_paspor }}</p>
                        @else
                            <p class="text-gray-500 text-sm italic">Belum diisi</p>
                        @endif
                    </div>
                </div>

                <!-- Status Keberangkatan -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-green-500/10 rounded-lg">
                        <iconify-icon icon="mdi:airplane-takeoff" width="16" height="16" class="text-green-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Status Keberangkatan</p>
                        @if($siswa->keberangkatan)
                            <p class="text-green-400 text-sm font-medium">Sudah Berangkat</p>
                        @else
                            <p class="text-yellow-400 text-sm font-medium">Belum Berangkat</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card Footer - Actions -->
            <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
                @if($siswa->keberangkatan)
                    <a href="{{ route('keberangkatan.create', $siswa->id) }}" 
                       class="w-full inline-flex items-center justify-center gap-2 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-4 py-3 rounded-lg transition-all duration-300 text-sm">
                        <iconify-icon icon="mdi:eye" width="16" height="16"></iconify-icon>
                        <span>Lihat Data Keberangkatan</span>
                    </a>
                @else
                    <a href="{{ route('keberangkatan.create', $siswa->id) }}" 
                       class="w-full inline-flex items-center justify-center gap-2 bg-green-600/20 hover:bg-green-600/40 text-green-400 px-4 py-3 rounded-lg transition-all duration-300 text-sm">
                        <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                        <span>Isi Data Keberangkatan</span>
                    </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Scripts -->
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

<style>
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

    /* Pulse animation for status */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Stagger animation for mobile cards */
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