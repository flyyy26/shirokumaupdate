<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatPekerjaan;
use App\Helpers\LogHelper;

class RiwayatPekerjaanController extends Controller
{
    public function store(Request $request)
    {
        $siswa = Auth::user()->siswa;

        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'nama_pekerjaan' => 'required|string|max:255',
            'nama_pekerjaan_katakana' => 'nullable|string|max:255',
            'tempat_bekerja' => 'required|in:Indonesia,Jepang',
            'pengalaman_jepang' => 'nullable|string|max:255',

            'gaji_perbulan' => 'nullable|numeric',
            'tahun_mulai' => 'nullable|digits:4',
            'bulan_mulai' => 'nullable|string|max:20',
            'tahun_selesai' => 'nullable|digits:4',
            'bulan_selesai' => 'nullable|string|max:20',
            'deskripsi_pekerjaan' => 'nullable|string',
        ]);

        // Jika Indonesia → kosongkan pengalaman_jepang
        if ($validated['tempat_bekerja'] === 'Indonesia') {
            $validated['pengalaman_jepang'] = null;
        }

        $siswa->riwayatPekerjaans()->create($validated);

        LogHelper::log(
            'Tambah Riwayat Pekerjaan',
            'Menambah data riwayat pekerjaan siswa'
        );

        return back()->with('success', 'Riwayat pekerjaan berhasil ditambahkan.')->with('active_tab', 'pekerjaan');
    }
    public function update(Request $request, $id)
    {
        $data = RiwayatPekerjaan::findOrFail($id);

        if ($data->siswa_id !== Auth::user()->siswa->id) {
            abort(403);
        }

        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'nama_pekerjaan' => 'required|string|max:255',
            'nama_pekerjaan_katakana' => 'nullable|string|max:255',
            'tempat_bekerja' => 'required|in:Indonesia,Jepang',
            'pengalaman_jepang' => 'nullable|string|max:255',

            'gaji_perbulan' => 'nullable|numeric',
            'tahun_mulai' => 'nullable|digits:4',
            'bulan_mulai' => 'nullable|string|max:20',
            'tahun_selesai' => 'nullable|digits:4',
            'bulan_selesai' => 'nullable|string|max:20',
            'deskripsi_pekerjaan' => 'nullable|string',
        ]);

        if ($validated['tempat_bekerja'] === 'Indonesia') {
            $validated['pengalaman_jepang'] = null;
        }

        $data->update($validated);

        LogHelper::log(
            'Update Riwayat Pekerjaan',
            'Memperbarui data riwayat pekerjaan siswa'
        );

        return back()->with('success', 'Riwayat pekerjaan berhasil diupdate.')->with('active_tab', 'pekerjaan');
    }
    public function destroy($id)
    {
        $data = RiwayatPekerjaan::findOrFail($id);

        if ($data->siswa_id !== Auth::user()->siswa->id) {
            abort(403);
        }

        $data->delete();

            LogHelper::log(
                'Hapus Riwayat Pekerjaan',
                'Menghapus data riwayat pekerjaan siswa'
            );

        return back()->with('success', 'Riwayat pekerjaan dihapus.')->with('active_tab', 'pekerjaan');
    }
}
