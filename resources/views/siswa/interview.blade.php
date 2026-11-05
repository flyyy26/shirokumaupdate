@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header with Glassmorphism Effect -->
    <div class="mb-0 md:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <iconify-icon icon="mdi:calendar-clock" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Jadwal Interview</h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Informasi detail mengenai proses seleksi pekerjaan Anda</p>
                </div>
            </div>
            
            @php
                $statusKode = $siswa->status->kode_status ?? null;

                if(in_array($statusKode, ['karantina','berangkat'])){
                    $label = 'Lulus';
                    $warna = 'text-green-400';
                    $bgColor = 'bg-green-500/10';
                    $borderColor = 'border-green-500/30';
                    $icon = 'mdi:check-circle';
                }
                elseif($statusKode === 'kandidat'){
                    $label = 'Tidak Lulus';
                    $warna = 'text-red-400';
                    $bgColor = 'bg-red-500/10';
                    $borderColor = 'border-red-500/30';
                    $icon = 'mdi:close-circle';
                }
                elseif($statusKode === 'interview'){
                    $label = 'Menunggu';
                    $warna = 'text-yellow-400';
                    $bgColor = 'bg-yellow-500/10';
                    $borderColor = 'border-yellow-500/30';
                    $icon = 'mdi:clock-outline';
                }
                else{
                    $label = 'N/A';
                    $warna = 'text-gray-400';
                    $bgColor = 'bg-gray-500/10';
                    $borderColor = 'border-gray-500/30';
                    $icon = 'mdi:help-circle';
                }
            @endphp

            <div class="flex items-center gap-2 sm:gap-3 {{ $bgColor }} border {{ $borderColor }} px-3 sm:px-5 py-2 sm:py-2.5 rounded-xl backdrop-blur-sm w-full sm:w-auto">
                <iconify-icon icon="{{ $icon }}" width="18" height="18" class="{{ $warna }} sm:w-5 sm:h-5"></iconify-icon>
                <span class="text-xs sm:text-sm font-medium text-gray-300">
                    Status Interview:
                    <span class="{{ $warna }} font-semibold ml-1">{{ $label }}</span>
                </span>
            </div>
        </div>
    </div>

    <div class="space-y-4 sm:space-y-6">
        @forelse($logs as $log)
        <div class="group bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-0 md:rounded-2xl shadow-2xl border border-gray-700/50 overflow-hidden transition-all duration-500 hover:border-blue-500/50 hover:shadow-xl hover:shadow-blue-900/20 backdrop-blur-sm">
            <div class="flex flex-col lg:flex-row">
                {{-- Bagian Kiri: Visual/Status dengan efek glass --}}
                <div class="lg:w-1/4 xl:w-1/5 bg-gradient-to-br from-gray-900/80 to-gray-800/80 p-6 sm:p-8 flex flex-col items-center justify-center border-b lg:border-b-0 lg:border-r border-gray-700/50 relative overflow-hidden">
                    <!-- Background decoration -->
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-purple-500/5"></div>
                    <div class="absolute -top-20 -right-20 w-40 h-40 bg-blue-500/10 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-purple-500/10 rounded-full blur-3xl"></div>
                    
                    <div class="relative mb-4 sm:mb-6">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 blur-2xl opacity-20 rounded-full animate-pulse"></div>
                        <div class="relative w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 rounded-2xl bg-gradient-to-br from-gray-700 to-gray-800 p-1 shadow-xl">
                            <img src="{{ $log->company->logo ? asset('storage/' . $log->company->logo) : 'https://ui-avatars.com/api/?name=' . urlencode($log->company->nama_perusahaan ?? 'C') . '&color=7F9CF5&background=EBF4FF&size=128' }}" 
                                 class="w-full h-full object-contain rounded-xl transition-all duration-500 group-hover:scale-110">
                        </div>
                    </div>
                    
                    <div class="relative text-center w-full">
                        <p class="text-gray-500 text-xs uppercase tracking-widest mb-2 font-semibold">Hasil Seleksi</p>
                        @if($log->hasil === 'lulus')
                            <div class="inline-flex items-center gap-2 px-3 sm:px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-gradient-to-r from-green-500/20 to-emerald-500/20 text-green-400 border border-green-500/30 shadow-lg shadow-green-500/10">
                                <iconify-icon icon="mdi:trophy" width="14" height="14"></iconify-icon>
                                <span>Lulus Seleksi</span>
                            </div>
                        @elseif($log->hasil === 'gagal')
                            <div class="inline-flex items-center gap-2 px-3 sm:px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-gradient-to-r from-red-500/20 to-orange-500/20 text-red-400 border border-red-500/30 shadow-lg shadow-red-500/10">
                                <iconify-icon icon="mdi:close-octagon" width="14" height="14"></iconify-icon>
                                <span>Tidak Lulus</span>
                            </div>
                        @else
                            <div class="inline-flex items-center gap-2 px-3 sm:px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-gradient-to-r from-yellow-500/20 to-amber-500/20 text-yellow-400 border border-yellow-500/30 shadow-lg shadow-yellow-500/10">
                                <iconify-icon icon="mdi:clock-hour" width="14" height="14" class="animate-spin-slow"></iconify-icon>
                                <span>Menunggu</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Bagian Kanan: Detail dengan grid responsif --}}
                <div class="flex-1 p-5 sm:p-6 lg:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
                        <!-- Company Info -->
                        <div class="space-y-3 sm:space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-blue-500/10 rounded-lg">
                                    <iconify-icon icon="mdi:office-building" width="18" height="18" class="text-blue-400 sm:w-5 sm:h-5"></iconify-icon>
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-500 text-xs uppercase font-semibold tracking-wider">Perusahaan</p>
                                    <p class="text-base sm:text-lg font-bold text-white mt-0.5 break-words">{{ $log->company->nama_perusahaan ?? '-' }}</p>
                                    <p class="text-gray-400 text-xs sm:text-sm flex items-center gap-1 mt-1">
                                        <iconify-icon icon="mdi:map-marker" width="12" height="12"></iconify-icon>
                                        {{ $log->company->prefektur ?? '' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-purple-500/10 rounded-lg">
                                    <iconify-icon icon="mdi:briefcase" width="18" height="18" class="text-purple-400 sm:w-5 sm:h-5"></iconify-icon>
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-500 text-xs uppercase font-semibold tracking-wider">Jenis Pekerjaan</p>
                                    <p class="text-base sm:text-lg font-semibold text-blue-400 mt-0.5 break-words">{{ $log->job->jenis_pekerjaan ?? '-' }}</p>
                                    <p class="text-gray-400 text-xs sm:text-sm">{{ $log->job->jenis_ginou ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Interview Details -->
                        <div class="space-y-3 sm:space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-green-500/10 rounded-lg">
                                    <iconify-icon icon="mdi:calendar" width="18" height="18" class="text-green-400 sm:w-5 sm:h-5"></iconify-icon>
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-500 text-xs uppercase font-semibold tracking-wider">Waktu Interview</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <p class="text-white font-medium text-sm sm:text-base">
                                            {{ $log->tanggal_interview ? $log->tanggal_interview->translatedFormat('d F Y') : 'Akan diinformasikan' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-yellow-500/10 rounded-lg">
                                    <iconify-icon icon="mdi:map-marker-radius" width="18" height="18" class="text-yellow-400 sm:w-5 sm:h-5"></iconify-icon>
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-500 text-xs uppercase font-semibold tracking-wider">Lokasi Kerja</p>
                                    <p class="text-white font-medium text-sm sm:text-base mt-1 break-words">{{ $log->job->lokasi_kerja ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info Card (optional) -->
                    @if($log->catatan)
                    <div class="mt-4 sm:mt-6 p-3 sm:p-4 bg-gray-700/20 rounded-xl border border-gray-700/50">
                        <div class="flex items-start gap-3">
                            <iconify-icon icon="mdi:note-text" width="18" height="18" class="text-gray-400 flex-shrink-0"></iconify-icon>
                            <p class="text-gray-300 text-xs sm:text-sm">{{ $log->catatan }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-700/50">
                        <div class="flex flex-wrap gap-2 sm:gap-3">
                            <a href="{{ route('biodata.print') }}" target="_blank" 
                               class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-gray-700 hover:bg-gray-600 text-white px-3 sm:px-6 py-2 sm:py-2.5 rounded-xl transition-all duration-300 font-medium text-xs sm:text-sm shadow-lg hover:shadow-xl group">
                                <iconify-icon icon="mdi:printer" width="16" height="16" class="sm:w-4 sm:h-4 group-hover:rotate-12 transition-transform"></iconify-icon>
                                <span>Cetak CV</span>
                            </a>
                            
                            @if($siswa->mcu)
                                <a href="{{ asset('storage/' . $siswa->mcu) }}" target="_blank" 
                                   class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-3 sm:px-6 py-2 sm:py-2.5 rounded-xl transition-all duration-300 font-medium text-xs sm:text-sm shadow-lg shadow-green-900/20 hover:shadow-xl group">
                                    <iconify-icon icon="mdi:eye" width="16" height="16" class="sm:w-4 sm:h-4 group-hover:scale-110 transition-transform"></iconify-icon>
                                    <span>Lihat MCU</span>
                                </a>
                            @endif
                            
                            <button onclick="openMcuModal()" 
                                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-3 sm:px-6 py-2 sm:py-2.5 rounded-xl transition-all duration-300 font-medium text-xs sm:text-sm shadow-lg shadow-blue-900/20 hover:shadow-xl group">
                                <iconify-icon icon="mdi:cloud-upload" width="16" height="16" class="sm:w-4 sm:h-4 group-hover:-translate-y-0.5 transition-transform"></iconify-icon>
                                <span>{{ $siswa->mcu ? 'Ganti MCU' : 'Upload MCU' }}</span>
                            </button>
                        </div>
                        
                        <!-- Hint text -->
                        <p class="text-gray-600 text-xs mt-3 flex items-center gap-1">
                            <iconify-icon icon="mdi:information" width="12" height="12"></iconify-icon>
                            Dokumen MCU diperlukan untuk proses selanjutnya
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-2xl p-8 sm:p-12 text-center backdrop-blur-sm">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full"></div>
                <div class="relative bg-gray-800 w-20 h-20 sm:w-24 sm:h-24 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                    <iconify-icon icon="mdi:calendar-clock" width="32" height="32" class="text-gray-600 sm:w-10 sm:h-10"></iconify-icon>
                </div>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-white mb-2">Belum Ada Jadwal Interview</h3>
            <p class="text-gray-500 text-sm sm:text-base max-w-md mx-auto">
                Anda belum terdaftar dalam proses interview pekerjaan manapun saat ini. Silakan cek kembali nanti.
            </p>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Upload MCU dengan desain yang lebih baik -->
<div id="mcuModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md transition-all duration-300">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-md rounded-2xl border border-gray-700/50 shadow-2xl p-6 sm:p-8 mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <div class="flex justify-between items-center mb-6 border-b border-gray-700/50 pb-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500/10 rounded-lg">
                    <iconify-icon icon="mdi:file-document" width="24" height="24" class="text-blue-400"></iconify-icon>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-white">Upload MCU</h3>
            </div>
            <button onclick="closeMcuModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <form action="{{ route('upload.mcu') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-4">
                <div class="bg-gray-700/30 rounded-xl p-4 border border-gray-700/50">
                    <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center gap-1">
                        <iconify-icon icon="mdi:file" width="16" height="16"></iconify-icon>
                        File MCU
                    </label>
                    
                    <!-- Custom file upload -->
                    <div class="relative">
                        <input type="file" name="mcu" id="mcuFile" required accept=".pdf,.jpg,.jpeg,.png" class="hidden">
                        <label for="mcuFile" class="flex items-center justify-between w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white cursor-pointer hover:border-blue-500 transition-colors group">
                            <span class="flex items-center gap-2">
                                <iconify-icon icon="mdi:upload" width="18" height="18" class="text-gray-400 group-hover:text-blue-400"></iconify-icon>
                                <span class="text-sm" id="fileName">Pilih file MCU</span>
                            </span>
                            <span class="text-xs bg-gray-700 px-2 py-1 rounded text-gray-400">Max 5MB</span>
                        </label>
                    </div>
                    
                    <!-- File info -->
                    <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                        <iconify-icon icon="mdi:file-pdf" width="12" height="12"></iconify-icon>
                        <iconify-icon icon="mdi:file-image" width="12" height="12"></iconify-icon>
                        Format: PDF, JPG, PNG
                    </p>
                </div>

                @if($siswa->mcu)
                <div class="bg-green-500/10 border border-green-500/30 rounded-lg p-3 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <iconify-icon icon="mdi:file-check" width="18" height="18" class="text-green-400"></iconify-icon>
                        <span class="text-sm text-gray-300">File MCU sudah ada</span>
                    </div>
                    <a href="{{ asset('storage/' . $siswa->mcu) }}" target="_blank" class="text-green-400 hover:text-green-300 text-sm flex items-center gap-1">
                        <iconify-icon icon="mdi:eye" width="14" height="14"></iconify-icon>
                        Lihat
                    </a>
                </div>
                @endif
            </div>

            <div class="mt-8 flex gap-3">
                <button type="button" onclick="closeMcuModal()" 
                        class="flex-1 px-4 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-xl transition-all duration-300 text-sm font-medium">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium py-3 rounded-xl transition-all duration-300 shadow-lg shadow-blue-900/20 flex items-center justify-center gap-2 text-sm">
                    <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // File upload preview
    document.getElementById('mcuFile')?.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Pilih file MCU';
        document.getElementById('fileName').textContent = fileName;
    });

    // Modal functions with animation
    function openMcuModal() {
        const modal = document.getElementById('mcuModal');
        const modalContent = modal.querySelector('.modal-show');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        document.body.style.overflow = 'hidden';
    }
    
    function closeMcuModal() {
        const modal = document.getElementById('mcuModal');
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
            closeMcuModal();
        }
    });
    
    // Close modal when clicking outside
    document.getElementById('mcuModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeMcuModal();
        }
    });
</script>

<style>
    /* Animations */
    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    
    .animate-spin-slow {
        animation: spin-slow 3s linear infinite;
    }
    
    /* Modal animation */
    .modal-show {
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    /* Hover effects */
    .group:hover .absolute.inset-0.bg-gradient-to-br {
        opacity: 0.8;
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
    
    /* Responsive text */
    @media (max-width: 640px) {
        .text-xs {
            font-size: 0.7rem;
        }
    }
    
    /* Card hover effect */
    .group:hover {
        transform: translateY(-2px);
    }
    
    /* Gradient animation */
    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }
    
    .bg-gradient-to-br {
        background-size: 200% 200%;
        animation: gradient 15s ease infinite;
    }
    
    /* File upload button */
    .file\\:mr-4 {
        transition: all 0.3s ease;
    }
    
    .file\\:mr-4:hover {
        filter: brightness(1.1);
        transform: scale(1.02);
    }
</style>
@endsection