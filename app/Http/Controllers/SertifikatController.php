<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;

class SertifikatController extends Controller
{
    public function store(Request $request)
    {
        $siswa = Auth::user()->siswa;

        $validated = $request->validate([
            'nama_sertifikat' => 'required|string|max:255',
            'tanggal_diterbitkan' => 'nullable|date',
            'tanggal_expired' => 'nullable|date',
            'dokumen_sertifikat' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png',
            'level_jlpt' => 'nullable|string|max:10',
            // max 5120 = 5MB
        ]);

        if ($request->hasFile('dokumen_sertifikat')) {
            $validated['dokumen_sertifikat'] =
                $request->file('dokumen_sertifikat')
                        ->store('sertifikat', 'public');
        }

        $siswa->sertifikats()->create($validated);

            LogHelper::log(
                'Tambah Sertifikat',
                'Menambah data sertifikat siswa'
            );

        return back()->with('success','Sertifikat berhasil ditambahkan.')->with('active_tab', 'sertifikat');
    }
    public function update(Request $request, $id)
    {
        $data = Sertifikat::findOrFail($id);

        if ($data->siswa_id !== Auth::user()->siswa->id) {
            abort(403);
        }

        $validated = $request->validate([
            'nama_sertifikat' => 'required|string|max:255',
            'tanggal_diterbitkan' => 'nullable|date',
            'tanggal_expired' => 'nullable|date',
            'dokumen_sertifikat' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png',
            'level_jlpt' => 'nullable|string|max:10',
        ]);

        if ($request->hasFile('dokumen_sertifikat')) {

            if ($data->dokumen_sertifikat) {
                Storage::disk('public')->delete($data->dokumen_sertifikat);
            }

            $validated['dokumen_sertifikat'] =
                $request->file('dokumen_sertifikat')
                        ->store('sertifikat', 'public');
        }

        $data->update($validated);

        LogHelper::log(
            'Update Sertifikat',
            'Memperbarui data sertifikat siswa'
        );

        return back()->with('success','Sertifikat berhasil diupdate.')->with('active_tab', 'sertifikat');
    }
    public function destroy($id)
    {
        $data = Sertifikat::findOrFail($id);

        if ($data->siswa_id !== Auth::user()->siswa->id) {
            abort(403);
        }

        if ($data->dokumen_sertifikat) {
            Storage::disk('public')->delete($data->dokumen_sertifikat);
        }

        $data->delete();

        LogHelper::log(
            'Hapus Sertifikat',
            'Menghapus data sertifikat siswa'
        );

        return back()->with('success','Sertifikat dihapus.')->with('active_tab', 'sertifikat');
    }
}
