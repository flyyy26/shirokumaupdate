<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;

class KartuKeluargaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $siswa = $user->siswa()->with('kartuKeluarga')->first();

        logHelper::log(
            'Lihat Kartu Keluarga',
            'Melihat data kartu keluarga'
        );

        return view('kartu_keluarga', compact('siswa'));
    }
    public function store(Request $request)
    {
        $siswa = auth()->user()->siswa;

        $validated = $request->validate([
            'nomor_kk' => 'required|string|max:20',
            'alamat_keluarga' => 'required',
            'alamat_keluarga_katakana' => 'nullable',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'rt_rw' => 'nullable|string|max:10',
            'tanggal_dikeluarkan' => 'required|date',
            'nama_kepala_dinas' => 'required|string|max:255',
            'nip_kepala_dinas' => 'required|string|max:50',
            'foto_kk' => 'nullable|file|max:5120',
            'ada_golongan_darah' => 'required|boolean',
        ]);

        if (isset($validated['alamat_keluarga'])) {
            $validated['alamat_keluarga'] = strtoupper($validated['alamat_keluarga']);
        }

        if ($request->hasFile('foto_kk')) {
            $validated['foto_kk'] =
                $request->file('foto_kk')->store('kk', 'public');
        }

        $validated['siswa_id'] = $siswa->id;

        KartuKeluarga::updateOrCreate(
            ['siswa_id' => $siswa->id],
            $validated
        );

        LogHelper::log(
            'Tambah Kartu Keluarga',
            'Menambah data kartu keluarga siswa'
        );

        return back()->with('success','Data KK berhasil disimpan');
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->siswa) {
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $siswa = $user->siswa;

        $kk = $siswa->kartuKeluarga;

        if (!$kk) {
            return back()->with('error', 'Data KK belum ada.');
        }

        $validated = $request->validate([
            'nomor_kk' => 'required|string|max:20',
            'alamat_keluarga' => 'required',
            'alamat_keluarga_katakana' => 'nullable',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'rt_rw' => 'nullable|string|max:10',
            'tanggal_dikeluarkan' => 'required|date',
            'nama_kepala_dinas' => 'required|string|max:255',
            'nip_kepala_dinas' => 'required|string|max:50',
            'foto_kk' => 'nullable|file|max:5120',
            'ada_golongan_darah' => 'required|boolean',
        ]);

        if (isset($validated['alamat_keluarga'])) {
            $validated['alamat_keluarga'] = strtoupper($validated['alamat_keluarga']);
        }

        // ==========================
        // HANDLE FOTO REPLACE
        // ==========================
        if ($request->hasFile('foto_kk')) {

            // hapus file lama
            if ($kk->foto_kk && Storage::disk('public')->exists($kk->foto_kk)) {
                Storage::disk('public')->delete($kk->foto_kk);
            }

            $validated['foto_kk'] =
                $request->file('foto_kk')->store('kk', 'public');
        }

        $kk->update($validated);

        LogHelper::log(
            'Update Kartu Keluarga',
            'Memperbarui data kartu keluarga siswa'
        );

        return back()->with('success', 'Data KK berhasil diperbarui.');
    }
}
