@extends('layouts.app')

@section('content')
<div class="container mx-auto pb-10">
    <!-- Header Profil -->
    <div class="mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-0 md:rounded-2xl shadow-xl p-4 md:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-4">
                <a href="{{ route('siswa.index') }}" class="p-2 bg-white/10 hover:bg-white/20 rounded-lg transition-all">
                    <iconify-icon icon="mdi:arrow-left" width="24" height="24"></iconify-icon>
                </a>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold">Detail Siswa</h1>
                    <p class="text-blue-100 mt-1">Informasi lengkap dan dokumen siswa</p>
                </div>
            </div>
            <div class="flex gap-3 w-full sm:w-auto">
                <a href="{{ route('siswa.print-cv', $siswa->id) }}" 
                target="_blank"
                class="w-full sm:w-auto flex items-center justify-center gap-2 bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all duration-300 shadow-lg">
                    <iconify-icon icon="mdi:printer" width="20" height="20"></iconify-icon>
                    Cetak CV
                </a>
            </div>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="bg-gray-800/50 backdrop-blur-sm rounded-0 md:rounded-2xl shadow-xl border border-gray-700/50 p-6 mb-8">
        <div class="flex flex-col md:flex-row gap-8">
            <div class="md:w-1/4">
                <div class="sticky top-4 group">
                    @if($siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}" class="rounded-xl w-full object-cover h-64 shadow-lg group-hover:shadow-xl transition-all duration-300">
                    @else
                        <div class="bg-gradient-to-br from-gray-700 to-gray-900 rounded-xl w-full h-64 flex items-center justify-center">
                            <iconify-icon icon="mdi:account" width="64" height="64" class="text-gray-500"></iconify-icon>
                        </div>
                    @endif
                </div>
            </div>

            <div class="md:w-3/4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-700/30 p-4 rounded-xl">
                        <span class="text-gray-400 text-sm flex items-center gap-2">
                            <iconify-icon icon="mdi:account" width="16" height="16"></iconify-icon>
                            Nama Lengkap
                        </span>
                        <p class="text-white font-semibold text-lg">{{ $siswa->nama_lengkap }}</p>
                    </div>
                    <div class="bg-gray-700/30 p-4 rounded-xl">
                        <span class="text-gray-400 text-sm flex items-center gap-2">
                            <iconify-icon icon="mdi:account-details" width="16" height="16"></iconify-icon>
                            Nama Panggilan
                        </span>
                        <p class="text-white font-semibold">{{ $siswa->nama_panggilan ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-700/30 p-4 rounded-xl">
                        <span class="text-gray-400 text-sm flex items-center gap-2">
                            <iconify-icon icon="mdi:calendar" width="16" height="16"></iconify-icon>
                            Tempat, Tanggal Lahir
                        </span>
                        <p class="text-white font-semibold">{{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') }}</p>
                    </div>
                    <div class="bg-gray-700/30 p-4 rounded-xl">
                        <span class="text-gray-400 text-sm flex items-center gap-2">
                            <iconify-icon icon="mdi:clock" width="16" height="16"></iconify-icon>
                            Usia
                        </span>
                        <p class="text-white font-semibold">{{ $siswa->usia }}</p>
                    </div>
                    <div class="bg-gray-700/30 p-4 rounded-xl">
                        <span class="text-gray-400 text-sm flex items-center gap-2">
                            <iconify-icon icon="mdi:gender-{{ $siswa->jenis_kelamin === 'L' ? 'male' : 'female' }}" width="16" height="16"></iconify-icon>
                            Jenis Kelamin
                        </span>
                        <p class="text-white font-semibold">{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div class="bg-gray-700/30 p-4 rounded-xl">
                        <span class="text-gray-400 text-sm flex items-center gap-2">
                            <iconify-icon icon="mdi:church" width="16" height="16"></iconify-icon>
                            Agama
                        </span>
                        <p class="text-white font-semibold">{{ $siswa->agama }}</p>
                    </div>
                    <div class="bg-gray-700/30 p-4 rounded-xl md:col-span-2">
                        <span class="text-gray-400 text-sm flex items-center gap-2">
                            <iconify-icon icon="mdi:map-marker" width="16" height="16"></iconify-icon>
                            Alamat
                        </span>
                        <p class="text-white font-semibold uppercase">{{ $siswa->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigasi Tab Admin -->
    <div class="bg-gray-800/50 backdrop-blur-sm w-full rounded-0 md:rounded-2xl shadow-xl border border-gray-700/50 overflow-hidden">
        <div class="border-b w-full border-gray-700/50 bg-[#111827]/50">
            <div class="flex flex-nowrap items-center gap-1 md:gap-2 p-2 md:p-4 overflow-x-auto scrollbar-hide">
                @foreach(['biodata' => 'Biodata', 'keluarga' => 'Keluarga', 'pendidikan' => 'Pendidikan', 'jiko-piaru' => 'Jiko Piaru', 'pekerjaan' => 'Pekerjaan', 'sertifikat' => 'Sertifikat', 'kartu-keluarga' => 'Kartu Keluarga', 'dokumen' => 'Dokumen & Upload'] as $key => $label)
                    <button 
                        class="admin-tab-btn snap-center flex-none px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 whitespace-nowrap border border-transparent text-gray-400 hover:bg-gray-800" 
                        data-tab="admin-{{ $key }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Konten Tab -->
        <div class="p-5 pt-8 md:pt-0">
            
                        <!-- TAB BIODATA (Read Only) -->
            <div class="admin-tab-content pt-5" id="admin-biodata">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Status Siswa -->
                    <div class="bg-gray-700/30 rounded-xl p-6 md:col-span-2">
                        <h3 class="text-blue-400 font-semibold mb-4 border-b border-gray-600 pb-2">Status Siswa</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-gray-400 text-sm block">Status Siswa Sebelumnya</span>
                                <p class="text-white font-medium">{{ $siswa->biodata->status_siswa_sebelumnya ?? '-' }}</p>
                            </div>
                            @if(($siswa->biodata->status_siswa_sebelumnya ?? '') === 'LPK')
                            <div>
                                <span class="text-gray-400 text-sm block">Nama LPK</span>
                                <p class="text-white font-medium">{{ $siswa->biodata->nama_lpk ?? '-' }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Data Pribadi -->
                    <div class="bg-gray-700/30 rounded-xl p-6 md:col-span-2">
                        <h3 class="text-blue-400 font-semibold mb-4 border-b border-gray-600 pb-2">Informasi Pribadi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><span class="text-gray-400 text-sm block">NIK</span><p class="text-white">{{ $siswa->biodata->nik ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Level Bahasa Jepang</span><p class="text-white">{{ $siswa->biodata->level_bahasa_jepang ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Periode Mulai</span><p class="text-white">{{ $siswa->biodata->periode_mulai ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Wilayah Alamat</span><p class="text-white">{{ $siswa->biodata->wilayah_alamat ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Rencana Lama di Jepang</span><p class="text-white">{{ $siswa->biodata->rencana_lama_di_jepang ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Golongan Darah</span><p class="text-white">{{ $siswa->biodata->golongan_darah ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Status Perkawinan</span><p class="text-white">{{ $siswa->biodata->status_perkawinan ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Jumlah Anak</span><p class="text-white">{{ $siswa->biodata->jumlah_anak ?? '-' }}</p></div>
                        </div>
                    </div>

                    <!-- Fisik & Kesehatan -->
                    <div class="bg-gray-700/30 rounded-xl p-6">
                        <h3 class="text-green-400 font-semibold mb-4 border-b border-gray-600 pb-2">Informasi Fisik</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div><span class="text-gray-400 text-sm block">Tinggi Badan</span><p class="text-white">{{ $siswa->biodata->tinggi_badan ?? '-' }} cm</p></div>
                            <div><span class="text-gray-400 text-sm block">Berat Badan</span><p class="text-white">{{ $siswa->biodata->berat_badan ?? '-' }} kg</p></div>
                            <div><span class="text-gray-400 text-sm block">Ukuran Sepatu</span><p class="text-white">{{ $siswa->biodata->ukuran_sepatu ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Ukuran Pinggang</span><p class="text-white">{{ $siswa->biodata->ukuran_pinggang ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Tangan Dominan</span><p class="text-white">{{ $siswa->biodata->tangan_dominan ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Kondisi Mata Kiri</span><p class="text-white">{{ $siswa->biodata->kondisi_mata_kiri ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Kondisi Mata Kanan</span><p class="text-white">{{ $siswa->biodata->kondisi_mata_kanan ?? '-' }}</p></div>
                        </div>
                    </div>

                    <!-- Kesehatan -->
                    <div class="bg-gray-700/30 rounded-xl p-6">
                        <h3 class="text-red-400 font-semibold mb-4 border-b border-gray-600 pb-2">Informasi Kesehatan</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div><span class="text-gray-400 text-sm block">Buta Warna</span><p class="text-white">{{ $siswa->biodata->buta_warna ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Alergi</span><p class="text-white">{{ $siswa->biodata->alergi ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Merokok</span><p class="text-white">{{ $siswa->biodata->merokok ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Peminum Alkohol</span><p class="text-white">{{ $siswa->biodata->peminum_alkohol ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Tatto</span><p class="text-white">{{ $siswa->biodata->tatto ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Gigi Berlubang</span><p class="text-white">{{ $siswa->biodata->gigi_berlubang ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Patah Tulang</span><p class="text-white">{{ $siswa->biodata->patah_tulang ?? '-' }}</p></div>
                            <div><span class="text-gray-400 text-sm block">Kacamata</span><p class="text-white">{{ $siswa->biodata->kacamata ?? '-' }}</p></div>
                            <div class="col-span-2"><span class="text-gray-400 text-sm block">Riwayat Penyakit</span><p class="text-white">{{ $siswa->biodata->riwayat_penyakit ?? '-' }}</p></div>
                        </div>
                    </div>

                    <!-- Deskripsi Diri & Hobi -->
                    <div class="bg-gray-700/30 rounded-xl p-6 md:col-span-2">
                        <h3 class="text-yellow-400 font-semibold mb-4 border-b border-gray-600 pb-2">Deskripsi Diri & Hobi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2"><span class="text-gray-400 text-sm block">Keunggulan Diri</span><p class="text-white whitespace-pre-wrap">{{ $siswa->biodata->keunggulan_diri ?? '-' }}</p></div>
                            <div class="md:col-span-2"><span class="text-gray-400 text-sm block">Kekurangan Diri</span><p class="text-white whitespace-pre-wrap">{{ $siswa->biodata->kekurangan_diri ?? '-' }}</p></div>
                            <div class="md:col-span-2">
                                <span class="text-gray-400 text-sm block mb-2">Hobi</span>
                                <div class="flex flex-wrap gap-2">
                                    @php 
                                        $hobiArr = is_array($siswa->biodata->hobi ?? null) ? $siswa->biodata->hobi : json_decode($siswa->biodata->hobi ?? '[]', true); 
                                    @endphp
                                    @forelse($hobiArr as $hobi)
                                        <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-lg text-sm">{{ $hobi }}</span>
                                    @empty
                                        <span class="text-white">-</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB KELUARGA (Read Only) -->
            <div class="admin-tab-content hidden pt-5" id="admin-keluarga">
                <div class="space-y-4">
                    @forelse($siswa->keluargas as $item)
                        <div class="bg-gray-700/30 rounded-xl p-5 border border-gray-600/50">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="font-semibold text-white">{{ $item->nama }}</div>
                                    <div class="text-sm text-blue-400">{{ $item->hubungan_keluarga }}</div>
                                    <div class="text-sm text-gray-400 mt-1">
                                        {{ $item->tempat_lahir }}, {{ $item->tanggal_lahir }} <br>
                                        Pekerjaan: {{ $item->pekerjaan ?? '-' }} <br>
                                        No. HP: {{ $item->no_telepon ?? '-' }}
                                    </div>
                                </div>
                                @if($item->jenis_keluarga == 'jepang')
                                    <span class="bg-red-500/20 text-red-400 px-2 py-1 rounded-lg text-xs">{{ $item->alamat_jepang }}</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-4">Belum ada data keluarga.</div>
                    @endforelse
                </div>
            </div>

            <!-- TAB PENDIDIKAN (Read Only) -->
            <div class="admin-tab-content hidden pt-5" id="admin-pendidikan">
                <div class="space-y-4">
                    @forelse($siswa->pendidikans as $item)
                        <div class="bg-gray-700/30 rounded-xl p-5 border border-gray-600/50">
                            <div class="flex justify-between">
                                <div>
                                    <div class="font-semibold text-white">{{ $item->nama_sekolah }}</div>
                                    <div class="text-sm text-blue-400">{{ $item->jenjang_pendidikan }} - {{ $item->jurusan }}</div>
                                    <div class="text-sm text-gray-400 mt-1">Tahun Masuk: {{ $item->bulan_masuk }} {{ $item->tahun_masuk }} | Lulus: {{ $item->tanggal_lulus ?? '-' }}</div>
                                </div>
                                @if($item->dokumen_ijazah)
                                    <a href="{{ asset('storage/'.$item->dokumen_ijazah) }}" target="_blank" class="text-blue-400 hover:text-blue-300">
                                        <iconify-icon icon="mdi:file-pdf" width="20" height="20"></iconify-icon>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-4">Belum ada data pendidikan.</div>
                    @endforelse
                </div>
            </div>

            <!-- TAB JIKO PIARU (Read Only) -->
            <div class="admin-tab-content hidden pt-5" id="admin-jiko-piaru">
                <div class="bg-gray-700/30 rounded-xl p-5 border border-gray-600/50">
                    @if($siswa->jikoPiaru && $siswa->jikoPiaru->content_jp)
                        <p class="text-white whitespace-pre-wrap font-japanese">{{ $siswa->jikoPiaru->content_jp }}</p>
                    @else
                        <p class="text-gray-500 text-center">Belum ada data Jiko Piaru.</p>
                    @endif
                </div>
            </div>

            <!-- TAB PEKERJAAN (Read Only) -->
            <div class="admin-tab-content hidden pt-5" id="admin-pekerjaan">
                <div class="space-y-4">
                    @forelse($siswa->riwayatPekerjaans as $item)
                        <div class="bg-gray-700/30 rounded-xl p-5 border border-gray-600/50">
                            <div class="font-semibold text-white">{{ $item->nama_perusahaan }}</div>
                            <div class="text-sm text-blue-400">{{ $item->nama_pekerjaan }} ({{ $item->tempat_bekerja }})</div>
                            <div class="text-sm text-gray-400 mt-1">{{ $item->bulan_mulai }} {{ $item->tahun_mulai }} - {{ $item->bulan_selesai }} {{ $item->tahun_selesai }}</div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-4">Belum ada riwayat pekerjaan.</div>
                    @endforelse
                </div>
            </div>

            <!-- TAB SERTIFIKAT (Read Only) -->
            <div class="admin-tab-content hidden pt-5" id="admin-sertifikat">
                <div class="space-y-4">
                    @forelse($siswa->sertifikats as $item)
                        <div class="bg-gray-700/30 rounded-xl p-5 border border-gray-600/50 flex justify-between items-center">
                            <div>
                                <div class="font-semibold text-white">{{ $item->nama_sertifikat }}</div>
                                <div class="text-sm text-gray-400">Terbit: {{ $item->tanggal_diterbitkan }} | Level JLPT: {{ $item->level_jlpt ?? '-' }}</div>
                            </div>
                            @if($item->dokumen_sertifikat)
                                <a href="{{ asset('storage/'.$item->dokumen_sertifikat) }}" target="_blank" class="text-blue-400 hover:text-blue-300 flex items-center gap-2">
                                    Lihat <iconify-icon icon="mdi:file-pdf" width="20" height="20"></iconify-icon>
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-4">Belum ada sertifikat.</div>
                    @endforelse
                </div>
            </div>

                        <!-- TAB KARTU KELUARGA (Read Only) -->
            <div class="admin-tab-content hidden pt-5" id="admin-kartu-keluarga">

                @if($siswa->kartuKeluarga)
                    <div class="bg-gray-700/30 rounded-xl p-6 border border-gray-600/50">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nomor KK & Tanggal -->
                            <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700/50">
                                <span class="text-gray-400 text-xs uppercase tracking-wider block mb-1">Nomor KK</span>
                                <p class="text-white font-semibold text-lg">{{ $siswa->kartuKeluarga->nomor_kk }}</p>
                            </div>
                            <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700/50">
                                <span class="text-gray-400 text-xs uppercase tracking-wider block mb-1">Tanggal Dikeluarkan</span>
                                <p class="text-white font-semibold">{{ optional($siswa->kartuKeluarga->tanggal_dikeluarkan)->format('d F Y') }}</p>
                            </div>

                            <!-- Alamat -->
                            <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700/50 md:col-span-2">
                                <span class="text-gray-400 text-xs uppercase tracking-wider block mb-1">Alamat Lengkap</span>
                                <p class="text-white">{{ $siswa->kartuKeluarga->alamat_keluarga }}</p>
                                @if($siswa->kartuKeluarga->alamat_keluarga_katakana)
                                    <p class="text-gray-400 text-sm mt-1">({{ $siswa->kartuKeluarga->alamat_keluarga_katakana }})</p>
                                @endif
                            </div>

                            <!-- Wilayah -->
                            <div class="grid grid-cols-2 gap-4 md:col-span-2">
                                <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700/50">
                                    <span class="text-gray-400 text-xs block mb-1">Provinsi</span>
                                    <p class="text-white text-sm">{{ $siswa->kartuKeluarga->provinsi }}</p>
                                </div>
                                <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700/50">
                                    <span class="text-gray-400 text-xs block mb-1">Kabupaten/Kota</span>
                                    <p class="text-white text-sm">{{ $siswa->kartuKeluarga->kabupaten }}</p>
                                </div>
                                <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700/50">
                                    <span class="text-gray-400 text-xs block mb-1">Kecamatan</span>
                                    <p class="text-white text-sm">{{ $siswa->kartuKeluarga->kecamatan }}</p>
                                </div>
                                <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700/50">
                                    <span class="text-gray-400 text-xs block mb-1">Desa/Kelurahan</span>
                                    <p class="text-white text-sm">{{ $siswa->kartuKeluarga->desa }}</p>
                                </div>
                            </div>

                            <!-- RT/RW & Golongan Darah -->
                            <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700/50">
                                <span class="text-gray-400 text-xs block mb-1">RT/RW</span>
                                <p class="text-white text-sm">{{ $siswa->kartuKeluarga->rt_rw ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700/50">
                                <span class="text-gray-400 text-xs block mb-1">Golongan Darah</span>
                                <p class="text-white text-sm">{{ $siswa->kartuKeluarga->ada_golongan_darah ? 'Tercantum' : 'Tidak Ada' }}</p>
                            </div>

                            <!-- Kepala Dinas -->
                            <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700/50">
                                <span class="text-gray-400 text-xs block mb-1">Nama Kepala Dinas</span>
                                <p class="text-white text-sm">{{ $siswa->kartuKeluarga->nama_kepala_dinas }}</p>
                            </div>
                            <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700/50">
                                <span class="text-gray-400 text-xs block mb-1">NIP Kepala Dinas</span>
                                <p class="text-white text-sm">{{ $siswa->kartuKeluarga->nip_kepala_dinas }}</p>
                            </div>
                        </div>
                        
                        @if($siswa->kartuKeluarga->foto_kk)
                            <div class="mt-6 pt-4 border-t border-gray-600/50">
                                <a href="{{ asset('storage/'.$siswa->kartuKeluarga->foto_kk) }}" target="_blank" class="inline-flex items-center gap-2 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 px-4 py-2 rounded-lg text-sm transition-all">
                                    <iconify-icon icon="mdi:image" width="18" height="18"></iconify-icon>
                                    Lihat Foto KK
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-gray-700/30 rounded-xl p-8 text-center border border-gray-600/50">
                        <iconify-icon icon="mdi:family-tree-off" width="48" height="48" class="text-gray-500 mb-3"></iconify-icon>
                        <p class="text-gray-400">Data Kartu Keluarga belum dilengkapi oleh siswa.</p>
                    </div>
                @endif
            </div>

            <!-- TAB DOKUMEN & UPLOAD (Untuk Admin) -->
            <div class="admin-tab-content hidden pt-5" id="admin-dokumen">
            
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Akte Kelahiran -->
                    <div class="bg-gray-700/30 rounded-xl p-6 border border-gray-600/50">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-3 bg-cyan-600/20 rounded-lg">
                                    <iconify-icon icon="mdi:file-document" width="24" height="24" class="text-cyan-400"></iconify-icon>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold">Akte Kelahiran</h3>
                                </div>
                            </div>
                            <form action="{{ route('admin.upload.akte', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="dokumen_akte" accept=".pdf,.jpg,.jpeg,.png" onchange="this.form.submit()" hidden id="adminAkteUpload">
                                <button type="button" onclick="document.getElementById('adminAkteUpload').click()" class="bg-cyan-600/20 hover:bg-cyan-600/40 text-cyan-400 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-all">
                                    <iconify-icon icon="mdi:cloud-upload" width="18" height="18"></iconify-icon>
                                    {{ $siswa->dokumen_akte ? 'Ubah' : 'Unggah' }}
                                </button>
                            </form>
                        </div>
                        @if($siswa->dokumen_akte)
                            <div class="mt-4 pt-4 border-t border-gray-600/50">
                                <a href="{{ asset('storage/'.$siswa->dokumen_akte) }}" target="_blank" class="text-cyan-400 hover:text-cyan-300 text-sm flex items-center gap-1">
                                    <iconify-icon icon="mdi:file-pdf" width="16" height="16"></iconify-icon> Lihat Dokumen
                                </a>
                            </div>
                        @endif
                    </div>
            
                    <!-- KTP -->
                    <div class="bg-gray-700/30 rounded-xl p-6 border border-gray-600/50">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-3 bg-cyan-600/20 rounded-lg">
                                    <iconify-icon icon="mdi:card-account-details" width="24" height="24" class="text-cyan-400"></iconify-icon>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold">KTP</h3>
                                </div>
                            </div>
                            <form action="{{ route('admin.upload.ktp', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="dokumen_ktp" accept=".pdf,.jpg,.jpeg,.png" onchange="this.form.submit()" hidden id="adminKtpUpload">
                                <button type="button" onclick="document.getElementById('adminKtpUpload').click()" class="bg-cyan-600/20 hover:bg-cyan-600/40 text-cyan-400 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-all">
                                    <iconify-icon icon="mdi:cloud-upload" width="18" height="18"></iconify-icon>
                                    {{ $siswa->dokumen_ktp ? 'Ubah' : 'Unggah' }}
                                </button>
                            </form>
                        </div>
                        @if($siswa->dokumen_ktp)
                            <div class="mt-4 pt-4 border-t border-gray-600/50">
                                <a href="{{ asset('storage/'.$siswa->dokumen_ktp) }}" target="_blank" class="text-cyan-400 hover:text-cyan-300 text-sm flex items-center gap-1">
                                    <iconify-icon icon="mdi:file-pdf" width="16" height="16"></iconify-icon> Lihat Dokumen
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- COE -->
                    <div class="bg-gray-700/30 rounded-xl p-6 border border-gray-600/50">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-3 bg-purple-600/20 rounded-lg">
                                    <iconify-icon icon="mdi:file-certificate" width="24" height="24" class="text-purple-400"></iconify-icon>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold">COE</h3>
                                    @if($siswa->nomor_coe)
                                        <p class="text-xs text-purple-400 mt-1">No: {{ $siswa->nomor_coe }}</p>
                                    @endif
                                </div>
                            </div>
                            <button onclick="openAdminCoeModal()" class="bg-purple-600/20 hover:bg-purple-600/40 text-purple-400 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-all">
                                <iconify-icon icon="mdi:cloud-upload" width="18" height="18"></iconify-icon>
                                {{ $siswa->dokumen_coe ? 'Ubah' : 'Unggah' }}
                            </button>
                        </div>
                        
                        @if($siswa->dokumen_coe)
                            <div class="mt-4 pt-4 border-t border-purple-600/20">
                                <!-- Menampilkan Tanggal COE -->
                                <div class="mb-3">
                                    <p class="text-xs text-gray-500">Tanggal COE</p>
                                    <p class="text-sm text-purple-400 font-medium">
                                        {{ $siswa->tanggal_coe ? \Carbon\Carbon::parse($siswa->tanggal_coe)->format('d/m/Y') : '-' }}
                                    </p>
                                </div>
                                <a href="{{ asset('storage/'.$siswa->dokumen_coe) }}" target="_blank" class="text-purple-400 hover:text-purple-300 text-sm flex items-center gap-1">
                                    <iconify-icon icon="mdi:file-pdf" width="16" height="16"></iconify-icon> Lihat Dokumen
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- VISA -->
                    <div class="bg-gray-700/30 rounded-xl p-6 border border-gray-600/50">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-3 bg-indigo-600/20 rounded-lg">
                                    <iconify-icon icon="mdi:passport" width="24" height="24" class="text-indigo-400"></iconify-icon>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold">Visa Jepang</h3>
                                    @if($siswa->nomor_visa)
                                        <p class="text-xs text-indigo-400 mt-1">No: {{ $siswa->nomor_visa }}</p>
                                    @endif
                                </div>
                            </div>
                            <button onclick="openAdminVisaModal()" class="bg-indigo-600/20 hover:bg-indigo-600/40 text-indigo-400 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-all">
                                <iconify-icon icon="mdi:cloud-upload" width="18" height="18"></iconify-icon>
                                {{ $siswa->dokumen_visa ? 'Ubah' : 'Unggah' }}
                            </button>
                        </div>
                        
                        @if($siswa->dokumen_visa)
                            <div class="mt-4 pt-4 border-t border-indigo-600/20">
                                <!-- Menampilkan Tanggal Visa & Masa Berlaku -->
                                <div class="grid grid-cols-2 gap-4 mb-3">
                                    <div>
                                        <p class="text-xs text-gray-500">Tanggal Visa</p>
                                        <p class="text-sm text-indigo-400 font-medium">
                                            {{ $siswa->tanggal_visa ? \Carbon\Carbon::parse($siswa->tanggal_visa)->format('d/m/Y') : '-' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Masa Berlaku</p>
                                        <p class="text-sm text-indigo-400 font-medium">
                                            {{ str_replace('_', ' ', $siswa->masa_berlaku_visa ?? '-') }}
                                        </p>
                                    </div>
                                </div>
                                
                                <a href="{{ asset('storage/'.$siswa->dokumen_visa) }}" target="_blank" class="text-indigo-400 hover:text-indigo-300 text-sm flex items-center gap-1">
                                    <iconify-icon icon="mdi:file-pdf" width="16" height="16"></iconify-icon> Lihat Dokumen
                                </a>
                            </div>
                        @endif
                    </div>
            
                    <!-- Paspor -->
                    <div class="bg-gray-700/30 rounded-xl p-6 border border-gray-600/50">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-3 bg-red-600/20 rounded-lg">
                                    <iconify-icon icon="mdi:passport" width="24" height="24" class="text-red-400"></iconify-icon>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold">Paspor</h3>
                                    @if($siswa->biodata->nomor_paspor ?? $siswa->nomor_paspor)
                                        <p class="text-xs text-red-400 mt-1">No: {{ $siswa->biodata->nomor_paspor ?? $siswa->nomor_paspor }}</p>
                                    @endif
                                </div>
                            </div>
                            <button onclick="openAdminPasporModal()" class="bg-red-600/20 hover:bg-red-600/40 text-red-400 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-all">
                                <iconify-icon icon="mdi:cloud-upload" width="18" height="18"></iconify-icon>
                                {{ $siswa->dokumen_paspor ? 'Ubah' : 'Unggah' }}
                            </button>
                        </div>

                        @if($siswa->dokumen_paspor)
                            <div class="mt-4 pt-4 border-t border-red-600/20">
                                <!-- Tampilkan Data Tanggal -->
                                <div class="grid grid-cols-2 gap-4 mb-3">
                                    <div>
                                        <p class="text-xs text-gray-500">Tanggal Pembuatan</p>
                                        <p class="text-sm text-red-400 font-medium">
                                            {{ optional($siswa->biodata->tanggal_pembuatan_paspor ?? $siswa->tanggal_pembuatan_paspor)->format('d/m/Y') ?? '-' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Tanggal Dikeluarkan</p>
                                        <p class="text-sm text-red-400 font-medium">
                                            {{ optional($siswa->biodata->tanggal_paspor_dikeluarkan ?? $siswa->tanggal_keluar_paspor)->format('d/m/Y') ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Link Lihat Dokumen -->
                                <a href="{{ asset('storage/'.$siswa->dokumen_paspor) }}" target="_blank" class="text-red-400 hover:text-red-300 text-sm flex items-center gap-1">
                                    <iconify-icon icon="mdi:file-pdf" width="16" height="16"></iconify-icon> Lihat Dokumen
                                </a>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- ── MODAL MODAL UNTUK ADMIN ── -->

<!-- Admin Modal Upload COE -->
<div id="adminCoeModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-md rounded-2xl border border-gray-700/50 shadow-2xl">
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-purple-600/20 rounded-lg">
                    <iconify-icon icon="mdi:file-certificate" width="24" height="24" class="text-purple-400"></iconify-icon>
                </div>
                <h3 class="text-xl font-bold text-white">Upload COE</h3>
            </div>
            <button onclick="closeAdminCoeModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <form action="{{ route('admin.upload.coe', $siswa->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div class="space-y-2">
                <label class="block text-gray-300 text-sm font-medium">Nomor COE</label>
                <input type="text" name="nomor_coe" value="{{ $siswa->nomor_coe ?? '' }}" required class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
            </div>
            <div class="space-y-2">
                <label class="block text-gray-300 text-sm font-medium">Tanggal COE</label>
                <input type="date" name="tanggal_coe" value="{{ $siswa->tanggal_coe ?? '' }}" required class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
            </div>
            <div class="space-y-2">
                <label class="block text-gray-300 text-sm font-medium">File COE (PDF/Image)</label>
                <input type="file" name="dokumen_coe" accept=".pdf,.jpg,.jpeg,.png" required class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-purple-600 file:text-white hover:file:bg-purple-700">
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAdminCoeModal()" class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all text-sm font-medium">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white rounded-lg transition-all text-sm font-medium flex items-center gap-2">
                    <iconify-icon icon="mdi:cloud-upload" width="16" height="16"></iconify-icon> Upload
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Admin Modal Upload Visa -->
<div id="adminVisaModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-md rounded-2xl border border-gray-700/50 shadow-2xl">
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-600/20 rounded-lg">
                    <iconify-icon icon="mdi:passport" width="24" height="24" class="text-indigo-400"></iconify-icon>
                </div>
                <h3 class="text-xl font-bold text-white">Upload Visa</h3>
            </div>
            <button onclick="closeAdminVisaModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <form action="{{ route('admin.upload.visa', $siswa->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div class="space-y-2">
                <label class="block text-gray-300 text-sm font-medium">Nomor Visa</label>
                <input type="text" name="nomor_visa" value="{{ $siswa->nomor_visa ?? '' }}" required class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
            </div>
            <div class="space-y-2">
                <label class="block text-gray-300 text-sm font-medium">Tanggal Visa</label>
                <input type="date" name="tanggal_visa" value="{{ $siswa->tanggal_visa ?? '' }}" required class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
            </div>
            <div class="space-y-2">
                <label class="block text-gray-300 text-sm font-medium">Masa Berlaku</label>
                <select name="masa_berlaku_visa" required class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                    <option value="">Pilih Masa Berlaku</option>
                    <option value="1_tahun" {{ ($siswa->masa_berlaku_visa ?? '') == '1_tahun' ? 'selected' : '' }}>1 Tahun</option>
                    <option value="2_tahun" {{ ($siswa->masa_berlaku_visa ?? '') == '2_tahun' ? 'selected' : '' }}>2 Tahun</option>
                    <option value="3_tahun" {{ ($siswa->masa_berlaku_visa ?? '') == '3_tahun' ? 'selected' : '' }}>3 Tahun</option>
                    <option value="5_tahun" {{ ($siswa->masa_berlaku_visa ?? '') == '5_tahun' ? 'selected' : '' }}>5 Tahun</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="block text-gray-300 text-sm font-medium">File Visa (PDF/Image)</label>
                <input type="file" name="dokumen_visa" accept=".pdf,.jpg,.jpeg,.png" required class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-600 file:text-white hover:file:bg-indigo-700">
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAdminVisaModal()" class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all text-sm font-medium">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white rounded-lg transition-all text-sm font-medium flex items-center gap-2">
                    <iconify-icon icon="mdi:cloud-upload" width="16" height="16"></iconify-icon> Upload
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Admin Modal Paspor -->
<!-- Admin Modal Paspor -->
<div id="adminPasporModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-gray-800 w-full max-w-xl rounded-2xl shadow-2xl border border-gray-700">
        <div class="p-6 border-b border-gray-700 flex justify-between items-center">
            <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                <iconify-icon icon="mdi:passport" width="24" height="24" class="text-red-400"></iconify-icon>
                Data & Unggah Paspor
            </h3>
            <button onclick="closeAdminPasporModal()" class="text-gray-400 hover:text-white transition-colors">
                <iconify-icon icon="mdi:close" width="24"></iconify-icon>
            </button>
        </div>

        <form action="{{ route('admin.upload.paspor', $siswa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                
                <div>
                    <label class="block text-gray-300 text-sm mb-2">Nomor Paspor</label>
                    <input type="text" name="nomor_paspor" 
                           value="{{ old('nomor_paspor', $siswa->biodata->nomor_paspor ?? $siswa->nomor_paspor) }}" 
                           placeholder="Masukkan nomor paspor" required
                           class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500 transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-300 text-sm mb-2">Tanggal Pembuatan</label>
                        <input type="date" name="tanggal_pembuatan_paspor" 
                               value="{{ old('tanggal_pembuatan_paspor', optional($siswa->biodata->tanggal_pembuatan_paspor ?? $siswa->tanggal_pembuatan_paspor)->format('Y-m-d')) }}" required
                               class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500 transition">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm mb-2">Tanggal Dikeluarkan</label>
                        <input type="date" name="tanggal_keluar_paspor" 
                               value="{{ old('tanggal_keluar_paspor', optional($siswa->biodata->tanggal_paspor_dikeluarkan ?? $siswa->tanggal_keluar_paspor)->format('Y-m-d')) }}" required
                               class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500 transition">
                    </div>
                </div>

                <div class="pt-2">
                    <label class="block text-gray-300 text-sm mb-2">File Paspor (PDF, JPG, PNG)</label>
                    <input type="file" name="dokumen_paspor" id="admin_dokumen_paspor" accept=".pdf,.jpg,.jpeg,.png" 
                           class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2.5 text-white">
                    <p class="text-xs text-gray-500 mt-1">Maksimal 5MB. Biarkan kosong jika tidak ingin mengubah file.</p>
                    
                    <div class="mt-3">
                        @if(!empty($siswa->dokumen_paspor))
                            <a href="{{ asset('storage/'.$siswa->dokumen_paspor) }}" target="_blank">
                                <img id="admin_preview_paspor" src="{{ asset('storage/'.$siswa->dokumen_paspor) }}" class="h-24 rounded-lg border border-gray-600 cursor-pointer hover:opacity-80 transition">
                            </a>
                        @else
                            <img id="admin_preview_paspor" class="h-24 rounded-lg border border-gray-600 hidden">
                        @endif
                    </div>
                </div>

            </div>
            
            <div class="p-6 border-t border-gray-700 flex justify-end gap-3">
                <button type="button" onclick="closeAdminPasporModal()" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg transition-all duration-300">Batal</button>
                <button type="submit" class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 transition-all duration-300">
                    <iconify-icon icon="mdi:content-save" width="18" height="18"></iconify-icon> 
                    Simpan Data & File
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // ── LOGIKA TAB ADMIN ──
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.admin-tab-btn');
        const contents = document.querySelectorAll('.admin-tab-content');

        function activateTab(tabId) {
            tabs.forEach(t => {
                if(t.dataset.tab === tabId) {
                    t.classList.add('bg-blue-600', 'text-white', 'shadow-md', 'shadow-blue-500/20');
                    t.classList.remove('text-gray-400', 'hover:bg-gray-800');
                } else {
                    t.classList.remove('bg-blue-600', 'text-white', 'shadow-md', 'shadow-blue-500/20');
                    t.classList.add('text-gray-400', 'hover:bg-gray-800');
                }
            });

            contents.forEach(c => {
                c.classList.toggle('hidden', c.id !== tabId);
            });
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', () => activateTab(tab.dataset.tab));
        });

        // Default tab
                // Cek apakah ada session active_tab dari Controller (setelah upload)
        const activeTabFromSession = "{{ session('active_tab') }}";
        
        if (activeTabFromSession && activeTabFromSession !== "") {
            activateTab(activeTabFromSession);
        } else {
            // Default tab jika tidak ada session
            activateTab('admin-biodata');
        }
    });

    // ── MODAL FUNCTIONS ──
    function openAdminCoeModal() { document.getElementById('adminCoeModal').classList.remove('hidden'); document.getElementById('adminCoeModal').classList.add('flex'); }
    function closeAdminCoeModal() { document.getElementById('adminCoeModal').classList.add('hidden'); document.getElementById('adminCoeModal').classList.remove('flex'); }
    
    function openAdminVisaModal() { document.getElementById('adminVisaModal').classList.remove('hidden'); document.getElementById('adminVisaModal').classList.add('flex'); }
    function closeAdminVisaModal() { document.getElementById('adminVisaModal').classList.add('hidden'); document.getElementById('adminVisaModal').classList.remove('flex'); }
    
    function openAdminPasporModal() { document.getElementById('adminPasporModal').classList.remove('hidden'); document.getElementById('adminPasporModal').classList.add('flex'); }
    function closeAdminPasporModal() { document.getElementById('adminPasporModal').classList.add('hidden'); document.getElementById('adminPasporModal').classList.remove('flex'); }

    // Preview Paspor
    document.getElementById('admin_dokumen_paspor')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('admin_preview_paspor');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection