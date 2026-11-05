<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendidikan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;

class PendidikanController extends Controller
{
    public function store(Request $request)
    {
        $siswa = Auth::user()->siswa;

        $validated = $request->validate([
            'jenjang_pendidikan' => 'required|string',
            'nama_sekolah' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|digits:4',
            'bulan_masuk' => 'nullable|string|max:20',
            'tanggal_lulus' => 'nullable|date',
            'dokumen_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('dokumen_ijazah')) {
            $validated['dokumen_ijazah'] =
                $request->file('dokumen_ijazah')->store('ijazah', 'public');
        }

        $siswa->pendidikans()->create($validated);

            LogHelper::log(
                'Tambah Pendidikan',
                'Menambah data pendidikan siswa'
            );

        return back()
            ->with('success', 'Data pendidikan berhasil ditambahkan.')
            ->with('active_tab', 'pendidikan');
    }
    public function update(Request $request, $id)
    {
        $pendidikan = Pendidikan::findOrFail($id);

        // 🔒 Pastikan milik siswa yang login
        if ($pendidikan->siswa_id !== Auth::user()->siswa->id) {
            abort(403);
        }

        $validated = $request->validate([
            'jenjang_pendidikan' => 'required|string',
            'nama_sekolah' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|digits:4',
            'bulan_masuk' => 'nullable|string|max:20',
            'tanggal_lulus' => 'nullable|date',
            'dokumen_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Jika upload file baru
        if ($request->hasFile('dokumen_ijazah')) {

            // hapus file lama
            if ($pendidikan->dokumen_ijazah) {
                Storage::disk('public')->delete($pendidikan->dokumen_ijazah);
            }

            $validated['dokumen_ijazah'] =
                $request->file('dokumen_ijazah')->store('ijazah', 'public');
        }

        $pendidikan->update($validated);

        LogHelper::log(
            'Update Pendidikan',
            'Memperbarui data pendidikan siswa'
        );

        return back()
            ->with('success', 'Data pendidikan berhasil diupdate.')
            ->with('active_tab', 'pendidikan');
    }
    public function destroy($id)
    {
        $pendidikan = Pendidikan::findOrFail($id);

        if ($pendidikan->siswa_id !== Auth::user()->siswa->id) {
            abort(403);
        }

        if ($pendidikan->dokumen_ijazah) {
            Storage::disk('public')->delete($pendidikan->dokumen_ijazah);
        }

        $pendidikan->delete();

        LogHelper::log(
            'Hapus Pendidikan',
            'Menghapus data pendidikan siswa'
        );

        return back()
            ->with('success', 'Data pendidikan berhasil dihapus.')
            ->with('active_tab', 'pendidikan');
    }
}
