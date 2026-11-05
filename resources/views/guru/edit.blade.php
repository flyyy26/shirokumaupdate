@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Edit Guru</h1>

<form action="{{ route('guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
@csrf
@method('PUT')

@if($guru->foto)
    <img src="{{ asset('storage/'.$guru->foto) }}" 
         class="w-24 h-24 object-cover rounded mb-3">
@endif

<input type="file" name="foto"
    class="w-full p-2 rounded bg-gray-800">

<input type="text" name="nama_lengkap"
    value="{{ $guru->nama_lengkap }}"
    class="w-full p-2 rounded bg-gray-800">

<input type="text" name="nama_panggilan"
    value="{{ $guru->nama_panggilan }}"
    class="w-full p-2 rounded bg-gray-800">

<input type="text" name="tempat_lahir"
    value="{{ $guru->tempat_lahir }}"
    class="w-full p-2 rounded bg-gray-800">

<input type="text" name="tanggal_lahir"
    value="{{ \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d/m/Y') }}"
    class="w-full p-2 rounded bg-gray-800 text-white">

<select name="jenis_kelamin" class="w-full p-2 rounded bg-gray-800">
    <option value="L" {{ $guru->jenis_kelamin == 'L' ? 'selected' : '' }}>
        Laki-laki
    </option>
    <option value="P" {{ $guru->jenis_kelamin == 'P' ? 'selected' : '' }}>
        Perempuan
    </option>
</select>

<select name="level_diampu" class="w-full p-2 rounded bg-gray-800">
    <option value="N5" {{ $guru->level_diampu == 'N5' ? 'selected' : '' }}>N5</option>
    <option value="N4" {{ $guru->level_diampu == 'N4' ? 'selected' : '' }}>N4</option>
    <option value="N3" {{ $guru->level_diampu == 'N3' ? 'selected' : '' }}>N3</option>
    <option value="N2" {{ $guru->level_diampu == 'N2' ? 'selected' : '' }}>N2</option>
    <option value="N1" {{ $guru->level_diampu == 'N1' ? 'selected' : '' }}>N1</option>
</select>

<select name="status" class="w-full p-2 rounded bg-gray-800">
    <option value="aktif" {{ $guru->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
    <option value="nonaktif" {{ $guru->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
</select>

<input type="text" name="no_hp"
    value="{{ $guru->no_hp }}"
    placeholder="Nomor Telepon"
    class="w-full p-2 rounded bg-gray-800 text-white">

<textarea name="alamat"
    class="w-full p-2 rounded bg-gray-800 text-white"
    placeholder="Alamat Lengkap">{{ $guru->alamat }}</textarea>

<div class="flex gap-3">
    <button class="bg-yellow-500 px-4 py-2 rounded hover:bg-yellow-600">
        Update
    </button>

    <a href="{{ route('guru.index') }}"
       class="bg-gray-600 px-4 py-2 rounded hover:bg-gray-700">
        Kembali
    </a>
</div>

</form>

@endsection