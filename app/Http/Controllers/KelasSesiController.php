<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasSesi;
use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;


class KelasSesiController extends Controller
{
    public function store(Request $request, $kelas_id)
    {
        $request->validate([
            'nama_sesi' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        KelasSesi::create([
            'kelas_id' => $kelas_id,
            'nama_sesi' => $request->nama_sesi,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return back()->with('success','Sesi berhasil ditambahkan');
    }
    public function destroy($id)
    {
        $sesi = KelasSesi::findOrFail($id);

        // Cek apakah sudah ada absensi
        $adaAbsensi = Absensi::where('kelas_sesi_id', $sesi->id)->exists();

        if ($adaAbsensi) {
            return back()->with('error', 'Sesi tidak bisa dihapus karena sudah memiliki data absensi.');
        }

        $sesi->delete();

        return back()->with('success', 'Sesi berhasil dihapus.');
    }
}
