@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header with Glassmorphism Effect -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <iconify-icon icon="mdi:account-group" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Data Siswa</h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola data siswa dan informasi terkait</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <!-- Tombol Salin Link Registrasi -->
                <button onclick="copyRegistrationLink()" 
                        class="flex-1 sm:flex-none bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl text-sm group"
                        id="copyButton" type="button">
                    <iconify-icon icon="mdi:link-variant" width="18" height="18" class="sm:w-5 sm:h-5 group-hover:scale-110 transition-transform"></iconify-icon>
                    <span id="copyButtonText" class="hidden sm:inline">Salin Link Registrasi</span>
                    <span id="copyButtonTextMobile" class="sm:hidden">Salin Link</span>
                </button>

                <!-- Tombol Tambah Siswa (yang sudah ada) -->
                <button onclick="openModal()" 
                        class="flex-1 sm:flex-none bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm sm:text-base group">
                    <iconify-icon icon="mdi:plus" width="18" height="18" class="sm:w-5 sm:h-5 group-hover:scale-110 transition-transform"></iconify-icon>
                    <span class="hidden sm:inline">Tambah Siswa</span>
                    <span class="sm:hidden">Tambah</span>
                </button>
            </div>
        </div>

        <!-- Toast Notification - Pastikan hidden secara default -->
        <div id="copyToast" class="fixed bottom-4 right-4 bg-green-500/95 backdrop-blur-sm text-white px-5 py-3 rounded-xl shadow-2xl flex items-center gap-3 transform transition-all duration-500 translate-y-20 opacity-0 z-50 border border-green-400/30 hidden">
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                <iconify-icon icon="mdi:check-circle" width="18" height="18" class="text-white"></iconify-icon>
            </div>
            <div>
                <p class="font-semibold">Berhasil!</p>
                <p class="text-sm text-white/90">Link registrasi telah disalin</p>
            </div>
        </div>

        <script>
// Single function untuk copy link
function copyRegistrationLink() {
    // URL registrasi
    const registrationUrl = '{{ url('/register') }}';
    
    // Cek apakah browser mendukung clipboard API
    if (navigator.clipboard && navigator.clipboard.writeText) {
        // Modern API
        navigator.clipboard.writeText(registrationUrl).then(() => {
            showCopySuccess();
        }).catch(() => {
            // Fallback jika clipboard API gagal
            fallbackCopy(registrationUrl);
        });
    } else {
        // Fallback untuk browser lama
        fallbackCopy(registrationUrl);
    }
}

// Fallback copy method
function fallbackCopy(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    textArea.style.top = '-999999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        const successful = document.execCommand('copy');
        if (successful) {
            showCopySuccess();
        } else {
            alert('Gagal menyalin link. Silakan salin manual: ' + text);
        }
    } catch (err) {
        alert('Gagal menyalin link. Silakan salin manual: ' + text);
    } finally {
        document.body.removeChild(textArea);
    }
}

// Fungsi untuk menampilkan notifikasi sukses
function showCopySuccess() {
    const toast = document.getElementById('copyToast');
    const copyBtn = document.getElementById('copyButton');
    const btnText = document.getElementById('copyButtonText');
    const btnTextMobile = document.getElementById('copyButtonTextMobile');
    
    // Simpan teks asli
    const originalText = btnText.innerText;
    const originalTextMobile = btnTextMobile.innerText;
    
    // Tampilkan toast
    toast.classList.remove('hidden', 'translate-y-20', 'opacity-0');
    toast.classList.add('translate-y-0', 'opacity-100');
    
    // Ubah teks tombol
    btnText.innerText = 'Tersalin!';
    btnTextMobile.innerText = 'Tersalin!';
    
    // Ubah warna tombol
    copyBtn.classList.remove('from-purple-600', 'to-purple-700', 'hover:from-purple-700', 'hover:to-purple-800');
    copyBtn.classList.add('from-green-600', 'to-green-700', 'hover:from-green-700', 'hover:to-green-800');
    
    // Sembunyikan toast setelah 3 detik
    setTimeout(() => {
        toast.classList.add('translate-y-20', 'opacity-0');
        // Sembunyikan total setelah animasi selesai
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 500);
    }, 3000);
    
    // Kembalikan tombol ke keadaan semula setelah 2 detik
    setTimeout(() => {
        btnText.innerText = originalText;
        btnTextMobile.innerText = originalTextMobile;
        copyBtn.classList.remove('from-green-600', 'to-green-700', 'hover:from-green-700', 'hover:to-green-800');
        copyBtn.classList.add('from-purple-600', 'to-purple-700', 'hover:from-purple-700', 'hover:to-purple-800');
    }, 2000);
}

// Pastikan toast tersembunyi saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    const toast = document.getElementById('copyToast');
    toast.classList.add('hidden', 'translate-y-20', 'opacity-0');
    toast.classList.remove('translate-y-0', 'opacity-100');
});

// Hapus event listener yang tidak perlu
// Jangan panggil fungsi copy di sini
</script>

        <style>
        /* Animasi untuk toast */
        @keyframes slideIn {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        #copyToast {
            animation: slideIn 0.3s ease-out;
        }

        /* Hover effect untuk tombol */
        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            #copyToast {
                left: 1rem;
                right: 1rem;
                bottom: 1rem;
                width: auto;
            }
        }
        </style>
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
                Daftar Siswa
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 text-gray-400 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Nama</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Status</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">MCU</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">CV</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($siswas as $siswa)
                    <tr class="hover:bg-gray-700/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-8 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                @if($siswa->foto)
                                    <img src="{{ asset('storage/' . $siswa->foto) }}" 
                                         class="w-10 h-10 rounded-lg object-cover border-2 border-gray-600 group-hover:border-blue-500 transition-all">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($siswa->nama_lengkap, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-white font-medium">{{ $siswa->nama_lengkap }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($siswa->biodata && $siswa->biodata->status_siswa_sebelumnya)
                                @if($siswa->biodata->status_siswa_sebelumnya == 'Mandiri')
                                    <span class="bg-purple-500/20 text-purple-400 px-3 py-1 rounded-full text-xs font-medium">
                                        Mandiri
                                    </span>
                                @elseif($siswa->biodata->status_siswa_sebelumnya == 'LPK')
                                    <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-xs font-medium" title="{{ $siswa->biodata->nama_lpk }}">
                                        LPK: {{ $siswa->biodata->nama_lpk ? Str::limit($siswa->biodata->nama_lpk, 20) : '-' }}
                                    </span>
                                @endif
                            @else
                                <span class="bg-gray-500/20 text-gray-400 px-3 py-1 rounded-full text-xs font-medium">
                                    -
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($siswa->mcu)
                                <a href="{{ asset('storage/' . $siswa->mcu) }}" target="_blank" 
                                   class="text-blue-400 hover:text-blue-300 flex items-center gap-1">
                                    <iconify-icon icon="mdi:file-pdf" width="16" height="16"></iconify-icon>
                                    <span class="text-sm">Lihat</span>
                                </a>
                            @else
                                <span class="text-gray-600 italic text-sm">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('siswa.print-cv', $siswa->id) }}" target="_blank" 
                               class="text-green-400 hover:text-green-300 flex items-center gap-1">
                                <iconify-icon icon="mdi:printer" width="16" height="16"></iconify-icon>
                                <span class="text-sm">Cetak</span>
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Login As -->
                                <form action="{{ route('siswa.login-as', $siswa->id) }}" method="POST" 
                                      onsubmit="return confirm('Login sebagai {{ $siswa->nama_lengkap }}?')">
                                    @csrf
                                    <button class="bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 p-2 rounded-lg transition-all duration-300 group"
                                            title="Login sebagai siswa">
                                        <iconify-icon icon="mdi:login" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                    </button>
                                </form>

                                <!-- Di bagian button edit, ubah data-tanggal -->
                                <button 
                                    onclick="openEditModal(this)"
                                    data-id="{{ $siswa->id }}"
                                    data-nama="{{ $siswa->nama_lengkap }}"
                                    data-email="{{ $siswa->user?->email ?? '' }}"
                                    data-katakana="{{ $siswa->nama_lengkap_katakana ?? '' }}"
                                    data-panggilan="{{ $siswa->nama_panggilan ?? '' }}"
                                    data-panggilan-katakana="{{ $siswa->nama_panggilan_katakana ?? '' }}"
                                    data-tempat="{{ $siswa->tempat_lahir }}"
                                    data-tanggal="{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y') : '' }}"
                                    data-jk="{{ $siswa->jenis_kelamin }}"
                                    data-agama="{{ $siswa->agama }}"
                                    data-hp="{{ $siswa->no_hp ?? '' }}"
                                    data-alamat="{{ $siswa->alamat ?? '' }}"
                                    class="bg-yellow-600/20 hover:bg-yellow-600/40 text-yellow-400 p-2 rounded-lg transition-all duration-300 group"
                                    title="Edit">
                                    <iconify-icon icon="mdi:pencil" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                                </button>

                                <!-- Delete -->
                                <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" 
                                      onsubmit="return confirm('Hapus siswa ini? Data user terkait juga akan dihapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600/20 hover:bg-red-600/40 text-red-400 p-2 rounded-lg transition-all duration-300 group"
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
                                    <iconify-icon icon="mdi:account-group" width="40" height="40" class="text-gray-600"></iconify-icon>
                                </div>
                                <p class="text-gray-500 text-sm">Belum ada data siswa</p>
                                <button onclick="openModal()" 
                                        class="mt-2 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-all">
                                    <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                                    Tambah Siswa Pertama
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($siswas->count() > 0)
        <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
            <div class="flex items-center gap-2 text-gray-400 text-sm">
                <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
                <span>Total {{ $siswas->count() }} siswa terdaftar</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Mobile Card View (visible only on mobile) -->
    <div class="md:hidden space-y-4">
        @forelse($siswas as $siswa)
        <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
            <!-- Card Header -->
            <div class="p-4 border-b border-gray-700/50 bg-gray-900/30">
                <div class="flex items-center gap-3">
                    @if($siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" 
                             class="w-12 h-12 rounded-lg object-cover border-2 border-gray-600">
                    @else
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                            {{ substr($siswa->nama_lengkap, 0, 1) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <h3 class="text-white font-semibold">{{ $siswa->nama_lengkap }}</h3>
                    </div>
                    @if($siswa->jenis_kelamin == 'L')
                        <span class="bg-blue-500/20 text-blue-400 px-2 py-1 rounded-full text-xs">Laki-laki</span>
                    @else
                        <span class="bg-pink-500/20 text-pink-400 px-2 py-1 rounded-full text-xs">Perempuan</span>
                    @endif
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-4 space-y-3">
                <!-- TTL -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-purple-500/10 rounded-lg">
                        <iconify-icon icon="mdi:calendar" width="16" height="16" class="text-purple-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Tempat, Tanggal Lahir</p>
                        <p class="text-white text-sm">{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') : '-' }}</p>
                    </div>
                </div>

                <!-- No HP -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-green-500/10 rounded-lg">
                        <iconify-icon icon="mdi:phone" width="16" height="16" class="text-green-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">No. HP</p>
                        <p class="text-white text-sm">{{ $siswa->no_hp ?? '-' }}</p>
                    </div>
                </div>

                <!-- MCU & CV -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-700/20 p-3 rounded-lg">
                        <p class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                            <iconify-icon icon="mdi:file-pdf" width="12" height="12"></iconify-icon>
                            MCU
                        </p>
                        @if($siswa->mcu)
                            <a href="{{ asset('storage/' . $siswa->mcu) }}" target="_blank" 
                               class="text-blue-400 hover:text-blue-300 text-sm flex items-center gap-1">
                                <iconify-icon icon="mdi:eye" width="14" height="14"></iconify-icon>
                                Lihat
                            </a>
                        @else
                            <span class="text-gray-600 text-sm">-</span>
                        @endif
                    </div>
                    
                    <div class="bg-gray-700/20 p-3 rounded-lg">
                        <p class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                            <iconify-icon icon="mdi:file-document" width="12" height="12"></iconify-icon>
                            CV
                        </p>
                        <a href="{{ route('siswa.print-cv', $siswa->id) }}" target="_blank" 
                           class="text-green-400 hover:text-green-300 text-sm flex items-center gap-1">
                            <iconify-icon icon="mdi:printer" width="14" height="14"></iconify-icon>
                            Cetak
                        </a>
                    </div>
                </div>

                <!-- Alamat (if exists) -->
                @if($siswa->alamat)
                <div class="bg-gray-700/20 p-3 rounded-lg">
                    <p class="text-gray-400 text-xs flex items-center gap-1 mb-1">
                        <iconify-icon icon="mdi:map-marker" width="12" height="12"></iconify-icon>
                        Alamat
                    </p>
                    <p class="text-white text-sm">{{ $siswa->alamat }}</p>
                </div>
                @endif
            </div>

            <!-- Card Footer with Actions -->
            <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
                <div class="grid grid-cols-3 gap-2">
                    <!-- Login As -->
                    <form action="{{ route('siswa.login-as', $siswa->id) }}" method="POST" 
                          onsubmit="return confirm('Login sebagai {{ $siswa->nama_lengkap }}?')">
                        @csrf
                        <button class="w-full flex items-center justify-center gap-1 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-2 py-2 rounded-lg transition-all duration-300 text-xs">
                            <iconify-icon icon="mdi:login" width="14" height="14"></iconify-icon>
                            <span>Login</span>
                        </button>
                    </form>

                    <!-- Edit -->
                    <!-- Di bagian button edit, ubah data-tanggal -->
                    <button 
                        onclick="openEditModal(this)"
                        data-id="{{ $siswa->id }}"
                        data-nama="{{ $siswa->nama_lengkap }}"
                        data-katakana="{{ $siswa->nama_lengkap_katakana ?? '' }}"
                        data-panggilan="{{ $siswa->nama_panggilan ?? '' }}"
                        data-panggilan-katakana="{{ $siswa->nama_panggilan_katakana ?? '' }}"
                        data-tempat="{{ $siswa->tempat_lahir }}"
                        data-tanggal="{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '' }}"
                        data-jk="{{ $siswa->jenis_kelamin }}"
                        data-agama="{{ $siswa->agama }}"
                        data-hp="{{ $siswa->no_hp ?? '' }}"
                        data-alamat="{{ $siswa->alamat ?? '' }}"
                        class="bg-yellow-600/20 hover:bg-yellow-600/40 text-yellow-400 p-2 rounded-lg transition-all duration-300 group"
                        title="Edit">
                        <iconify-icon icon="mdi:pencil" width="16" height="16" class="group-hover:scale-110 transition-transform"></iconify-icon>
                    </button>

                    <!-- Delete -->
                    <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" 
                          onsubmit="return confirm('Hapus siswa ini? Data user terkait juga akan dihapus.')">
                        @csrf
                        @method('DELETE')
                        <button class="w-full flex items-center justify-center gap-1 bg-red-600/20 hover:bg-red-600/40 text-red-400 px-2 py-2 rounded-lg transition-all duration-300 text-xs">
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
                    <iconify-icon icon="mdi:account-group" width="32" height="32" class="text-gray-600"></iconify-icon>
                </div>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Belum Ada Data Siswa</h3>
            <p class="text-gray-500 text-sm max-w-xs mx-auto mb-4">
                Anda belum menambahkan data siswa. Silakan tambah siswa baru.
            </p>
            <button onclick="openModal()" 
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300">
                <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                Tambah Siswa
            </button>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Tambah Siswa -->
<div id="modalSiswa" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md px-4">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-3xl rounded-2xl border border-gray-700/50 shadow-2xl transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500/10 rounded-lg">
                    <iconify-icon icon="mdi:account-plus" width="24" height="24" class="text-blue-400"></iconify-icon>
                </div>
                <h3 class="text-xl font-bold text-white">Tambah Siswa Baru</h3>
            </div>
            <button onclick="closeModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <!-- Modal Body -->
        <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6 max-h-[70vh] overflow-y-auto space-y-6">
                <!-- Informasi Akun -->
                <div>
                    <h4 class="text-blue-400 font-semibold mb-3 flex items-center gap-2 text-sm uppercase tracking-wider">
                        <iconify-icon icon="mdi:account" width="16" height="16"></iconify-icon>
                        Informasi Akun
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:email" width="14" height="14"></iconify-icon>
                                Email
                            </label>
                            <input type="email" name="email" required
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                   placeholder="email@contoh.com">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:lock" width="14" height="14"></iconify-icon>
                                Password <span class="text-red-400">*</span>
                            </label>
                            <input type="password" name="password" required 
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                   placeholder="Minimal 6 karakter">
                        </div>
                    </div>
                </div>

                <!-- Biodata Siswa -->
                <div>
                    <h4 class="text-green-400 font-semibold mb-3 flex items-center gap-2 text-sm uppercase tracking-wider">
                        <iconify-icon icon="mdi:card-account-details" width="16" height="16"></iconify-icon>
                        Biodata Siswa
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:account" width="14" height="14"></iconify-icon>
                                Nama Lengkap <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="nama_lengkap" required 
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                   placeholder="Nama lengkap">
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:translate" width="14" height="14"></iconify-icon>
                                Nama Lengkap (Katakana)
                            </label>
                            <input type="text" name="nama_lengkap_katakana" required
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                   placeholder="Nama dalam katakana">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:account" width="14" height="14"></iconify-icon>
                                Nama Panggilan
                            </label>
                            <input type="text" name="nama_panggilan" required
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                   placeholder="Nama panggilan">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:translate" width="14" height="14"></iconify-icon>
                                Nama Panggilan (Katakana)
                            </label>
                            <input type="text" name="nama_panggilan_katakana" required
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                   placeholder="Nama panggilan katakana">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:gender-male-female" width="14" height="14"></iconify-icon>
                                Jenis Kelamin <span class="text-red-400">*</span>
                            </label>
                            <select name="jenis_kelamin" required 
                                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:church" width="14" height="14"></iconify-icon>
                                Agama <span class="text-red-400">*</span>
                            </label>
                            <select name="agama" required 
                                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                                <option value="">Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:city" width="14" height="14"></iconify-icon>
                                Tempat Lahir <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="tempat_lahir" required 
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                   placeholder="Kota lahir">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:calendar" width="14" height="14"></iconify-icon>
                                Tanggal Lahir <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="tanggal_lahir" id="tanggal_lahir_modal" required 
                                   placeholder="dd/mm/yyyy"
                                   class="flatpickr w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:phone" width="14" height="14"></iconify-icon>
                                No. HP
                            </label>
                            <input type="text" name="no_hp" required
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                                   placeholder="081234567890">
                        </div>

                        <!-- Di bagian Alamat - ganti bagian sebelumnya -->
                        <div class="md:col-span-2 space-y-3">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:map-marker" width="14" height="14"></iconify-icon>
                                Alamat Lengkap <span class="text-red-400">*</span>
                            </label>
                            
                            <!-- Provinsi -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <select id="provinsi" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white" required>
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                </div>
                                
                                <!-- Kota/Kabupaten -->
                                <div>
                                    <select id="kabupaten" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white" disabled required>
                                        <option value="">Pilih Kabupaten/Kota</option>
                                    </select>
                                </div>
                                
                                <!-- Kecamatan -->
                                <div>
                                    <select id="kecamatan" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white" disabled required>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                </div>
                                
                                <!-- Desa/Kelurahan -->
                                <div>
                                    <select id="desa" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white" disabled required>
                                        <option value="">Pilih Desa/Kelurahan</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Hidden input untuk alamat final -->
                            <input type="hidden" name="alamat" id="alamat_final" value="">
                            
                            <!-- Preview alamat -->
                            <div class="bg-gray-800/50 border border-gray-600 rounded-lg p-3">
                                <p class="text-xs text-gray-400 mb-1">Preview alamat:</p>
                                <p id="alamat_preview" class="text-white text-sm break-words font-bold uppercase">-</p>
                            </div>
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:camera" width="14" height="14"></iconify-icon>
                                Foto
                            </label>
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-gray-700 rounded-lg border border-gray-600 overflow-hidden flex items-center justify-center" id="photoPreview">
                                        <iconify-icon icon="mdi:camera-plus" width="24" height="24" class="text-gray-500"></iconify-icon>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="foto" id="foto" accept="image/*" class="hidden" required>
                                    <label for="foto" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg cursor-pointer transition-all text-sm">
                                        <iconify-icon icon="mdi:cloud-upload" width="18" height="18"></iconify-icon>
                                        Pilih Foto
                                    </label>
                                    <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG. Maksimal 2MB</p>
                                    <p class="text-xs text-gray-500" id="file-name">Tidak ada file dipilih</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-blue-900/20">
                    <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                    Simpan Siswa
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Siswa -->
<div id="modalEditSiswa" class="fixed inset-0 bg-black/90 hidden items-start justify-center z-50 backdrop-blur-md overflow-y-auto py-10 px-4">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-3xl rounded-2xl border border-gray-700/50 shadow-2xl transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-yellow-500/10 rounded-lg">
                    <iconify-icon icon="mdi:pencil" width="24" height="24" class="text-yellow-400"></iconify-icon>
                </div>
                <h3 class="text-xl font-bold text-white">Edit Data Siswa</h3>
            </div>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="formEditSiswa" method="POST" enctype="multipart/form-data" class="p-6 max-h-[70vh] overflow-y-auto">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Informasi Akun -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:email" width="14" height="14"></iconify-icon>
                        Email <span class="text-red-400">*</span>
                    </label>
                    <input type="email" name="email" id="edit_email" required 
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                </div>

                <!-- Biodata Siswa -->
                <div>
                    <h4 class="text-green-400 font-semibold mb-3 flex items-center gap-2 text-sm uppercase tracking-wider">
                        <iconify-icon icon="mdi:card-account-details" width="16" height="16"></iconify-icon>
                        Biodata Siswa
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:account" width="14" height="14"></iconify-icon>
                                Nama Lengkap <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="nama_lengkap" id="edit_nama_lengkap" required 
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:translate" width="14" height="14"></iconify-icon>
                                Nama Lengkap (Katakana)
                            </label>
                            <input type="text" name="nama_lengkap_katakana" id="edit_nama_lengkap_katakana" 
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:account" width="14" height="14"></iconify-icon>
                                Nama Panggilan
                            </label>
                            <input type="text" name="nama_panggilan" id="edit_nama_panggilan" 
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:translate" width="14" height="14"></iconify-icon>
                                Nama Panggilan (Katakana)
                            </label>
                            <input type="text" name="nama_panggilan_katakana" id="edit_nama_panggilan_katakana" 
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:gender-male-female" width="14" height="14"></iconify-icon>
                                Jenis Kelamin <span class="text-red-400">*</span>
                            </label>
                            <select name="jenis_kelamin" id="edit_jenis_kelamin" required 
                                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:church" width="14" height="14"></iconify-icon>
                                Agama <span class="text-red-400">*</span>
                            </label>
                            <select name="agama" id="edit_agama" required 
                                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:city" width="14" height="14"></iconify-icon>
                                Tempat Lahir <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="tempat_lahir" id="edit_tempat_lahir" required 
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:calendar" width="14" height="14"></iconify-icon>
                                Tanggal Lahir <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="tanggal_lahir" id="edit_tanggal_lahir" required 
                                   placeholder="dd/mm/yyyy"
                                   class="flatpickr w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:phone" width="14" height="14"></iconify-icon>
                                No. HP
                            </label>
                            <input type="text" name="no_hp" id="edit_no_hp" 
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm">
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:map-marker" width="14" height="14"></iconify-icon>
                                Alamat
                            </label>
                            <textarea name="alamat" id="edit_alamat" rows="2" 
                                      class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"></textarea>
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                                <iconify-icon icon="mdi:camera" width="14" height="14"></iconify-icon>
                                Foto (Biarkan kosong jika tidak ingin mengubah)
                            </label>
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-gray-700 rounded-lg border border-gray-600 overflow-hidden flex items-center justify-center" id="editPhotoPreview">
                                        <iconify-icon icon="mdi:camera-plus" width="24" height="24" class="text-gray-500"></iconify-icon>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="foto" id="edit_foto" accept="image/*" class="hidden">
                                    <label for="edit_foto" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg cursor-pointer transition-all text-sm">
                                        <iconify-icon icon="mdi:cloud-upload" width="18" height="18"></iconify-icon>
                                        Pilih Foto Baru
                                    </label>
                                    <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG. Maksimal 2MB</p>
                                    <p class="text-xs text-gray-500" id="edit-file-name">Tidak ada file dipilih</p>
                                </div>
                            </div>
                            <div id="currentPhotoContainer" class="hidden mt-2">
                                <p class="text-xs text-gray-400">Foto saat ini:</p>
                                <img id="currentPhoto" src="" class="w-12 h-12 object-cover rounded-lg mt-1">
                            </div>
                        </div>
                    </div>
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
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-700/50">
                <button type="button"
                    onclick="closeEditModal()"
                    class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-yellow-900/20">
                    <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                    Update Siswa
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 dengan placeholder berbeda
    const placeholders = {
        'provinsi': 'Pilih Provinsi',
        'kabupaten': 'Pilih Kabupaten/Kota',
        'kecamatan': 'Pilih Kecamatan',
        'desa': 'Pilih Desa/Kelurahan'
    };

    $.each(placeholders, function(id, placeholder) {
        $('#' + id).select2({
            width: '100%',
            placeholder: placeholder,
            allowClear: true,
            theme: 'bootstrap-5',
            dropdownCssClass: 'bg-gray-800 text-white'
        });
    });

    // Load Provinces
    $.get('/wilayah/provinces', function(data) {
        let select = $('#provinsi');
        select.empty().append('<option value=""></option>'); // Empty option untuk placeholder
        data.forEach(item => {
            select.append(new Option(item.name, item.id, false, false));
        });
        select.trigger('change');
    }).fail(function() {
        console.error('Gagal load provinsi');
    });

    // Province change
    $('#provinsi').on('change', function() {
        let id = $(this).val();
        
        $('#kabupaten').empty().append('<option value=""></option>').prop('disabled', true).trigger('change');
        $('#kecamatan').empty().append('<option value=""></option>').prop('disabled', true).trigger('change');
        $('#desa').empty().append('<option value=""></option>').prop('disabled', true).trigger('change');
        
        if (id) {
            $.get('/wilayah/regencies/' + id, function(data) {
                let select = $('#kabupaten');
                select.empty().append('<option value=""></option>');
                data.forEach(item => {
                    select.append(new Option(item.name, item.id, false, false));
                });
                select.prop('disabled', false).trigger('change');
            });
        }
        updateAlamat();
    });

    // Kabupaten change
    $('#kabupaten').on('change', function() {
        let id = $(this).val();
        
        $('#kecamatan').empty().append('<option value=""></option>').prop('disabled', true).trigger('change');
        $('#desa').empty().append('<option value=""></option>').prop('disabled', true).trigger('change');
        
        if (id) {
            $.get('/wilayah/districts/' + id, function(data) {
                let select = $('#kecamatan');
                select.empty().append('<option value=""></option>');
                data.forEach(item => {
                    select.append(new Option(item.name, item.id, false, false));
                });
                select.prop('disabled', false).trigger('change');
            });
        }
        updateAlamat();
    });

    // Kecamatan change
    $('#kecamatan').on('change', function() {
        let id = $(this).val();
        
        $('#desa').empty().append('<option value=""></option>').prop('disabled', true).trigger('change');
        
        if (id) {
            $.get('/wilayah/villages/' + id, function(data) {
                let select = $('#desa');
                select.empty().append('<option value=""></option>');
                data.forEach(item => {
                    select.append(new Option(item.name, item.id, false, false));
                });
                select.prop('disabled', false).trigger('change');
            });
        }
        updateAlamat();
    });

    // Desa change
    $('#desa').on('change', updateAlamat);

    // Update alamat function
    function updateAlamat() {
        let prov = $('#provinsi option:selected').text();
        let kab = $('#kabupaten option:selected').text();
        let kec = $('#kecamatan option:selected').text();
        let desa = $('#desa option:selected').text();

        // Skip jika masih placeholder
        if (!prov || prov === 'Pilih Provinsi') prov = '';
        if (!kab || kab === 'Pilih Kabupaten/Kota') kab = '';
        if (!kec || kec === 'Pilih Kecamatan') kec = '';
        if (!desa || desa === 'Pilih Desa/Kelurahan') desa = '';

        let parts = [];
        if (desa) parts.push(desa.toUpperCase().trim());
        if (kec) parts.push('KEC. ' + kec.toUpperCase().trim());
        if (kab) parts.push(kab.toUpperCase().trim());
        if (prov) parts.push(prov.toUpperCase().trim());
        
        if (parts.length > 0) {
            parts.push('INDONESIA');
            let alamat = parts.join(', ');
            $('#alamat_final').val(alamat);
            $('#alamat_preview').text(alamat);
        } else {
            $('#alamat_final').val('');
            $('#alamat_preview').text('-');
        }
    }
});
</script>

<!-- Debug info (hapus setelah berhasil) -->
<style>
/* Target semua elemen teks di dalam select2 */
.select2-container * {
    color: inherit;
}

/* Wrapper select2 */
.select2-container--bootstrap-5 .select2-selection--single {
    background-color: #374151 !important;
    border-color: #4b5563 !important;
    height: auto !important;
}

/* Teks yang dipilih */
.select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
    color: #ffffff !important;
}

/* Placeholder */
.select2-container--bootstrap-5 .select2-selection--single .select2-selection__placeholder {
    color: #9ca3af !important;
}

/* Arrow */
.select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
    height: 48px !important;
    width: 40px !important;
}

/* Arrow icon */
.select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow b {
    border-color: #9ca3af transparent transparent transparent !important;
}

/* Ketika dropdown terbuka */
.select2-container--bootstrap-5.select2-container--open .select2-selection--single .select2-selection__arrow b {
    border-color: transparent transparent #9ca3af transparent !important;
}

/* Dropdown */
.select2-container--bootstrap-5 .select2-dropdown {
    background-color: #1f2937 !important;
    border-color: #4b5563 !important;
}

/* Options */
.select2-container--bootstrap-5 .select2-results__option {
    color: #ffffff !important;
}

/* Hover option */
.select2-container--bootstrap-5 .select2-results__option--highlighted {
    background-color: #3b82f6 !important;
    color: #ffffff !important;
}

/* Selected option */
.select2-container--bootstrap-5 .select2-results__option[aria-selected="true"] {
    background-color: #2563eb !important;
    color: #ffffff !important;
}

/* Search box */
.select2-container--bootstrap-5 .select2-search--dropdown {
    background-color: #1f2937 !important;
    padding: 8px !important;
}

.select2-container--bootstrap-5 .select2-search__field {
    background-color: #374151 !important;
    color: #ffffff !important;
    border-color: #4b5563 !important;
    border-radius: 6px !important;
    padding: 8px 12px !important;
}

/* Clear button */
.select2-container--bootstrap-5 .select2-selection__clear {
    color: #9ca3af !important;
    font-size: 18px !important;
    line-height: 48px !important;
}

/* Hover clear button */
.select2-container--bootstrap-5 .select2-selection__clear:hover {
    color: #ffffff !important;
}
</style>

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

    /* File input styling */
    input[type="file"] {
        cursor: pointer;
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
    // Data siswa (untuk edit)
    const siswas = @json($siswas);

    // Initialize Flatpickr
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".flatpickr", {
            locale: "id",
            dateFormat: "d/m/Y",
            altInput: true,
            altFormat: "d F Y",
            maxDate: "today",
            theme: "dark"
        });
    });

    // Modal functions
    function openModal() {
        const modal = document.getElementById('modalSiswa');
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
        const modal = document.getElementById('modalSiswa');
        const modalContent = modal.querySelector('.modal-show');
        
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);
    }

    function openEditModal(btn) {
        const modal = document.getElementById('modalEditSiswa');
        const modalContent = modal.querySelector('.modal-show');
        const form = document.getElementById('formEditSiswa');

        form.action = `/siswa/${btn.dataset.id}`;

        // Isi form dengan data dari button
        document.getElementById('edit_nama_lengkap').value = btn.dataset.nama || '';
        document.getElementById('edit_email').value = btn.dataset.email || '';
        document.getElementById('edit_nama_lengkap_katakana').value = btn.dataset.katakana || '';
        document.getElementById('edit_nama_panggilan').value = btn.dataset.panggilan || '';
        document.getElementById('edit_nama_panggilan_katakana').value = btn.dataset.panggilanKatakana || '';
        document.getElementById('edit_tempat_lahir').value = btn.dataset.tempat || '';
        
        // Tanggal lahir - langsung set value
        const tanggalInput = document.getElementById('edit_tanggal_lahir');
        if (tanggalInput) {
            tanggalInput.value = btn.dataset.tanggal || '';
            
            // Trigger Flatpickr to update
            if (tanggalInput._flatpickr) {
                tanggalInput._flatpickr.setDate(btn.dataset.tanggal || '', true);
            }
        }
        
        document.getElementById('edit_jenis_kelamin').value = btn.dataset.jk || '';
        document.getElementById('edit_agama').value = btn.dataset.agama || '';
        document.getElementById('edit_no_hp').value = btn.dataset.hp || '';
        document.getElementById('edit_alamat').value = btn.dataset.alamat || '';

        // Show current photo if exists
        const siswa = siswas.find(s => s.id == btn.dataset.id);
        if (siswa && siswa.foto) {
            document.getElementById('currentPhoto').src = '/storage/' + siswa.foto;
            document.getElementById('currentPhotoContainer').classList.remove('hidden');
        } else {
            document.getElementById('currentPhotoContainer').classList.add('hidden');
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        const modal = document.getElementById('modalEditSiswa');
        const modalContent = modal.querySelector('.modal-show');
        
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);
    }

    // Photo preview for create modal
    document.getElementById('foto')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileName = document.getElementById('file-name');
        const preview = document.getElementById('photoPreview');
        
        if (file) {
            fileName.textContent = file.name;
            
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB');
                this.value = '';
                fileName.textContent = 'Tidak ada file dipilih';
                preview.innerHTML = '<iconify-icon icon="mdi:camera-plus" width="24" height="24" class="text-gray-500"></iconify-icon>';
                return;
            }
            
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar (JPG/PNG)');
                this.value = '';
                fileName.textContent = 'Tidak ada file dipilih';
                preview.innerHTML = '<iconify-icon icon="mdi:camera-plus" width="24" height="24" class="text-gray-500"></iconify-icon>';
                return;
            }
            
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

    // Photo preview for edit modal
    document.getElementById('edit_foto')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileName = document.getElementById('edit-file-name');
        const preview = document.getElementById('editPhotoPreview');
        
        if (file) {
            fileName.textContent = file.name;
            
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB');
                this.value = '';
                fileName.textContent = 'Tidak ada file dipilih';
                preview.innerHTML = '<iconify-icon icon="mdi:camera-plus" width="24" height="24" class="text-gray-500"></iconify-icon>';
                return;
            }
            
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar (JPG/PNG)');
                this.value = '';
                fileName.textContent = 'Tidak ada file dipilih';
                preview.innerHTML = '<iconify-icon icon="mdi:camera-plus" width="24" height="24" class="text-gray-500"></iconify-icon>';
                return;
            }
            
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
            closeModal();
            closeEditModal();
        }
    });

    // Close modal when clicking outside
    document.getElementById('modalSiswa')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    document.getElementById('modalEditSiswa')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });
</script>
@endsection