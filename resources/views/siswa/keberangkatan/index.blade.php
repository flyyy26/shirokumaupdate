@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header -->
    <div class="mb-6 bg-gradient-to-r from-blue-600 to-blue-800 rounded-0 md:rounded-2xl shadow-xl p-6 text-white">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-xl">
                <iconify-icon icon="mdi:airplane-takeoff" width="32" height="32"></iconify-icon>
            </div>
            <div>
                <h1 class="text-md md:text-2xl font-bold">Informasi Keberangkatan Saya</h1>
                <p class="text-blue-100">{{ $siswa->nama_lengkap }}</p>
            </div>
        </div>
    </div>

    @if($keberangkatan)
        <div class="bg-gray-800/50 rounded-2xl border border-gray-700/50 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Tanggal Berangkat -->
                <div class="bg-gray-700/30 rounded-xl p-5">
                    <h3 class="text-gray-400 text-sm mb-3 flex items-center gap-1">
                        <iconify-icon icon="mdi:calendar" width="16" height="16" class="text-blue-400"></iconify-icon>
                        Tanggal Keberangkatan
                    </h3>
                    <p class="text-white text-lg">
                        {{ $keberangkatan->tanggal_berangkat ? \Carbon\Carbon::parse($keberangkatan->tanggal_berangkat)->format('d F Y') : '-' }}
                    </p>
                    <p class="text-gray-500 text-sm mt-1">
                        Jam: {{ $keberangkatan->jam_keberangkatan ?? '-' }}
                    </p>
                </div>

                <!-- Maskapai & No Penerbangan -->
                <div class="bg-gray-700/30 rounded-xl p-5">
                    <h3 class="text-gray-400 text-sm mb-3 flex items-center gap-1">
                        <iconify-icon icon="mdi:airplane" width="16" height="16" class="text-blue-400"></iconify-icon>
                        Maskapai
                    </h3>
                    <p class="text-white text-lg">{{ $keberangkatan->maskapai ?? '-' }}</p>
                    <p class="text-gray-500 text-sm mt-1">
                        No. Penerbangan: {{ $keberangkatan->nomor_penerbangan ?? '-' }}
                    </p>
                </div>

                <!-- Rute Penerbangan -->
                <div class="bg-gray-700/30 rounded-xl p-5 md:col-span-2">
                    <h3 class="text-gray-400 text-sm mb-3 flex items-center gap-1">
                        <iconify-icon icon="mdi:map-marker-path" width="16" height="16" class="text-blue-400"></iconify-icon>
                        Rute Penerbangan
                    </h3>
                    <div class="flex items-center gap-4">
                        <div class="flex-1 text-center">
                            <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-2">
                                <iconify-icon icon="mdi:airplane-takeoff" width="24" height="24" class="text-blue-400"></iconify-icon>
                            </div>
                            <p class="text-white font-semibold">Keberangkatan</p>
                            <p class="text-gray-400">{{ $keberangkatan->bandara_asal ?? '-' }}</p>
                        </div>
                        <div class="text-gray-600">
                            <iconify-icon icon="mdi:arrow-right" width="24" height="24"></iconify-icon>
                        </div>
                        <div class="flex-1 text-center">
                            <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-2">
                                <iconify-icon icon="mdi:airplane-landing" width="24" height="24" class="text-green-400"></iconify-icon>
                            </div>
                            <p class="text-white font-semibold">Tujuan</p>
                            <p class="text-gray-400">{{ $keberangkatan->bandara_tujuan ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Keterangan -->
                @if($keberangkatan->keterangan)
                <div class="bg-gray-700/30 rounded-xl p-5 md:col-span-2">
                    <h3 class="text-gray-400 text-sm mb-3 flex items-center gap-1">
                        <iconify-icon icon="mdi:note-text" width="16" height="16" class="text-yellow-400"></iconify-icon>
                        Keterangan
                    </h3>
                    <p class="text-white">{{ $keberangkatan->keterangan }}</p>
                </div>
                @endif
                
                <!-- Status Dokumen Penting -->
                <div class="bg-gray-700/30 rounded-xl p-5 md:col-span-2">
                    <h3 class="text-gray-400 text-sm mb-4 flex items-center gap-2">
                        <iconify-icon icon="mdi:file-document-multiple" width="18" height="18" class="text-yellow-400"></iconify-icon>
                        Status Dokumen Keberangkatan
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Paspor -->
                        <div class="bg-gray-800/50 rounded-lg p-4 border {{ $siswa->dokumen_paspor ? 'border-green-500/30' : 'border-gray-600/50' }}">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="p-2 {{ $siswa->dokumen_paspor ? 'bg-green-500/20' : 'bg-gray-700' }} rounded-lg">
                                        <iconify-icon icon="mdi:passport" width="20" height="20" 
                                            class="{{ $siswa->dokumen_paspor ? 'text-green-400' : 'text-gray-500' }}"></iconify-icon>
                                    </div>
                                    <span class="text-white font-medium">Paspor</span>
                                </div>
                                @if($siswa->dokumen_paspor)
                                    <span class="text-green-400 flex items-center gap-1 text-sm">
                                        <iconify-icon icon="mdi:check-circle" width="16" height="16"></iconify-icon>
                                        <span class="hidden sm:inline">Sudah</span>
                                    </span>
                                @else
                                    <span class="text-gray-500 flex items-center gap-1 text-sm">
                                        <iconify-icon icon="mdi:close-circle" width="16" height="16"></iconify-icon>
                                        <span class="hidden sm:inline">Belum</span>
                                    </span>
                                @endif
                            </div>
                            @if($siswa->dokumen_paspor)
                                <div class="mt-2 text-xs text-gray-400">
                                    <p>No: {{ $siswa->nomor_paspor ?? '-' }}</p>
                                    <p class="mt-1">
                                        <a href="{{ asset('storage/'.$siswa->dokumen_paspor) }}" target="_blank" 
                                           class="text-blue-400 hover:text-blue-300 flex items-center gap-1">
                                            <iconify-icon icon="mdi:eye" width="14" height="14"></iconify-icon>
                                            Lihat Dokumen
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Visa -->
                        <div class="bg-gray-800/50 rounded-lg p-4 border {{ $siswa->dokumen_visa ? 'border-green-500/30' : 'border-gray-600/50' }}">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="p-2 {{ $siswa->dokumen_visa ? 'bg-green-500/20' : 'bg-gray-700' }} rounded-lg">
                                        <iconify-icon icon="mdi:passport" width="20" height="20" 
                                            class="{{ $siswa->dokumen_visa ? 'text-green-400' : 'text-gray-500' }}"></iconify-icon>
                                    </div>
                                    <span class="text-white font-medium">Visa</span>
                                </div>
                                @if($siswa->dokumen_visa)
                                    <span class="text-green-400 flex items-center gap-1 text-sm">
                                        <iconify-icon icon="mdi:check-circle" width="16" height="16"></iconify-icon>
                                        <span class="hidden sm:inline">Sudah</span>
                                    </span>
                                @else
                                    <span class="text-gray-500 flex items-center gap-1 text-sm">
                                        <iconify-icon icon="mdi:close-circle" width="16" height="16"></iconify-icon>
                                        <span class="hidden sm:inline">Belum</span>
                                    </span>
                                @endif
                            </div>
                            @if($siswa->dokumen_visa)
                                <div class="mt-2 text-xs text-gray-400">
                                    <p>No: {{ $siswa->nomor_visa ?? '-' }}</p>
                                    <p>Berlaku: {{ $siswa->masa_berlaku_visa ?? '-' }}</p>
                                    <p class="mt-1">
                                        <a href="{{ asset('storage/'.$siswa->dokumen_visa) }}" target="_blank" 
                                           class="text-blue-400 hover:text-blue-300 flex items-center gap-1">
                                            <iconify-icon icon="mdi:eye" width="14" height="14"></iconify-icon>
                                            Lihat Dokumen
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- COE -->
                        <div class="bg-gray-800/50 rounded-lg p-4 border {{ $siswa->dokumen_coe ? 'border-green-500/30' : 'border-gray-600/50' }}">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="p-2 {{ $siswa->dokumen_coe ? 'bg-green-500/20' : 'bg-gray-700' }} rounded-lg">
                                        <iconify-icon icon="mdi:file-certificate" width="20" height="20" 
                                            class="{{ $siswa->dokumen_coe ? 'text-green-400' : 'text-gray-500' }}"></iconify-icon>
                                    </div>
                                    <span class="text-white font-medium">COE</span>
                                </div>
                                @if($siswa->dokumen_coe)
                                    <span class="text-green-400 flex items-center gap-1 text-sm">
                                        <iconify-icon icon="mdi:check-circle" width="16" height="16"></iconify-icon>
                                        <span class="hidden sm:inline">Sudah</span>
                                    </span>
                                @else
                                    <span class="text-gray-500 flex items-center gap-1 text-sm">
                                        <iconify-icon icon="mdi:close-circle" width="16" height="16"></iconify-icon>
                                        <span class="hidden sm:inline">Belum</span>
                                    </span>
                                @endif
                            </div>
                            @if($siswa->dokumen_coe)
                                <div class="mt-2 text-xs text-gray-400">
                                    <p>No: {{ $siswa->nomor_coe ?? '-' }}</p>
                                    <p>Tanggal: {{ $siswa->tanggal_coe ? \Carbon\Carbon::parse($siswa->tanggal_coe)->format('d/m/Y') : '-' }}</p>
                                    <p class="mt-1">
                                        <a href="{{ asset('storage/'.$siswa->dokumen_coe) }}" target="_blank" 
                                           class="text-blue-400 hover:text-blue-300 flex items-center gap-1">
                                            <iconify-icon icon="mdi:eye" width="14" height="14"></iconify-icon>
                                            Lihat Dokumen
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Ringkasan Dokumen -->
                    @php
                        $totalDokumen = 3;
                        $dokumenLengkap = 0;
                        if ($siswa->dokumen_paspor) $dokumenLengkap++;
                        if ($siswa->dokumen_visa) $dokumenLengkap++;
                        if ($siswa->dokumen_coe) $dokumenLengkap++;
                        $progressPersen = ($dokumenLengkap / $totalDokumen) * 100;
                    @endphp
                    
                    <div class="mt-4 pt-4 border-t border-gray-600/50">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-400 text-sm">Kelengkapan Dokumen</span>
                            <span class="text-white text-sm font-semibold">{{ $dokumenLengkap }}/{{ $totalDokumen }}</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-2 rounded-full transition-all duration-500" 
                                 style="width: {{ $progressPersen }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            @if($dokumenLengkap == $totalDokumen)
                                <span class="text-green-400">✓ Semua dokumen lengkap</span>
                            @else
                                <span class="text-yellow-400">⚠️ Masih ada {{ $totalDokumen - $dokumenLengkap }} dokumen belum diupload</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @else

        <!-- Belum ada data keberangkatan -->
        <div class="bg-gray-800/50 rounded-2xl border border-gray-700/50 p-12 text-center">
            <div class="w-20 h-20 bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-4">
                <iconify-icon icon="mdi:airplane-off" width="32" height="32" class="text-gray-500"></iconify-icon>
            </div>
            <h3 class="text-xl text-white font-semibold mb-2">Belum Ada Informasi Keberangkatan</h3>
            <p class="text-gray-400 max-w-md mx-auto">
                Saat ini belum ada data keberangkatan untuk Anda. Silahkan cek kembali secara berkala.
            </p>
        </div>
        
        <!-- Belum ada data keberangkatan, tapi tetap tampilkan status dokumen -->
        <div class="bg-gray-800/50 rounded-2xl border border-gray-700/50 p-6 mb-6">
            <h3 class="text-gray-400 text-sm mb-4 flex items-center gap-2">
                <iconify-icon icon="mdi:file-document-multiple" width="18" height="18" class="text-yellow-400"></iconify-icon>
                Status Dokumen Keberangkatan
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                <!-- Paspor -->
                <div class="bg-gray-700/30 rounded-lg p-4 border {{ $siswa->dokumen_paspor ? 'border-green-500/30' : 'border-gray-600/50' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="p-2 {{ $siswa->dokumen_paspor ? 'bg-green-500/20' : 'bg-gray-700' }} rounded-lg">
                                <iconify-icon icon="mdi:passport" width="20" height="20" 
                                    class="{{ $siswa->dokumen_paspor ? 'text-green-400' : 'text-gray-500' }}"></iconify-icon>
                            </div>
                            <span class="text-white font-medium">Paspor</span>
                        </div>
                        @if($siswa->dokumen_paspor)
                            <span class="text-green-400">
                                <iconify-icon icon="mdi:check-circle" width="20" height="20"></iconify-icon>
                            </span>
                        @else
                            <span class="text-gray-500">
                                <iconify-icon icon="mdi:close-circle" width="20" height="20"></iconify-icon>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Visa -->
                <div class="bg-gray-700/30 rounded-lg p-4 border {{ $siswa->dokumen_visa ? 'border-green-500/30' : 'border-gray-600/50' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="p-2 {{ $siswa->dokumen_visa ? 'bg-green-500/20' : 'bg-gray-700' }} rounded-lg">
                                <iconify-icon icon="mdi:passport" width="20" height="20" 
                                    class="{{ $siswa->dokumen_visa ? 'text-green-400' : 'text-gray-500' }}"></iconify-icon>
                            </div>
                            <span class="text-white font-medium">Visa</span>
                        </div>
                        @if($siswa->dokumen_visa)
                            <span class="text-green-400">
                                <iconify-icon icon="mdi:check-circle" width="20" height="20"></iconify-icon>
                            </span>
                        @else
                            <span class="text-gray-500">
                                <iconify-icon icon="mdi:close-circle" width="20" height="20"></iconify-icon>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- COE -->
                <div class="bg-gray-700/30 rounded-lg p-4 border {{ $siswa->dokumen_coe ? 'border-green-500/30' : 'border-gray-600/50' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="p-2 {{ $siswa->dokumen_coe ? 'bg-green-500/20' : 'bg-gray-700' }} rounded-lg">
                                <iconify-icon icon="mdi:file-certificate" width="20" height="20" 
                                    class="{{ $siswa->dokumen_coe ? 'text-green-400' : 'text-gray-500' }}"></iconify-icon>
                            </div>
                            <span class="text-white font-medium">COE</span>
                        </div>
                        @if($siswa->dokumen_coe)
                            <span class="text-green-400">
                                <iconify-icon icon="mdi:check-circle" width="20" height="20"></iconify-icon>
                            </span>
                        @else
                            <span class="text-gray-500">
                                <iconify-icon icon="mdi:close-circle" width="20" height="20"></iconify-icon>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            @php
                $totalDokumen = 3;
                $dokumenLengkap = 0;
                if ($siswa->dokumen_paspor) $dokumenLengkap++;
                if ($siswa->dokumen_visa) $dokumenLengkap++;
                if ($siswa->dokumen_coe) $dokumenLengkap++;
                $progressPersen = ($dokumenLengkap / $totalDokumen) * 100;
            @endphp
            
            <div class="mt-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-400 text-sm">Kelengkapan Dokumen</span>
                    <span class="text-white text-sm font-semibold">{{ $dokumenLengkap }}/{{ $totalDokumen }}</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-500 to-green-500 h-2 rounded-full" 
                         style="width: {{ $progressPersen }}%"></div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection