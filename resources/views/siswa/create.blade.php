@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Tambah Siswa</h1>

<form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
@csrf

<input type="file" name="foto"
    class="w-full p-2 rounded bg-gray-800">

<input type="text" name="nama_lengkap" placeholder="Nama Lengkap"
    class="w-full p-2 rounded bg-gray-800">

<input type="text" name="nama_panggilan" placeholder="Nama Panggilan"
    class="w-full p-2 rounded bg-gray-800">

<input type="text" name="tempat_lahir" placeholder="Tempat Lahir"
    class="w-full p-2 rounded bg-gray-800">

<input type="text" name="tanggal_lahir"
    id="tanggal_lahir"
    value="{{ old('tanggal_lahir', isset($guru) ? \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d/m/Y') : '') }}"
    class="w-full p-2 rounded bg-gray-800 text-white"
    placeholder="dd/mm/yyyy"
    required>

<select name="jenis_kelamin" class="w-full p-2 rounded bg-gray-800">
    <option value="L">Laki-laki</option>
    <option value="P">Perempuan</option>
</select>

<input type="text" name="agama" placeholder="Agama"
    class="w-full p-2 rounded bg-gray-800 text-white">

<input type="text" name="no_hp" placeholder="Nomor Telepon"
    class="w-full p-2 rounded bg-gray-800 text-white">

<textarea name="alamat" placeholder="Alamat Lengkap"
    class="w-full p-2 rounded bg-gray-800 text-white"></textarea>

<div class="flex gap-3">
    <button class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">
        Simpan
    </button>
    <a href="{{ route('siswa.index') }}"
        class="bg-gray-600 px-4 py-2 rounded hover:bg-gray-700">
        Kembali
    </a>
</div>

</form>

@endsection