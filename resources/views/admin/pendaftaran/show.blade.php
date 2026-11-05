@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-4xl p-3 md:p-0">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-white flex items-center gap-2">
            <a href="{{ route('admin.pendaftaran.index') }}" class="text-gray-400 hover:text-white">
                <iconify-icon icon="mdi:arrow-left" width="24" height="24"></iconify-icon>
            </a>
            Detail Pendaftaran
        </h1>
        
        <div class="flex gap-2">
            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $pendaftaran->no_hp) }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 text-sm">
                <iconify-icon icon="mdi:whatsapp" width="18" height="18"></iconify-icon>
                Hubungi
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Data Diri -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">Data Pribadi</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-500 text-xs uppercase">Nama Lengkap</label>
                        <p class="text-white font-medium">{{ $pendaftaran->nama_lengkap }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500 text-xs uppercase">Program</label>
                        <p class="text-blue-400 font-medium uppercase">{{ $pendaftaran->program }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500 text-xs uppercase">Tempat, Tanggal Lahir</label>
                        <p class="text-white">{{ $pendaftaran->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500 text-xs uppercase">No HP</label>
                        <p class="text-white">{{ $pendaftaran->no_hp }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="text-gray-500 text-xs uppercase">Alamat</label>
                        <p class="text-white">{{ $pendaftaran->alamat }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl border border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">Pendidikan & Fisik</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-500 text-xs uppercase">Pendidikan Terakhir</label>
                        <p class="text-white">{{ $pendaftaran->pendidikan_terakhir }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500 text-xs uppercase">Jurusan</label>
                        <p class="text-white">{{ $pendaftaran->jurusan ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500 text-xs uppercase">Pengalaman Jepang</label>
                        <p class="text-white">{{ $pendaftaran->pernah_belajar_jepang ? 'Sudah Pernah' : 'Belum Pernah' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500 text-xs uppercase">Fisik</label>
                        <p class="text-white">{{ $pendaftaran->tinggi_badan }} cm / {{ $pendaftaran->berat_badan }} kg</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Bukti Pembayaran -->
        <div class="md:col-span-1">
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-6 sticky top-6">
                <h3 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">Bukti Pembayaran</h3>
                
                @if($pendaftaran->bukti_pembayaran)
                    <div class="mb-4 rounded-lg overflow-hidden border border-gray-600">
                        @php
                            $ext = pathinfo($pendaftaran->bukti_pembayaran, PATHINFO_EXTENSION);
                        @endphp
                        
                        @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                            <img src="{{ asset('storage/' . $pendaftaran->bukti_pembayaran) }}" class="w-full h-auto object-contain">
                        @else
                            <div class="p-8 text-center bg-gray-700">
                                <iconify-icon icon="mdi:file-pdf" width="48" class="text-red-400 mb-2"></iconify-icon>
                                <p class="text-white text-sm">Dokumen PDF</p>
                            </div>
                        @endif
                    </div>
                    
                    <a href="{{ asset('storage/' . $pendaftaran->bukti_pembayaran) }}" target="_blank" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg flex items-center justify-center gap-2 text-sm transition-colors">
                        <iconify-icon icon="mdi:download" width="18"></iconify-icon>
                        Download / Lihat
                    </a>
                @else
                    <div class="p-6 text-center border-2 border-dashed border-gray-600 rounded-lg">
                        <iconify-icon icon="mdi:image-off" width="32" class="text-gray-500 mb-2"></iconify-icon>
                        <p class="text-gray-500 text-sm">Tidak ada bukti pembayaran</p>
                    </div>
                @endif

                <div class="mt-6 pt-4 border-t border-gray-700">
                    <p class="text-gray-400 text-xs mb-2">Tanggal Daftar</p>
                    <p class="text-white text-sm">{{ $pendaftaran->created_at->format('d F Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
