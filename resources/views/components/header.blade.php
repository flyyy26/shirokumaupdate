@php
    $role = auth()->user()->role;
    $currentRoute = request()->route()->getName();
    $currentUrl = request()->path();
@endphp
<header class="bg-gradient-to-r from-slate-800 to-slate-900 border-b border-slate-700/50 sticky top-0 z-30 backdrop-blur-sm">
    <div class="px-4 sm:px-6 py-3 sm:py-4">
        <div class="flex items-center justify-between">
            <!-- Left Section: Mobile Menu Button & Page Title -->
            <div class="flex items-center gap-3">
                <!-- Mobile Menu Button (hanya muncul di mobile) -->
                <button id="mobileMenuBtn" class="lg:hidden p-2 bg-slate-700/50 hover:bg-slate-600/50 rounded-lg text-white transition-all">
                    <iconify-icon icon="mdi:menu" width="20" height="20"></iconify-icon>
                </button>

                <!-- Page Indicator dengan Icon (hanya di mobile) -->
                <div class="lg:hidden flex items-center gap-2">
                    <div class="p-2 bg-blue-500/10 rounded-lg">
                        @php
                            $currentPath = request()->path();
                            $iconMap = [
                                'biodata' => 'mdi:account-details',
                                'interview' => 'mdi:chat',
                                'karantina' => 'mdi:medical-bag',
                                'izin-keluar' => 'mdi:exit-to-app',
                                'kartu-keluarga' => 'mdi:family-tree',
                                'pembayaran' => 'mdi:cash',
                                'logs' => 'mdi:history',
                                'settings' => 'mdi:cog',
                                'guru' => 'mdi:teach',
                                'siswa' => 'mdi:account-group',
                                'perusahaan' => 'mdi:office-building',
                                'tagihan' => 'mdi:cash',
                            ];
                            
                            $icon = 'mdi:view-dashboard'; // default
                            foreach ($iconMap as $key => $value) {
                                if (str_contains($currentPath, $key)) {
                                    $icon = $value;
                                    break;
                                }
                            }
                        @endphp
                        <iconify-icon icon="{{ $icon }}" width="18" height="18" class="text-blue-400"></iconify-icon>
                    </div>
                    <div>
                        <h1 class="text-base font-semibold text-white">
                            @php
                                $titleMap = [
                                    'biodata' => 'Biodata',
                                    'interview' => 'Interview',
                                    'karantina-siswa' => 'Karantina',
                                    'izin-keluar' => 'Izin Keluar',
                                    'kartu-keluarga' => 'Kartu Keluarga',
                                    'pembayaran' => 'Pembayaran',
                                    'logs' => 'Log Aktivitas',
                                    'settings' => 'Pengaturan',
                                    'guru' => 'Guru',
                                    'siswa' => 'Siswa',
                                    'perusahaan' => 'Perusahaan',
                                    'tagihan' => 'Tagihan',
                                ];
                                
                                $title = 'Dashboard'; // default
                                foreach ($titleMap as $key => $value) {
                                    if (str_contains($currentPath, $key)) {
                                        $title = $value;
                                        break;
                                    }
                                }
                            @endphp
                            {{ $title }}
                        </h1>
                    </div>
                </div>

                <!-- Breadcrumb untuk desktop -->
                <nav class="hidden lg:flex items-center gap-2 text-sm">
                    <a href="/dashboard" class="text-gray-400 hover:text-white transition-colors">
                        <iconify-icon icon="mdi:home" width="16" height="16"></iconify-icon>
                    </a>
                    <iconify-icon icon="mdi:chevron-right" width="14" height="14" class="text-gray-600"></iconify-icon>
                    <span class="text-blue-400 font-medium">Dashboard</span>
                </nav>
            </div>

            <!-- Center Section: Search (hidden on mobile) -->
            <!-- <div class="hidden md:block flex-1 max-w-md mx-4">
                <div class="relative">
                    <input type="text" 
                           placeholder="Cari sesuatu... (Ctrl+K)" 
                           class="w-full bg-slate-700/50 border border-slate-600 rounded-lg pl-9 pr-4 py-2 text-sm text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    <iconify-icon icon="mdi:magnify" width="16" height="16" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></iconify-icon>
                </div>
            </div> -->

            <!-- Right Section: Actions & User Menu -->
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Search Button for Mobile -->
                <!-- <button class="md:hidden p-2 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all">
                    <iconify-icon icon="mdi:magnify" width="18" height="18"></iconify-icon>
                </button> -->

                <!-- Notifications -->
                <!-- <button class="relative p-2 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all group">
                    <iconify-icon icon="mdi:bell-outline" width="18" height="18" class="group-hover:scale-110 transition-transform"></iconify-icon>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-slate-800"></span>
                </button> -->

                <!-- Fullscreen Toggle (desktop only) -->
                <button onclick="toggleFullscreen()" class="hidden lg:block p-2 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all group">
                    <iconify-icon icon="mdi:fullscreen" width="18" height="18" class="group-hover:scale-110 transition-transform"></iconify-icon>
                </button>

                <!-- Divider (desktop only) -->
                <div class="hidden lg:block h-6 w-px bg-slate-700/50 mx-1"></div>

                <!-- User Menu (Desktop) -->
                <div class="hidden lg:block relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-3 hover:bg-slate-700/50 pl-2 pr-3 py-1.5 rounded-lg transition-all group">
                        <!-- User Avatar dengan foto/inisial -->
                        <div class="w-8 h-8 rounded-lg overflow-hidden shadow-lg group-hover:shadow-xl transition-shadow bg-gradient-to-br from-blue-500 to-purple-600">
                            @php
                                $siswa = Auth::user()->siswa;
                            @endphp
                            @if($siswa && $siswa->foto)
                                <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">
                                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- User Info -->
                        <div class="text-left">
                            <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-400">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                        </div>

                        <!-- Dropdown Icon -->
                        <iconify-icon icon="mdi:chevron-down" width="16" height="16" class="text-gray-400 transition-transform duration-300" :class="{'rotate-180': open}"></iconify-icon>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" x-cloak @click.away="open = false" 
                         class="absolute right-0 mt-2 w-56 bg-slate-800 rounded-xl shadow-2xl border border-slate-700/50 overflow-hidden z-50"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1">
                        
                        <!-- User Info Header -->
                        <div class="p-4 bg-gradient-to-r from-blue-600/10 to-purple-600/10 border-b border-slate-700/50">
                            <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                            <p class="text-xs text-blue-400 mt-1 capitalize">{{ Auth::user()->role }}</p>
                        </div>

                        <!-- Menu Items -->
                        <div class="p-2">
                            @if($role === 'siswa')
                                <a href="/biodata" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-300 hover:bg-slate-700/50 hover:text-white rounded-lg transition-colors">
                                    <iconify-icon icon="mdi:account" width="18" height="18" class="text-gray-400"></iconify-icon>
                                    <span>Profil Saya</span>
                                </a>
                            @endif

                            <a href="/settings" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-300 hover:bg-slate-700/50 hover:text-white rounded-lg transition-colors">
                                <iconify-icon icon="mdi:cog" width="18" height="18" class="text-gray-400"></iconify-icon>
                                <span>Pengaturan</span>
                            </a>

                            <div class="border-t border-slate-700/50 my-2"></div>

                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-sm text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                                    <iconify-icon icon="mdi:logout" width="18" height="18" class="text-red-400"></iconify-icon>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile User Avatar (triggers mobile dropdown) -->
                <div class="lg:hidden relative" x-data="{ open: false }">
                    <button @click="open = !open" class="p-1 hover:bg-slate-700/50 rounded-lg transition-all">
                        <div class="w-8 h-8 rounded-lg overflow-hidden shadow-lg bg-gradient-to-br from-blue-500 to-purple-600">
                            @php
                                $siswa = Auth::user()->siswa;
                            @endphp
                            @if($siswa && $siswa->foto)
                                <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">
                                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </button>

                    <!-- Mobile Dropdown Menu -->
                    <div x-show="open" x-cloak @click.away="open = false" 
                         class="absolute right-0 mt-2 w-64 bg-slate-800 rounded-xl shadow-2xl border border-slate-700/50 overflow-hidden z-50"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        
                        <!-- User Info -->
                        <div class="p-4 bg-gradient-to-r from-blue-600/10 to-purple-600/10 border-b border-slate-700/50">
                            <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                            <p class="text-xs text-blue-400 mt-1 capitalize">{{ Auth::user()->role }}</p>
                        </div>

                        <!-- Menu Items -->
                        <div class="p-2">
                            <a href="/biodata" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-300 hover:bg-slate-700/50 hover:text-white rounded-lg transition-colors">
                                <iconify-icon icon="mdi:account" width="18" height="18" class="text-gray-400"></iconify-icon>
                                <span>Profil Saya</span>
                            </a>

                            <a href="/settings" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-300 hover:bg-slate-700/50 hover:text-white rounded-lg transition-colors">
                                <iconify-icon icon="mdi:cog" width="18" height="18" class="text-gray-400"></iconify-icon>
                                <span>Pengaturan</span>
                            </a>

                            <div class="border-t border-slate-700/50 my-2"></div>

                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-sm text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                                    <iconify-icon icon="mdi:logout" width="18" height="18" class="text-red-400"></iconify-icon>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Search Bar (hidden by default) -->
        <!-- <div class="md:hidden mt-3 hidden" id="mobileSearch">
            <div class="relative">
                <input type="text" 
                       placeholder="Cari sesuatu..." 
                       class="w-full bg-slate-700/50 border border-slate-600 rounded-lg pl-9 pr-4 py-2.5 text-sm text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                <iconify-icon icon="mdi:magnify" width="16" height="16" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></iconify-icon>
            </div>
        </div> -->
    </div>
</header>

<!-- Tambahkan Alpine.js untuk dropdown -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    // Toggle mobile search
    document.querySelector('.md\\:hidden.p-2[icon="mdi:magnify"]')?.addEventListener('click', function() {
        const searchBar = document.getElementById('mobileSearch');
        searchBar.classList.toggle('hidden');
        if (!searchBar.classList.contains('hidden')) {
            searchBar.querySelector('input').focus();
        }
    });

    // Fullscreen toggle function
    function toggleFullscreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    }

    // Close dropdown when clicking outside (fallback untuk Alpine.js)
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('[x-data="{ open: false }"]');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target)) {
                if (dropdown.__x) {
                    dropdown.__x.$data.open = false;
                }
            }
        });
    });

    // Handle window resize untuk responsive
    let resizeTimer;
    window.addEventListener('resize', function() {
        document.body.classList.add('resize-animation-stopper');
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            document.body.classList.remove('resize-animation-stopper');
        }, 400);
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K untuk focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const desktopSearch = document.querySelector('.hidden.md\\:block input[placeholder*="Cari"]');
            const mobileSearch = document.querySelector('#mobileSearch input');
            
            if (window.innerWidth >= 768 && desktopSearch) {
                desktopSearch.focus();
            } else if (window.innerWidth < 768) {
                const mobileSearchBar = document.getElementById('mobileSearch');
                mobileSearchBar.classList.remove('hidden');
                if (mobileSearch) {
                    mobileSearch.focus();
                }
            }
        }
        
        // ESC untuk menutup dropdown dan mobile search
        if (e.key === 'Escape') {
            const openDropdowns = document.querySelectorAll('[x-data="{ open: false }"]');
            openDropdowns.forEach(dropdown => {
                if (dropdown.__x) {
                    dropdown.__x.$data.open = false;
                }
            });
            
            // Close mobile search
            document.getElementById('mobileSearch')?.classList.add('hidden');
        }
    });

    // Show keyboard shortcut hint di search
    const desktopSearch = document.querySelector('.hidden.md\\:block input[placeholder*="Cari"]');
    if (desktopSearch) {
        const shortcutHint = document.createElement('span');
        shortcutHint.className = 'absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-500';
        shortcutHint.textContent = '⌘K';
        desktopSearch.parentElement.appendChild(shortcutHint);
    }
</script>

<style>
    /* Animasi untuk header */
    header {
        transition: all 0.3s ease;
    }

    /* Sticky header dengan efek blur */
    .sticky {
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    /* Hover effects */
    .hover\:bg-slate-700\/50 {
        transition: all 0.2s ease;
    }

    /* Rotate animation untuk chevron */
    .rotate-180 {
        transform: rotate(180deg);
    }

    /* Custom scrollbar untuk dropdown */
    .bg-slate-800 {
        scrollbar-width: thin;
        scrollbar-color: #4b5563 #1f2937;
    }

    .bg-slate-800::-webkit-scrollbar {
        width: 4px;
    }

    .bg-slate-800::-webkit-scrollbar-track {
        background: #1f2937;
    }

    .bg-slate-800::-webkit-scrollbar-thumb {
        background-color: #4b5563;
        border-radius: 4px;
    }

    /* Transisi untuk dropdown */
    [x-cloak] { 
        display: none !important; 
    }

    /* Gradient animation untuk avatar */
    .bg-gradient-to-br {
        background-size: 200% 200%;
        animation: gradientShift 5s ease infinite;
    }

    @keyframes gradientShift {
        0%, 100% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
    }

    /* Responsive breakpoints */
    @media (max-width: 640px) {
        header .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }

    /* Focus states */
    input:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
    }

    /* Loading state untuk tombol */
    .loading {
        position: relative;
        pointer-events: none;
        opacity: 0.7;
    }

    .loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid transparent;
        border-top-color: currentColor;
        border-radius: 50%;
        animation: spinner 0.6s linear infinite;
    }

    @keyframes spinner {
        to {
            transform: rotate(360deg);
        }
    }

    /* Animasi untuk mobile search */
    #mobileSearch {
        animation: slideDown 0.3s ease-out;
    }

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
</style>