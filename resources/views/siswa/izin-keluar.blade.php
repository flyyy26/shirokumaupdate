@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Header with Glassmorphism Effect -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <iconify-icon icon="mdi:exit-to-app" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Izin Keluar</h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola permohonan izin keluar karantina</p>
                </div>
            </div>
            
            <button onclick="openIzinModal()" 
                    class="w-full sm:w-auto bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm sm:text-base">
                <iconify-icon icon="mdi:plus" width="18" height="18" class="sm:w-5 sm:h-5"></iconify-icon>
                <span>Ajukan Izin Baru</span>
            </button>
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

    <!-- Desktop Table View (hidden on mobile) -->
    <div class="hidden md:block bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
        <div class="p-4 sm:p-6 border-b border-gray-700/50">
            <h2 class="text-lg sm:text-xl font-bold text-white flex items-center gap-2">
                <iconify-icon icon="mdi:format-list-bulleted" width="20" height="20" class="text-blue-400"></iconify-icon>
                Daftar Pengajuan Izin
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 text-gray-400 text-xs uppercase tracking-wider">
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
                            <div class="flex items-center gap-2">
                                <div class="w-1 h-8 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <div>
                                    <div class="text-white font-medium">{{ \Carbon\Carbon::parse($item->tanggal_keluar)->locale('id')->translatedFormat('d F Y') }}</div>
                                    <div class="text-gray-400 text-xs flex items-center gap-1 mt-0.5">
                                        <iconify-icon icon="mdi:clock-outline" width="12" height="12"></iconify-icon>
                                        {{ $item->jam_keluar }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-white">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->locale('id')->translatedFormat('d F Y') }}</div>
                            <div class="text-gray-400 text-xs flex items-center gap-1 mt-0.5">
                                <iconify-icon icon="mdi:clock-outline" width="12" height="12"></iconify-icon>
                                {{ $item->jam_kembali }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-white">{{$item->alamat_tujuan}}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('siswa.izin.print', $item->id) }}" target="_blank"
                                   class="bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 p-2 rounded-lg transition-all duration-300 inline-flex items-center gap-2 group"
                                   title="Cetak Izin">
                                    <iconify-icon icon="mdi:printer" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                    <span class="text-xs hidden lg:inline">Cetak</span>
                                </a>
                                
                                @if($item->status == 'pending')
                                <button onclick="showDetail('{{ $item->id }}')"
                                        class="bg-gray-600/20 hover:bg-gray-600/40 text-gray-400 p-2 rounded-lg transition-all duration-300"
                                        title="Lihat Detail">
                                    <iconify-icon icon="mdi:eye" width="16" height="16"></iconify-icon>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="bg-gray-700/30 p-4 rounded-full">
                                    <iconify-icon icon="mdi:calendar-blank" width="40" height="40" class="text-gray-600"></iconify-icon>
                                </div>
                                <p class="text-gray-500 text-sm">Belum ada pengajuan izin keluar</p>
                                <button onclick="openIzinModal()" 
                                        class="mt-2 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-all">
                                    <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                                    Ajukan Izin Pertama
                                </button>
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
                <span>Total {{ $izin->count() }} pengajuan izin</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Mobile Card View (visible only on mobile) -->
    <div class="md:hidden space-y-4">
        @forelse($izin as $item)
        <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
            <!-- Header Card dengan Status -->
            <div class="p-4 border-b border-gray-700/50 bg-gray-900/30 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="w-1 h-8 bg-blue-500 rounded-full"></div>
                    <span class="text-white font-medium text-sm">Izin Keluar</span>
                </div>
            </div>
            
            <!-- Body Card -->
            <div class="p-4 space-y-3">
                <!-- Tanggal Keluar -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-blue-500/10 rounded-lg">
                        <iconify-icon icon="mdi:calendar-export" width="16" height="16" class="text-blue-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Tanggal Keluar</p>
                        <p class="text-white font-medium text-sm">{{ \Carbon\Carbon::parse($item->tanggal_keluar)->locale('id')->translatedFormat('d F Y') }}</p>
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
                        <p class="text-white font-medium text-sm">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->locale('id')->translatedFormat('d F Y') }}</p>
                        <p class="text-gray-500 text-xs flex items-center gap-1 mt-0.5">
                            <iconify-icon icon="mdi:clock-outline" width="10" height="10"></iconify-icon>
                            {{ $item->jam_kembali }}
                        </p>
                    </div>
                </div>

                <!-- Tanggal Kembali -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-green-500/10 rounded-lg">
                        <iconify-icon icon="mdi:calendar-import" width="16" height="16" class="text-green-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Alamat Tujuan</p>
                        <p class="text-white font-medium text-sm">{{ $item->alamat_tujuan }}</p>
                    </div>
                </div>
                
                <!-- Alasan (jika ada) -->
                @if($item->alasan)
                <div class="mt-2 p-3 bg-gray-700/20 rounded-lg border border-gray-700/30">
                    <p class="text-gray-400 text-xs mb-1 flex items-center gap-1">
                        <iconify-icon icon="mdi:note-text" width="12" height="12"></iconify-icon>
                        Alasan
                    </p>
                    <p class="text-gray-300 text-sm">{{ $item->alasan }}</p>
                </div>
                @endif
            </div>
            
            <!-- Footer Card dengan Aksi -->
            <div class="p-4 border-t border-gray-700/50 bg-gray-900/30 flex justify-end gap-2">
                <a href="{{ route('siswa.izin.print', $item->id) }}" target="_blank"
                   class="flex-1 inline-flex items-center justify-center gap-2 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-3 py-2 rounded-lg transition-all duration-300 text-sm">
                    <iconify-icon icon="mdi:printer" width="16" height="16"></iconify-icon>
                    <span>Cetak</span>
                </a>
                
                @if($item->status == 'pending')
                <button onclick="showDetail('{{ $item->id }}')"
                        class="flex-1 inline-flex items-center justify-center gap-2 bg-gray-600/20 hover:bg-gray-600/40 text-gray-400 px-3 py-2 rounded-lg transition-all duration-300 text-sm">
                    <iconify-icon icon="mdi:eye" width="16" height="16"></iconify-icon>
                    <span>Detail</span>
                </button>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-2xl p-8 text-center backdrop-blur-sm">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full"></div>
                <div class="relative bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                    <iconify-icon icon="mdi:calendar-blank" width="32" height="32" class="text-gray-600"></iconify-icon>
                </div>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Belum Ada Pengajuan Izin</h3>
            <p class="text-gray-500 text-sm max-w-xs mx-auto mb-4">
                Anda belum mengajukan izin keluar. Silakan ajukan izin melalui tombol di bawah.
            </p>
            <button onclick="openIzinModal()" 
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300">
                <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                Ajukan Izin Sekarang
            </button>
        </div>
        @endforelse
    </div>

    <!-- Modal Form Izin Keluar -->
    <div id="izinModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md transition-all duration-300">
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-2xl rounded-2xl border border-gray-700/50 shadow-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-500/10 rounded-lg">
                        <iconify-icon icon="mdi:exit-to-app" width="24" height="24" class="text-blue-400"></iconify-icon>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-white">Form Izin Keluar</h2>
                </div>
                <button onclick="closeIzinModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                    <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
                </button>
            </div>

            <!-- Modal Body -->
            <form method="POST" action="{{ route('siswa.izin.store') }}">
                @csrf
                
                <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                    <!-- Alasan Izin -->
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:note-text" width="16" height="16"></iconify-icon>
                            Alasan Izin <span class="text-red-400">*</span>
                        </label>
                        <textarea name="alasan" 
                                rows="3"
                                placeholder="Tuliskan alasan izin keluar..."
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                required></textarea>
                    </div>

                    <!-- Yang Menemani -->
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:account-group" width="16" height="16"></iconify-icon>
                            Yang Menemani
                        </label>
                        <input type="text" 
                            name="yang_menemani"
                            placeholder="Nama yang menemani (jika ada)"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                    </div>

                    <!-- Alamat Tujuan -->
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:map-marker" width="16" height="16"></iconify-icon>
                            Alamat Tujuan <span class="text-red-400">*</span>
                        </label>
                        <input type="text" 
                            name="alamat_tujuan"
                            placeholder="Masukkan alamat tujuan"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                            required>
                    </div>

                    <!-- Grid untuk Tanggal dan Jam -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Tanggal Keluar -->
                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:calendar-export" width="16" height="16"></iconify-icon>
                                Tanggal Keluar <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                    name="tanggal_keluar"
                                    class="tanggal w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                    placeholder="Pilih tanggal"
                                    required>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                    <iconify-icon icon="mdi:calendar" width="16" height="16"></iconify-icon>
                                </span>
                            </div>
                        </div>

                        <!-- Jam Keluar -->
                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:clock-outline" width="16" height="16"></iconify-icon>
                                Jam Keluar <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                    name="jam_keluar"
                                    class="jam w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                    placeholder="Pilih jam"
                                    required>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                    <iconify-icon icon="mdi:clock" width="16" height="16"></iconify-icon>
                                </span>
                            </div>
                        </div>

                        <!-- Tanggal Kembali -->
                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:calendar-import" width="16" height="16"></iconify-icon>
                                Tanggal Kembali <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                    name="tanggal_kembali"
                                    class="tanggal w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                    placeholder="Pilih tanggal"
                                    required>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                    <iconify-icon icon="mdi:calendar" width="16" height="16"></iconify-icon>
                                </span>
                            </div>
                        </div>

                        <!-- Jam Kembali -->
                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:clock-outline" width="16" height="16"></iconify-icon>
                                Jam Kembali <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                    name="jam_kembali"
                                    class="jam w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                    placeholder="Pilih jam"
                                    required>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                    <iconify-icon icon="mdi:clock" width="16" height="16"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="bg-blue-500/5 border border-blue-500/20 rounded-lg p-3 flex items-start gap-3">
                        <iconify-icon icon="mdi:information" width="18" height="18" class="text-blue-400 flex-shrink-0 mt-0.5"></iconify-icon>
                        <p class="text-gray-400 text-xs">
                            Setelah Anda menyimpan data ini, data akan ditampilkan pada tabel. Selanjutnya, Anda dapat mencetak surat izin dan meminta tanda tangan pembina sebagai persetujuan.
                        </p>
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 p-4 border-t border-gray-700/50">
                    <button type="button"
                        onclick="closeIzinModal()"
                        class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-blue-900/20">
                        <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                        Ajukan Izin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Detail Modal (untuk melihat detail izin) -->
<div id="detailModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md transition-all duration-300">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-lg rounded-2xl border border-gray-700/50 shadow-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500/10 rounded-lg">
                    <iconify-icon icon="mdi:file-document" width="24" height="24" class="text-blue-400"></iconify-icon>
                </div>
                <h2 class="text-lg font-bold text-white">Detail Izin Keluar</h2>
            </div>
            <button onclick="closeDetailModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>
        <div class="p-6 space-y-4" id="detailContent">
            <!-- Detail akan diisi via JavaScript -->
        </div>
        <div class="flex justify-end p-6 border-t border-gray-700/50">
            <button onclick="closeDetailModal()"
                    class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

<script>
// Flatpickr initialization
flatpickr(".tanggal", {
    locale: "id",
    dateFormat: "Y-m-d",
    minDate: "today",
    theme: "dark"
});

flatpickr(".jam", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true,
    theme: "dark"
});

// Modal functions
function openIzinModal() {
    const modal = document.getElementById('izinModal');
    const modalContent = modal.querySelector('.modal-show');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    document.body.style.overflow = 'hidden';
}

function closeIzinModal() {
    const modal = document.getElementById('izinModal');
    const modalContent = modal.querySelector('.modal-show');
    
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }, 300);
}

// Detail modal function (contoh, sesuaikan dengan data yang ada)
function showDetail(id) {
    // Di sini Anda bisa fetch data detail dari server
    // Atau tampilkan modal dengan data yang sudah ada
    const modal = document.getElementById('detailModal');
    const modalContent = modal.querySelector('.modal-show');
    const detailContent = document.getElementById('detailContent');
    
    // Contoh data (sesuaikan dengan struktur data Anda)
    detailContent.innerHTML = `
        <div class="space-y-3">
            <div class="flex justify-between items-center p-3 bg-gray-700/30 rounded-lg">
                <span class="text-gray-400">ID Izin</span>
                <span class="text-white font-medium">#${id}</span>
            </div>
            <div class="flex justify-between items-center p-3 bg-gray-700/30 rounded-lg">
                <span class="text-gray-400">Status</span>
                <span class="text-yellow-400 font-medium">Menunggu</span>
            </div>
            <div class="p-3 bg-gray-700/30 rounded-lg">
                <p class="text-gray-400 mb-1">Alasan</p>
                <p class="text-white">Sedang dalam proses verifikasi</p>
            </div>
        </div>
    `;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    document.body.style.overflow = 'hidden';
}

function closeDetailModal() {
    const modal = document.getElementById('detailModal');
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
        closeIzinModal();
        closeDetailModal();
    }
});

// Close modal when clicking outside
document.getElementById('izinModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeIzinModal();
    }
});

document.getElementById('detailModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDetailModal();
    }
});
</script>

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

/* Card hover effects */
.bg-gradient-to-br {
    transition: all 0.3s ease;
}

.bg-gradient-to-br:hover {
    transform: translateY(-2px);
}

/* Status badge animations */
.inline-flex {
    transition: all 0.2s ease;
}

.inline-flex:hover {
    transform: scale(1.05);
}

/* Flatpickr dark theme customization */
.flatpickr-calendar {
    background: #ffffff !important;
    border: 1px solid #ffffff !important;
    border-radius: 12px !important;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
}

.flatpickr-months {
    background: #ffffff !important;
    border-bottom: 1px solid #ffffff !important;
}

.flatpickr-weekday {
    color: #2b2b2b !important;
}

.flatpickr-day {
    color: #2f3034 !important;
}

.flatpickr-day.selected {
    background: #3b82f6 !important;
    border-color: #2563eb !important;
}

.flatpickr-day.today {
    border-color: #60a5fa !important;
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
@endsection