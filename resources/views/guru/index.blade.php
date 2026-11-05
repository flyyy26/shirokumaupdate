@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header with Glassmorphism Effect -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <iconify-icon icon="mdi:teach" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Data Guru</h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola data guru pengajar</p>
                </div>
            </div>
            
            <button onclick="openGuruModal()" 
                    class="w-full sm:w-auto bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm sm:text-base">
                <iconify-icon icon="mdi:plus" width="18" height="18" class="sm:w-5 sm:h-5"></iconify-icon>
                <span>Tambah Guru</span>
            </button>
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

    <!-- Desktop Table View (hidden on mobile) -->
    <div class="hidden md:block bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
        <div class="p-4 sm:p-6 border-b border-gray-700/50">
            <h2 class="text-lg sm:text-xl font-bold text-white flex items-center gap-2">
                <iconify-icon icon="mdi:format-list-bulleted" width="20" height="20" class="text-blue-400"></iconify-icon>
                Daftar Guru
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 text-gray-400 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Foto</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Nama</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Level</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Usia</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Status</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($gurus as $guru)
                    <tr class="hover:bg-gray-700/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-1 h-8 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                @if($guru->foto)
                                <img src="{{ asset('storage/'.$guru->foto) }}" 
                                     class="w-10 h-10 object-cover rounded-lg border-2 border-gray-600 group-hover:border-blue-500 transition-all">
                                @else
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">{{ substr($guru->nama_lengkap, 0, 1) }}</span>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-white font-medium">{{ $guru->nama_lengkap }}</div>
                            <div class="text-gray-400 text-xs">{{ $guru->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-xs font-medium">
                                {{ $guru->level_diampu }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-300">{{ $guru->usia }} Tahun</td>
                        <td class="px-6 py-4">
                            @if($guru->status == 'aktif')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-red-500/10 text-red-500 border border-red-500/20">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                Tidak Aktif
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openGuruModal({{ $guru->id }})" 
                                        class="bg-yellow-600/20 hover:bg-yellow-600/40 text-yellow-400 p-2 rounded-lg transition-all duration-300 group"
                                        title="Edit">
                                    <iconify-icon icon="mdi:pencil" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                </button>
                                
                                <button onclick="deleteGuru({{ $guru->id }})" 
                                        class="bg-red-600/20 hover:bg-red-600/40 text-red-400 p-2 rounded-lg transition-all duration-300 group"
                                        title="Hapus">
                                    <iconify-icon icon="mdi:delete" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="bg-gray-700/30 p-4 rounded-full">
                                    <iconify-icon icon="mdi:teach" width="40" height="40" class="text-gray-600"></iconify-icon>
                                </div>
                                <p class="text-gray-500 text-sm">Belum ada data guru</p>
                                <button onclick="openGuruModal()" 
                                        class="mt-2 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-all">
                                    <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                                    Tambah Guru Pertama
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($gurus->count() > 0)
        <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
            <div class="flex items-center gap-2 text-gray-400 text-sm">
                <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
                <span>Total {{ $gurus->count() }} guru terdaftar</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Mobile Card View (visible only on mobile) -->
    <div class="md:hidden space-y-4">
        @forelse($gurus as $guru)
        <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
            <!-- Card Header -->
            <div class="p-4 border-b border-gray-700/50 bg-gray-900/30">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @if($guru->foto)
                        <img src="{{ asset('storage/'.$guru->foto) }}" 
                             class="w-12 h-12 object-cover rounded-lg border-2 border-gray-600">
                        @else
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">{{ substr($guru->nama_lengkap, 0, 1) }}</span>
                        </div>
                        @endif
                        <div>
                            <h3 class="text-white font-semibold">{{ $guru->nama_lengkap }}</h3>
                            <p class="text-gray-400 text-xs">{{ $guru->email }}</p>
                        </div>
                    </div>
                    @if($guru->status == 'aktif')
                    <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs border border-green-500/30">
                        Aktif
                    </span>
                    @else
                    <span class="bg-red-500/20 text-red-400 px-2 py-1 rounded-full text-xs border border-red-500/30">
                        Nonaktif
                    </span>
                    @endif
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-4 space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-700/20 p-3 rounded-lg">
                        <p class="text-gray-400 text-xs flex items-center gap-1">
                            <iconify-icon icon="mdi:school" width="12" height="12"></iconify-icon>
                            Level
                        </p>
                        <p class="text-white text-sm font-medium">{{ $guru->level_diampu }}</p>
                    </div>
                    <div class="bg-gray-700/20 p-3 rounded-lg">
                        <p class="text-gray-400 text-xs flex items-center gap-1">
                            <iconify-icon icon="mdi:calendar" width="12" height="12"></iconify-icon>
                            Usia
                        </p>
                        <p class="text-white text-sm">{{ $guru->usia }} Tahun</p>
                    </div>
                </div>
                
                @if($guru->alamat)
                <div class="bg-gray-700/20 p-3 rounded-lg">
                    <p class="text-gray-400 text-xs flex items-center gap-1">
                        <iconify-icon icon="mdi:map-marker" width="12" height="12"></iconify-icon>
                        Alamat
                    </p>
                    <p class="text-white text-sm">{{ $guru->alamat }}</p>
                </div>
                @endif
            </div>

            <!-- Card Footer -->
            <div class="p-4 border-t border-gray-700/50 bg-gray-900/30 flex justify-end gap-2">
                <button onclick="openGuruModal({{ $guru->id }})" 
                        class="flex-1 inline-flex items-center justify-center gap-2 bg-yellow-600/20 hover:bg-yellow-600/40 text-yellow-400 px-3 py-2 rounded-lg transition-all duration-300 text-sm">
                    <iconify-icon icon="mdi:pencil" width="16" height="16"></iconify-icon>
                    <span>Edit</span>
                </button>
                
                <button onclick="deleteGuru({{ $guru->id }})" 
                        class="flex-1 inline-flex items-center justify-center gap-2 bg-red-600/20 hover:bg-red-600/40 text-red-400 px-3 py-2 rounded-lg transition-all duration-300 text-sm">
                    <iconify-icon icon="mdi:delete" width="16" height="16"></iconify-icon>
                    <span>Hapus</span>
                </button>
            </div>
        </div>
        @empty
        <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-2xl p-8 text-center backdrop-blur-sm">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full"></div>
                <div class="relative bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                    <iconify-icon icon="mdi:teach" width="32" height="32" class="text-gray-600"></iconify-icon>
                </div>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Belum Ada Data Guru</h3>
            <p class="text-gray-500 text-sm max-w-xs mx-auto mb-4">
                Anda belum menambahkan data guru. Silakan tambah guru baru.
            </p>
            <button onclick="openGuruModal()" 
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300">
                <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                Tambah Guru
            </button>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Form Guru (Create/Edit) -->
<div id="guruModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md transition-all duration-300">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-2xl rounded-2xl border border-gray-700/50 shadow-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500/10 rounded-lg">
                    <iconify-icon id="modalIcon" icon="mdi:account-plus" width="24" height="24" class="text-blue-400"></iconify-icon>
                </div>
                <h2 id="modalTitle" class="text-lg sm:text-xl font-bold text-white">Tambah Data Guru</h2>
            </div>
            <button onclick="closeGuruModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="guruForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="guru_id" id="guruId">

            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <!-- Nama Lengkap -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:account" width="14" height="14"></iconify-icon>
                        Nama Lengkap <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" 
                           placeholder="Masukkan nama lengkap"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                           required>
                </div>

                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:account" width="14" height="14"></iconify-icon>
                        Nama Panggilan <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="nama_panggilan" id="nama_panggilan" 
                           placeholder="Masukkan nama lengkap"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                           required>
                </div>

                <!-- Level Diampu -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:school" width="14" height="14"></iconify-icon>
                        Level Diampu <span class="text-red-400">*</span>
                    </label>
                    <select name="level_diampu" id="level_diampu" 
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                            required>
                        <option value="">Pilih Level</option>
                        <option value="N1">N1</option>
                        <option value="N2">N2</option>
                        <option value="N3">N3</option>
                        <option value="N4">N4</option>
                        <option value="N5">N5</option>
                    </select>
                </div>

                <!-- Tempat & Tanggal Lahir -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:city" width="14" height="14"></iconify-icon>
                            Tempat Lahir <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" 
                               placeholder="Kota lahir"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                               required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:calendar" width="14" height="14"></iconify-icon>
                            Tanggal Lahir <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="tanggal_lahir" id="tanggal_lahir" 
                               placeholder="dd/mm/yyyy"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                               required>
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:gender-male-female" width="14" height="14"></iconify-icon>
                        Jenis Kelamin <span class="text-red-400">*</span>
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 text-white">
                            <input type="radio" name="jenis_kelamin" value="L" class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 focus:ring-blue-500">
                            <span class="text-sm">Laki-laki</span>
                        </label>
                        <label class="flex items-center gap-2 text-white">
                            <input type="radio" name="jenis_kelamin" value="P" class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 focus:ring-blue-500">
                            <span class="text-sm">Perempuan</span>
                        </label>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:map-marker" width="14" height="14"></iconify-icon>
                        Alamat <span class="text-red-400">*</span>
                    </label>
                    <textarea name="alamat" id="alamat" rows="2"
                              placeholder="Alamat lengkap"
                              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                              required></textarea>
                </div>

                <!-- No HP -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:phone" width="14" height="14"></iconify-icon>
                        No. HP <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="no_hp" id="no_hp" 
                           placeholder="081234567890"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                           required>
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:account-check" width="14" height="14"></iconify-icon>
                        Status <span class="text-red-400">*</span>
                    </label>
                    <select name="status" id="status" 
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                            required>
                        <option value="">Pilih Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Tidak Aktif</option>
                    </select>
                </div>

                <!-- Foto -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:camera" width="14" height="14"></iconify-icon>
                        Foto Profil
                    </label>
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-gray-700 rounded-lg border border-gray-600 overflow-hidden flex items-center justify-center" id="photoPreview">
                                <iconify-icon icon="mdi:camera-plus" width="24" height="24" class="text-gray-500"></iconify-icon>
                            </div>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="foto" id="foto" accept="image/*" class="hidden">
                            <label for="foto" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg cursor-pointer transition-all text-sm">
                                <iconify-icon icon="mdi:cloud-upload" width="18" height="18"></iconify-icon>
                                Pilih Foto
                            </label>
                            <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG. Maksimal 2MB</p>
                            <p class="text-xs text-gray-500" id="file-name">Tidak ada file dipilih</p>
                        </div>
                    </div>
                    <div id="currentPhoto" class="hidden mt-2">
                        <p class="text-xs text-gray-400">Foto saat ini:</p>
                        <img id="currentPhotoImg" src="" class="w-12 h-12 object-cover rounded-lg mt-1">
                    </div>
                </div>

                <!-- Informasi Tambahan -->
                <div class="bg-blue-500/5 border border-blue-500/20 rounded-lg p-3 flex items-start gap-2 mt-4">
                    <iconify-icon icon="mdi:information" width="16" height="16" class="text-blue-400 flex-shrink-0 mt-0.5"></iconify-icon>
                    <p class="text-gray-400 text-xs">
                        Field dengan tanda <span class="text-red-400">*</span> wajib diisi. Pastikan data yang dimasukkan sesuai.
                    </p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 p-4 border-t border-gray-700/50">
                <button type="button"
                    onclick="closeGuruModal()"
                    class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                    Batal
                </button>
                <button type="submit"
                    id="submitBtn"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-blue-900/20">
                    <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                    <span id="submitText">Simpan Data</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md transition-all duration-300">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-md rounded-2xl border border-gray-700/50 shadow-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-3 bg-red-500/10 rounded-full">
                    <iconify-icon icon="mdi:alert" width="28" height="28" class="text-red-400"></iconify-icon>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Hapus Data Guru</h3>
                    <p class="text-sm text-gray-400">Apakah Anda yakin?</p>
                </div>
            </div>
            
            <p class="text-gray-300 text-sm mb-6">
                Data guru yang dihapus tidak dapat dikembalikan. Pastikan Anda yakin dengan keputusan ini.
            </p>
            
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-3">
                    <button type="button"
                        onclick="closeDeleteModal()"
                        class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2">
                        <iconify-icon icon="mdi:delete" width="16" height="16"></iconify-icon>
                        Hapus
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

    /* Focus states */
    input:focus, select:focus, textarea:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
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
    // Data guru (untuk edit)
    const gurus = @json($gurus);

    // Modal functions
    function openGuruModal(id = null) {
        const modal = document.getElementById('guruModal');
        const modalContent = modal.querySelector('.modal-show');
        const modalTitle = document.getElementById('modalTitle');
        const modalIcon = document.getElementById('modalIcon');
        const form = document.getElementById('guruForm');
        const formMethod = document.getElementById('formMethod');
        const submitText = document.getElementById('submitText');
        
        // Reset form
        form.reset();
        document.getElementById('photoPreview').innerHTML = '<iconify-icon icon="mdi:camera-plus" width="24" height="24" class="text-gray-500"></iconify-icon>';
        document.getElementById('file-name').textContent = 'Tidak ada file dipilih';
        document.getElementById('currentPhoto').classList.add('hidden');
        
        if (id) {
            // Edit mode
            const guru = gurus.find(g => g.id === id);
            if (guru) {
                modalTitle.textContent = 'Edit Data Guru';
                modalIcon.setAttribute('icon', 'mdi:pencil');
                submitText.textContent = 'Update Data';
                formMethod.value = 'PUT';
                form.action = `/guru/${id}`;
                
                // Fill form with data
                document.getElementById('nama_lengkap').value = guru.nama_lengkap;
                document.getElementById('nama_panggilan').value = guru.nama_panggilan;
                document.getElementById('level_diampu').value = guru.level_diampu;
                document.getElementById('tempat_lahir').value = guru.tempat_lahir;
                
                // Konversi format tanggal dari YYYY-MM-DD ke DD/MM/YYYY untuk input text
                if (guru.tanggal_lahir) {
                    const dateParts = guru.tanggal_lahir.split('-');
                    if (dateParts.length === 3) {
                        document.getElementById('tanggal_lahir').value = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`;
                    }
                }
                
                document.querySelector(`input[name="jenis_kelamin"][value="${guru.jenis_kelamin}"]`).checked = true;
                document.getElementById('alamat').value = guru.alamat;
                document.getElementById('no_hp').value = guru.no_hp;
                document.getElementById('status').value = guru.status;
                
                // Show current photo if exists
                if (guru.foto) {
                    document.getElementById('currentPhotoImg').src = '/storage/' + guru.foto;
                    document.getElementById('currentPhoto').classList.remove('hidden');
                }
            }
        } else {
            // Create mode
            modalTitle.textContent = 'Tambah Data Guru';
            modalIcon.setAttribute('icon', 'mdi:account-plus');
            submitText.textContent = 'Simpan Data';
            formMethod.value = 'POST';
            form.action = '{{ route("guru.store") }}';
        }
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        document.body.style.overflow = 'hidden';
    }

    function closeGuruModal() {
        const modal = document.getElementById('guruModal');
        const modalContent = modal.querySelector('.modal-show');
        
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);
    }

    // Delete functions
    function deleteGuru(id) {
        const modal = document.getElementById('deleteModal');
        const modalContent = modal.querySelector('.modal-show');
        const deleteForm = document.getElementById('deleteForm');
        
        deleteForm.action = `/guru/${id}`;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const modalContent = modal.querySelector('.modal-show');
        
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);
    }

    // Photo preview
    document.getElementById('foto')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileName = document.getElementById('file-name');
        const preview = document.getElementById('photoPreview');
        
        if (file) {
            fileName.textContent = file.name;
            
            // Check file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB');
                this.value = '';
                fileName.textContent = 'Tidak ada file dipilih';
                preview.innerHTML = '<iconify-icon icon="mdi:camera-plus" width="24" height="24" class="text-gray-500"></iconify-icon>';
                return;
            }
            
            // Check file type
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar (JPG/PNG)');
                this.value = '';
                fileName.textContent = 'Tidak ada file dipilih';
                preview.innerHTML = '<iconify-icon icon="mdi:camera-plus" width="24" height="24" class="text-gray-500"></iconify-icon>';
                return;
            }
            
            // Preview image
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            };
            reader.readAsDataURL(file);
        } else {
            fileName.textContent = 'Tidak ada file dipilih';
            preview.innerHTML = '<iconify-icon icon="mdi:camera-plus" width="24" height="24" class="text-gray-500"></iconify-icon>';
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeGuruModal();
            closeDeleteModal();
        }
    });

    // Close modal when clicking outside
    document.getElementById('guruModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeGuruModal();
        }
    });

    document.getElementById('deleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endsection