@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header with Glassmorphism Effect -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex items-center space-x-3 sm:space-x-4">
            <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                <iconify-icon icon="mdi:cash" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Pembayaran & Tagihan</h1>
                <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola tagihan dan riwayat pembayaran Anda</p>
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

    <!-- Tabs Modern -->
    <div class="mb-6 border-b border-gray-700/50 overflow-x-auto">
        <div class="flex flex-col md:flex-row flex-nowrap gap-1 sm:gap-2 px-2 sm:px-0 min-w-max">
            <button class="tab-btn px-4 sm:px-6 py-3 font-semibold text-sm sm:text-base text-gray-400 hover:text-white transition-all duration-300 flex items-center gap-2 whitespace-nowrap border-b-2 border-transparent active-tab" data-tab="tagihan">
                <iconify-icon icon="mdi:file-document" width="18" height="18"></iconify-icon>
                <span>Tagihan Belum Dibayar</span>
                @if($tagihan->count() > 0)
                <span class="bg-red-500/20 text-red-400 text-xs px-2 py-0.5 rounded-full">{{ $tagihan->count() }}</span>
                @endif
            </button>
            <button class="tab-btn px-4 sm:px-6 py-3 font-semibold text-sm sm:text-base text-gray-400 hover:text-white transition-all duration-300 flex items-center gap-2 whitespace-nowrap border-b-2 border-transparent" data-tab="riwayat">
                <iconify-icon icon="mdi:history" width="18" height="18"></iconify-icon>
                <span>Riwayat Transaksi</span>
            </button>
        </div>
    </div>

    <!-- Tab Content: Tagihan -->
    <div id="tagihan" class="tab-content">
        @if($tagihan->isEmpty())
        <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-0 md:rounded-2xl p-8 sm:p-12 text-center backdrop-blur-sm">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full"></div>
                <div class="relative bg-gray-800 w-20 h-20 sm:w-24 sm:h-24 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                    <iconify-icon icon="mdi:cash-off" width="32" height="32" class="text-gray-600 sm:w-10 sm:h-10"></iconify-icon>
                </div>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-white mb-2">Tidak Ada Tagihan</h3>
            <p class="text-gray-500 text-sm sm:text-base max-w-md mx-auto">
                Semua tagihan Anda telah lunas. Tidak ada tagihan yang perlu dibayar saat ini.
            </p>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($tagihan as $item)
            <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-red-500/50 hover:shadow-xl hover:shadow-red-900/10 transition-all duration-300 group">
                <!-- Card Header -->
                <div class="p-4 sm:p-5 border-b border-gray-700/50 bg-gray-900/30">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-2">
                            <div class="p-2 bg-red-500/10 rounded-lg group-hover:bg-red-500/20 transition-colors">
                                <iconify-icon icon="mdi:file-document" width="18" height="18" class="text-red-400"></iconify-icon>
                            </div>
                            <h3 class="text-base sm:text-lg font-bold text-white">{{ $item->judul }}</h3>
                        </div>
                        <span class="bg-red-500/20 text-red-400 text-xs px-2 py-1 rounded-full border border-red-500/30">Belum Dibayar</span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-4 sm:p-5 space-y-3">
                    <div>
                        <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Nominal Tagihan</p>
                        <p class="text-2xl sm:text-3xl font-bold text-white">Rp {{ number_format($item->nominal, 0, ',', '.') }}</p>
                    </div>

                    <div class="flex items-center gap-2 text-sm">
                        <div class="p-1.5 bg-yellow-500/10 rounded-lg">
                            <iconify-icon icon="mdi:calendar" width="14" height="14" class="text-yellow-400"></iconify-icon>
                        </div>
                        <span class="text-gray-300">Jatuh Tempo: <br/><span class="text-yellow-400 font-medium">{{ \Carbon\Carbon::parse($item->jatuh_tempo)->locale('id')->translatedFormat('d F Y') }}</span></span>
                    </div>

                    @if($item->keterangan)
                    <div class="bg-gray-700/30 p-3 rounded-lg border border-gray-700/50">
                        <p class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                            <iconify-icon icon="mdi:note-text" width="12" height="12"></iconify-icon>
                            Keterangan
                        </p>
                        <p class="text-gray-300 text-sm">{{ $item->keterangan }}</p>
                    </div>
                    @endif
                </div>

                <!-- Card Footer -->
                <div class="p-4 sm:p-5 border-t border-gray-700/50 bg-gray-900/30">
                    <button onclick="openPaymentModal({{ $item->id }}, '{{ $item->judul }}', {{ $item->nominal }})" 
                            class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <iconify-icon icon="mdi:cash" width="18" height="18"></iconify-icon>
                        <span>Lunasi Sekarang</span>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Tab Content: Riwayat -->
    <div id="riwayat" class="tab-content hidden">
        @if($riwayat->isEmpty())
        <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-0 md:rounded-2xl p-8 sm:p-12 text-center backdrop-blur-sm">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full"></div>
                <div class="relative bg-gray-800 w-20 h-20 sm:w-24 sm:h-24 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                    <iconify-icon icon="mdi:history" width="32" height="32" class="text-gray-600 sm:w-10 sm:h-10"></iconify-icon>
                </div>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-white mb-2">Belum Ada Riwayat Transaksi</h3>
            <p class="text-gray-500 text-sm sm:text-base max-w-md mx-auto">
                Anda belum melakukan transaksi pembayaran apapun.
            </p>
        </div>
        @else
        <div class="hidden md:block bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
            <div class="p-4 sm:p-6 border-b border-gray-700/50">
                <h2 class="text-lg sm:text-xl font-bold text-white flex items-center gap-2">
                    <iconify-icon icon="mdi:history" width="20" height="20" class="text-blue-400"></iconify-icon>
                    Riwayat Transaksi
                </h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-900/50 text-gray-400 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-bold border-b border-gray-700/50">Judul Tagihan</th>
                            <th class="px-6 py-4 font-bold border-b border-gray-700/50">Nominal</th>
                            <th class="px-6 py-4 font-bold border-b border-gray-700/50">Tanggal Bayar</th>
                            <th class="px-6 py-4 font-bold border-b border-gray-700/50">Status</th>
                            <th class="px-6 py-4 font-bold border-b border-gray-700/50">Bukti</th>
                            <th class="px-6 py-4 font-bold border-b border-gray-700/50 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @foreach($riwayat as $item)
                        <tr class="hover:bg-gray-700/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-1 h-8 bg-green-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <span class="text-white font-medium">{{ $item->judul }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-white font-medium">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-300">
                                {{ $item->payment ? $item->payment->created_at->locale('id')->translatedFormat('d F Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($item->status == 'lunas')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    Lunas
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full animate-pulse"></span>
                                    Menunggu Verifikasi
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($item->payment && $item->payment->bukti_pembayaran)
                                <a href="{{ asset('storage/' . $item->payment->bukti_pembayaran) }}" target="_blank" 
                                   class="text-blue-400 hover:text-blue-300 text-sm flex items-center gap-1">
                                    <iconify-icon icon="mdi:eye" width="16" height="16"></iconify-icon>
                                    <span>Lihat</span>
                                </a>
                                @else
                                <span class="text-gray-600 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('pembayaran.print', $item->id) }}" target="_blank" 
                                   class="inline-flex items-center gap-1 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-3 py-1.5 rounded-lg transition-all duration-300 text-xs group">
                                    <iconify-icon icon="mdi:printer" width="14" height="14" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                    <span>Cetak</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
                <div class="flex items-center gap-2 text-gray-400 text-sm">
                    <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
                    <span>Total {{ $riwayat->count() }} transaksi</span>
                </div>
            </div>
        </div>

        <div class="md:hidden space-y-4">
            @foreach($riwayat as $item)
            <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-green-500/50 transition-all duration-300">
                <div class="p-4 border-b border-gray-700/50 bg-gray-900/30 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <div class="p-2 bg-blue-500/10 rounded-lg">
                            <iconify-icon icon="mdi:file-document" width="16" height="16" class="text-blue-400"></iconify-icon>
                        </div>
                        <span class="text-white font-medium text-sm">{{ $item->judul }}</span>
                    </div>
                    @if($item->status == 'lunas')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                        Lunas
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full animate-pulse"></span>
                        Menunggu
                    </span>
                    @endif
                </div>

                <div class="p-4 space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-green-500/10 rounded-lg">
                            <iconify-icon icon="mdi:cash" width="16" height="16" class="text-green-400"></iconify-icon>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-400 text-xs">Nominal</p>
                            <p class="text-white font-bold text-base">Rp {{ number_format($item->nominal, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-yellow-500/10 rounded-lg">
                            <iconify-icon icon="mdi:calendar" width="16" height="16" class="text-yellow-400"></iconify-icon>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-400 text-xs">Tanggal Bayar</p>
                            <p class="text-white text-sm">{{ $item->payment ? $item->payment->created_at->locale('id')->translatedFormat('d F Y H:i') : '-' }}</p>
                        </div>
                    </div>

                    @if($item->payment && $item->payment->bukti_pembayaran)
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-purple-500/10 rounded-lg">
                            <iconify-icon icon="mdi:file-image" width="16" height="16" class="text-purple-400"></iconify-icon>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-400 text-xs">Bukti Pembayaran</p>
                            <a href="{{ asset('storage/' . $item->payment->bukti_pembayaran) }}" target="_blank" 
                               class="text-blue-400 hover:text-blue-300 text-sm flex items-center gap-1">
                                <iconify-icon icon="mdi:eye" width="14" height="14"></iconify-icon>
                                Lihat Bukti
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
                    <a href="{{ route('pembayaran.print', $item->id) }}" target="_blank" 
                       class="w-full inline-flex items-center justify-center gap-2 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-4 py-2 rounded-lg transition-all duration-300 text-sm">
                        <iconify-icon icon="mdi:printer" width="16" height="16"></iconify-icon>
                        <span>Cetak Bukti Pembayaran</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Modal Pembayaran -->
    <div id="paymentModal" class="fixed inset-0 bg-black/90 hidden items-start justify-center z-50 backdrop-blur-md transition-all duration-300">
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-md rounded-2xl border border-gray-700/50 shadow-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-green-500/10 rounded-lg">
                        <iconify-icon icon="mdi:cash" width="24" height="24" class="text-green-400"></iconify-icon>
                    </div>
                    <h2 class="text-lg font-bold text-white">Konfirmasi Pembayaran</h2>
                </div>
                <button onclick="closePaymentModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                    <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
                </button>
            </div>

            <!-- Modal Body -->
            <form id="paymentForm" method="POST" enctype="multipart/form-data" onsubmit="return validatePaymentForm()">
                <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <!-- Informasi Rekening -->
                    <div class="mb-6 bg-blue-600/10 p-4 rounded-xl border border-blue-600/30">
                        <p class="text-sm text-blue-300 mb-3 flex items-center gap-1">
                            <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
                            Silakan transfer ke rekening berikut:
                        </p>
                        <div class="bg-gray-800 p-3 rounded-lg border border-gray-700">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-400 text-xs">Bank</span>
                                <span class="text-white font-bold">BCA</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-400 text-xs">Nomor Rekening</span>
                                <span class="text-white font-bold">0541492550</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-xs">Atas Nama</span>
                                <span class="text-white font-bold">Irfan Maulana Sidik</span>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-blue-600/30 flex justify-between items-center">
                            <span class="text-gray-300 text-sm">Total Tagihan:</span>
                            <span class="font-bold text-white text-lg" id="modalNominal">Rp 0</span>
                        </div>
                    </div>

                    <div>
                        @csrf
                        <div class="space-y-4">
                            <!-- Nama Bank -->
                            <div id="field-bank">
                                <label class="block text-gray-300 text-sm font-medium mb-1 flex items-center gap-1">
                                    <iconify-icon icon="mdi:bank" width="14" height="14"></iconify-icon>
                                    Nama Bank Pengirim <span class="text-red-400">*</span>
                                </label>
                                <input type="text" name="nama_bank" id="bankInput" required placeholder="Contoh: BCA, Mandiri, BRI" 
                                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                                <p class="text-xs text-red-400 error-message hidden mt-1" id="error-bank">Nama bank harus diisi</p>
                            </div>

                            <!-- Nomor Rekening -->
                            <div id="field-norek">
                                <label class="block text-gray-300 text-sm font-medium mb-1 flex items-center gap-1">
                                    <iconify-icon icon="mdi:credit-card" width="14" height="14"></iconify-icon>
                                    Nomor Rekening Pengirim <span class="text-red-400">*</span>
                                </label>
                                <input type="text" name="nomor_rekening" id="norekInput" required placeholder="Nomor rekening Anda" 
                                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                                <p class="text-xs text-red-400 error-message hidden mt-1" id="error-norek">Nomor rekening harus diisi</p>
                            </div>

                            <!-- Upload Bukti -->
                            <div id="field-file">
                                <label class="block text-gray-300 text-sm font-medium mb-1 flex items-center gap-1">
                                    <iconify-icon icon="mdi:cloud-upload" width="14" height="14"></iconify-icon>
                                    Upload Bukti Transfer <span class="text-red-400">*</span>
                                </label>
                                <div class="flex items-center gap-3">
                                    <input type="file" name="bukti_pembayaran" id="fileInput" required accept="image/*" class="hidden">
                                    <label for="fileInput" class="cursor-pointer inline-flex items-center gap-2 bg-gray-700 hover:bg-gray-600 border border-gray-600 rounded-lg px-4 py-3 text-white transition-all duration-200">
                                        <iconify-icon icon="mdi:cloud-upload" width="18" height="18"></iconify-icon>
                                        <span class="text-sm">Pilih File</span>
                                    </label>
                                    <span class="text-sm text-gray-400" id="file-name">Tidak ada file dipilih</span>
                                </div>
                                <p class="text-xs text-red-400 error-message hidden mt-1" id="error-file">Bukti pembayaran harus diupload</p>
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max. 2MB)</p>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="mt-4 bg-yellow-500/5 border border-yellow-500/20 rounded-lg p-3 flex items-start gap-2">
                            <iconify-icon icon="mdi:alert-circle" width="16" height="16" class="text-yellow-400 flex-shrink-0 mt-0.5"></iconify-icon>
                            <p class="text-gray-400 text-xs">
                                Pastikan data yang diisi sesuai dengan bukti transfer. Pembayaran akan diverifikasi oleh admin.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 p-4 border-t border-gray-700/50">
                    <button type="button"
                        onclick="closePaymentModal()"
                        class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-green-900/20">
                        <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                        Simpan Pembayaran
                    </button>
                </div>
            </form>
        </div>
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

    /* Card hover effects */
    .bg-gradient-to-br {
        transition: all 0.3s ease;
    }

    .bg-gradient-to-br:hover {
        transform: translateY(-2px);
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
    .tab-btn.active-tab {
        color: #3b82f6;
        border-bottom-color: #3b82f6;
    }

    .tab-btn.active-tab iconify-icon {
        color: #3b82f6;
    }

    .tab-btn:not(.active-tab):hover {
        color: #e5e7eb;
    }

    /* Error styles */
    .border-red-500 {
        border-color: #ef4444 !important;
    }

    /* File input styling */
    input[type="file"] {
        cursor: pointer;
    }

    /* Pulse animation for pending status */
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
    // File upload preview
    document.getElementById('fileInput')?.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Tidak ada file dipilih';
        document.getElementById('file-name').textContent = fileName;
        
        // Reset error
        document.getElementById('error-file').classList.add('hidden');
        document.getElementById('fileInput').classList.remove('border-red-500');
    });

    // Tab Logic
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active-tab'));
            contents.forEach(c => c.classList.add('hidden'));

            tab.classList.add('active-tab');
            document.getElementById(tab.dataset.tab).classList.remove('hidden');
        });
    });

    // Modal Logic
    function openPaymentModal(id, judul, nominal) {
        const modal = document.getElementById('paymentModal');
        const modalContent = modal.querySelector('.modal-show');
        const form = document.getElementById('paymentForm');
        const nominalDisplay = document.getElementById('modalNominal');

        form.action = `/pembayaran/${id}`;
        nominalDisplay.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(nominal);
        
        // Reset form
        form.reset();
        document.getElementById('file-name').textContent = 'Tidak ada file dipilih';
        
        // Reset errors
        document.querySelectorAll('.error-message').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        document.body.style.overflow = 'hidden';
    }

    function closePaymentModal() {
        const modal = document.getElementById('paymentModal');
        const modalContent = modal.querySelector('.modal-show');
        
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);
    }

    // Form Validation
    function validatePaymentForm() {
        let isValid = true;
        
        // Reset errors
        document.querySelectorAll('.error-message').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
        
        // Validate Bank
        const bank = document.getElementById('bankInput').value.trim();
        if (bank === '') {
            document.getElementById('error-bank').classList.remove('hidden');
            document.getElementById('bankInput').classList.add('border-red-500');
            isValid = false;
        }
        
        // Validate No Rekening
        const norek = document.getElementById('norekInput').value.trim();
        if (norek === '') {
            document.getElementById('error-norek').classList.remove('hidden');
            document.getElementById('norekInput').classList.add('border-red-500');
            isValid = false;
        }
        
        // Validate File
        const file = document.getElementById('fileInput').files[0];
        if (!file) {
            document.getElementById('error-file').classList.remove('hidden');
            document.getElementById('fileInput').classList.add('border-red-500');
            isValid = false;
        } else {
            // Check file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB');
                document.getElementById('fileInput').value = '';
                document.getElementById('file-name').textContent = 'Tidak ada file dipilih';
                isValid = false;
            }
            
            // Check file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                alert('Format file harus JPG atau PNG');
                document.getElementById('fileInput').value = '';
                document.getElementById('file-name').textContent = 'Tidak ada file dipilih';
                isValid = false;
            }
        }
        
        return isValid;
    }

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePaymentModal();
        }
    });

    // Close modal when clicking outside
    document.getElementById('paymentModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closePaymentModal();
        }
    });
</script>
@endsection