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
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">{{ $company->nama_perusahaan }}</h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1 flex flex-wrap items-center gap-2">
                        <span>{{ implode(', ', $company->bidang_usaha ?? []) }}</span>
                        <span class="w-1 h-1 bg-blue-300 rounded-full"></span>
                        <span>Prefektur: {{ $company->prefektur }}</span>
                    </p>
                </div>
            </div>
            
            <button onclick="openModal()" 
                    class="w-full sm:w-auto bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm sm:text-base">
                <iconify-icon icon="mdi:plus" width="18" height="18" class="sm:w-5 sm:h-5"></iconify-icon>
                <span>Tambah Job</span>
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

    <!-- Jobs List -->
    <div class="space-y-6">
        @forelse($company->jobs as $job)
        <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
            <!-- Desktop Table View (hidden on mobile) -->
            <div class="hidden md:block">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-900/50 text-gray-400 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-bold border-b border-gray-700/50">Jenis Pekerjaan</th>
                                <th class="px-6 py-4 font-bold border-b border-gray-700/50">Ginou</th>
                                <th class="px-6 py-4 font-bold border-b border-gray-700/50">Kuota</th>
                                <th class="px-6 py-4 font-bold border-b border-gray-700/50">Gaji</th>
                                <th class="px-6 py-4 font-bold border-b border-gray-700/50">Lokasi</th>
                                <th class="px-6 py-4 font-bold border-b border-gray-700/50 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700/50">
                            <tr class="hover:bg-gray-700/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1 h-8 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        <span class="text-white font-medium">{{ $job->jenis_pekerjaan }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-purple-500/20 text-purple-400 px-3 py-1 rounded-full text-xs">
                                        {{ $job->jenis_ginou }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-300">{{ $job->kuota ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($job->gaji_pokok)
                                        <span class="text-green-400 font-medium">
                                            ¥{{ number_format($job->gaji_pokok,0,',','.') }}/{{ $job->tipe_gaji }}
                                        </span>
                                    @else
                                        <span class="text-gray-600">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $job->lokasi_kerja ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">

                                        <!-- Hubungkan Siswa -->
                                        <button onclick="openAssignModal({{ $job->id }}, {{ $job->siswa->pluck('id') }}, {{ $job->kuota ?? 'null' }})"
                                                class="bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 p-2 rounded-lg transition-all duration-300 group"
                                                title="Hubungkan Siswa">
                                            <iconify-icon icon="mdi:account-plus" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                        </button>
                                        <!-- Edit -->
                                        <button onclick="openEditModal({{ $job }})" 
                                                class="bg-yellow-600/20 hover:bg-yellow-600/40 text-yellow-400 p-2 rounded-lg transition-all duration-300 group"
                                                title="Edit Job">
                                            <iconify-icon icon="mdi:pencil" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                        </button>

                                        <!-- Delete -->
                                        <form method="POST" action="{{ route('job.destroy', $job->id) }}" class="inline" onsubmit="return confirm('Yakin hapus job ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-600/20 hover:bg-red-600/40 text-red-400 p-2 rounded-lg transition-all duration-300 group"
                                                    title="Hapus Job">
                                                <iconify-icon icon="mdi:delete" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View (visible only on mobile) -->
            <div class="md:hidden">
                <!-- Job Header -->
                <div class="p-4 border-b border-gray-700/50 bg-gray-900/30">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-white font-semibold">{{ $job->jenis_pekerjaan }}</h3>
                            <p class="text-gray-400 text-xs mt-1">{{ $job->jenis_ginou }}</p>
                        </div>
                        @if($job->status == 'Draft')
                            <span class="bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-full text-xs">Draft</span>
                        @elseif($job->status == 'Interview')
                            <span class="bg-blue-500/20 text-blue-400 px-2 py-1 rounded-full text-xs">Interview</span>
                        @elseif($job->status == 'Close')
                            <span class="bg-red-500/20 text-red-400 px-2 py-1 rounded-full text-xs">Close</span>
                        @endif
                    </div>
                </div>

                <!-- Job Details -->
                <div class="p-4 space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-700/20 p-3 rounded-lg">
                            <p class="text-gray-400 text-xs flex items-center gap-1">
                                <iconify-icon icon="mdi:account-group" width="12" height="12"></iconify-icon>
                                Kuota
                            </p>
                            <p class="text-white font-medium">{{ $job->kuota ?? '-' }}</p>
                        </div>
                        
                        <div class="bg-gray-700/20 p-3 rounded-lg">
                            <p class="text-gray-400 text-xs flex items-center gap-1">
                                <iconify-icon icon="mdi:cash" width="12" height="12"></iconify-icon>
                                Gaji
                            </p>
                            <p class="text-green-400 font-medium">
                                @if($job->gaji_pokok)
                                    ¥{{ number_format($job->gaji_pokok,0,',','.') }}/{{ $job->tipe_gaji }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        
                        <div class="col-span-2 bg-gray-700/20 p-3 rounded-lg">
                            <p class="text-gray-400 text-xs flex items-center gap-1">
                                <iconify-icon icon="mdi:map-marker" width="12" height="12"></iconify-icon>
                                Lokasi Kerja
                            </p>
                            <p class="text-white">{{ $job->lokasi_kerja ?? '-' }}</p>
                        </div>
                        
                        @if($job->fasilitas)
                        <div class="col-span-2 bg-gray-700/20 p-3 rounded-lg">
                            <p class="text-gray-400 text-xs flex items-center gap-1">
                                <iconify-icon icon="mdi:home" width="12" height="12"></iconify-icon>
                                Fasilitas
                            </p>
                            <p class="text-white">{{ $job->fasilitas }}</p>
                        </div>
                        @endif
                        
                        @if($job->deskripsi)
                        <div class="col-span-2 bg-gray-700/20 p-3 rounded-lg">
                            <p class="text-gray-400 text-xs flex items-center gap-1">
                                <iconify-icon icon="mdi:note-text" width="12" height="12"></iconify-icon>
                                Deskripsi
                            </p>
                            <p class="text-white text-sm">{{ $job->deskripsi }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
                    <div class="grid grid-cols-3 gap-2">
                        <button onclick="openAssignModal({{ $job->id }}, {{ $job->siswa->pluck('id') }}, {{ $job->kuota ?? 'null' }})"
                                class="flex items-center justify-center gap-1 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-2 py-2 rounded-lg transition-all duration-300 text-xs">
                            <iconify-icon icon="mdi:account-plus" width="14" height="14"></iconify-icon>
                            <span>Hubungkan</span>
                        </button>

                        <button onclick="openEditModal({{ $job }})" 
                                class="flex items-center justify-center gap-1 bg-yellow-600/20 hover:bg-yellow-600/40 text-yellow-400 px-2 py-2 rounded-lg transition-all duration-300 text-xs">
                            <iconify-icon icon="mdi:pencil" width="14" height="14"></iconify-icon>
                            <span>Edit</span>
                        </button>

                        <form method="POST" action="{{ route('job.destroy', $job->id) }}" class="inline" onsubmit="return confirm('Yakin hapus job ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" 
                                    class="w-full flex items-center justify-center gap-1 bg-red-600/20 hover:bg-red-600/40 text-red-400 px-2 py-2 rounded-lg transition-all duration-300 text-xs">
                                <iconify-icon icon="mdi:delete" width="14" height="14"></iconify-icon>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Assigned Siswa Section -->
            @if($job->siswa->isNotEmpty())
                <div class="border-t border-gray-700/50 bg-gray-900/30 p-4">
                    <div class="flex items-center justify-between cursor-pointer group" onclick="toggleSiswaList({{ $job->id }})">
                        <h4 class="text-white font-semibold flex items-center gap-2 text-sm">
                            <iconify-icon icon="mdi:account-group" width="16" height="16" class="text-blue-400"></iconify-icon>
                            Siswa Terhubung ({{ $job->siswa->count() }})
                        </h4>
                        <button class="text-gray-400 hover:text-white transition-all duration-300 transform group-hover:scale-110">
                            <iconify-icon id="chevron-{{ $job->id }}" icon="mdi:chevron-down" width="20" height="20" class="transition-transform duration-300"></iconify-icon>
                        </button>
                    </div>
                    
                    <div id="siswa-list-{{ $job->id }}" class="overflow-hidden transition-all duration-500 ease-in-out max-h-0 opacity-0 mt-0">
                        <div class="mt-4 space-y-2">
                            @include('partials.siswa-list', ['job' => $job])
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @empty
        <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-0 md:rounded-2xl p-8 text-center backdrop-blur-sm">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full"></div>
                <div class="relative bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                    <iconify-icon icon="mdi:briefcase-off" width="32" height="32" class="text-gray-600"></iconify-icon>
                </div>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Belum Ada Job</h3>
            <p class="text-gray-500 text-sm max-w-xs mx-auto mb-4">
                Perusahaan ini belum memiliki job. Silakan tambah job baru.
            </p>
            <button onclick="openModal()" 
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300">
                <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                Tambah Job Pertama
            </button>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Hubungkan Siswa -->
<div id="assignModal" class="fixed inset-0 bg-black/90 hidden items-start justify-center z-50 backdrop-blur-md overflow-y-auto py-10 px-4">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-2xl rounded-2xl border border-gray-700/50 shadow-2xl transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500/10 rounded-lg">
                    <iconify-icon icon="mdi:account-plus" width="24" height="24" class="text-blue-400"></iconify-icon>
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-white">Hubungkan Siswa</h2>
                    <p id="quota-info" class="text-sm text-gray-400"></p>
                </div>
            </div>
            <button onclick="closeAssignModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 max-h-[70vh] overflow-y-auto">
            <!-- Search Input -->
            <div class="mb-4">
                <div class="relative">
                    <input type="text" id="searchSiswa" placeholder="Cari nama siswa..." 
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg pl-10 pr-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                    <iconify-icon icon="mdi:magnify" width="18" height="18" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></iconify-icon>
                </div>
            </div>

            <form id="assignForm" method="POST">
                @csrf
                <div id="siswa-list-container" class="space-y-2 mb-4 max-h-[400px] overflow-y-auto pr-2">
                    {{-- Dinamis dari JS --}}
                </div>

                <div class="bg-blue-500/5 border border-blue-500/20 rounded-lg p-3 flex items-start gap-2 mb-4">
                    <iconify-icon icon="mdi:information" width="16" height="16" class="text-blue-400 flex-shrink-0 mt-0.5"></iconify-icon>
                    <p class="text-gray-400 text-xs">
                        Pilih siswa yang akan dihubungkan dengan job ini. Siswa yang sudah dihubungkan tidak akan ditampilkan.
                    </p>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeAssignModal()" 
                            class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-blue-900/20">
                        <iconify-icon icon="mdi:account-plus" width="16" height="16"></iconify-icon>
                        Hubungkan Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Job -->
<div id="modal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md px-4">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-3xl rounded-2xl border border-gray-700/50 shadow-2xl transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500/10 rounded-lg">
                    <iconify-icon icon="mdi:briefcase-plus" width="24" height="24" class="text-blue-400"></iconify-icon>
                </div>
                <h2 class="text-lg sm:text-xl font-bold text-white">Tambah Job Baru</h2>
            </div>
            <button onclick="closeModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <!-- Modal Body -->
        <form method="POST" action="{{ route('job.store') }}">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            <div class="space-y-4 p-6 max-h-[70vh] overflow-y-auto">
                <!-- Jenis Pekerjaan & Ginou -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:briefcase" width="14" height="14"></iconify-icon>
                            Jenis Pekerjaan <span class="text-red-400">*</span>
                        </label>
                        <select name="jenis_pekerjaan" id="jenis_pekerjaan_select" required
                                class="select2-pekerjaan w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white">
                            <option value="">Pilih Jenis Pekerjaan</option>
                            <optgroup label="Konstruksi (建設)">
                                <option value="Bekesting">Bekesting (型枠施工)</option>
                                <option value="Pemasangan Scaffolding">Pemasangan Scaffolding (足場組立)</option>
                                <option value="Pengecoran Beton">Pengecoran Beton (コンクリート打ち)</option>
                                <option value="Pemasangan Baja Tulangan">Pemasangan Baja Tulangan (鉄筋組立て)</option>
                                <option value="Pekerjaan Tanah">Pekerjaan Tanah (土工)</option>
                                <option value="Pemasangan Keramik">Pemasangan Keramik (タイル張り)</option>
                            </optgroup>
                            
                            <optgroup label="Manufaktur (製造業)">
                                <option value="Pengolahan Makanan">Pengolahan Makanan (飲食料品製造)</option>
                                <option value="Penyusunan Komponen Elektronik">Elektronik (電気・電子情報関連)</option>
                                <option value="Pengelasan">Pengelasan (溶接)</option>
                                <option value="Pengepresan Logam">Pengepresan Logam (金属プレス)</option>
                                <option value="Permesinan">Permesinan (機械加工)</option>
                                <option value="Pengecatan">Pengecatan (塗装)</option>
                            </optgroup>

                            <optgroup label="Pertanian & Peternakan (農業・畜産)">
                                <option value="Pertanian Tanaman Pangan">Pertanian (耕種農業)</option>
                                <option value="Peternakan Ayam">Peternakan Ayam (養鶏業)</option>
                                <option value="Peternakan Babi">Peternakan Babi (養豚業)</option>
                                <option value="Peternakan Sapi">Peternakan Sapi (酪農)</option>
                            </optgroup>

                            <optgroup label="Lainnya (その他)">
                                <option value="Perawat / Kaigo">Perawat / Kaigo (介護)</option>
                                <option value="Pembersihan Gedung">Pembersihan Gedung (ビルクリーニング)</option>
                                <option value="Perhotelan">Perhotelan (宿泊)</option>
                                <option value="Restoran">Restoran (外食業)</option>
                                <option value="Laundry">Laundry (リネンサプライ)</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:card-account-details" width="14" height="14"></iconify-icon>
                            Jenis Ginou <span class="text-red-400">*</span>
                        </label>
                        <select name="jenis_ginou" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                            <option value="Tokutei Ginou">特定技能履歴書 (Visa Kerja)</option>
                            <option value="Ginojisshusei">技能実習生履歴書 (Visa Magang)</option>
                        </select>
                    </div>
                </div>

                <!-- Kuota & Tanggal Interview -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:account-group" width="14" height="14"></iconify-icon>
                            Kuota
                        </label>
                        <input type="number" name="kuota" placeholder="Jumlah kuota" min="1"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:calendar" width="14" height="14"></iconify-icon>
                            Tanggal Interview
                        </label>
                        <input type="date" name="tanggal_interview"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                    </div>
                </div>

                <!-- Gaji -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:cash" width="14" height="14"></iconify-icon>
                            Gaji Pokok (JPY)
                        </label>
                        <input type="number" name="gaji_pokok" placeholder="Contoh: 150000"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:clock-outline" width="14" height="14"></iconify-icon>
                            Tipe Gaji
                        </label>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <!-- Per Jam -->
                            <label class="relative flex items-center justify-center cursor-pointer group">
                                <input type="radio" name="tipe_gaji" value="jam" class="hidden peer" checked>
                                <div class="w-full bg-gray-700 border-2 border-gray-600 rounded-xl px-4 py-3 text-white transition-all duration-300 
                                            peer-checked:border-blue-500 peer-checked:bg-blue-500/10 peer-checked:shadow-lg peer-checked:shadow-blue-500/20
                                            hover:border-blue-400 group-hover:scale-[1.02]">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="relative">
                                                <div class="w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-blue-500 
                                                            transition-all duration-300 group-hover:border-blue-400
                                                            peer-checked:border-6 peer-checked:border-blue-500">
                                                </div>
                                                <div class="absolute inset-0 flex items-center justify-center opacity-0 peer-checked:opacity-100 
                                                            transition-opacity duration-300">
                                                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-white text-sm">Per Jam</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Per Bulan -->
                            <label class="relative flex items-center justify-center cursor-pointer group">
                                <input type="radio" name="tipe_gaji" value="bulan" class="hidden peer">
                                <div class="w-full bg-gray-700 border-2 border-gray-600 rounded-xl px-4 py-3 text-white transition-all duration-300 
                                            peer-checked:border-green-500 peer-checked:bg-green-500/10 peer-checked:shadow-lg peer-checked:shadow-green-500/20
                                            hover:border-green-400 group-hover:scale-[1.02]">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="relative">
                                                <div class="w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-green-500 
                                                            transition-all duration-300 group-hover:border-green-400
                                                            peer-checked:border-6 peer-checked:border-green-500">
                                                </div>
                                                <div class="absolute inset-0 flex items-center justify-center opacity-0 peer-checked:opacity-100 
                                                            transition-opacity duration-300">
                                                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-white text-sm">Per Bulan</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Lembur & Estimasi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:clock-plus" width="14" height="14"></iconify-icon>
                            Status Lembur
                        </label>
                        <label class="flex items-center gap-3 w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 cursor-pointer hover:border-blue-500 transition-colors">
                            <input type="checkbox" name="lembur" value="1" class="w-5 h-5 bg-gray-800 border-gray-500 rounded text-blue-500 focus:ring-blue-500 focus:ring-offset-gray-800">
                            <span class="text-white text-sm">Tersedia Lembur</span>
                        </label>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:clock-alert" width="14" height="14"></iconify-icon>
                            Estimasi Jam Lembur
                        </label>
                        <input type="number" name="estimasi_lembur_jam" placeholder="Jam per bulan"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                    </div>
                </div>

                <!-- Kontrak & Lokasi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:calendar-clock" width="14" height="14"></iconify-icon>
                            Kontrak (tahun)
                        </label>
                        <input type="number" name="kontrak_tahun" placeholder="Contoh: 2"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:map-marker" width="14" height="14"></iconify-icon>
                            Lokasi Kerja
                        </label>
                        <input type="text" name="lokasi_kerja" placeholder="Kota, Prefektur"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                    </div>
                </div>

                <!-- Fasilitas & Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:home" width="14" height="14"></iconify-icon>
                            Fasilitas
                        </label>
                        <input type="text" name="fasilitas" placeholder="Mess/Tidak"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:flag" width="14" height="14"></iconify-icon>
                            Status
                        </label>
                        <select name="status"
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                            <option value="Draft">Draft</option>
                            <option value="Interview">Interview</option>
                            <option value="Close">Close</option>
                        </select>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:note-text" width="14" height="14"></iconify-icon>
                        Deskripsi (opsional)
                    </label>
                    <textarea name="deskripsi" rows="3" placeholder="Deskripsi job..."
                              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"></textarea>
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
                <button type="button" onclick="closeModal()" 
                        class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                    Batal
                </button>
                <button type="submit" 
                        class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-blue-900/20">
                    <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                    Simpan Job
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Job -->
<div id="editModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md px-4">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-3xl rounded-2xl border border-gray-700/50 shadow-2xl transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-yellow-500/10 rounded-lg">
                    <iconify-icon icon="mdi:pencil" width="24" height="24" class="text-yellow-400"></iconify-icon>
                </div>
                <h2 class="text-lg sm:text-xl font-bold text-white">Edit Job</h2>
            </div>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4 p-6 max-h-[70vh] overflow-y-auto">
                <!-- Jenis Pekerjaan & Ginou -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium">Jenis Pekerjaan</label>
                        <select name="jenis_pekerjaan" id="edit_jenis_pekerjaan" required
                                class="select2-edit w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white">
                            <option value="">Pilih Jenis Pekerjaan</option>
                            <optgroup label="Konstruksi (建設)">
                                <option value="Bekesting">Bekesting (型枠施工)</option>
                                <option value="Pemasangan Scaffolding">Pemasangan Scaffolding (足場組立)</option>
                                <option value="Pengecoran Beton">Pengecoran Beton (コンクリート打ち)</option>
                                <option value="Pemasangan Baja Tulangan">Pemasangan Baja Tulangan (鉄筋組立て)</option>
                                <option value="Pekerjaan Tanah">Pekerjaan Tanah (土工)</option>
                                <option value="Pemasangan Keramik">Pemasangan Keramik (タイル張り)</option>
                            </optgroup>
                            
                            <optgroup label="Manufaktur (製造業)">
                                <option value="Pengolahan Makanan">Pengolahan Makanan (飲食料品製造)</option>
                                <option value="Penyusunan Komponen Elektronik">Elektronik (電気・電子情報関連)</option>
                                <option value="Pengelasan">Pengelasan (溶接)</option>
                                <option value="Pengepresan Logam">Pengepresan Logam (金属プレス)</option>
                                <option value="Permesinan">Permesinan (機械加工)</option>
                                <option value="Pengecatan">Pengecatan (塗装)</option>
                            </optgroup>

                            <optgroup label="Pertanian & Peternakan (農業・畜産)">
                                <option value="Pertanian Tanaman Pangan">Pertanian (耕種農業)</option>
                                <option value="Peternakan Ayam">Peternakan Ayam (養鶏業)</option>
                                <option value="Peternakan Babi">Peternakan Babi (養豚業)</option>
                                <option value="Peternakan Sapi">Peternakan Sapi (酪農)</option>
                            </optgroup>

                            <optgroup label="Lainnya (その他)">
                                <option value="Perawat / Kaigo">Perawat / Kaigo (介護)</option>
                                <option value="Pembersihan Gedung">Pembersihan Gedung (ビルクリーニング)</option>
                                <option value="Perhotelan">Perhotelan (宿泊)</option>
                                <option value="Restoran">Restoran (外食業)</option>
                                <option value="Laundry">Laundry (リネンサプライ)</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium">Jenis Ginou</label>
                        <select name="jenis_ginou" id="edit_jenis_ginou" 
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white">
                            <option value="Tokutei Ginou">特定技能履歴書 (Visa Magang)</option>
                            <option value="Ginojisshusei">技能実習生履歴書 (Visa Kerja)</option>
                        </select>
                    </div>
                </div>

                <!-- Kuota & Tanggal Interview -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2 w-full">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:account-group" width="14" height="14"></iconify-icon>
                            Kuota
                        </label>
                        <input type="number" name="kuota" id="edit_kuota" placeholder="Kuota"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white">
                    </div>
                    <div class="space-y-2 w-full">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:calendar" width="14" height="14"></iconify-icon>
                            Tanggal Interview
                        </label>
                        <input type="date" name="tanggal_interview" id="edit_tanggal_interview"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white">
                    </div>
                </div>

                <!-- Gaji -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2 w-full">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:clock-outline" width="14" height="14"></iconify-icon>
                            Gaji Pokok
                        </label>
                        <input type="number" name="gaji_pokok" id="edit_gaji_pokok" placeholder="Gaji Pokok"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white">
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:clock-outline" width="14" height="14"></iconify-icon>
                            Tipe Gaji
                        </label>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <!-- Per Jam -->
                            <label class="relative flex items-center justify-center cursor-pointer group">
                                <input type="radio" name="tipe_gaji" value="jam" id="edit_tipe_jam" class="hidden peer">
                                <div class="w-full bg-gray-700 border-2 border-gray-600 rounded-xl px-4 py-3 text-white transition-all duration-300 
                                            peer-checked:border-blue-500 peer-checked:bg-blue-500/10 peer-checked:shadow-lg peer-checked:shadow-blue-500/20
                                            hover:border-blue-400 group-hover:scale-[1.02]">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="relative">
                                                <div class="w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-blue-500 
                                                            transition-all duration-300 group-hover:border-blue-400
                                                            peer-checked:border-6 peer-checked:border-blue-500">
                                                </div>
                                                <div class="absolute inset-0 flex items-center justify-center opacity-0 peer-checked:opacity-100 
                                                            transition-opacity duration-300">
                                                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-white text-sm">Per Jam</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Per Bulan -->
                            <label class="relative flex items-center justify-center cursor-pointer group">
                                <input type="radio" name="tipe_gaji" value="bulan" id="edit_tipe_bulan" class="hidden peer">
                                <div class="w-full bg-gray-700 border-2 border-gray-600 rounded-xl px-4 py-3 text-white transition-all duration-300 
                                            peer-checked:border-green-500 peer-checked:bg-green-500/10 peer-checked:shadow-lg peer-checked:shadow-green-500/20
                                            hover:border-green-400 group-hover:scale-[1.02]">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="relative">
                                                <div class="w-5 h-5 rounded-full border-2 border-gray-500 peer-checked:border-green-500 
                                                            transition-all duration-300 group-hover:border-green-400
                                                            peer-checked:border-6 peer-checked:border-green-500">
                                                </div>
                                                <div class="absolute inset-0 flex items-center justify-center opacity-0 peer-checked:opacity-100 
                                                            transition-opacity duration-300">
                                                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-white text-sm">Per Bulan</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Lembur & Estimasi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:clock-plus" width="14" height="14"></iconify-icon>
                            Status Lembur
                        </label>
                        <label class="flex items-center gap-3 w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 cursor-pointer hover:border-blue-500 transition-colors">
                            <input type="checkbox" name="lembur" value="1" id="edit_lembur" class="w-5 h-5 bg-gray-800 border-gray-500 rounded text-blue-500 focus:ring-blue-500 focus:ring-offset-gray-800">
                            <span class="text-white text-sm">Tersedia Lembur</span>
                        </label>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:clock-alert" width="14" height="14"></iconify-icon>
                            Estimasi Jam Lembur
                        </label>
                        <input type="number" name="estimasi_lembur_jam" id="edit_estimasi_lembur" placeholder="Jam per bulan"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                    </div>
                </div>

                <!-- Kontrak & Lokasi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2 w-full">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:calendar-clock" width="14" height="14"></iconify-icon>
                            Kontrak (tahun)
                        </label>
                        <input type="number" name="kontrak_tahun" id="edit_kontrak" placeholder="Kontrak (tahun)"
                           class="bg-gray-700 w-full border border-gray-600 rounded-lg px-4 py-3 text-white">
                    </div>
                    <div class="space-y-2 w-full">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:map-marker" width="14" height="14"></iconify-icon>
                            Lokasi Kerja
                        </label>
                        <input type="text" name="lokasi_kerja" id="edit_lokasi" placeholder="Lokasi Kerja"
                           class="bg-gray-700 w-full border border-gray-600 rounded-lg px-4 py-3 text-white">
                    </div>
                </div>

                <!-- Fasilitas & Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2 w-full">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:home" width="14" height="14"></iconify-icon>
                            Fasilitas
                        </label>
                        <input type="text" name="fasilitas" id="edit_fasilitas" placeholder="Fasilitas"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white">
                    </div>

                    <div class="space-y-2 w-full">
                        <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                            <iconify-icon icon="mdi:flag" width="14" height="14"></iconify-icon>
                            Status
                        </label>
                        <select name="status" id="edit_status"
                            class="bg-gray-700 w-full border border-gray-600 rounded-lg px-4 py-3 text-white">
                            <option value="Draft">Draft</option>
                            <option value="Interview">Interview</option>
                            <option value="Close">Close</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2 w-full">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:note-text" width="14" height="14"></iconify-icon>
                        Deskripsi (opsional)
                    </label>
                    <textarea name="deskripsi" id="edit_deskripsi" rows="3" placeholder="Deskripsi"
                          class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white"></textarea>
                </div>
                <!-- Deskripsi -->
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 p-4 border-t border-gray-700/50">
                <button type="button" onclick="closeEditModal()" 
                        class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                    Batal
                </button>
                <button type="submit" 
                        class="px-6 py-2.5 bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-yellow-900/20">
                    <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                    Update Job
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

    /* Select2 Dark Theme */
    .select2-container--default .select2-selection--single {
        background-color: #374151 !important;
        border-color: #4B5563 !important;
        height: 46px !important;
        border-radius: 0.5rem !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: white !important;
        line-height: 46px !important;
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
        background-color: #3b82f6 !important;
    }
</style>

<style>
    /* Select2 Dark Theme - Simple Version */
    .select2-container--default .select2-selection--single {
        background-color: #374151 !important;
        border: 1px solid #4b5563 !important;
        border-radius: 0.5rem !important;
        height: 46px !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: white !important;
        line-height: 44px !important;
        padding-left: 16px !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #9ca3af !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 44px !important;
        right: 10px !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #9ca3af transparent transparent transparent !important;
    }
    
    .select2-dropdown {
        background-color: #1f2937 !important;
        border: 1px solid #4b5563 !important;
        border-radius: 0.5rem !important;
    }
    
    .select2-container--default .select2-results__option {
        color: #e5e7eb !important;
        padding: 8px 12px !important;
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #3b82f6 !important;
        color: white !important;
    }
    
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #374151 !important;
    }
    
    .select2-container--default .select2-results__group {
        color: #9ca3af !important;
        font-weight: 600 !important;
        font-size: 0.75rem !important;
        padding: 8px 12px 4px !important;
        background-color: #111827 !important;
    }
    
    .select2-container--default .select2-search--dropdown {
        background-color: #1f2937 !important;
        padding: 8px !important;
    }
    
    .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #374151 !important;
        color: white !important;
        border: 1px solid #4b5563 !important;
        border-radius: 0.375rem !important;
        padding: 8px !important;
    }
    
    .select2-container--default .select2-search--dropdown .select2-search__field::placeholder {
        color: #9ca3af !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__clear {
        color: #9ca3af !important;
        margin-right: 24px !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__clear:hover {
        color: #ef4444 !important;
    }
</style>

<style>
/* Styling untuk drag and drop */
.siswa-item {
    transition: all 0.2s ease;
    cursor: grab;
    position: relative;
}

.siswa-item:hover {
    border-color: #3b82f6 !important;
}

.siswa-item:active {
    cursor: grabbing;
}

/* Sortable classes */
.sortable-ghost {
    opacity: 0.4;
    background-color: #2d3748 !important;
    border: 2px dashed #4299e1 !important;
}

.sortable-drag {
    opacity: 0.8;
    transform: rotate(2deg) scale(1.02);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5), 0 10px 10px -5px rgba(0, 0, 0, 0.3) !important;
    z-index: 9999 !important;
}

.sortable-chosen {
    background-color: #2c5282 !important;
    border-color: #63b3ed !important;
}

/* Dropdown animation */
.max-h-0 {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s ease-in-out, opacity 0.3s ease-in-out, margin 0.3s ease-in-out;
}

.max-h-\[500px\] {
    max-height: 500px;
    transition: max-height 0.5s ease-in-out, opacity 0.3s ease-in-out, margin 0.3s ease-in-out;
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
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
$(document).ready(function() {
    // Setup CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // CEK URUTAN DARI DATABASE
    function cekUrutan() {
        console.log('=== URUTAN DI DATABASE ===');
        @foreach($company->jobs as $job)
            @foreach($job->siswa as $siswa)
                console.log('{{ $siswa->nama_lengkap }}: {{ $siswa->pivot->urutan }}');
            @endforeach
        @endforeach
    }
    
    // Panggil cekUrutan saat halaman dimuat
    cekUrutan();

    // Inisialisasi Sortable untuk setiap job
    $('[id^="siswa-list-"]').each(function() {
        let container = this.querySelector('.space-y-2');
        let jobId = this.id.replace('siswa-list-', '');
        
        if (!container) return;
        
        new Sortable(container, {
            animation: 150,
            handle: '.siswa-item',
            draggable: '.siswa-item',
            onEnd: function(evt) {
                let container = evt.to; // Container tempat item dijatuhkan
                let items = container.querySelectorAll('.siswa-item'); 
                let jobId = $(items[0]).data('job-id');
                let updates = {};
                
                // RE-INDEX SEMUA ITEM:
                // Kita looping semua elemen sesuai posisi barunya di layar
                items.forEach((item, index) => {
                    let siswaId = $(item).data('siswa-id');
                    let newUrutan = index + 1; // Posisi baru berdasarkan urutan DOM
                    
                    updates[siswaId] = newUrutan;
                    
                    // Update tampilan sementara (biar user langsung lihat perubahan angka)
                    $(item).find('.urutan-badge').text(newUrutan);
                    $(item).find('.text-gray-300').text('#' + newUrutan);
                    $(item).attr('data-urutan', newUrutan); 
                });
                
                console.log('Sinkronisasi Urutan Baru:', updates);
                
                // Kirim semua urutan baru ke server (Batch Update)
                $.ajax({
                    url: '{{ route("job.batch-update-urutan") }}',
                    type: 'POST',
                    data: {
                        job_id: jobId,
                        urutan: updates
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update status tombol naik/turun untuk setiap item
                            items.forEach((item, index) => {
                                updateButtonStates($(item), index + 1, items.length);
                            });
                            console.log('Database synced successfully');
                        }
                    },
                    error: function(xhr) {
                        alert('Gagal sinkronisasi ke server. Halaman akan dimuat ulang.');
                        location.reload();
                    }
                });
            }
        });
    });

    // Tombol Naik
    $(document).on('click', '.btn-move-up:not(:disabled)', function() {
        let $btn = $(this);
        let jobId = $btn.data('job-id');
        let siswaId = $btn.data('siswa-id');
        let current = $btn.data('urutan');
        
        if (current <= 1) return;
        
        $.ajax({
            url: '{{ route("job.update-urutan") }}',
            type: 'POST',
            data: {
                job_id: jobId,
                siswa_id: siswaId,
                new_urutan: current - 1
            },
            success: function() {
                location.reload();
            },
            error: function(xhr) {
                alert('Gagal: ' + xhr.responseJSON?.message || 'Unknown error');
            }
        });
    });

    // Tombol Turun
    $(document).on('click', '.btn-move-down:not(:disabled)', function() {
        let $btn = $(this);
        let jobId = $btn.data('job-id');
        let siswaId = $btn.data('siswa-id');
        let current = $btn.data('urutan');
        
        $.ajax({
            url: '{{ route("job.update-urutan") }}',
            type: 'POST',
            data: {
                job_id: jobId,
                siswa_id: siswaId,
                new_urutan: current + 1
            },
            success: function() {
                location.reload();
            },
            error: function(xhr) {
                alert('Gagal: ' + xhr.responseJSON?.message || 'Unknown error');
            }
        });
    });
});
</script>

<script>
    function toggleSiswaList(jobId) {
        const list = document.getElementById(`siswa-list-${jobId}`);
        const chevron = document.getElementById(`chevron-${jobId}`);
        
        if (list.classList.contains('max-h-0')) {
            // Buka dropdown
            list.classList.remove('max-h-0', 'opacity-0', 'mt-0');
            list.classList.add('max-h-[500px]', 'opacity-100', 'mt-4');
            chevron.style.transform = 'rotate(180deg)';
            
            // Hitung tinggi konten untuk animasi yang lebih akurat
            const contentHeight = list.scrollHeight;
            list.style.maxHeight = contentHeight + 'px';
        } else {
            // Tutup dropdown
            list.style.maxHeight = '0';
            list.classList.remove('max-h-[500px]', 'opacity-100', 'mt-4');
            list.classList.add('max-h-0', 'opacity-0', 'mt-0');
            chevron.style.transform = 'rotate(0deg)';
            
            // Setelah animasi selesai, hapus inline style
            setTimeout(() => {
                if (list.classList.contains('max-h-0')) {
                    list.style.maxHeight = '';
                }
            }, 500);
        }
    }
</script>

<script>
    const allSiswa = @json($all_siswa);

    // Initialize Select2
    $(document).ready(function() {
        $(document).ready(function() {
            $('.select2-pekerjaan').select2({
                placeholder: "Cari atau ketik jenis pekerjaan...",
                allowClear: true,
                width: '100%',
                tags: true,
                dropdownParent: $('#modal'),
                language: {
                    noResults: function() {
                        return "Pekerjaan tidak ditemukan";
                    }
                }
            });
        });

        $('.select2-edit').select2({
            placeholder: "Cari atau ketik jenis pekerjaan...",
            allowClear: true,
            width: '100%',
            tags: true,
            dropdownParent: $('#editModal'),
            language: {
                noResults: function() {
                    return "Pekerjaan tidak ditemukan, tekan Enter untuk menambahkan";
                }
            }
        });
    });

    // Modal functions
    function openModal() {
        const modal = document.getElementById('modal');
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

    // Edit Modal functions
    function openEditModal(job) {
        const modal = document.getElementById('editModal');
        const modalContent = modal.querySelector('.modal-show');
        const form = document.getElementById('editForm');
        
        form.action = `/job/${job.id}`;

        // Fill form data
        document.getElementById('edit_kuota').value = job.kuota || '';
        
        if (job.tanggal_interview) {
            document.getElementById('edit_tanggal_interview').value = job.tanggal_interview.substring(0, 10);
        } else {
            document.getElementById('edit_tanggal_interview').value = '';
        }

        document.getElementById('edit_gaji_pokok').value = job.gaji_pokok || '';
        document.getElementById('edit_estimasi_lembur').value = job.estimasi_lembur_jam || '';
        document.getElementById('edit_kontrak').value = job.kontrak_tahun || '';
        document.getElementById('edit_lokasi').value = job.lokasi_kerja || '';
        document.getElementById('edit_fasilitas').value = job.fasilitas || '';
        document.getElementById('edit_deskripsi').value = job.deskripsi || '';
        document.getElementById('edit_status').value = job.status || 'Draft';
        document.getElementById('edit_jenis_ginou').value = job.jenis_ginou || '';

        // Handle Radio Gaji
        if (job.tipe_gaji === 'jam') {
            document.getElementById('edit_tipe_jam').checked = true;
        } else {
            document.getElementById('edit_tipe_bulan').checked = true;
        }

        // Handle Checkbox Lembur
        document.getElementById('edit_lembur').checked = job.lembur ? true : false;

        // Handle Select2 Jenis Pekerjaan
        $('#edit_jenis_pekerjaan').val(job.jenis_pekerjaan).trigger('change');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        const modalContent = modal.querySelector('.modal-show');
        
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);
    }

    // Assign Modal functions
    function openAssignModal(jobId, assignedSiswaIds = [], jobQuota = null) {
        const modal = document.getElementById('assignModal');
        const modalContent = modal.querySelector('.modal-show');
        const form = document.getElementById('assignForm');
        const siswaContainer = document.getElementById('siswa-list-container');
        const quotaInfo = document.getElementById('quota-info');
        const searchInput = document.getElementById('searchSiswa');

        form.action = `/job/${jobId}/assign-siswa`;
        siswaContainer.innerHTML = '';

        // Hitung sisa kuota
        const assignedCount = assignedSiswaIds.length;
        const remainingQuota = jobQuota !== null ? jobQuota - assignedCount : null;

        // Set quota info
        if (jobQuota !== null) {
            quotaInfo.textContent = `(Terpilih: 0 / Sisa Kuota: ${remainingQuota})`;
        } else {
            quotaInfo.textContent = '(Kuota tidak terbatas)';
        }

        // Reset search input
        searchInput.value = '';

        const availableSiswa = allSiswa.filter(siswa => !assignedSiswaIds.includes(siswa.id));

        if (availableSiswa.length > 0) {
            availableSiswa.forEach(siswa => {
                const statusName = siswa.status ? siswa.status.nama_status : 'Tanpa Status';
                const label = `
                    <label class="flex items-center space-x-3 bg-gray-700/30 p-3 rounded-lg border border-gray-600/50 hover:bg-gray-700/50 cursor-pointer transition-all">
                        <input type="checkbox" name="siswas[]" value="${siswa.id}" 
                               class="w-4 h-4 bg-gray-600 border-gray-500 rounded text-blue-500 focus:ring-blue-500 focus:ring-offset-0">
                        <span class="text-white text-sm">${siswa.nama_lengkap} <span class="text-xs text-gray-400">(${statusName})</span></span>
                    </label>
                `;
                siswaContainer.insertAdjacentHTML('beforeend', label);
            });

            // Validasi kuota
            if (remainingQuota !== null) {
                const checkboxes = siswaContainer.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', () => {
                        const selectedCount = siswaContainer.querySelectorAll('input[type="checkbox"]:checked').length;
                        quotaInfo.textContent = `(Terpilih: ${selectedCount} / Sisa Kuota: ${remainingQuota})`;

                        if (selectedCount >= remainingQuota) {
                            checkboxes.forEach(cb => {
                                if (!cb.checked) {
                                    cb.disabled = true;
                                    cb.closest('label').classList.add('opacity-50', 'cursor-not-allowed');
                                }
                            });
                        } else {
                            checkboxes.forEach(cb => {
                                cb.disabled = false;
                                cb.closest('label').classList.remove('opacity-50', 'cursor-not-allowed');
                            });
                        }
                    });
                });
            }
        } else {
            siswaContainer.innerHTML = '<p class="text-gray-400 text-center py-8">Semua siswa sudah dihubungkan ke job ini atau tidak ada siswa yang tersedia.</p>';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        document.body.style.overflow = 'hidden';
    }

    function closeAssignModal() {
        const modal = document.getElementById('assignModal');
        const modalContent = modal.querySelector('.modal-show');
        
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);
    }

    // Search functionality
    document.getElementById('searchSiswa')?.addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        const labels = document.querySelectorAll('#siswa-list-container label');

        labels.forEach(label => {
            const text = label.textContent.toLowerCase();
            if (text.includes(filter)) {
                label.style.display = "";
            } else {
                label.style.display = "none";
            }
        });
    });

    // Close modals with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
            closeEditModal();
            closeAssignModal();
        }
    });

    // Close modals when clicking outside
    document.getElementById('modal')?.addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
    
    document.getElementById('editModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeEditModal();
    });
    
    document.getElementById('assignModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeAssignModal();
    });
</script>
@endsection