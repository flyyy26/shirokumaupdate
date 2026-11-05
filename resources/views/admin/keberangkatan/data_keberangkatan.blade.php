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
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">
                    {{ $keberangkatan ? 'Edit Data Keberangkatan' : 'Tambah Data Keberangkatan' }}
                </h1>
                <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">
                    Siswa: <span class="font-semibold">{{ $siswa->nama_lengkap }}</span> ({{ $siswa->nomor_paspor ?? 'Paspor belum diisi' }})
                </p>
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

    @if($errors->any())
    <div class="mb-4 bg-red-500/10 border-l-4 border-red-500 text-red-400 p-4 rounded-lg animate-slideDown">
        <div class="flex items-center gap-3 mb-2">
            <iconify-icon icon="mdi:alert" width="20" height="20" class="text-red-500"></iconify-icon>
            <span class="font-semibold">Terdapat {{ $errors->count() }} kesalahan:</span>
        </div>
        <ul class="list-disc list-inside space-y-1 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Keberangkatan (2 kolom di desktop) -->
        <div class="lg:col-span-2">
            <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
                <!-- Card Header -->
                <div class="p-4 sm:p-6 border-b border-gray-700/50 bg-gradient-to-r from-blue-600/10 to-purple-600/10">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-500/10 rounded-lg">
                            <iconify-icon icon="mdi:airplane-takeoff" width="20" height="20" class="text-blue-400"></iconify-icon>
                        </div>
                        <h2 class="text-lg font-bold text-white">Informasi Keberangkatan</h2>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-4 sm:p-6">
                    <form action="{{ $keberangkatan ? route('keberangkatan.update', $keberangkatan->id) : route('keberangkatan.store') }}" 
                          method="POST">
                        @csrf
                        @if($keberangkatan)
                            @method('PUT')
                        @endif

                        <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">

                        <div class="space-y-4">
                            <!-- Tanggal & Jam -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-300 flex items-center gap-1">
                                        <iconify-icon icon="mdi:calendar" width="16" height="16" class="text-blue-400"></iconify-icon>
                                        Tanggal Berangkat
                                    </label>
                                    <div class="relative">
                                        <input type="date" name="tanggal_berangkat" 
                                               value="{{ old('tanggal_berangkat', $keberangkatan->tanggal_berangkat ?? '') }}"
                                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                                        <iconify-icon icon="mdi:calendar" width="16" height="16" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none"></iconify-icon>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-300 flex items-center gap-1">
                                        <iconify-icon icon="mdi:clock-outline" width="16" height="16" class="text-blue-400"></iconify-icon>
                                        Jam Keberangkatan
                                    </label>
                                    <div class="relative">
                                        <input type="time" name="jam_keberangkatan" 
                                               value="{{ old('jam_keberangkatan', $keberangkatan->jam_keberangkatan ?? '') }}"
                                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                                        <iconify-icon icon="mdi:clock-outline" width="16" height="16" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none"></iconify-icon>
                                    </div>
                                </div>
                            </div>

                            <!-- Bandara Asal & Tujuan -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-300 flex items-center gap-1">
                                        <iconify-icon icon="mdi:airport" width="16" height="16" class="text-blue-400"></iconify-icon>
                                        Bandara Asal
                                    </label>
                                    <input type="text" name="bandara_asal" 
                                           value="{{ old('bandara_asal', $keberangkatan->bandara_asal ?? '') }}"
                                           placeholder="Contoh: Soekarno-Hatta (CGK)"
                                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-300 flex items-center gap-1">
                                        <iconify-icon icon="mdi:airport" width="16" height="16" class="text-blue-400"></iconify-icon>
                                        Bandara Tujuan
                                    </label>
                                    <input type="text" name="bandara_tujuan" 
                                           value="{{ old('bandara_tujuan', $keberangkatan->bandara_tujuan ?? '') }}"
                                           placeholder="Contoh: Narita (NRT)"
                                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                                </div>
                            </div>

                            <!-- Maskapai & Nomor Penerbangan -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-300 flex items-center gap-1">
                                        <iconify-icon icon="mdi:airplane" width="16" height="16" class="text-blue-400"></iconify-icon>
                                        Maskapai
                                    </label>
                                    <input type="text" name="maskapai" 
                                           value="{{ old('maskapai', $keberangkatan->maskapai ?? '') }}"
                                           placeholder="Contoh: Garuda Indonesia"
                                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-300 flex items-center gap-1">
                                        <iconify-icon icon="mdi:ticket" width="16" height="16" class="text-blue-400"></iconify-icon>
                                        Nomor Penerbangan
                                    </label>
                                    <input type="text" name="nomor_penerbangan" 
                                           value="{{ old('nomor_penerbangan', $keberangkatan->nomor_penerbangan ?? '') }}"
                                           placeholder="Contoh: GA-888"
                                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-300 flex items-center gap-1">
                                    <iconify-icon icon="mdi:note-text" width="16" height="16" class="text-blue-400"></iconify-icon>
                                    Keterangan
                                </label>
                                <textarea name="keterangan" rows="3" 
                                          placeholder="Catatan tambahan (opsional)"
                                          class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition resize-none">{{ old('keterangan', $keberangkatan->keterangan ?? '') }}</textarea>
                            </div>

                            <!-- Informasi Tambahan -->
                            <div class="bg-blue-500/5 border border-blue-500/20 rounded-lg p-3 flex items-start gap-2 mt-4">
                                <iconify-icon icon="mdi:information" width="16" height="16" class="text-blue-400 flex-shrink-0 mt-0.5"></iconify-icon>
                                <p class="text-gray-400 text-xs">
                                    Pastikan data keberangkatan diisi dengan lengkap dan benar. Informasi ini akan digunakan untuk dokumen perjalanan siswa.
                                </p>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-gray-700/50 mt-4">
                                <a href="{{ route('keberangkatan.index') }}" 
                                   class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium text-center">
                                    Batal
                                </a>
                                <button type="submit" 
                                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl">
                                    <iconify-icon icon="mdi:content-save" width="18" height="18"></iconify-icon>
                                    <span>Simpan Data Keberangkatan</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar - Dokumen Siswa (1 kolom di desktop) -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
                <!-- Card Header -->
                <div class="p-4 sm:p-6 border-b border-gray-700/50 bg-gradient-to-r from-blue-600/10 to-purple-600/10">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-yellow-500/10 rounded-lg">
                            <iconify-icon icon="mdi:file-document" width="20" height="20" class="text-yellow-400"></iconify-icon>
                        </div>
                        <h2 class="text-lg font-bold text-white">Dokumen Siswa</h2>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-4 sm:p-6">
                    <div class="space-y-4">
                        <!-- Info Siswa Ringkas -->
                        <div class="bg-gray-700/30 p-3 rounded-lg border border-gray-700/50">
                            <div class="flex items-center gap-3">
                                @if($siswa->foto)
                                    <img src="{{ asset('storage/' . $siswa->foto) }}" 
                                         class="w-10 h-10 rounded-full object-cover border border-gray-600">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($siswa->nama_lengkap, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-white text-sm font-medium">{{ $siswa->nama_lengkap }}</p>
                                    <p class="text-gray-400 text-xs">{{ $siswa->nomor_paspor ?? 'Paspor belum diisi' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Dokumen -->
                        <div class="space-y-3">
                            <!-- Dokumen Paspor -->
                            <div class="flex items-center justify-between p-3 bg-gray-700/20 rounded-lg border border-gray-700/50 hover:border-blue-500/30 transition-all">
                                <div class="flex items-center gap-2">
                                    <div class="p-1.5 bg-blue-500/10 rounded-lg">
                                        <iconify-icon icon="mdi:passport" width="16" height="16" class="text-blue-400"></iconify-icon>
                                    </div>
                                    <span class="text-sm text-white">Paspor</span>
                                </div>
                                @if($siswa->dokumen_paspor)
                                    <a href="{{ asset('storage/'.$siswa->dokumen_paspor) }}" target="_blank" 
                                       class="text-green-400 hover:text-green-300 text-sm flex items-center gap-1">
                                        <iconify-icon icon="mdi:eye" width="16" height="16"></iconify-icon>
                                        <span>Lihat</span>
                                    </a>
                                @else
                                    <span class="text-gray-500 text-sm flex items-center gap-1">
                                        <iconify-icon icon="mdi:close-circle" width="14" height="14"></iconify-icon>
                                        Belum Upload
                                    </span>
                                @endif
                            </div>

                            <!-- Dokumen COE -->
                            <div class="flex items-center justify-between p-3 bg-gray-700/20 rounded-lg border border-gray-700/50 hover:border-green-500/30 transition-all">
                                <div class="flex items-center gap-2">
                                    <div class="p-1.5 bg-green-500/10 rounded-lg">
                                        <iconify-icon icon="mdi:file-certificate" width="16" height="16" class="text-green-400"></iconify-icon>
                                    </div>
                                    <span class="text-sm text-white">COE</span>
                                </div>
                                @if($siswa->dokumen_coe)
                                    <a href="{{ asset('storage/'.$siswa->dokumen_coe) }}" target="_blank" 
                                       class="text-green-400 hover:text-green-300 text-sm flex items-center gap-1">
                                        <iconify-icon icon="mdi:eye" width="16" height="16"></iconify-icon>
                                        <span>Lihat</span>
                                    </a>
                                @else
                                    <span class="text-gray-500 text-sm flex items-center gap-1">
                                        <iconify-icon icon="mdi:close-circle" width="14" height="14"></iconify-icon>
                                        Belum Upload
                                    </span>
                                @endif
                            </div>

                            <!-- Dokumen Visa -->
                            <div class="flex items-center justify-between p-3 bg-gray-700/20 rounded-lg border border-gray-700/50 hover:border-purple-500/30 transition-all">
                                <div class="flex items-center gap-2">
                                    <div class="p-1.5 bg-purple-500/10 rounded-lg">
                                        <iconify-icon icon="mdi:card-account-details" width="16" height="16" class="text-purple-400"></iconify-icon>
                                    </div>
                                    <span class="text-sm text-white">Visa</span>
                                </div>
                                @if($siswa->dokumen_visa)
                                    <a href="{{ asset('storage/'.$siswa->dokumen_visa) }}" target="_blank" 
                                       class="text-green-400 hover:text-green-300 text-sm flex items-center gap-1">
                                        <iconify-icon icon="mdi:eye" width="16" height="16"></iconify-icon>
                                        <span>Lihat</span>
                                    </a>
                                @else
                                    <span class="text-gray-500 text-sm flex items-center gap-1">
                                        <iconify-icon icon="mdi:close-circle" width="14" height="14"></iconify-icon>
                                        Belum Upload
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Catatan Dokumen -->
                        <div class="bg-yellow-500/5 border border-yellow-500/20 rounded-lg p-3 mt-4">
                            <p class="text-gray-400 text-xs flex items-start gap-1">
                                <iconify-icon icon="mdi:alert-circle" width="14" height="14" class="text-yellow-400 flex-shrink-0 mt-0.5"></iconify-icon>
                                <span>Pastikan semua dokumen sudah diupload sebelum siswa diberangkatkan.</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="mt-4 bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm p-4">
                <div class="flex items-start gap-2">
                    <div class="p-1.5 bg-blue-500/10 rounded-lg">
                        <iconify-icon icon="mdi:information" width="16" height="16" class="text-blue-400"></iconify-icon>
                    </div>
                    <div>
                        <h4 class="text-white text-sm font-medium mb-1">Informasi Penting</h4>
                        <ul class="text-xs text-gray-400 space-y-1 list-disc list-inside">
                            <li>Isi semua data keberangkatan dengan lengkap</li>
                            <li>Pastikan jadwal sesuai dengan tiket pesawat</li>
                            <li>Dokumen harus sudah diupload sebelum keberangkatan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
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

    /* Focus states */
    input:focus, select:focus, textarea:focus {
        outline: none;
        box-shadow: 0 0 0 2px #3b82f6;
    }

    /* Custom date input styling */
    input[type="date"]::-webkit-calendar-picker-indicator,
    input[type="time"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
        opacity: 0.5;
        cursor: pointer;
    }

    input[type="date"]::-webkit-calendar-picker-indicator:hover,
    input[type="time"]::-webkit-calendar-picker-indicator:hover {
        opacity: 1;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .grid-cols-1 {
            gap: 1rem;
        }
    }
</style>
@endsection