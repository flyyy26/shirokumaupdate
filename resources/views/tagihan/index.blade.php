@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header with Glassmorphism Effect -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <iconify-icon icon="mdi:cash" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Kelola Tagihan</h1>
                    <p class="text-indigo-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola tagihan dan pembayaran siswa</p>
                </div>
            </div>
            
            <button onclick="openModal()" 
                    class="w-full sm:w-auto bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm sm:text-base">
                <iconify-icon icon="mdi:plus" width="18" height="18" class="sm:w-5 sm:h-5"></iconify-icon>
                <span>Tambah Tagihan</span>
            </button>
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
    <div class="hidden md:block bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-indigo-500/50 transition-all duration-300">
        <div class="p-4 sm:p-6 border-b border-gray-700/50 bg-gray-900/30">
            <h2 class="text-lg sm:text-xl font-bold text-white flex items-center gap-2">
                <iconify-icon icon="mdi:format-list-bulleted" width="20" height="20" class="text-indigo-400"></iconify-icon>
                Daftar Tagihan
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 text-gray-400 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Siswa</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Judul</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Nominal</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Jatuh Tempo</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Status</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Bukti</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($billings as $b)
                    <tr class="hover:bg-gray-700/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-8 bg-indigo-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                @if($b->siswa->foto)
                                    <img src="{{ asset('storage/' . $b->siswa->foto) }}" 
                                         class="w-8 h-8 rounded-full object-cover border border-gray-600">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs">
                                        {{ substr($b->siswa->nama_lengkap, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-white font-medium">{{ $b->siswa->nama_lengkap }}</div>
                                    <div class="text-gray-400 text-xs">{{ $b->siswa->no_hp ?? 'No HP tidak tersedia' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-white font-medium">{{ $b->judul }}</div>
                            @if($b->keterangan)
                            <div class="text-gray-500 text-xs mt-0.5">{{ Str::limit($b->keterangan, 30) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-green-400 font-semibold">Rp {{ number_format($b->nominal, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-white">{{ \Carbon\Carbon::parse($b->jatuh_tempo)->translatedFormat('d M Y') }}</div>
                            @php
                                $today = \Carbon\Carbon::today();
                                $dueDate = \Carbon\Carbon::parse($b->jatuh_tempo);
                                $daysLeft = $today->diffInDays($dueDate, false);
                            @endphp
                            @if($b->status == 'belum_bayar' && $daysLeft < 0)
                                <div class="text-red-400 text-xs mt-0.5">Terlambat {{ abs($daysLeft) }} hari</div>
                            @elseif($b->status == 'belum_bayar' && $daysLeft <= 3 && $daysLeft >= 0)
                                <div class="text-yellow-400 text-xs mt-0.5">Sisa {{ $daysLeft }} hari</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($b->status == 'belum_bayar')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>
                                    Belum Bayar
                                </span>
                            @elseif($b->status == 'menunggu_verifikasi')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-500 border border-blue-500/20">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>
                                    Menunggu Verifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    Lunas
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($b->payment && $b->payment->bukti_pembayaran)
                                <a href="{{ asset('storage/' . $b->payment->bukti_pembayaran) }}" target="_blank"
                                   class="text-blue-400 hover:text-blue-300 text-sm flex items-center gap-1">
                                    <iconify-icon icon="mdi:file-image" width="14" height="14"></iconify-icon>
                                    <span>Lihat Bukti</span>
                                </a>
                            @else
                                <span class="text-gray-600 text-sm">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Cetak -->
                                <a href="{{ route('pembayaran.print', $b->id) }}" target="_blank"
                                   class="bg-gray-600/20 hover:bg-gray-600/40 text-gray-400 p-2 rounded-lg transition-all duration-300 group"
                                   title="Cetak Tagihan">
                                    <iconify-icon icon="mdi:printer" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                </a>

                                <!-- Verifikasi (jika menunggu) -->
                                @if($b->status == 'menunggu_verifikasi')
                                <form action="{{ route('tagihan.verify', $b->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" 
                                            onclick="return confirm('Verifikasi pembayaran ini?')"
                                            class="bg-green-600/20 hover:bg-green-600/40 text-green-400 p-2 rounded-lg transition-all duration-300 group"
                                            title="Verifikasi Pembayaran">
                                        <iconify-icon icon="mdi:check" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                    </button>
                                </form>
                                @endif

                                <!-- Hapus -->
                                <form action="{{ route('tagihan.destroy', $b->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Hapus tagihan ini?')"
                                            class="bg-red-600/20 hover:bg-red-600/40 text-red-400 p-2 rounded-lg transition-all duration-300 group"
                                            title="Hapus Tagihan">
                                        <iconify-icon icon="mdi:delete" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="bg-gray-700/30 p-4 rounded-full">
                                    <iconify-icon icon="mdi:cash-off" width="40" height="40" class="text-gray-600"></iconify-icon>
                                </div>
                                <p class="text-gray-500 text-sm">Belum ada data tagihan</p>
                                <button onclick="openModal()" 
                                        class="mt-2 bg-indigo-600/20 hover:bg-indigo-600/40 text-indigo-400 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-all">
                                    <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                                    Tambah Tagihan Pertama
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($billings->count() > 0)
        <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
            <div class="flex items-center gap-2 text-gray-400 text-sm">
                <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
                <span>Total {{ $billings->count() }} tagihan</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Mobile Card View (visible only on mobile) -->
    <div class="md:hidden space-y-4">
        @forelse($billings as $b)
        <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-indigo-500/50 transition-all duration-300">
            <!-- Card Header - Siswa Info & Status -->
            <div class="p-4 border-b border-gray-700/50 bg-gray-900/30">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        @if($b->siswa->foto)
                            <img src="{{ asset('storage/' . $b->siswa->foto) }}" 
                                 class="w-12 h-12 rounded-full object-cover border border-gray-600">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                                {{ substr($b->siswa->nama_lengkap, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="text-white font-semibold">{{ $b->siswa->nama_lengkap }}</h3>
                            <p class="text-gray-400 text-xs">{{ $b->siswa->no_hp ?? 'No HP tidak tersedia' }}</p>
                        </div>
                    </div>
                    
                    @if($b->status == 'belum_bayar')
                        <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1.5 rounded-full text-xs border border-yellow-500/30">
                            Belum Bayar
                        </span>
                    @elseif($b->status == 'menunggu_verifikasi')
                        <span class="bg-blue-500/20 text-blue-400 px-3 py-1.5 rounded-full text-xs border border-blue-500/30">
                            Menunggu
                        </span>
                    @else
                        <span class="bg-green-500/20 text-green-400 px-3 py-1.5 rounded-full text-xs border border-green-500/30">
                            Lunas
                        </span>
                    @endif
                </div>
            </div>

            <!-- Card Body - Tagihan Details -->
            <div class="p-4 space-y-3">
                <!-- Judul & Nominal -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-indigo-500/10 rounded-lg">
                        <iconify-icon icon="mdi:tag" width="16" height="16" class="text-indigo-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Judul Tagihan</p>
                        <p class="text-white font-medium text-sm">{{ $b->judul }}</p>
                        <p class="text-green-400 font-bold text-base mt-1">Rp {{ number_format($b->nominal, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Jatuh Tempo -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-red-500/10 rounded-lg">
                        <iconify-icon icon="mdi:calendar" width="16" height="16" class="text-red-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Jatuh Tempo</p>
                        <p class="text-white text-sm">{{ \Carbon\Carbon::parse($b->jatuh_tempo)->translatedFormat('d F Y') }}</p>
                        @php
                            $today = \Carbon\Carbon::today();
                            $dueDate = \Carbon\Carbon::parse($b->jatuh_tempo);
                            $daysLeft = $today->diffInDays($dueDate, false);
                        @endphp
                        @if($b->status == 'belum_bayar' && $daysLeft < 0)
                            <p class="text-red-400 text-xs mt-1">Terlambat {{ abs($daysLeft) }} hari</p>
                        @elseif($b->status == 'belum_bayar' && $daysLeft <= 3 && $daysLeft >= 0)
                            <p class="text-yellow-400 text-xs mt-1">Sisa {{ $daysLeft }} hari</p>
                        @endif
                    </div>
                </div>

                <!-- Keterangan (jika ada) -->
                @if($b->keterangan)
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-purple-500/10 rounded-lg">
                        <iconify-icon icon="mdi:note-text" width="16" height="16" class="text-purple-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Keterangan</p>
                        <p class="text-gray-300 text-sm">{{ $b->keterangan }}</p>
                    </div>
                </div>
                @endif

                <!-- Bukti Pembayaran (jika ada) -->
                @if($b->payment && $b->payment->bukti_pembayaran)
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-blue-500/10 rounded-lg">
                        <iconify-icon icon="mdi:file-image" width="16" height="16" class="text-blue-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Bukti Pembayaran</p>
                        <a href="{{ asset('storage/' . $b->payment->bukti_pembayaran) }}" target="_blank"
                           class="text-blue-400 hover:text-blue-300 text-sm flex items-center gap-1">
                            <iconify-icon icon="mdi:eye" width="14" height="14"></iconify-icon>
                            Lihat Bukti
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Card Footer - Actions -->
            <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
                <div class="grid grid-cols-3 gap-2">
                    <!-- Cetak -->
                    <a href="{{ route('pembayaran.print', $b->id) }}" target="_blank"
                       class="flex items-center justify-center gap-1 bg-gray-600/20 hover:bg-gray-600/40 text-gray-400 px-2 py-2 rounded-lg transition-all duration-300 text-xs">
                        <iconify-icon icon="mdi:printer" width="14" height="14"></iconify-icon>
                        <span>Cetak</span>
                    </a>

                    <!-- Verifikasi (jika menunggu) -->
                    @if($b->status == 'menunggu_verifikasi')
                    <form action="{{ route('tagihan.verify', $b->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" 
                                onclick="return confirm('Verifikasi pembayaran ini?')"
                                class="w-full flex items-center justify-center gap-1 bg-green-600/20 hover:bg-green-600/40 text-green-400 px-2 py-2 rounded-lg transition-all duration-300 text-xs">
                            <iconify-icon icon="mdi:check" width="14" height="14"></iconify-icon>
                            <span>Verifikasi</span>
                        </button>
                    </form>
                    @endif

                    <!-- Hapus -->
                    <form action="{{ route('tagihan.destroy', $b->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Hapus tagihan ini?')"
                                class="w-full flex items-center justify-center gap-1 bg-red-600/20 hover:bg-red-600/40 text-red-400 px-2 py-2 rounded-lg transition-all duration-300 text-xs">
                            <iconify-icon icon="mdi:delete" width="14" height="14"></iconify-icon>
                            <span>Hapus</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-2xl p-8 text-center backdrop-blur-sm">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-indigo-500 blur-3xl opacity-20 rounded-full"></div>
                <div class="relative bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                    <iconify-icon icon="mdi:cash-off" width="32" height="32" class="text-gray-600"></iconify-icon>
                </div>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Belum Ada Tagihan</h3>
            <p class="text-gray-500 text-sm max-w-xs mx-auto mb-4">
                Anda belum menambahkan tagihan. Silakan tambah tagihan baru.
            </p>
            <button onclick="openModal()" 
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300">
                <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                Tambah Tagihan
            </button>
        </div>
        @endforelse
    </div>

    <!-- Summary Stats (optional) -->
    @if($billings->count() > 0)
    <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-4">
        @php
            $totalTagihan = $billings->sum('nominal');
            $totalLunas = $billings->where('status', 'lunas')->sum('nominal');
            $totalBelum = $billings->where('status', 'belum_bayar')->sum('nominal');
            $totalMenunggu = $billings->where('status', 'menunggu_verifikasi')->sum('nominal');
        @endphp
        
        <div class="bg-gradient-to-br from-indigo-600/20 to-indigo-700/20 rounded-xl p-4 border border-indigo-500/30 text-center">
            <iconify-icon icon="mdi:cash" width="24" height="24" class="text-indigo-400 mx-auto mb-2"></iconify-icon>
            <p class="text-2xl font-bold text-white">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400">Total Tagihan</p>
        </div>
        
        <div class="bg-gradient-to-br from-green-600/20 to-green-700/20 rounded-xl p-4 border border-green-500/30 text-center">
            <iconify-icon icon="mdi:check-circle" width="24" height="24" class="text-green-400 mx-auto mb-2"></iconify-icon>
            <p class="text-2xl font-bold text-white">Rp {{ number_format($totalLunas, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400">Lunas</p>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-600/20 to-yellow-700/20 rounded-xl p-4 border border-yellow-500/30 text-center">
            <iconify-icon icon="mdi:clock-outline" width="24" height="24" class="text-yellow-400 mx-auto mb-2"></iconify-icon>
            <p class="text-2xl font-bold text-white">Rp {{ number_format($totalBelum, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400">Belum Dibayar</p>
        </div>
        
        <div class="bg-gradient-to-br from-blue-600/20 to-blue-700/20 rounded-xl p-4 border border-blue-500/30 text-center">
            <iconify-icon icon="mdi:progress-clock" width="24" height="24" class="text-blue-400 mx-auto mb-2"></iconify-icon>
            <p class="text-2xl font-bold text-white">Rp {{ number_format($totalMenunggu, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400">Menunggu</p>
        </div>
    </div>
    @endif
</div>

<!-- Modal Tambah Tagihan -->
<div id="modalTagihan" class="fixed inset-0 bg-black/90 hidden items-start justify-center z-50 backdrop-blur-md overflow-y-auto py-10 px-4">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-2xl rounded-2xl border border-gray-700/50 shadow-2xl transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-500/10 rounded-lg">
                    <iconify-icon icon="mdi:cash-plus" width="24" height="24" class="text-indigo-400"></iconify-icon>
                </div>
                <h2 class="text-lg font-bold text-white">Tambah Tagihan Baru</h2>
            </div>
            <button onclick="closeModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <!-- Modal Body -->
        <form action="{{ route('tagihan.store') }}" method="POST" class="p-6">
            @csrf

            <div class="space-y-4">
                <!-- Pilih Siswa (Multiple) -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:account-group" width="14" height="14"></iconify-icon>
                        Pilih Siswa <span class="text-red-400">*</span>
                    </label>
                    <select name="siswa_ids[]" class="select2 w-full" multiple required>
                        @foreach($siswa as $s)
                            <option value="{{ $s->id }}">
                                {{ $s->nama_lengkap }} ({{ $s->no_hp ?? 'No HP tidak tersedia' }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500">Tekan Ctrl untuk memilih lebih dari satu siswa</p>
                </div>

                <!-- Judul Tagihan -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:tag" width="14" height="14"></iconify-icon>
                        Judul Tagihan <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="judul" placeholder="Contoh: SPP Bulan Maret"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm"
                           required>
                </div>

                <!-- Nominal -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:cash" width="14" height="14"></iconify-icon>
                        Nominal <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                        <input type="number" name="nominal" placeholder="0"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg pl-10 pr-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm"
                               required>
                    </div>
                </div>

                <!-- Jatuh Tempo -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:calendar" width="14" height="14"></iconify-icon>
                        Jatuh Tempo <span class="text-red-400">*</span>
                    </label>
                    <input type="date" name="jatuh_tempo"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm"
                           required>
                </div>

                <!-- Keterangan -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:note-text" width="14" height="14"></iconify-icon>
                        Keterangan
                    </label>
                    <textarea name="keterangan" rows="3" placeholder="Deskripsi tagihan (opsional)"
                              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm"></textarea>
                </div>

                <!-- Informasi Tambahan -->
                <div class="bg-indigo-500/5 border border-indigo-500/20 rounded-lg p-3 flex items-start gap-2">
                    <iconify-icon icon="mdi:information" width="16" height="16" class="text-indigo-400 flex-shrink-0 mt-0.5"></iconify-icon>
                    <p class="text-gray-400 text-xs">
                        Tagihan akan dibuat untuk semua siswa yang dipilih. Status awal akan diatur sebagai "Belum Bayar".
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
                        class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-indigo-900/20">
                    <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                    Simpan Tagihan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

    /* Select2 Dark Theme */
    .select2-container--default .select2-selection--multiple {
        background-color: #374151 !important;
        border-color: #4B5563 !important;
        border-radius: 0.5rem !important;
        min-height: 46px !important;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #1F2937 !important;
        border-color: #4B5563 !important;
        color: white !important;
        margin-top: 8px !important;
    }
    
    .select2-dropdown {
        background-color: #1F2937 !important;
        border-color: #4B5563 !important;
        border-radius: 0.5rem !important;
    }
    
    .select2-container--default .select2-results__option {
        color: #e5e7eb !important;
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #6366f1 !important;
    }

    /* Pulse animation for menunggu status */
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
</style>

<script>
    // Modal functions
    function openModal() {
        const modal = document.getElementById('modalTagihan');
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
        const modal = document.getElementById('modalTagihan');
        const modalContent = modal.querySelector('.modal-show');
        
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);
    }

    // Initialize Select2
    $(document).ready(function() {
        $('.select2').select2({
            dropdownParent: $('#modalTagihan'),
            width: '100%',
            placeholder: 'Pilih siswa',
            allowClear: true
        });
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

    // Close modal when clicking outside
    document.getElementById('modalTagihan')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
@endsection