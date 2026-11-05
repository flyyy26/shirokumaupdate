<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Mail\PendaftaranBaru;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{
    // --- ADMIN METHODS ---
    public function index()
    {
        $pendaftarans = Pendaftaran::latest()->get();
        return view('admin.pendaftaran.index', compact('pendaftarans'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function destroy(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->bukti_pembayaran) {
            Storage::disk('public')->delete($pendaftaran->bukti_pembayaran);
        }
        $pendaftaran->delete();
        return back()->with('success', 'Data pendaftaran berhasil dihapus');
    }

    // --- PUBLIC METHODS ---

    public function create()
    {
        return view('pendaftaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'program' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'no_hp' => 'required',
            'pendidikan_terakhir' => 'required',
            'pernah_belajar_jepang' => 'required',
            'alamat' => 'required',
            'tinggi_badan' => 'required',
            'berat_badan' => 'required',
            'bukti_pembayaran' => 'required|image|max:2048',
        ]);

        $data = $request->all();

        // Handle File Upload
        if ($request->hasFile('bukti_pembayaran')) {
            $data['bukti_pembayaran'] = $request->file('bukti_pembayaran')->store('pendaftaran', 'public');
        }

        $pendaftaran = Pendaftaran::create($data);

        // Kirim email ke admin
        try {
            Mail::to('mraflyyy26@gmail.com')->send(new PendaftaranBaru($pendaftaran));
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email pendaftaran: ' . $e->getMessage());
        }

        return redirect()->back()->with('success','Pendaftaran berhasil dikirim');
    }
}