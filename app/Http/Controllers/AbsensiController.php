<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\KelasSesi;
use App\Models\Absensi;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index($kelas_id, $sesi_id)
    {
        $kelas = Kelas::with(['siswas' => function($q) {
            // Filter siswa yang berstatus karantina
            $statusKarantina = \App\Models\StudentStatus::where('nama_status', 'like', '%karantina%')->first();
            if ($statusKarantina) {
                $q->where('student_status_id', $statusKarantina->id);
            }
        }])->findOrFail($kelas_id);
        
        $sesi = KelasSesi::findOrFail($sesi_id);
    
        $tanggal = request('tanggal') ?? Carbon::today()->toDateString();
    
        $absensi = Absensi::where('kelas_sesi_id', $sesi_id)
                    ->where('tanggal', $tanggal)
                    ->get()
                    ->keyBy('siswa_id');
    
        return view('karantina.absensi', compact(
            'kelas','sesi','tanggal','absensi'
        ));
    }
    public function store(Request $request, $kelas_id, $sesi_id)
    {
        $tanggal = $request->tanggal;
    
        foreach ($request->status as $siswa_id => $status) {
            Absensi::updateOrCreate(
                [
                    'kelas_id' => $kelas_id,
                    'kelas_sesi_id' => $sesi_id,
                    'siswa_id' => $siswa_id,
                    'tanggal' => $tanggal,
                ],
                [
                    'status' => $status
                ]
            );
        }
    
        // Redirect ke halaman karantina dengan pesan sukses
        return redirect()->route('kelas.index')
            ->with('success', 'Absensi berhasil disimpan');
    }
    public function rekap($kelas_id)
    {
        $kelas = Kelas::with('siswas')->findOrFail($kelas_id);

        $rekap = Absensi::where('kelas_id', $kelas_id)
            ->selectRaw('siswa_id,
                SUM(status="hadir") as hadir,
                SUM(status="izin") as izin,
                SUM(status="sakit") as sakit,
                SUM(status="alfa") as alfa')
            ->groupBy('siswa_id')
            ->get()
            ->keyBy('siswa_id');

        return view('karantina.rekap', compact('kelas','rekap'));
    }
}
