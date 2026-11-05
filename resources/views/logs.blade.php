@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header with Glassmorphism Effect -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex items-center space-x-3 sm:space-x-4">
            <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                <iconify-icon icon="mdi:history" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Log Aktivitas Saya</h1>
                <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Riwayat aktivitas yang Anda lakukan dalam sistem</p>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="mb-4 sm:mb-6 bg-blue-500/5 border border-blue-500/20 rounded-xl p-3 sm:p-4 flex items-center gap-3">
        <div class="p-1.5 bg-blue-500/10 rounded-lg flex items-center">
            <iconify-icon icon="mdi:information" width="16" height="16" class="text-blue-400"></iconify-icon>
        </div>
        <p class="text-gray-400 text-xs sm:text-sm">
            Menampilkan total <span class="text-white font-semibold">{{ $logs->total() }}</span> aktivitas terakhir Anda. 
            Data tersimpan selama 30 hari terakhir.
        </p>
    </div>

    <!-- Desktop Table View (hidden on mobile) -->
    <div class="hidden md:block bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
        <div class="p-4 sm:p-6 border-b border-gray-700/50">
            <h2 class="text-lg sm:text-xl font-bold text-white flex items-center gap-2">
                <iconify-icon icon="mdi:format-list-bulleted" width="20" height="20" class="text-blue-400"></iconify-icon>
                Daftar Aktivitas
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 text-gray-400 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50 w-16">#</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Action</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">URL</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Description</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse ($logs as $log)
                        <tr class="hover:bg-gray-700/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-1 h-6 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <span class="text-gray-300 font-mono text-sm">{{ $loop->iteration + ($logs->currentPage()-1) * $logs->perPage() }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium 
                                    @if($log->action == 'CREATE' || $log->action == 'Tambah')
                                        bg-green-500/10 text-green-500 border border-green-500/20
                                    @elseif($log->action == 'UPDATE' || $log->action == 'Update')
                                        bg-yellow-500/10 text-yellow-500 border border-yellow-500/20
                                    @elseif($log->action == 'DELETE' || $log->action == 'Hapus')
                                        bg-red-500/10 text-red-500 border border-red-500/20
                                    @elseif($log->action == 'LOGIN')
                                        bg-blue-500/10 text-blue-500 border border-blue-500/20
                                    @else
                                        bg-gray-500/10 text-gray-400 border border-gray-500/20
                                    @endif">
                                    <span class="w-1.5 h-1.5 rounded-full 
                                        @if($log->action == 'CREATE' || $log->action == 'Tambah') bg-green-500
                                        @elseif($log->action == 'UPDATE' || $log->action == 'Update') bg-yellow-500
                                        @elseif($log->action == 'DELETE' || $log->action == 'Hapus') bg-red-500
                                        @elseif($log->action == 'LOGIN') bg-blue-500
                                        @else bg-gray-400
                                        @endif">
                                    </span>
                                    {{ $log->action ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5">
                                    <iconify-icon icon="mdi:link-variant" width="14" height="14" class="text-gray-500"></iconify-icon>
                                    <span class="text-gray-300 text-sm break-all max-w-xs">{{ $log->url }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5">
                                    <iconify-icon icon="mdi:note-text" width="14" height="14" class="text-gray-500"></iconify-icon>
                                    <span class="text-gray-300 text-sm">{{ $log->description ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5">
                                    <iconify-icon icon="mdi:clock-outline" width="14" height="14" class="text-gray-500"></iconify-icon>
                                    <span class="text-gray-300 text-sm">{{ $log->created_at->locale('id')->translatedFormat('d M Y H:i:s') }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="bg-gray-700/30 p-4 rounded-full">
                                        <iconify-icon icon="mdi:history" width="40" height="40" class="text-gray-600"></iconify-icon>
                                    </div>
                                    <p class="text-gray-500 text-sm">Belum ada log aktivitas</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Card View (visible only on mobile) -->
    <div class="md:hidden space-y-4">
        @forelse ($logs as $log)
        <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300">
            <!-- Card Header -->
            <div class="p-4 border-b border-gray-700/50 bg-gray-900/30 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 bg-blue-500/10 rounded-lg">
                        <iconify-icon icon="mdi:counter" width="14" height="14" class="text-blue-400"></iconify-icon>
                    </div>
                    <span class="text-white text-sm font-mono">#{{ $loop->iteration + ($logs->currentPage()-1) * $logs->perPage() }}</span>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium 
                    @if($log->action == 'CREATE' || $log->action == 'Tambah')
                        bg-green-500/10 text-green-500 border border-green-500/20
                    @elseif($log->action == 'UPDATE' || $log->action == 'Update')
                        bg-yellow-500/10 text-yellow-500 border border-yellow-500/20
                    @elseif($log->action == 'DELETE' || $log->action == 'Hapus')
                        bg-red-500/10 text-red-500 border border-red-500/20
                    @elseif($log->action == 'LOGIN')
                        bg-blue-500/10 text-blue-500 border border-blue-500/20
                    @else
                        bg-gray-500/10 text-gray-400 border border-gray-500/20
                    @endif">
                    <span class="w-1.5 h-1.5 rounded-full 
                        @if($log->action == 'CREATE' || $log->action == 'Tambah') bg-green-500
                        @elseif($log->action == 'UPDATE' || $log->action == 'Update') bg-yellow-500
                        @elseif($log->action == 'DELETE' || $log->action == 'Hapus') bg-red-500
                        @elseif($log->action == 'LOGIN') bg-blue-500
                        @else bg-gray-400
                        @endif">
                    </span>
                    {{ $log->action ?? '-' }}
                </span>
            </div>

            <!-- Card Body -->
            <div class="p-4 space-y-3">
                <!-- URL -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-purple-500/10 rounded-lg flex-shrink-0">
                        <iconify-icon icon="mdi:link-variant" width="16" height="16" class="text-purple-400"></iconify-icon>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-gray-400 text-xs">URL</p>
                        <p class="text-white text-sm break-words">{{ $log->url }}</p>
                    </div>
                </div>

                <!-- Description -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-green-500/10 rounded-lg flex-shrink-0">
                        <iconify-icon icon="mdi:note-text" width="16" height="16" class="text-green-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Deskripsi</p>
                        <p class="text-white text-sm">{{ $log->description ?? '-' }}</p>
                    </div>
                </div>

                <!-- Waktu -->
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-yellow-500/10 rounded-lg flex-shrink-0">
                        <iconify-icon icon="mdi:clock-outline" width="16" height="16" class="text-yellow-400"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs">Waktu</p>
                        <p class="text-white text-sm">{{ $log->created_at->locale('id')->translatedFormat('d M Y H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-2xl p-8 text-center backdrop-blur-sm">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full"></div>
                <div class="relative bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                    <iconify-icon icon="mdi:history" width="32" height="32" class="text-gray-600"></iconify-icon>
                </div>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Belum Ada Log Aktivitas</h3>
            <p class="text-gray-500 text-sm max-w-xs mx-auto">
                Belum ada aktivitas yang tercatat dalam sistem.
            </p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($logs->hasPages())
    <div class="mt-6 sm:mt-8">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-gray-500">
                Menampilkan {{ $logs->firstItem() }} - {{ $logs->lastItem() }} dari {{ $logs->total() }} data
            </div>
            
            <div class="flex items-center gap-2">
                @if ($logs->onFirstPage())
                    <span class="px-3 py-2 bg-gray-800/50 text-gray-500 rounded-lg cursor-not-allowed border border-gray-700/50">
                        <iconify-icon icon="mdi:chevron-left" width="18" height="18"></iconify-icon>
                    </span>
                @else
                    <a href="{{ $logs->previousPageUrl() }}" class="px-3 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg transition-colors border border-gray-700/50">
                        <iconify-icon icon="mdi:chevron-left" width="18" height="18"></iconify-icon>
                    </a>
                @endif

                <div class="flex items-center gap-1">
                    @foreach ($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                        @if ($page == $logs->currentPage())
                            <span class="px-3 py-2 bg-blue-600 text-white rounded-lg font-medium">{{ $page }}</span>
                        @elseif ($page == 1 || $page == $logs->lastPage() || ($page >= $logs->currentPage() - 2 && $page <= $logs->currentPage() + 2))
                            <a href="{{ $url }}" class="px-3 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg transition-colors border border-gray-700/50">{{ $page }}</a>
                        @elseif ($page == $logs->currentPage() - 3 || $page == $logs->currentPage() + 3)
                            <span class="px-3 py-2 text-gray-500">...</span>
                        @endif
                    @endforeach
                </div>

                @if ($logs->hasMorePages())
                    <a href="{{ $logs->nextPageUrl() }}" class="px-3 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg transition-colors border border-gray-700/50">
                        <iconify-icon icon="mdi:chevron-right" width="18" height="18"></iconify-icon>
                    </a>
                @else
                    <span class="px-3 py-2 bg-gray-800/50 text-gray-500 rounded-lg cursor-not-allowed border border-gray-700/50">
                        <iconify-icon icon="mdi:chevron-right" width="18" height="18"></iconify-icon>
                    </span>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Scripts -->
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

<style>
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

    /* Table styles */
    table {
        border-collapse: separate;
        border-spacing: 0;
    }

    thead th {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    /* Pagination active */
    .bg-blue-600 {
        box-shadow: 0 4px 10px -2px rgba(37, 99, 235, 0.3);
    }

    /* Action badges */
    .inline-flex {
        transition: all 0.2s ease;
    }

    .inline-flex:hover {
        transform: scale(1.05);
    }

    /* Break word for long URLs */
    .break-words {
        word-break: break-word;
        overflow-wrap: break-word;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .text-xs {
            font-size: 0.7rem;
        }
    }

    /* Animation for hover */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-5px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .group:hover .w-1 {
        animation: slideIn 0.3s ease-out;
    }

    /* Gradient text for header */
    .bg-gradient-to-r {
        background-size: 200% 200%;
        animation: gradientShift 15s ease infinite;
    }

    @keyframes gradientShift {
        0%, 100% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
    }

    /* Info card */
    .bg-blue-500\/5 {
        backdrop-filter: blur(4px);
    }

    /* Empty state animation */
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-5px);
        }
    }

    .relative.inline-block {
        animation: float 3s ease-in-out infinite;
    }
</style>
@endsection