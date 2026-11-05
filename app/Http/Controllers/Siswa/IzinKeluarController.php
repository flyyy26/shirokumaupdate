<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;

class IzinKeluarController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;

        $izin = IzinKeluar::where('siswa_id', $siswa->id)
            ->latest()
            ->get();

        return view('siswa.izin-keluar', compact('izin'));
    }

    public function indexAdmin()
    {
        $izin = IzinKeluar::with('siswa')
            ->latest()
            ->get();

        return view('izin-keluar', compact('izin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alasan' => 'required',
            'yang_menemani' => 'nullable|string',
            'alamat_tujuan' => 'required',
            'tanggal_keluar' => 'required|date',
            'jam_keluar' => 'required',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_keluar',
            'jam_kembali' => 'required'
        ]);

        $siswa = Auth::user()->siswa;

        IzinKeluar::create([
            'siswa_id' => $siswa->id,
            'alasan' => $request->alasan,
            'yang_menemani' => $request->yang_menemani,
            'alamat_tujuan' => $request->alamat_tujuan,
            'tanggal_keluar' => $request->tanggal_keluar,
            'jam_keluar' => $request->jam_keluar,
            'tanggal_kembali' => $request->tanggal_kembali,
            'jam_kembali' => $request->jam_kembali,
        ]);

        return back()->with('success','Pengajuan izin berhasil dikirim');
    }

    public function print($id)
    {
        $izin = IzinKeluar::with('siswa')->findOrFail($id);

        $pdf = Pdf::loadView('siswa.izin.print', compact('izin'));

        return $pdf->stream('izin-keluar.pdf'); 
        // stream = buka di tab baru
    }
}