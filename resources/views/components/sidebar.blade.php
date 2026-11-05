@php
    $role = auth()->user()->role;
    $currentRoute = request()->route()->getName();
    $currentUrl = request()->path();
    
    // Cek apakah menu karantina sedang aktif atau salah satu submenunya aktif
    $isKarantinaActive = $currentUrl == 'karantina-siswa' || $currentUrl == 'izin-keluar' || str_starts_with($currentUrl, 'karantina/');
@endphp

<!-- Iconify CDN - Pastikan ini ada di bagian head atau sebelum konten -->
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

<!-- Mobile Menu Button -->
<div class="lg:hidden fixed top-4 left-4 z-50">
    <button id="mobileMenuBtn" class="p-2 bg-slate-800 rounded-lg shadow-lg text-white hover:bg-slate-700 transition">
        <iconify-icon icon="mdi:menu" width="24" height="24"></iconify-icon>
    </button>
</div>

<!-- Overlay for mobile -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden lg:hidden"></div>

<!-- Sidebar -->
<div id="sidebar" class="fixed left-0 top-0 h-screen bg-gradient-to-b from-slate-800 to-slate-900 shadow-2xl transition-all duration-300 z-50
            w-64 lg:w-64
            -translate-x-full lg:translate-x-0
            border-r border-slate-700/50">

    <!-- Sidebar Header with Logo -->
    <div class="relative flex items-center px-6 py-4 border-b border-slate-700/50 bg-gradient-to-r from-blue-600/10 to-purple-600/10">
        <div class="flex items-center gap-3">
            <div>
                <img src="{{ asset('images/logo_footer.png') }}" 
                     alt="Logo"
                     class="h-16 w-auto">
            </div>
        </div>
        
        <!-- Close button for mobile -->
        <button id="closeSidebarBtn" class="lg:hidden absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">
            <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="p-4 h-[calc(100vh-11rem)] overflow-y-auto scrollbar-thin scrollbar-thumb-slate-600 scrollbar-track-transparent" style="scrollbar-color: #475569 transparent;">
        <div class="space-y-1">
            <!-- Dashboard - Common for all -->
            <a href="/dashboard" 
               class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'dashboard' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                <iconify-icon icon="mdi:view-dashboard" width="20" height="20" class="{{ $currentUrl == 'dashboard' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                <span class="font-medium">Dashboard</span>
                @if($currentUrl == 'dashboard')
                    <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                @endif
            </a>

            @if($role === 'admin')
                <!-- Admin Navigation -->
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider flex items-center gap-1">
                        <iconify-icon icon="mdi:shield-crown" width="14" height="14"></iconify-icon>
                        Administration
                    </p>
                </div>

                <a href="/guru" 
                   class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'guru' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <iconify-icon icon="mdi:teach" width="20" height="20" class="{{ $currentUrl == 'guru' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                    <span class="font-medium">Guru</span>
                    @if($currentUrl == 'guru')
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>

                <a href="/siswa" 
                   class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'siswa' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <iconify-icon icon="mdi:account-group" width="20" height="20" class="{{ $currentUrl == 'siswa' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                    <span class="font-medium">Siswa</span>
                    @if($currentUrl == 'siswa')
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>

                <a href="/perusahaan" 
                   class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'perusahaan' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <iconify-icon icon="mdi:office-building" width="20" height="20" class="{{ $currentUrl == 'perusahaan' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                    <span class="font-medium">Perusahaan</span>
                    @if($currentUrl == 'perusahaan')
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>

                <div class="space-y-1">
                    <!-- Parent Menu: Karantina (dengan toggle) -->
                    <div class="relative">
                        <button onclick="toggleKarantinaSubmenu()" 
                                class="w-full flex items-center justify-between gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 text-gray-300 hover:bg-slate-700/50 hover:text-white group {{ $isKarantinaActive ? 'bg-slate-700/30 text-white' : '' }}">
                            <div class="flex items-center gap-3">
                                <iconify-icon icon="mdi:medical-bag" width="20" height="20" class="{{ $isKarantinaActive ? 'text-blue-400' : 'text-gray-400' }} group-hover:text-blue-400"></iconify-icon>
                                <span class="font-medium">Karantina</span>
                            </div>
                            <iconify-icon icon="mdi:chevron-down" width="18" height="18" 
                                        class="transform transition-transform duration-300 {{ session('karantina_submenu_open', false) ? 'rotate-180' : '' }}"
                                        id="karantinaChevron"></iconify-icon>
                        </button>
                    </div>

                    <!-- Submenu Items -->
                    <div id="karantinaSubmenu" class="ml-6 space-y-1 overflow-hidden transition-all duration-300 {{ session('karantina_submenu_open', false) ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                        <!-- Karantina Dashboard -->
                        <a href="/karantina" 
                           class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 text-sm {{ $currentUrl == 'karantina-siswa' ? 'bg-gradient-to-r from-blue-600/80 to-blue-700/80 text-white shadow-lg' : 'text-gray-400 hover:bg-slate-700/30 hover:text-white' }} group">
                            <iconify-icon icon="mdi:view-dashboard" width="16" height="16" class="{{ $currentUrl == 'karantina-siswa' ? 'text-white' : 'text-gray-500' }} group-hover:text-blue-400"></iconify-icon>
                            <span>Kelas</span>
                            @if($currentUrl == 'karantina')
                                <span class="ml-auto w-1 h-1 bg-white rounded-full"></span>
                            @endif
                        </a>

                        <!-- Izin Keluar -->
                        <a href="/admin/izin-keluar" 
                           class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 text-sm {{ $currentUrl == 'izin-keluar' ? 'bg-gradient-to-r from-blue-600/80 to-blue-700/80 text-white shadow-lg' : 'text-gray-400 hover:bg-slate-700/30 hover:text-white' }} group">
                            <iconify-icon icon="mdi:exit-to-app" width="16" height="16" class="{{ $currentUrl == 'izin-keluar' ? 'text-white' : 'text-gray-500' }} group-hover:text-blue-400"></iconify-icon>
                            <span>Izin Keluar</span>
                            @if($currentUrl == 'admin/izin-keluar')
                                <span class="ml-auto w-1 h-1 bg-white rounded-full"></span>
                            @endif
                        </a>
                    </div>
                </div>
                
                <a href="/keberangkatan" 
                class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'keberangkatan' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                
                <iconify-icon icon="mdi:airplane-takeoff" width="20" height="20"
                class="{{ $currentUrl == 'keberangkatan' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                
                <span class="font-medium">Keberangkatan</span>
                
                @if($currentUrl == 'keberangkatan')
                <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                @endif
                
                </a>
                <a href="/tagihan" 
                   class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'tagihan' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <iconify-icon icon="mdi:cash" width="20" height="20" class="{{ $currentUrl == 'tagihan' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                    <span class="font-medium">Tagihan</span>
                    @if($currentUrl == 'tagihan')
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>
                <a href="/admin/pendaftaran" 
                class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'admin/pendaftaran' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <iconify-icon icon="mdi:clipboard-text" width="20" height="20" class="{{ $currentUrl == 'admin/pendaftaran' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                    <span class="font-medium">Pendaftaran</span>
                    @if($currentUrl == 'admin/pendaftaran')
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>

                <a href="/admin/pertemuan" 
                class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'admin/pertemuan' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <iconify-icon icon="griddy-icons:meet-and-greet-filled" width="20" height="20" class="{{ $currentUrl == 'admin/pertemuan' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                    <span class="font-medium">Pertemuan</span>
                    @if($currentUrl == 'admin/pertemuan')
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>

                <a href="/inbox" 
                class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'inbox' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <iconify-icon icon="ic:baseline-message" width="20" height="20" class="{{ $currentUrl == 'inbox' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                    <span class="font-medium">Kotak Masuk</span>
                    @if($currentUrl == 'inbox')
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>

                <a href="/gallery" 
                class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'gallery' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <iconify-icon icon="mdi:image-filter-frames" width="20" height="20" class="{{ $currentUrl == 'gallery' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                    <span class="font-medium">Galeri</span>
                    @if($currentUrl == 'gallery')
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>

                <a href="/faq" 
                class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'faq' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <iconify-icon icon="wpf:faq" width="20" height="20" class="{{ $currentUrl == 'faq' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                    <span class="font-medium">Faq</span>
                    @if($currentUrl == 'faq')
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>
                <a href="/job-vacancy" 
                class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'job-vacancy' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <iconify-icon icon="material-symbols:work" width="20" height="20" class="{{ $currentUrl == 'job-vacancy' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                    <span class="font-medium">Lowongan Kerja</span>
                    @if($currentUrl == 'job-vacancy')
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>
            @endif

            @if($role === 'siswa')
                @php
                    $siswa = auth()->user()->siswa;
                    $statusKode = $siswa?->status?->kode_status;
                @endphp

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider flex items-center gap-1">
                        <iconify-icon icon="mdi:school" width="14" height="14"></iconify-icon>
                        Student Menu
                    </p>
                </div>

                <a href="/biodata" 
                   class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'biodata' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <iconify-icon icon="mdi:account-details" width="20" height="20" class="{{ $currentUrl == 'biodata' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                    <span class="font-medium">Biodata</span>
                    @if($currentUrl == 'biodata')
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>

                {{-- Interview muncul jika sedang proses interview atau punya riwayat interview --}}
                @if(($statusKode && $statusKode !== 'kandidat') || ($siswa && $siswa->interviewLogs()->exists()))
                <a href="{{ route('siswa.interview') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('siswa.interview') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <iconify-icon icon="mdi:chat" width="20" height="20" class="{{ request()->routeIs('siswa.interview') ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                    <span class="font-medium">Interview</span>
                    @if(request()->routeIs('siswa.interview'))
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>
                @endif

                {{-- Karantina Menu dengan Submenu (hanya muncul jika sudah masuk karantina) --}}
                @if(in_array($statusKode, ['karantina','berangkat']))
                <div class="space-y-1">
                    <!-- Parent Menu: Karantina (dengan toggle) -->
                    <div class="relative">
                        <button onclick="toggleKarantinaSubmenu()" 
                                class="w-full flex items-center justify-between gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 text-gray-300 hover:bg-slate-700/50 hover:text-white group {{ $isKarantinaActive ? 'bg-slate-700/30 text-white' : '' }}">
                            <div class="flex items-center gap-3">
                                <iconify-icon icon="mdi:medical-bag" width="20" height="20" class="{{ $isKarantinaActive ? 'text-blue-400' : 'text-gray-400' }} group-hover:text-blue-400"></iconify-icon>
                                <span class="font-medium">Karantina</span>
                            </div>
                            <iconify-icon icon="mdi:chevron-down" width="18" height="18" 
                                        class="transform transition-transform duration-300 {{ session('karantina_submenu_open', false) ? 'rotate-180' : '' }}"
                                        id="karantinaChevron"></iconify-icon>
                        </button>
                    </div>

                    <!-- Submenu Items -->
                    <div id="karantinaSubmenu" class="ml-6 space-y-1 overflow-hidden transition-all duration-300 {{ session('karantina_submenu_open', false) ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                        <!-- Karantina Dashboard -->
                        <a href="/karantina-siswa" 
                           class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 text-sm {{ $currentUrl == 'karantina-siswa' ? 'bg-gradient-to-r from-blue-600/80 to-blue-700/80 text-white shadow-lg' : 'text-gray-400 hover:bg-slate-700/30 hover:text-white' }} group">
                            <iconify-icon icon="mdi:view-dashboard" width="16" height="16" class="{{ $currentUrl == 'karantina-siswa' ? 'text-white' : 'text-gray-500' }} group-hover:text-blue-400"></iconify-icon>
                            <span>Absensi</span>
                            @if($currentUrl == 'karantina-siswa')
                                <span class="ml-auto w-1 h-1 bg-white rounded-full"></span>
                            @endif
                        </a>

                        <!-- Izin Keluar -->
                        <a href="/izin-keluar" 
                           class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 text-sm {{ $currentUrl == 'izin-keluar' ? 'bg-gradient-to-r from-blue-600/80 to-blue-700/80 text-white shadow-lg' : 'text-gray-400 hover:bg-slate-700/30 hover:text-white' }} group">
                            <iconify-icon icon="mdi:exit-to-app" width="16" height="16" class="{{ $currentUrl == 'izin-keluar' ? 'text-white' : 'text-gray-500' }} group-hover:text-blue-400"></iconify-icon>
                            <span>Izin Keluar</span>
                            @if($currentUrl == 'izin-keluar')
                                <span class="ml-auto w-1 h-1 bg-white rounded-full"></span>
                            @endif
                        </a>
                    </div>
                </div>
                <a href="/keberangkatan-saya" 
                   class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'keberangkatan-saya' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <iconify-icon icon="mdi:airplane-takeoff" width="20" height="20" class="{{ $currentUrl == 'keberangkatan-saya' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                    <span class="font-medium">Keberangkatan</span>
                    @if($currentUrl == 'keberangkatan-saya')
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>
                @endif

                <a href="/kartu-keluarga" 
                   class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'kartu-keluarga' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <iconify-icon icon="mdi:family-tree" width="20" height="20" class="{{ $currentUrl == 'kartu-keluarga' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                    <span class="font-medium">Kartu Keluarga</span>
                    @if($currentUrl == 'kartu-keluarga')
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>

                <a href="/pembayaran" 
                   class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'pembayaran' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <iconify-icon icon="mdi:credit-card" width="20" height="20" class="{{ $currentUrl == 'pembayaran' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                    <span class="font-medium">Pembayaran</span>
                    @if($currentUrl == 'pembayaran')
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>

                <a href="/logs" 
                   class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ $currentUrl == 'logs' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <iconify-icon icon="mdi:history" width="20" height="20" class="{{ $currentUrl == 'logs' ? 'text-white' : 'text-gray-400' }}"></iconify-icon>
                    <span class="font-medium">Log User</span>
                    @if($currentUrl == 'logs')
                        <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                    @endif
                </a>
            @endif
        </div>
    </nav>

    <!-- Logout Button at Bottom -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-700/50 bg-gradient-to-t from-slate-900 to-transparent">
        <form method="POST" action="/logout" class="w-full">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-gray-300 hover:bg-red-600/20 hover:text-red-400 transition-all duration-200 group">
                <iconify-icon icon="mdi:logout" width="20" height="20" class="text-gray-400 group-hover:text-red-400"></iconify-icon>
                <span class="font-medium">Logout</span>
                <span class="ml-auto text-xs text-gray-600">Ctrl+L</span>
            </button>
        </form>
    </div>
</div>

<!-- JavaScript untuk dropdown submenu -->
<script>
// Fungsi untuk toggle submenu karantina
function toggleKarantinaSubmenu() {
    const submenu = document.getElementById('karantinaSubmenu');
    const chevron = document.getElementById('karantinaChevron');
    
    if (submenu.classList.contains('max-h-96')) {
        // Close submenu
        submenu.classList.remove('max-h-96', 'opacity-100');
        submenu.classList.add('max-h-0', 'opacity-0');
        chevron.classList.remove('rotate-180');
        
        // Simpan state ke session (opsional, bisa via AJAX)
        // saveSubmenuState('closed');
    } else {
        // Open submenu
        submenu.classList.remove('max-h-0', 'opacity-0');
        submenu.classList.add('max-h-96', 'opacity-100');
        chevron.classList.add('rotate-180');
        
        // Simpan state ke session (opsional)
        // saveSubmenuState('open');
    }
}

// Fungsi untuk menyimpan state submenu (opsional, jika ingin persist)
function saveSubmenuState(state) {
    // Bisa menggunakan fetch API untuk menyimpan ke session
    fetch('/save-submenu-state', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ submenu: 'karantina', state: state })
    });
}

// Auto-open submenu jika salah satu submenu aktif
document.addEventListener('DOMContentLoaded', function() {
    const isKarantinaActive = {{ $isKarantinaActive ? 'true' : 'false' }};
    const submenu = document.getElementById('karantinaSubmenu');
    const chevron = document.getElementById('karantinaChevron');
    
    if (isKarantinaActive && submenu && chevron) {
        submenu.classList.remove('max-h-0', 'opacity-0');
        submenu.classList.add('max-h-96', 'opacity-100');
        chevron.classList.add('rotate-180');
    }
});

// JavaScript untuk Mobile Responsiveness (sama seperti sebelumnya)
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const closeSidebarBtn = document.getElementById('closeSidebarBtn');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
    }

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', openSidebar);
    }

    if (closeSidebarBtn) {
        closeSidebarBtn.addEventListener('click', closeSidebar);
    }

    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        } else {
            sidebar.classList.add('-translate-x-full');
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'l') {
            e.preventDefault();
            document.querySelector('form[action="/logout"] button')?.click();
        }
    });

    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 1024) {
                closeSidebar();
            }
        });
    });
});
</script>

<!-- Custom Scrollbar Styles (sama seperti sebelumnya) -->
<style>
/* Iconify icon styling */
iconify-icon {
    display: inline-block;
    vertical-align: middle;
}

/* Scrollbar styles */
.scrollbar-thin {
    scrollbar-width: thin;
}

.scrollbar-thin::-webkit-scrollbar {
    width: 4px;
}

.scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
}

.scrollbar-thin::-webkit-scrollbar-thumb {
    background-color: #475569;
    border-radius: 20px;
}

.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background-color: #64748b;
}

/* Active link animation */
.nav-link {
    position: relative;
    overflow: hidden;
}

.nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #3b82f6, #8b5cf6);
    transition: width 0.3s ease;
}

.nav-link:hover::after {
    width: 80%;
}

.nav-link.active::after {
    width: 80%;
}

/* Active link background */
.nav-link.bg-gradient-to-r {
    position: relative;
    overflow: hidden;
}

.nav-link.bg-gradient-to-r::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, rgba(255,255,255,0.1), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.nav-link.bg-gradient-to-r:hover::before {
    opacity: 1;
}

/* Sidebar gradient animation */
.bg-gradient-to-b {
    background-size: 100% 200%;
    animation: gradientShift 10s ease infinite;
}

@keyframes gradientShift {
    0%, 100% {
        background-position: 0% 0%;
    }
    50% {
        background-position: 0% 100%;
    }
}

/* Active menu indicator */
.nav-link .ml-auto.w-1\.5 {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.7;
        transform: scale(1.2);
    }
}

/* Hover effect for menu items */
.nav-link:not(.bg-gradient-to-r):hover {
    transform: translateX(5px);
}

/* Transition for all interactive elements */
.nav-link, .nav-link * {
    transition: all 0.2s ease;
}

/* Responsive adjustments */
@media (max-width: 1023px) {
    #sidebar {
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
    }
}

/* Submenu transitions */
#karantinaSubmenu {
    transition: all 0.3s ease-in-out;
    transform-origin: top;
}

/* Chevron rotation */
.rotate-180 {
    transform: rotate(180deg);
}

/* Submenu link styling */
.nav-link.text-sm {
    font-size: 0.875rem;
    padding-top: 0.6rem;
    padding-bottom: 0.6rem;
}

/* Indent untuk submenu */
.ml-6 {
    margin-left: 1.5rem;
}

/* Active submenu item */
.nav-link.bg-gradient-to-r\/80 {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.8), rgba(29, 78, 216, 0.8));
}
</style>