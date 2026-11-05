@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header with Glassmorphism Effect -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <iconify-icon icon="mdi:family-tree" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Kartu Keluarga</h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola data kartu keluarga Anda</p>
                </div>
            </div>
            
            @if($siswa->kartuKeluarga)
            <button onclick="openKKModal()" 
                    class="w-full sm:w-auto bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm sm:text-base">
                <iconify-icon icon="mdi:pencil" width="18" height="18" class="sm:w-5 sm:h-5"></iconify-icon>
                <span>Edit Data KK</span>
            </button>
            @else
            <button onclick="openKKModal()" 
                    class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm sm:text-base">
                <iconify-icon icon="mdi:plus" width="18" height="18" class="sm:w-5 sm:h-5"></iconify-icon>
                <span>Lengkapi Data KK</span>
            </button>
            @endif
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

    @if ($errors->any())
    <div class="mb-4 bg-red-500/10 border-l-4 border-red-500 text-red-400 p-4 rounded-lg animate-slideDown">
        <div class="flex items-center gap-3 mb-2">
            <iconify-icon icon="mdi:alert" width="20" height="20" class="text-red-500"></iconify-icon>
            <span class="font-semibold">Terdapat kesalahan:</span>
        </div>
        <ul class="list-disc list-inside space-y-1 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if($siswa->kartuKeluarga)
    <!-- Data Kartu Keluarga Card -->
    <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-0 md:rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
        <!-- Card Header -->
        <div class="p-4 sm:p-6 border-b border-gray-700/50 bg-gray-900/30">
            <div class="flex items-center gap-2">
                <div class="p-2 bg-blue-500/10 rounded-lg">
                    <iconify-icon icon="mdi:family-tree" width="20" height="20" class="text-blue-400"></iconify-icon>
                </div>
                <h2 class="text-lg sm:text-xl font-bold text-white">Data Kartu Keluarga</h2>
                @if($siswa->kartuKeluarga->foto_kk)
                <div class="ml-auto">
                    <a href="{{ asset('storage/'.$siswa->kartuKeluarga->foto_kk) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm transition-all duration-300">
                        <iconify-icon icon="mdi:image" width="16" height="16"></iconify-icon>
                        <span>Lihat Foto KK</span>
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Card Body - Grid Layout -->
        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Nomor KK -->
                <div class="bg-gray-700/20 p-4 rounded-xl border border-gray-700/30 hover:border-blue-500/30 transition-all duration-300 group">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-1.5 bg-blue-500/10 rounded-lg group-hover:bg-blue-500/20 transition-colors">
                            <iconify-icon icon="mdi:identifier" width="14" height="14" class="text-blue-400"></iconify-icon>
                        </div>
                        <span class="text-gray-400 text-xs uppercase tracking-wider">Nomor KK</span>
                    </div>
                    <p class="text-white font-medium text-sm sm:text-base break-words">{{ $siswa->kartuKeluarga->nomor_kk }}</p>
                </div>

                <!-- Tanggal Dikeluarkan -->
                <div class="bg-gray-700/20 p-4 rounded-xl border border-gray-700/30 hover:border-green-500/30 transition-all duration-300 group">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-1.5 bg-green-500/10 rounded-lg group-hover:bg-green-500/20 transition-colors">
                            <iconify-icon icon="mdi:calendar" width="14" height="14" class="text-green-400"></iconify-icon>
                        </div>
                        <span class="text-gray-400 text-xs uppercase tracking-wider">Tanggal Dikeluarkan</span>
                    </div>
                    <p class="text-white font-medium text-sm sm:text-base">
                        {{ \Carbon\Carbon::parse($siswa->kartuKeluarga->tanggal_dikeluarkan)->locale('id')->translatedFormat('d F Y') }}
                    </p>
                </div>

                <!-- Nama Kepala Dinas -->
                <div class="bg-gray-700/20 p-4 rounded-xl border border-gray-700/30 hover:border-purple-500/30 transition-all duration-300 group">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-1.5 bg-purple-500/10 rounded-lg group-hover:bg-purple-500/20 transition-colors">
                            <iconify-icon icon="mdi:account-tie" width="14" height="14" class="text-purple-400"></iconify-icon>
                        </div>
                        <span class="text-gray-400 text-xs uppercase tracking-wider">Kepala Dinas</span>
                    </div>
                    <p class="text-white font-medium text-sm sm:text-base break-words">{{ $siswa->kartuKeluarga->nama_kepala_dinas }}</p>
                </div>

                <!-- NIP Kepala Dinas -->
                <div class="bg-gray-700/20 p-4 rounded-xl border border-gray-700/30 hover:border-orange-500/30 transition-all duration-300 group">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-1.5 bg-orange-500/10 rounded-lg group-hover:bg-orange-500/20 transition-colors">
                            <iconify-icon icon="mdi:card-account-details" width="14" height="14" class="text-orange-400"></iconify-icon>
                        </div>
                        <span class="text-gray-400 text-xs uppercase tracking-wider">NIP Kepala Dinas</span>
                    </div>
                    <p class="text-white font-medium text-sm sm:text-base">{{ $siswa->kartuKeluarga->nip_kepala_dinas }}</p>
                </div>

                <!-- Golongan Darah -->
                <div class="bg-gray-700/20 p-4 rounded-xl border border-gray-700/30 hover:border-red-500/30 transition-all duration-300 group">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-1.5 bg-red-500/10 rounded-lg group-hover:bg-red-500/20 transition-colors">
                            <iconify-icon icon="mdi:blood-bag" width="14" height="14" class="text-red-400"></iconify-icon>
                        </div>
                        <span class="text-gray-400 text-xs uppercase tracking-wider">Golongan Darah</span>
                    </div>
                    <p class="text-white font-medium text-sm sm:text-base">
                        {{ $siswa->kartuKeluarga->ada_golongan_darah ? 'Ya' : 'Tidak' }}
                    </p>
                </div>

                <!-- RT/RW -->
                <div class="bg-gray-700/20 p-4 rounded-xl border border-gray-700/30 hover:border-cyan-500/30 transition-all duration-300 group">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-1.5 bg-cyan-500/10 rounded-lg group-hover:bg-cyan-500/20 transition-colors">
                            <iconify-icon icon="mdi:sign-direction" width="14" height="14" class="text-cyan-400"></iconify-icon>
                        </div>
                        <span class="text-gray-400 text-xs uppercase tracking-wider">RT/RW</span>
                    </div>
                    <p class="text-white font-medium text-sm sm:text-base">{{ $siswa->kartuKeluarga->rt_rw ?? '-' }}</p>
                </div>
            </div>

            <!-- Alamat Section - Full Width -->
            <div class="mt-6 space-y-4">
                <!-- Alamat Keluarga -->
                <div class="bg-gray-700/20 p-4 rounded-xl border border-gray-700/30 hover:border-blue-500/30 transition-all duration-300">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="p-1.5 bg-blue-500/10 rounded-lg">
                            <iconify-icon icon="mdi:map-marker" width="16" height="16" class="text-blue-400"></iconify-icon>
                        </div>
                        <span class="text-gray-400 text-xs uppercase tracking-wider">Alamat Keluarga</span>
                    </div>
                    <p class="text-white text-sm sm:text-base break-words">{{ $siswa->kartuKeluarga->alamat_keluarga }}</p>
                </div>

                <!-- Alamat Katakana -->
                @if($siswa->kartuKeluarga->alamat_keluarga_katakana)
                <div class="bg-gray-700/20 p-4 rounded-xl border border-gray-700/30 hover:border-purple-500/30 transition-all duration-300">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="p-1.5 bg-purple-500/10 rounded-lg">
                            <iconify-icon icon="mdi:translate" width="16" height="16" class="text-purple-400"></iconify-icon>
                        </div>
                        <span class="text-gray-400 text-xs uppercase tracking-wider">Alamat (Katakana)</span>
                    </div>
                    <p class="text-white text-sm sm:text-base break-words">{{ $siswa->kartuKeluarga->alamat_keluarga_katakana }}</p>
                </div>
                @endif

                <!-- Wilayah Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-gray-700/20 p-3 rounded-lg border border-gray-700/30">
                        <span class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                            <iconify-icon icon="mdi:map" width="12" height="12"></iconify-icon>
                            Provinsi
                        </span>
                        <p class="text-white text-sm">{{ $siswa->kartuKeluarga->provinsi }}</p>
                    </div>
                    <div class="bg-gray-700/20 p-3 rounded-lg border border-gray-700/30">
                        <span class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                            <iconify-icon icon="mdi:map-marker" width="12" height="12"></iconify-icon>
                            Kabupaten/Kota
                        </span>
                        <p class="text-white text-sm">{{ $siswa->kartuKeluarga->kabupaten }}</p>
                    </div>
                    <div class="bg-gray-700/20 p-3 rounded-lg border border-gray-700/30">
                        <span class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                            <iconify-icon icon="mdi:map-marker-radius" width="12" height="12"></iconify-icon>
                            Kecamatan
                        </span>
                        <p class="text-white text-sm">{{ $siswa->kartuKeluarga->kecamatan }}</p>
                    </div>
                    <div class="bg-gray-700/20 p-3 rounded-lg border border-gray-700/30">
                        <span class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                            <iconify-icon icon="mdi:home-map-marker" width="12" height="12"></iconify-icon>
                            Desa/Kelurahan
                        </span>
                        <p class="text-white text-sm">{{ $siswa->kartuKeluarga->desa }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Footer -->
        <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
            <div class="flex items-center gap-2 text-gray-400 text-xs sm:text-sm">
                <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
                <span>Data terakhir diperbarui: {{ $siswa->kartuKeluarga->updated_at->diffForHumans() }}</span>
            </div>
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-2xl p-8 sm:p-12 text-center backdrop-blur-sm">
        <div class="relative inline-block">
            <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full"></div>
            <div class="relative bg-gray-800 w-20 h-20 sm:w-24 sm:h-24 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                <iconify-icon icon="mdi:family-tree-off" width="32" height="32" class="text-gray-600 sm:w-10 sm:h-10"></iconify-icon>
            </div>
        </div>
        <h3 class="text-lg sm:text-xl font-bold text-white mb-2">Data Kartu Keluarga Belum Dilengkapi</h3>
        <p class="text-gray-500 text-sm sm:text-base max-w-md mx-auto mb-6">
            Lengkapi data kartu keluarga Anda untuk memudahkan proses administrasi selanjutnya.
        </p>
        <button onclick="openKKModal()" 
                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl text-sm sm:text-base font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <iconify-icon icon="mdi:plus" width="18" height="18"></iconify-icon>
            Lengkapi Data KK Sekarang
        </button>
    </div>
    @endif

    <!-- Modal Form Kartu Keluarga -->
    <div id="kkModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md transition-all duration-300">
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-4xl rounded-2xl border border-gray-700/50 shadow-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 sm:p-6 border-b border-gray-700/50">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-500/10 rounded-lg">
                        <iconify-icon icon="mdi:family-tree" width="24" height="24" class="text-blue-400"></iconify-icon>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-white">
                        {{ $siswa->kartuKeluarga ? 'Edit Data Kartu Keluarga' : 'Tambah Data Kartu Keluarga' }}
                    </h2>
                </div>
                <button onclick="closeKKModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                    <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
                </button>
            </div>

            <!-- Modal Body -->
            <form method="POST"
                  action="{{ $siswa->kartuKeluarga ? route('kartu-keluarga.update') : route('kartu-keluarga.store') }}"
                  enctype="multipart/form-data"">
                @csrf
                @if($siswa->kartuKeluarga)
                    @method('PUT')
                @endif

                <div class="space-y-4 p-4 sm:p-6 max-h-[70vh] overflow-y-auto">
                    <!-- Baris 1: Nomor KK & Tanggal Dikeluarkan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1 flex items-center gap-1">
                                Nomor KK <span class="text-red-400">*</span>
                            </label>
                            <input type="text"
                                name="nomor_kk"
                                value="{{ old('nomor_kk', $siswa->kartuKeluarga->nomor_kk ?? '') }}"
                                placeholder="Masukkan nomor KK"
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                required>
                        </div>

                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1 flex items-center gap-1">
                                Tanggal Dikeluarkan <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                    name="tanggal_dikeluarkan"
                                    id="tanggal_dikeluarkan_input"
                                    value="{{ old('tanggal_dikeluarkan', isset($siswa->kartuKeluarga->tanggal_dikeluarkan) ? $siswa->kartuKeluarga->tanggal_dikeluarkan->format('Y-m-d') : '') }}"
                                    placeholder="Pilih tanggal"
                                    class="flatpickr-input w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm cursor-pointer"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Baris 2: Alamat Keluarga -->
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-1 flex items-center gap-1">
                            Alamat Keluarga <span class="text-red-400">*</span>
                        </label>
                        <textarea name="alamat_keluarga"
                                  rows="2"
                                  placeholder="Masukkan alamat lengkap"
                                  class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                  required>{{ old('alamat_keluarga', $siswa->kartuKeluarga->alamat_keluarga ?? '') }}</textarea>
                    </div>

                    <!-- Baris 3: Alamat Katakana -->
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-1 flex items-center gap-1">
                            Alamat Keluarga (Katakana)
                        </label>
                        <textarea name="alamat_keluarga_katakana"
                                  rows="2"
                                  placeholder="Alamat dalam huruf katakana"
                                  class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">{{ old('alamat_keluarga_katakana', $siswa->kartuKeluarga->alamat_keluarga_katakana ?? '') }}</textarea>
                    </div>

                    <!-- Baris 4: Wilayah Indonesia (Select2) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1">Provinsi <span class="text-red-400">*</span></label>
                            <select name="provinsi" id="provinsi" class="select2-input w-full" required></select>
                        </div>
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1">Kabupaten/Kota <span class="text-red-400">*</span></label>
                            <select name="kabupaten" id="kabupaten" class="select2-input w-full" required></select>
                        </div>
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1">Kecamatan <span class="text-red-400">*</span></label>
                            <select name="kecamatan" id="kecamatan" class="select2-input w-full" required></select>
                        </div>
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1">Desa/Kelurahan <span class="text-red-400">*</span></label>
                            <select name="desa" id="desa" class="select2-input w-full" required></select>
                        </div>
                    </div>

                    <!-- Baris 5: RT/RW & Golongan Darah -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1 flex items-center gap-1">
                                RT/RW
                            </label>
                            <input type="text"
                                name="rt_rw"
                                value="{{ old('rt_rw', $siswa->kartuKeluarga->rt_rw ?? '') }}"
                                placeholder="Contoh: 001/002"
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                        </div>

                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1 flex items-center gap-1">
                                Golongan Darah <span class="text-red-400">*</span>
                            </label>
                            <div class="flex flex-wrap gap-6 mt-2">
                                <!-- Ya Option -->
                                <label class="relative flex items-center cursor-pointer group">
                                    <input type="radio" name="ada_golongan_darah" value="1" class="hidden peer" 
                                        {{ old('ada_golongan_darah', isset($siswa->kartuKeluarga) ? $siswa->kartuKeluarga->ada_golongan_darah : '') == '1' ? 'checked' : '' }} required>
                                    <div class="w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-blue-500 peer-checked:border-[6px] transition-all duration-200 group-hover:border-blue-400"></div>
                                    <div class="ml-3 flex items-center gap-2">
                                        <span class="text-white group-hover:text-blue-400 transition-colors text-sm">Tercantum</span>
                                    </div>
                                </label>

                                <!-- Tidak Option -->
                                <label class="relative flex items-center cursor-pointer group">
                                    <input type="radio" name="ada_golongan_darah" value="0" class="hidden peer"
                                        {{ old('ada_golongan_darah', isset($siswa->kartuKeluarga) ? $siswa->kartuKeluarga->ada_golongan_darah : '') == '0' ? 'checked' : '' }}>
                                    <div class="w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-red-500 peer-checked:border-[6px] transition-all duration-200 group-hover:border-red-400"></div>
                                    <div class="ml-3 flex items-center gap-2">
                                        <span class="text-white group-hover:text-red-400 transition-colors text-sm">Tidak Ada</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Baris 6: Nama & NIP Kepala Dinas -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1 flex items-center gap-1">
                                Nama Kepala Dinas <span class="text-red-400">*</span>
                            </label>
                            <input type="text"
                                name="nama_kepala_dinas"
                                value="{{ old('nama_kepala_dinas', $siswa->kartuKeluarga->nama_kepala_dinas ?? '') }}"
                                placeholder="Nama kepala dinas"
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                required>
                        </div>

                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1 flex items-center gap-1">
                                NIP Kepala Dinas <span class="text-red-400">*</span>
                            </label>
                            <input type="text"
                                name="nip_kepala_dinas"
                                value="{{ old('nip_kepala_dinas', $siswa->kartuKeluarga->nip_kepala_dinas ?? '') }}"
                                placeholder="NIP kepala dinas"
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                required>
                        </div>
                    </div>

                    <!-- Baris 7: Upload Foto KK -->
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-1 flex items-center gap-1">
                            Foto KK
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="file"
                                name="foto_kk"
                                id="foto_kk"
                                accept="image/*"
                                class="hidden">
                            <label for="foto_kk"
                                class="cursor-pointer inline-flex items-center gap-2 bg-gray-700 hover:bg-gray-600 border border-gray-600 rounded-lg px-4 py-3 text-white transition-all duration-200">
                                <iconify-icon icon="mdi:cloud-upload" width="18" height="18"></iconify-icon>
                                <span class="text-sm">Pilih File</span>
                            </label>
                            <span class="text-sm text-gray-400" id="file-name">Tidak ada file dipilih</span>
                        </div>
                        @if($siswa->kartuKeluarga && $siswa->kartuKeluarga->foto_kk)
                        <div class="mt-2">
                            <a href="{{ asset('storage/'.$siswa->kartuKeluarga->foto_kk) }}"
                               target="_blank"
                               class="text-blue-400 hover:text-blue-300 text-sm flex items-center gap-1">
                                <iconify-icon icon="mdi:eye" width="16" height="16"></iconify-icon>
                                Lihat foto saat ini
                            </a>
                        </div>
                        @endif
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="bg-blue-500/5 border border-blue-500/20 rounded-lg p-3 flex items-start gap-3 mt-4">
                        <iconify-icon icon="mdi:information" width="18" height="18" class="text-blue-400 flex-shrink-0 mt-0.5"></iconify-icon>
                        <p class="text-gray-400 text-xs">
                            Field dengan tanda <span class="text-red-400">*</span> wajib diisi. Pastikan data yang dimasukkan sesuai dengan dokumen resmi.
                        </p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-700/50">
                    <button type="button"
                        onclick="closeKKModal()"
                        class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-blue-900/20">
                        <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
    .bg-gray-700\/20 {
        transition: all 0.3s ease;
    }

    .bg-gray-700\/20:hover {
        transform: translateY(-2px);
    }

    /* Radio Button Custom Styling */
    .peer:checked ~ div:first-of-type {
        animation: radioPulse 0.3s ease-out;
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

    /* Select2 Custom Dark Theme */
    .select2-container--default .select2-selection--single {
        background-color: #374151 !important;
        border-color: #4B5563 !important;
        height: 46px !important;
        border-radius: 0.5rem !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: white !important;
        line-height: 46px !important;
        padding-left: 16px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 44px !important;
        right: 8px !important;
    }

    .select2-dropdown {
        background-color: #1F2937 !important;
        border-color: #4B5563 !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
    }

    .select2-container--default .select2-results__option {
        color: #e5e7eb !important;
        padding: 8px 12px !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #2563EB !important;
        color: white !important;
    }

    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #374151 !important;
        color: white !important;
    }

    .select2-search__field {
        background-color: #374151 !important;
        color: white !important;
        border-color: #4B5563 !important;
        border-radius: 0.375rem !important;
        padding: 6px !important;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #4B5563 !important;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        outline: none !important;
        border-color: #3b82f6 !important;
    }
</style>

<script>
// File upload preview
document.getElementById('foto_kk')?.addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Tidak ada file dipilih';
    document.getElementById('file-name').textContent = fileName;
});

// Modal functions
function openKKModal() {
    const modal = document.getElementById('kkModal');
    const modalContent = modal.querySelector('.modal-show');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    document.body.style.overflow = 'hidden';
}

function closeKKModal() {
    const modal = document.getElementById('kkModal');
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
        closeKKModal();
    }
});

// Close modal when clicking outside
document.getElementById('kkModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeKKModal();
    }
});

// Select2 initialization in modal
$(document).ready(function () {
    // Initialize Flatpickr
    flatpickr("#tanggal_dikeluarkan_input", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "j F Y",
        theme: "dark",
        locale: "id"
    });

    const provinsi = $('#provinsi');
    const kabupaten = $('#kabupaten');
    const kecamatan = $('#kecamatan');
    const desa = $('#desa');

    // Data Existing (untuk Edit)
    const savedProvinsi = "{{ $siswa->kartuKeluarga->provinsi ?? '' }}";
    const savedKabupaten = "{{ $siswa->kartuKeluarga->kabupaten ?? '' }}";
    const savedKecamatan = "{{ $siswa->kartuKeluarga->kecamatan ?? '' }}";
    const savedDesa = "{{ $siswa->kartuKeluarga->desa ?? '' }}";

    // Initialize Select2
    $('.select2-input').select2({
        dropdownParent: $('#kkModal'),
        width: '100%',
        minimumResultsForSearch: 5
    });

    // ============================================================
    // FUNCTIONS TO LOAD DATA
    // ============================================================

    function loadRegencies(provId, preSelected = null) {
        kabupaten.html('<option value="">Loading...</option>').trigger('change');
        kecamatan.html('<option value="">Pilih Kecamatan</option>').trigger('change');
        desa.html('<option value="">Pilih Desa</option>').trigger('change');

        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`)
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">Pilih Kabupaten/Kota</option>';
                let selectedId = null;
                data.forEach(item => {
                    let isSelected = (item.name === preSelected) ? 'selected' : '';
                    if(isSelected) selectedId = item.id;
                    options += `<option value="${item.name}" data-id="${item.id}" ${isSelected}>${item.name}</option>`;
                });
                kabupaten.html(options).trigger('change');

                // Chain load if preSelected exists
                if (selectedId && preSelected) {
                    loadDistricts(selectedId, savedKecamatan);
                }
            });
    }

    function loadDistricts(regencyId, preSelected = null) {
        kecamatan.html('<option value="">Loading...</option>').trigger('change');
        desa.html('<option value="">Pilih Desa</option>').trigger('change');

        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regencyId}.json`)
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">Pilih Kecamatan</option>';
                let selectedId = null;
                data.forEach(item => {
                    let isSelected = (item.name === preSelected) ? 'selected' : '';
                    if(isSelected) selectedId = item.id;
                    options += `<option value="${item.name}" data-id="${item.id}" ${isSelected}>${item.name}</option>`;
                });
                kecamatan.html(options).trigger('change');

                if (selectedId && preSelected) {
                    loadVillages(selectedId, savedDesa);
                }
            });
    }

    function loadVillages(districtId, preSelected = null) {
        desa.html('<option value="">Loading...</option>').trigger('change');

        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${districtId}.json`)
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">Pilih Desa/Kelurahan</option>';
                data.forEach(item => {
                    let isSelected = (item.name === preSelected) ? 'selected' : '';
                    options += `<option value="${item.name}" ${isSelected}>${item.name}</option>`;
                });
                desa.html(options).trigger('change');
            });
    }

    // ============================================================
    // INITIAL LOAD (PROVINSI)
    // ============================================================
    fetch("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json")
        .then(res => res.json())
        .then(data => {
            let options = '<option value="">Pilih Provinsi</option>';
            let selectedId = null;
            data.forEach(item => {
                let isSelected = (item.name === savedProvinsi) ? 'selected' : '';
                if(isSelected) selectedId = item.id;
                options += `<option value="${item.name}" data-id="${item.id}" ${isSelected}>${item.name}</option>`;
            });
            provinsi.html(options).trigger('change');

            if (selectedId && savedProvinsi) {
                loadRegencies(selectedId, savedKabupaten);
            }
        });

    // ============================================================
    // EVENT LISTENERS (USER INTERACTION)
    // ============================================================
    provinsi.on('change', function () {
        let id = $(this).find(':selected').data('id');
        if (id) {
            loadRegencies(id);
        }
    });

    kabupaten.on('change', function () {
        let id = $(this).find(':selected').data('id');
        if (id) {
            loadDistricts(id);
        }
    });

    kecamatan.on('change', function () {
        let id = $(this).find(':selected').data('id');
        if (id) {
            loadVillages(id);
        }
    });
});
</script>
@endsection