<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogHelper;

class KeluargaController extends Controller
{
    public function store(Request $request)
    {
        $siswa = Auth::user()->siswa;

        if ($request->jenis_keluarga === 'jepang') {

            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'hubungan_keluarga' => 'required|string|max:50',
                'alamat_jepang' => 'required|string|max:255',
            ]);

            $validated['jenis_keluarga'] = 'jepang';

        } else {

            $validated = $request->validate([
                'hubungan_keluarga' => 'required|string|max:50',
                'nama' => 'required|string|max:255',
                'tempat_lahir' => 'nullable|string|max:255',
                'tanggal_lahir' => 'nullable|date',
                'alamat_tinggal' => 'nullable|string|max:255',
                'pekerjaan' => 'nullable|string|max:255',
                'no_telepon' => 'nullable|string|max:20',
            ]);

            $validated['jenis_keluarga'] = 'lokal';
        }

        $siswa->keluargas()->create($validated);

        LogHelper::log(
            'Tambah Keluarga',
            'Menambah data keluarga'
        );

        return back()
            ->with('success', 'Data keluarga berhasil ditambahkan.')
            ->with('active_tab', 'keluarga');
    }

    public function update(Request $request, $id)
    {
        $siswa = Auth::user()->siswa;
        $keluarga = Keluarga::where('siswa_id', $siswa->id)->findOrFail($id);

        $validated = $request->validate([
            'hubungan_keluarga' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat_tinggal' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        $keluarga->update($validated);

        LogHelper::log(
            'Update Keluarga',
            'Memperbarui data keluarga siswa'
        );
        return back()
            ->with('success', 'Data keluarga berhasil diperbarui.')
            ->with('active_tab', 'keluarga');
    }

    public function destroy($id)
    {
        $siswa = Auth::user()->siswa;
        $keluarga = Keluarga::where('siswa_id', $siswa->id)->findOrFail($id);
        $keluarga->delete();

        LogHelper::log(
            'Hapus Keluarga',
            'Menghapus data keluarga'
        );

        return back()
            ->with('success', 'Data keluarga dihapus.')
            ->with('active_tab', 'keluarga');
    }
}
