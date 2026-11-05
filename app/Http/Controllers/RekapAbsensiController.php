<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Absensi;
use Carbon\Carbon;

class RekapAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::all();

        $kelasId = $request->kelas_id;
        $tanggal = $request->tanggal;
        $bulan = $request->bulan;

        $absensis = collect();

        if ($kelasId) {

            $query = Absensi::with(['siswa', 'sesi', 'kelas'])
                ->whereHas('kelas', function($q) use ($kelasId){
                    $q->where('id', $kelasId);
                });

            // PRIORITAS: tanggal lebih dulu
            if ($tanggal) {
                $query->whereDate('tanggal', $tanggal);
                $bulan = null; // reset bulan
            } 
            elseif ($bulan) {
                $parsed = Carbon::parse($bulan);
                $query->whereMonth('tanggal', $parsed->month)
                    ->whereYear('tanggal', $parsed->year);
                $tanggal = null; // reset tanggal
            }

            $absensis = $query->get();
        }

        return view('karantina.rekap', compact(
            'kelasList',
            'absensis',
            'kelasId',
            'tanggal',
            'bulan'
        ));
    }
}