@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <iconify-icon icon="mdi:calendar-check" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Data Pertemuan</h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola data pertemuan dan konsultasi</p>
                </div>
            </div>
            
            <a href="{{ route('pertemuan.create') }}" 
               class="w-full sm:w-auto bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm sm:text-base">
                <iconify-icon icon="mdi:plus" width="18" height="18" class="sm:w-5 sm:h-5"></iconify-icon>
                <span>Tambah Pertemuan</span>
            </a>
        </div>
    </div>

    <!-- Notification -->
    @if(session('success'))
    <div class="mb-6 bg-green-500/10 border-l-4 border-green-500 text-green-400 p-4 rounded-lg flex items-center gap-3">
        <iconify-icon icon="mdi:check-circle" width="20" height="20" class="text-green-500"></iconify-icon>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Table -->
    <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 text-gray-400 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">#</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Nama</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Program</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">No HP</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Email</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Alamat</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50">Tanggal</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-700/50 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($pertemuans as $pertemuan)
                    <tr class="hover:bg-gray-700/30 transition-colors group">
                        <td class="px-6 py-4 text-gray-400 text-sm">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">
                            <div class="text-white font-medium">{{ $pertemuan->nama_lengkap }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-xs font-medium">
                                {{ $pertemuan->program }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-300 text-sm">{{ $pertemuan->no_hp ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-300 text-sm">{{ $pertemuan->email ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-300 text-sm max-w-xs truncate">{{ $pertemuan->alamat_lengkap ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-400 text-sm">{{ $pertemuan->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.pertemuan.show', $pertemuan) }}" 
                                   class="bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 p-2 rounded-lg transition-all duration-300">
                                    <iconify-icon icon="mdi:eye" width="16" height="16"></iconify-icon>
                                </a>
                                <form action="{{ route('admin.pertemuan.destroy', $pertemuan) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data pertemuan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600/20 hover:bg-red-600/40 text-red-400 p-2 rounded-lg transition-all duration-300">
                                        <iconify-icon icon="mdi:delete" width="16" height="16"></iconify-icon>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="bg-gray-700/30 p-4 rounded-full">
                                    <iconify-icon icon="mdi:calendar-blank" width="40" height="40" class="text-gray-600"></iconify-icon>
                                </div>
                                <p class="text-gray-500 text-sm">Belum ada data pertemuan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pertemuans->count() > 0)
        <div class="p-4 border-t border-gray-700/50 bg-gray-900/30">
            <div class="flex items-center gap-2 text-gray-400 text-sm">
                <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
                <span>Total {{ $pertemuans->count() }} data pertemuan</span>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection