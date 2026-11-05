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
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Detail Pertemuan</h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">{{ $pertemuan->nama_lengkap }}</p>
                </div>
            </div>
            
            <a href="{{ route('admin.pertemuan.index') }}" 
               class="w-full sm:w-auto bg-white/20 hover:bg-white/30 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 text-sm sm:text-base">
                <iconify-icon icon="mdi:arrow-left" width="18" height="18"></iconify-icon>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-2xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="text-xs text-gray-500 font-medium uppercase tracking-wider">Nama Lengkap</label>
                        <p class="text-white font-medium text-lg mt-1">{{ $pertemuan->nama_lengkap }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 font-medium uppercase tracking-wider">Program</label>
                        <p class="text-white font-medium mt-1">
                            <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-sm">
                                {{ $pertemuan->program }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 font-medium uppercase tracking-wider">No HP</label>
                        <p class="text-white font-medium mt-1">{{ $pertemuan->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 font-medium uppercase tracking-wider">Email</label>
                        <p class="text-white font-medium mt-1">{{ $pertemuan->email ?? '-' }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="text-xs text-gray-500 font-medium uppercase tracking-wider">Alamat Lengkap</label>
                        <p class="text-gray-300 mt-1 leading-relaxed">{{ $pertemuan->alamat_lengkap ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 font-medium uppercase tracking-wider">Catatan Tambahan</label>
                        <p class="text-gray-300 mt-1 leading-relaxed">{{ $pertemuan->catatan ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 font-medium uppercase tracking-wider">Tanggal Dibuat</label>
                        <p class="text-gray-400 mt-1">{{ $pertemuan->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 font-medium uppercase tracking-wider">Terakhir Diperbarui</label>
                        <p class="text-gray-400 mt-1">{{ $pertemuan->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection