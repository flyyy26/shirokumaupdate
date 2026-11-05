@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Tambah Guru</h1>

<form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
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

<select name="level_diampu" class="w-full p-2 rounded bg-gray-800">
    <option value="N5">N5</option>
    <option value="N4">N4</option>
    <option value="N3">N3</option>
    <option value="N2">N2</option>
    <option value="N1">N1</option>
</select>

<select name="status" class="w-full p-2 rounded bg-gray-800">
    <option value="aktif">Aktif</option>
    <option value="nonaktif">Nonaktif</option>
</select>

<input type="text" name="no_hp" placeholder="Nomor Telepon"
    class="w-full p-2 rounded bg-gray-800 text-white">

<textarea name="alamat" placeholder="Alamat Lengkap"
    class="w-full p-2 rounded bg-gray-800 text-white"></textarea>

<div class="flex gap-3">
    <button class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">
        Simpan
    </button>
    <a href="{{ route('guru.index') }}"
        class="bg-gray-600 px-4 py-2 rounded hover:bg-gray-700">
        Kembali
    </a>
</div>

</form>

@endsection