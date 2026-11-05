@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-950 min-h-screen text-gray-200">
    <h2 class="text-2xl font-bold mb-6">Edit Data Siswa</h2>

    <div class="bg-gray-900 rounded-xl border border-gray-700 p-6 max-w-2xl">
        <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4">
                <!-- Foto -->
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Foto</label>
                    @if($siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" class="w-20 h-20 rounded-full object-cover mb-2 border border-gray-700">
                    @endif
                    <input type="file" name="foto" class="w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto.</p>
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" required class="w-full bg-gray-800 border border-gray-600 rounded px-3 py-2 text-white focus:border-blue-500 focus:outline-none">
                </div>

                <!-- Nama Panggilan -->
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Nama Panggilan</label>
                    <input type="text" name="nama_panggilan" value="{{ old('nama_panggilan', $siswa->nama_panggilan) }}" class="w-full bg-gray-800 border border-gray-600 rounded px-3 py-2 text-white focus:border-blue-500 focus:outline-none">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" required class="w-full bg-gray-800 border border-gray-600 rounded px-3 py-2 text-white focus:border-blue-500 focus:outline-none">
                        <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" required class="w-full bg-gray-800 border border-gray-600 rounded px-3 py-2 text-white focus:border-blue-500 focus:outline-none">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="tanggal_lahir" id="tanggal_lahir_edit" value="{{ old('tanggal_lahir', \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y')) }}" required class="w-full bg-gray-800 border border-gray-600 rounded px-3 py-2 text-white focus:border-blue-500 focus:outline-none">
                </div>

                <!-- Agama -->
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Agama <span class="text-red-500">*</span></label>
                    <select name="agama" required class="w-full bg-gray-800 border border-gray-600 rounded px-3 py-2 text-white focus:border-blue-500 focus:outline-none">
                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'] as $agama)
                            <option value="{{ $agama }}" {{ old('agama', $siswa->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- No HP -->
                <div>
                    <label class="block text-sm text-gray-400 mb-1">No HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $siswa->no_hp) }}" class="w-full bg-gray-800 border border-gray-600 rounded px-3 py-2 text-white focus:border-blue-500 focus:outline-none">
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Alamat</label>
                    <textarea name="alamat" rows="3" class="w-full bg-gray-800 border border-gray-600 rounded px-3 py-2 text-white focus:border-blue-500 focus:outline-none">{{ old('alamat', $siswa->alamat) }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('siswa.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded text-white transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded text-white font-semibold transition shadow-lg shadow-blue-900/20">Update Siswa</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#tanggal_lahir_edit", {
            dateFormat: "d/m/Y",
            locale: "id",
            allowInput: true,
            disableMobile: true
        });
    });
</script>
@endsection