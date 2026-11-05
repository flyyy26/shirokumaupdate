@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header with Glassmorphism Effect -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <iconify-icon icon="mdi:office-building" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Data Perusahaan</h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola data perusahaan mitra</p>
                </div>
            </div>
            
            <button onclick="openCreateModal()" 
                    class="w-full sm:w-auto bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm sm:text-base">
                <iconify-icon icon="mdi:plus" width="18" height="18" class="sm:w-5 sm:h-5"></iconify-icon>
                <span>Tambah Perusahaan</span>
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
                Daftar Perusahaan
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 text-gray-400 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Nama Perusahaan</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">PIC</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Prefektur</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Bidang Usaha</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($companies as $company)
                    <tr class="hover:bg-gray-700/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-8 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                @if($company->logo)
                                    <img src="{{ asset('storage/' . $company->logo) }}" 
                                         class="w-10 h-10 rounded-lg object-cover border-2 border-gray-600 group-hover:border-blue-500 transition-all">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($company->nama_perusahaan, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-white font-medium">{{ $company->nama_perusahaan }}</div>
                                    @if($company->nama_jepang)
                                    <div class="text-gray-400 text-xs">{{ $company->nama_jepang }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-white">{{ $company->nama_pic ?? '-' }}</div>
                            @if($company->jabatan_pic)
                            <div class="text-gray-400 text-xs">{{ $company->jabatan_pic }}</div>
                            @endif
                            @if($company->no_hp_pic)
                            <div class="text-gray-500 text-xs flex items-center gap-1 mt-1">
                                <iconify-icon icon="mdi:phone" width="10" height="10"></iconify-icon>
                                {{ $company->no_hp_pic }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-xs font-medium">
                                {{ $company->prefektur ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($company->bidang_usaha)
                                <div class="flex flex-wrap gap-1">
                                    @foreach($company->bidang_usaha as $bidang)
                                        <span class="bg-green-500/20 text-green-400 px-2 py-0.5 rounded-full text-xs">
                                            {{ $bidang }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-600">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Kelola Job -->
                                <a href="{{ route('perusahaan.show', $company->id) }}" 
                                   class="bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 p-2 rounded-lg transition-all duration-300 group"
                                   title="Kelola Job">
                                    <iconify-icon icon="mdi:briefcase" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                </a>

                                <!-- Edit -->
                                <button onclick='openEditModal(@json($company))' 
                                        class="bg-yellow-600/20 hover:bg-yellow-600/40 text-yellow-400 p-2 rounded-lg transition-all duration-300 group"
                                        title="Edit">
                                    <iconify-icon icon="mdi:pencil" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                </button>

                                <!-- Delete -->
                                <form action="{{ route('perusahaan.destroy', $company->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus perusahaan ini?')" 
                                            class="bg-red-600/20 hover:bg-red-600/40 text-red-400 p-2 rounded-lg transition-all duration-300 group"
                                            title="Hapus">
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
                                    <iconify-icon icon="mdi:office-building" width="40" height="40" class="text-gray-600"></iconify-icon>
                                </div>
                                <p class="text-gray-500 text-sm">Belum ada data perusahaan</p>
                                <button onclick="openCreateModal()" 
                                        class="mt-2 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-all">
                                    <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                                    Tambah Perusahaan Pertama
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($companies->count() > 0)
        <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
            <div class="flex items-center gap-2 text-gray-400 text-sm">
                <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
                <span>Total {{ $companies->count() }} perusahaan terdaftar</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Mobile Card View (visible only on mobile) -->
    <div class="md:hidden space-y-4">
        @forelse($companies as $company)
        <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
            <!-- Card Header -->
            <div class="p-4 border-b border-gray-700/50 bg-gray-900/30">
                <div class="flex items-center gap-3">
                    @if($company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}" 
                             class="w-12 h-12 rounded-lg object-cover border-2 border-gray-600">
                    @else
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                            {{ substr($company->nama_perusahaan, 0, 1) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <h3 class="text-white font-semibold">{{ $company->nama_perusahaan }}</h3>
                        @if($company->nama_jepang)
                        <p class="text-gray-400 text-xs">{{ $company->nama_jepang }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-4 space-y-3">
                <!-- Prefektur -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-blue-500/10 rounded-lg">
                        <iconify-icon icon="mdi:map-marker" width="16" height="16" class="text-blue-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Prefektur</p>
                        <p class="text-white text-sm">{{ $company->prefektur ?? '-' }}</p>
                    </div>
                </div>

                <!-- PIC -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-purple-500/10 rounded-lg">
                        <iconify-icon icon="mdi:account-tie" width="16" height="16" class="text-purple-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">PIC</p>
                        <p class="text-white text-sm">{{ $company->nama_pic ?? '-' }}</p>
                        @if($company->jabatan_pic)
                        <p class="text-gray-500 text-xs">{{ $company->jabatan_pic }}</p>
                        @endif
                        @if($company->no_hp_pic)
                        <p class="text-gray-500 text-xs flex items-center gap-1 mt-1">
                            <iconify-icon icon="mdi:phone" width="10" height="10"></iconify-icon>
                            {{ $company->no_hp_pic }}
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Bidang Usaha -->
                @if($company->bidang_usaha)
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-green-500/10 rounded-lg">
                        <iconify-icon icon="mdi:domain" width="16" height="16" class="text-green-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Bidang Usaha</p>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach($company->bidang_usaha as $bidang)
                                <span class="bg-green-500/20 text-green-400 px-2 py-0.5 rounded-full text-xs">
                                    {{ $bidang }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Email & Website -->
                <div class="grid grid-cols-2 gap-2">
                    @if($company->email_pic || $company->email)
                    <div class="bg-gray-700/20 p-2 rounded-lg">
                        <p class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                            <iconify-icon icon="mdi:email" width="10" height="10"></iconify-icon>
                            Email
                        </p>
                        <a href="mailto:{{ $company->email_pic ?? $company->email }}" 
                           class="text-blue-400 text-xs break-words">
                            {{ $company->email_pic ?? $company->email }}
                        </a>
                    </div>
                    @endif

                    @if($company->website)
                    <div class="bg-gray-700/20 p-2 rounded-lg">
                        <p class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                            <iconify-icon icon="mdi:web" width="10" height="10"></iconify-icon>
                            Website
                        </p>
                        <a href="{{ $company->website }}" target="_blank" 
                           class="text-blue-400 text-xs break-words">
                            {{ parse_url($company->website, PHP_URL_HOST) }}
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Alamat -->
                @if($company->alamat)
                <div class="bg-gray-700/20 p-3 rounded-lg">
                    <p class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                        <iconify-icon icon="mdi:map-marker" width="12" height="12"></iconify-icon>
                        Alamat
                    </p>
                    <p class="text-white text-sm">{{ $company->alamat }}</p>
                </div>
                @endif
            </div>

            <!-- Card Footer with Actions -->
            <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
                <div class="grid grid-cols-3 gap-2">
                    <!-- Kelola Job -->
                    <a href="{{ route('perusahaan.show', $company->id) }}" 
                       class="flex items-center justify-center gap-1 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-2 py-2 rounded-lg transition-all duration-300 text-xs">
                        <iconify-icon icon="mdi:briefcase" width="14" height="14"></iconify-icon>
                        <span>Jobs</span>
                    </a>

                    <!-- Edit -->
                    <button onclick='openEditModal(@json($company))' 
                            class="flex items-center justify-center gap-1 bg-yellow-600/20 hover:bg-yellow-600/40 text-yellow-400 px-2 py-2 rounded-lg transition-all duration-300 text-xs">
                        <iconify-icon icon="mdi:pencil" width="14" height="14"></iconify-icon>
                        <span>Edit</span>
                    </button>

                    <!-- Delete -->
                    <form action="{{ route('perusahaan.destroy', $company->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus perusahaan ini?')" 
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
                <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full"></div>
                <div class="relative bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                    <iconify-icon icon="mdi:office-building" width="32" height="32" class="text-gray-600"></iconify-icon>
                </div>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Belum Ada Data Perusahaan</h3>
            <p class="text-gray-500 text-sm max-w-xs mx-auto mb-4">
                Anda belum menambahkan data perusahaan. Silakan tambah perusahaan baru.
            </p>
            <button onclick="openCreateModal()" 
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300">
                <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                Tambah Perusahaan
            </button>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Create/Edit Perusahaan -->
<div id="modal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md px-4">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-3xl rounded-2xl border border-gray-700/50 shadow-2xl transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500/10 rounded-lg">
                    <iconify-icon id="modalIcon" icon="mdi:office-building-plus" width="24" height="24" class="text-blue-400"></iconify-icon>
                </div>
                <h2 id="modalTitle" class="text-lg sm:text-xl font-bold text-white">Tambah Perusahaan</h2>
            </div>
            <button onclick="closeModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="companyForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="POST">

            <div class="space-y-4 p-6 max-h-[70vh] overflow-y-auto">
                <!-- Logo Upload -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:image" width="14" height="14"></iconify-icon>
                        Logo Perusahaan
                    </label>
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-gray-700 rounded-lg border border-gray-600 overflow-hidden flex items-center justify-center" id="logoPreview">
                                <iconify-icon icon="mdi:image-plus" width="24" height="24" class="text-gray-500"></iconify-icon>
                            </div>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="logo" id="logo" accept="image/*" class="hidden">
                            <label for="logo" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg cursor-pointer transition-all text-sm">
                                <iconify-icon icon="mdi:cloud-upload" width="18" height="18"></iconify-icon>
                                Pilih Logo
                            </label>
                            <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG. Maksimal 2MB</p>
                            <p class="text-xs text-gray-500" id="logo-file-name">Tidak ada file dipilih</p>
                        </div>
                    </div>
                    <div id="currentLogoContainer" class="hidden mt-2">
                        <p class="text-xs text-gray-400">Logo saat ini:</p>
                        <img id="currentLogo" src="" class="w-12 h-12 object-cover rounded-lg mt-1">
                    </div>
                </div>

                <!-- Nama Perusahaan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:office-building" width="14" height="14"></iconify-icon>
                            Nama Perusahaan <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="nama_perusahaan" id="nama_perusahaan" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                               placeholder="PT. Contoh Abadi">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:translate" width="14" height="14"></iconify-icon>
                            Nama Perusahaan (Jepang)
                        </label>
                        <input type="text" name="nama_jepang" id="nama_jepang"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                               placeholder="会社名 (日本語)">
                    </div>
                </div>

                <!-- Prefektur & Alamat -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:map-marker" width="14" height="14"></iconify-icon>
                            Prefektur <span class="text-red-400">*</span>
                        </label>
                        <select name="prefektur" id="prefektur" required
                                class="select2 w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                            <option value="">Pilih Prefektur</option>
                            @foreach([
                                'Hokkaido','Aomori','Iwate','Miyagi','Akita','Yamagata','Fukushima',
                                'Ibaraki','Tochigi','Gunma','Saitama','Chiba','Tokyo','Kanagawa',
                                'Niigata','Toyama','Ishikawa','Fukui','Yamanashi','Nagano','Gifu','Shizuoka','Aichi',
                                'Mie','Shiga','Kyoto','Osaka','Hyogo','Nara','Wakayama',
                                'Tottori','Shimane','Okayama','Hiroshima','Yamaguchi',
                                'Tokushima','Kagawa','Ehime','Kochi',
                                'Fukuoka','Saga','Nagasaki','Kumamoto','Oita','Miyazaki','Kagoshima','Okinawa'
                            ] as $pref)
                                <option value="{{ $pref }}">{{ $pref }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:map-marker" width="14" height="14"></iconify-icon>
                            Alamat
                        </label>
                        <input type="text" name="alamat" id="alamat"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                               placeholder="Alamat lengkap">
                    </div>
                </div>

                <!-- PIC Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:account-tie" width="14" height="14"></iconify-icon>
                            Nama PIC
                        </label>
                        <input type="text" name="nama_pic" id="nama_pic"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                               placeholder="Nama penanggung jawab">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:translate" width="14" height="14"></iconify-icon>
                            Nama PIC (Jepang)
                        </label>
                        <input type="text" name="nama_pic_jepang" id="nama_pic_jepang"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                               placeholder="担当者名 (日本語)">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:badge-account" width="14" height="14"></iconify-icon>
                            Jabatan PIC
                        </label>
                        <input type="text" name="jabatan_pic" id="jabatan_pic"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                               placeholder="Contoh: Direktur">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:phone" width="14" height="14"></iconify-icon>
                            No. HP PIC
                        </label>
                        <input type="text" name="no_hp_pic" id="no_hp_pic"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                               placeholder="081234567890">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:email" width="14" height="14"></iconify-icon>
                            Email PIC
                        </label>
                        <input type="email" name="email_pic" id="email_pic"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                               placeholder="pic@perusahaan.com">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:web" width="14" height="14"></iconify-icon>
                            Website
                        </label>
                        <input type="url" name="website" id="website"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                            placeholder="https://www.example.com">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:domain" width="14" height="14"></iconify-icon>
                        Bidang Usaha
                    </label>
                    <select name="bidang_usaha[]" id="bidang_usaha" multiple
                            class="select2 w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                        <option value="Konstruksi">Konstruksi</option>
                        <option value="Manufaktur">Manufaktur</option>
                        <option value="Pertanian">Pertanian</option>
                        <option value="Perhotelan">Perhotelan</option>
                        <option value="Perikanan">Perikanan</option>
                        <option value="Teknologi Informasi">Teknologi Informasi</option>
                        <option value="Keuangan">Keuangan</option>
                        <option value="Pendidikan">Pendidikan</option>
                        <option value="Kesehatan">Kesehatan</option>
                        <option value="Transportasi">Transportasi</option>
                        <option value="Perdagangan">Perdagangan</option>
                        <option value="Jasa">Jasa</option>
                    </select>
                    <p class="text-xs text-gray-500">Tekan Ctrl untuk memilih lebih dari satu</p>
                </div>

                <!-- Informasi Tambahan -->
                <div class="bg-blue-500/5 border border-blue-500/20 rounded-lg p-3 flex items-start gap-2">
                    <iconify-icon icon="mdi:information" width="16" height="16" class="text-blue-400 flex-shrink-0 mt-0.5"></iconify-icon>
                    <p class="text-gray-400 text-xs">
                        Field dengan tanda <span class="text-red-400">*</span> wajib diisi. Pastikan data yang dimasukkan sesuai.
                    </p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 p-4 border-t border-gray-700/50">
                <button type="button"
                    onclick="closeModal()"
                    class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                    Batal
                </button>
                <button type="submit"
                    id="submitBtn"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-blue-900/20">
                    <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                    <span id="submitText">Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

    /* Select2 Dark Theme Customization */
    /* Single Select (Prefektur) */
    .select2-container--default .select2-selection--single {
        background-color: #374151 !important; /* bg-gray-700 */
        border-color: #4B5563 !important; /* border-gray-600 */
        border-radius: 0.5rem !important; /* rounded-lg */
        height: 48px !important;
        display: flex !important;
        align-items: center !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: white !important;
        line-height: 48px !important;
        padding-left: 1rem !important; /* px-4 */
        padding-right: 2rem !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #9CA3AF !important; /* text-gray-400 */
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px !important;
        right: 10px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #9CA3AF transparent transparent transparent !important;
    }

    /* Multiple Select (Bidang Usaha) */
    .select2-container--default .select2-selection--multiple {
        background-color: #374151 !important;
        border-color: #4B5563 !important;
        border-radius: 0.5rem !important;
        min-height: 48px !important;
        padding: 4px !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #1F2937 !important; /* bg-gray-800 */
        border-color: #4B5563 !important;
        color: #E5E7EB !important; /* text-gray-200 */
        border-radius: 0.375rem !important;
        padding: 4px 8px !important;
        margin-top: 5px !important;
        margin-left: 5px !important;
        display: flex;
        align-items: center;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #9CA3AF !important;
        border-right: 1px solid #4B5563 !important;
        margin-right: 8px !important;
        padding-right: 8px !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        background-color: transparent !important;
        color: #EF4444 !important; /* text-red-500 */
    }

    /* Dropdown & Search */
    .select2-dropdown {
        background-color: #1F2937 !important; /* bg-gray-800 */
        border-color: #4B5563 !important;
        border-radius: 0.5rem !important;
        overflow: hidden !important;
        z-index: 9999 !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5) !important;
    }

    .select2-container--default .select2-results__option {
        padding: 10px 16px !important;
        color: #D1D5DB !important; /* text-gray-300 */
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #3B82F6 !important; /* bg-blue-500 */
        color: white !important;
    }

    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #374151 !important;
        color: white !important;
    }

    .select2-search--dropdown .select2-search__field {
        background-color: #374151 !important;
        border: 1px solid #4B5563 !important;
        color: white !important;
        border-radius: 0.375rem !important;
        padding: 8px 12px !important;
        margin: 8px !important;
        width: calc(100% - 16px) !important;
    }

    .select2-container--default .select2-search--inline .select2-search__field {
        margin-top: 6px !important;
        margin-left: 8px !important;
        color: white !important;
    }

    .select2-container--default .select2-search--inline .select2-search__field::placeholder {
        color: #9CA3AF !important;
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
    // Initialize Select2
    $(document).ready(function() {
        $('#bidang_usaha').select2({
            dropdownParent: $('#modal'),
            width: '100%',
            placeholder: 'Pilih bidang usaha',
            allowClear: true
        });

        $('#prefektur').select2({
            dropdownParent: $('#modal'),
            width: '100%',
            placeholder: 'Pilih prefektur',
            allowClear: true
        });
    });

    // Logo preview
    document.getElementById('logo')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileName = document.getElementById('logo-file-name');
        const preview = document.getElementById('logoPreview');
        
        if (file) {
            fileName.textContent = file.name;
            
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB');
                this.value = '';
                fileName.textContent = 'Tidak ada file dipilih';
                preview.innerHTML = '<iconify-icon icon="mdi:image-plus" width="24" height="24" class="text-gray-500"></iconify-icon>';
                return;
            }
            
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar (JPG/PNG)');
                this.value = '';
                fileName.textContent = 'Tidak ada file dipilih';
                preview.innerHTML = '<iconify-icon icon="mdi:image-plus" width="24" height="24" class="text-gray-500"></iconify-icon>';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            };
            reader.readAsDataURL(file);
        } else {
            fileName.textContent = 'Tidak ada file dipilih';
            preview.innerHTML = '<iconify-icon icon="mdi:image-plus" width="24" height="24" class="text-gray-500"></iconify-icon>';
        }
    });

    // Modal functions
    function openCreateModal() {
        const modal = document.getElementById('modal');
        const modalContent = modal.querySelector('.modal-show');
        
        document.getElementById('modalTitle').textContent = 'Tambah Perusahaan';
        document.getElementById('modalIcon').setAttribute('icon', 'mdi:office-building-plus');
        document.getElementById('submitText').textContent = 'Simpan';
        document.getElementById('companyForm').action = "{{ route('perusahaan.store') }}";
        document.getElementById('methodField').value = 'POST';
        
        // Reset form
        document.getElementById('companyForm').reset();
        document.getElementById('logoPreview').innerHTML = '<iconify-icon icon="mdi:image-plus" width="24" height="24" class="text-gray-500"></iconify-icon>';
        document.getElementById('logo-file-name').textContent = 'Tidak ada file dipilih';
        document.getElementById('currentLogoContainer').classList.add('hidden');
        
        // Reset Select2
        $('#bidang_usaha').val(null).trigger('change');
        $('#prefektur').val(null).trigger('change');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        document.body.style.overflow = 'hidden';
    }

    function openEditModal(company) {
        const modal = document.getElementById('modal');
        const modalContent = modal.querySelector('.modal-show');
        
        document.getElementById('modalTitle').textContent = 'Edit Perusahaan';
        document.getElementById('modalIcon').setAttribute('icon', 'mdi:pencil');
        document.getElementById('submitText').textContent = 'Update';
        document.getElementById('companyForm').action = "/perusahaan/" + company.id;
        document.getElementById('methodField').value = 'PUT';
        
        // Fill form with company data
        document.getElementById('nama_perusahaan').value = company.nama_perusahaan || '';
        document.getElementById('nama_jepang').value = company.nama_jepang || '';
        document.getElementById('alamat').value = company.alamat || '';
        document.getElementById('nama_pic').value = company.nama_pic || '';
        document.getElementById('nama_pic_jepang').value = company.nama_pic_jepang || '';
        document.getElementById('jabatan_pic').value = company.jabatan_pic || '';
        document.getElementById('no_hp_pic').value = company.no_hp_pic || '';
        document.getElementById('email_pic').value = company.email_pic || '';
        document.getElementById('website').value = company.website || '';
        
        // Set Select2 values
        $('#prefektur').val(company.prefektur || null).trigger('change');
        $('#bidang_usaha').val(company.bidang_usaha || null).trigger('change');
        
        // Show current logo if exists
        if (company.logo) {
            document.getElementById('currentLogo').src = '/storage/' + company.logo;
            document.getElementById('currentLogoContainer').classList.remove('hidden');
        } else {
            document.getElementById('currentLogoContainer').classList.add('hidden');
        }
        
        // Reset logo preview
        document.getElementById('logoPreview').innerHTML = '<iconify-icon icon="mdi:image-plus" width="24" height="24" class="text-gray-500"></iconify-icon>';
        document.getElementById('logo-file-name').textContent = 'Tidak ada file dipilih';
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('modal');
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
            closeModal();
        }
    });

    // Close modal when clicking outside
    document.getElementById('modal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
@endsection