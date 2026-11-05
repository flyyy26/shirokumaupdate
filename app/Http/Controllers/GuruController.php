<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::latest()->get();

        LogHelper::log(
            'Lihat Guru',
            'Melihat daftar guru'
        );

        return view('guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required',
            'nama_panggilan' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date_format:d/m/Y',
            'jenis_kelamin' => 'required',
            'no_hp' => 'nullable|string|max:20',
            'level_diampu' => 'required|in:N1,N2,N3,N4,N5', // Pastikan "in" sesuai enum DB
            'status' => 'required|in:aktif,nonaktif',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->except('foto');

        $data['level_diampu'] = trim($validatedData['level_diampu']);
        // convert dd/mm/yyyy ke Y-m-d
        $data['tanggal_lahir'] = Carbon::createFromFormat(
            'd/m/Y',
            $request->tanggal_lahir
        )->format('Y-m-d');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        Guru::create($data);

        LogHelper::log(
            'Tambah Guru',
            'Menambah data guru: ' . $data['nama_lengkap']
        );

        return redirect()->route('guru.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function show(Guru $guru)
    {
        return view('guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'nama_panggilan' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date_format:d/m/Y',
            'jenis_kelamin' => 'required',
            'no_hp' => 'nullable|string|max:20',
            'level_diampu' => 'required|in:N1,N2,N3,N4,N5',
            'status' => 'required|in:aktif,nonaktif',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->except('foto');

        // convert dd/mm/yyyy ke Y-m-d
        $data['tanggal_lahir'] = Carbon::createFromFormat(
            'd/m/Y',
            $request->tanggal_lahir
        )->format('Y-m-d');

        if ($request->hasFile('foto')) {

            // hapus foto lama jika ada
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }

            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        $guru->update($data);

        return redirect()->route('guru.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return back()->with('success','Data berhasil dihapus');
    }
}