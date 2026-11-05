@extends('layouts.app')

@section('content')
<div class="container mx-auto p-3 md:p-0">
    <!-- Header -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex items-center space-x-3 sm:space-x-4">
            <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                <iconify-icon icon="mdi:clipboard-text" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Data Pendaftaran</h1>
                <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola data calon siswa yang mendaftar</p>
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
    <div class="hidden md:block bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 text-gray-400 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Tanggal</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Nama Lengkap</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Program</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">No HP</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Bukti Bayar</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($pendaftarans as $item)
                    <tr class="hover:bg-gray-700/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-1 h-8 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <div class="text-gray-300 text-sm">{{ $item->created_at->format('d M Y') }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-white font-medium">{{ $item->nama_lengkap }}</div>
                            <div class="text-gray-500 text-xs">{{ $item->tempat_lahir }}, {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-500/20 text-blue-400 px-3 py-1.5 rounded-full text-xs font-medium border border-blue-500/30">
                                {{ $item->program }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-300 text-sm">
                            {{ $item->no_hp }}
                        </td>
                        <td class="px-6 py-4">
                            @if($item->bukti_pembayaran)
                                <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank" 
                                   class="text-blue-400 hover:text-blue-300 text-sm flex items-center gap-1">
                                    <iconify-icon icon="mdi:file-image" width="16" height="16"></iconify-icon>
                                    <span>Lihat</span>
                                </a>
                            @else
                                <span class="bg-red-500/10 text-red-400 px-3 py-1.5 rounded-full text-xs border border-red-500/30">
                                    Belum upload
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.pendaftaran.show', $item->id) }}" 
                                   class="bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 p-2 rounded-lg transition-all duration-300 group"
                                   title="Detail">
                                    <iconify-icon icon="mdi:eye" width="18" height="18" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                </a>
                                <form action="{{ route('admin.pendaftaran.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data pendaftaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600/20 hover:bg-red-600/40 text-red-400 p-2 rounded-lg transition-all duration-300 group" title="Hapus">
                                        <iconify-icon icon="mdi:delete" width="18" height="18" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center gap-3">
                                <div class="bg-gray-700/30 p-4 rounded-full">
                                    <iconify-icon icon="mdi:clipboard-text" width="40" height="40" class="text-gray-600"></iconify-icon>
                                </div>
                                <p class="text-gray-500 text-sm">Belum ada data pendaftaran.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pendaftarans->count() > 0)
        <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
            <div class="flex items-center gap-2 text-gray-400 text-sm">
                <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
                <span>Total {{ $pendaftarans->count() }} data pendaftaran</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Mobile Card View (visible only on mobile) -->
    <div class="md:hidden space-y-4">
        @forelse($pendaftarans as $item)
        <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
            <!-- Card Header -->
            <div class="p-4 border-b border-gray-700/50 bg-gray-900/30">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-blue-500/10 rounded-lg">
                            <iconify-icon icon="mdi:account" width="16" height="16" class="text-blue-400"></iconify-icon>
                        </div>
                        <h3 class="text-white font-semibold">{{ $item->nama_lengkap }}</h3>
                    </div>
                    <span class="bg-blue-500/20 text-blue-400 px-2 py-1 rounded-full text-xs border border-blue-500/30">
                        {{ $item->program }}
                    </span>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-4 space-y-3">
                <!-- Tanggal Daftar -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-yellow-500/10 rounded-lg">
                        <iconify-icon icon="mdi:calendar" width="16" height="16" class="text-yellow-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Tanggal Daftar</p>
                        <p class="text-white text-sm">{{ $item->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <!-- Tempat, Tanggal Lahir -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-purple-500/10 rounded-lg">
                        <iconify-icon icon="mdi:calendar-birthday" width="16" height="16" class="text-purple-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Tempat, Tanggal Lahir</p>
                        <p class="text-white text-sm">{{ $item->tempat_lahir }}, {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}</p>
                    </div>
                </div>

                <!-- No HP -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-green-500/10 rounded-lg">
                        <iconify-icon icon="mdi:phone" width="16" height="16" class="text-green-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">No HP</p>
                        <p class="text-white text-sm">{{ $item->no_hp }}</p>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-orange-500/10 rounded-lg">
                        <iconify-icon icon="mdi:map-marker" width="16" height="16" class="text-orange-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Alamat</p>
                        <p class="text-white text-sm">{{ $item->alamat }}</p>
                    </div>
                </div>

                <!-- Pendidikan -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-indigo-500/10 rounded-lg">
                        <iconify-icon icon="mdi:school" width="16" height="16" class="text-indigo-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Pendidikan Terakhir</p>
                        <p class="text-white text-sm">{{ $item->pendidikan_terakhir }} - {{ $item->jurusan }}</p>
                    </div>
                </div>

                <!-- Pengalaman Bahasa Jepang -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-cyan-500/10 rounded-lg">
                        <iconify-icon icon="mdi:translate" width="16" height="16" class="text-cyan-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Pengalaman Bahasa Jepang</p>
                        <p class="text-white text-sm">{{ $item->pernah_belajar_jepang ? 'Sudah Pernah' : 'Belum Pernah' }}</p>
                    </div>
                </div>

                <!-- Data Fisik -->
                @if($item->tinggi_badan || $item->berat_badan)
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-pink-500/10 rounded-lg">
                        <iconify-icon icon="mdi:human" width="16" height="16" class="text-pink-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Data Fisik</p>
                        <p class="text-white text-sm">
                            @if($item->tinggi_badan) Tinggi: {{ $item->tinggi_badan }} cm @endif
                            @if($item->tinggi_badan && $item->berat_badan) | @endif
                            @if($item->berat_badan) Berat: {{ $item->berat_badan }} kg @endif
                        </p>
                    </div>
                </div>
                @endif

                <!-- Bukti Pembayaran -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-emerald-500/10 rounded-lg">
                        <iconify-icon icon="mdi:cash" width="16" height="16" class="text-emerald-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Bukti Pembayaran</p>
                        @if($item->bukti_pembayaran)
                            <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank" 
                               class="text-blue-400 hover:text-blue-300 text-sm flex items-center gap-1">
                                <iconify-icon icon="mdi:file-image" width="16" height="16"></iconify-icon>
                                Lihat Bukti
                            </a>
                        @else
                            <span class="bg-red-500/10 text-red-400 px-3 py-1.5 rounded-full text-xs border border-red-500/30">
                                Belum upload
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card Footer - Actions -->
            <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('admin.pendaftaran.show', $item->id) }}" 
                       class="flex items-center justify-center gap-2 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-4 py-2 rounded-lg transition-all duration-300 text-sm">
                        <iconify-icon icon="mdi:eye" width="16" height="16"></iconify-icon>
                        <span>Detail</span>
                    </a>
                    
                    <form action="{{ route('admin.pendaftaran.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data pendaftaran ini?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-red-600/20 hover:bg-red-600/40 text-red-400 px-4 py-2 rounded-lg transition-all duration-300 text-sm">
                            <iconify-icon icon="mdi:delete" width="16" height="16"></iconify-icon>
                            <span>Hapus</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-2xl p-8 text-center backdrop-blur-sm">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full"></div>
                <div class="relative bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                    <iconify-icon icon="mdi:clipboard-text" width="32" height="32" class="text-gray-600"></iconify-icon>
                </div>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Belum Ada Data Pendaftaran</h3>
            <p class="text-gray-500 text-sm max-w-xs mx-auto">
                Belum ada calon siswa yang mendaftar melalui form pendaftaran.
            </p>
        </div>
        @endforelse
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