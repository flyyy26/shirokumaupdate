<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

class SiswaKarantinaController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;

        if (!$siswa || !$siswa->kelas_id) {
            return view('siswa.karantina', ['kelas' => null]);
        }

        // Load kelas dengan relasi yang dibutuhkan
        $kelas = Kelas::with(['company', 'job', 'guru', 'sesi'])
            ->findOrFail($siswa->kelas_id);

        // Ambil data absensi siswa ini di kelas tersebut, dikelompokkan berdasarkan tanggal
        $absensis = Absensi::where('siswa_id', $siswa->id)
            ->where('kelas_id', $kelas->id)
            ->orderBy('tanggal', 'desc')
            ->get()
            ->groupBy('tanggal');

        return view('siswa.karantina', compact('kelas', 'absensis'));
    }
}