<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Billing;
use App\Models\Siswa;

class AdminBillingController extends Controller
{
    public function index()
    {
        $billings = Billing::with(['siswa', 'payment'])->latest()->get();
        $siswa = Siswa::orderBy('nama_lengkap')->get();

        return view('tagihan.index', compact('billings','siswa'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'nominal' => 'required|numeric',
            'siswa_ids' => 'required|array'
        ]);

        foreach ($request->siswa_ids as $siswa_id) {
            \App\Models\Billing::create([
                'siswa_id' => $siswa_id,
                'judul' => $request->judul,
                'nominal' => $request->nominal,
                'jatuh_tempo' => $request->jatuh_tempo,
                'keterangan' => $request->keterangan,
            ]);
        }

        return back()->with('success','Tagihan berhasil dibuat');
    }

    public function verify(Billing $tagihan)
    {
        $tagihan->update(['status' => 'lunas']);
        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function destroy(Billing $tagihan)
    {
        $tagihan->delete();
        return back()->with('success','Tagihan berhasil dihapus');
    }
}
