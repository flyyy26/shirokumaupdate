<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Keberangkatan;

class KeberangkatanController extends Controller
{

    public function index()
    {
        $students = Siswa::whereHas('status', function ($q) {
            $q->where('nama_status', 'berangkat');
        })->get();
    
        return view('admin.keberangkatan.index', compact('students'));
    }


    public function create($id)
    {
        $siswa = Siswa::findOrFail($id);
    
        $keberangkatan = Keberangkatan::where('siswa_id', $id)->first();
    
        return view('admin.keberangkatan.data_keberangkatan', compact('siswa','keberangkatan'));
    }


    public function store(Request $request)
    {
        Keberangkatan::create([
            'siswa_id' => $request->siswa_id,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'bandara_asal' => $request->bandara_asal,
            'bandara_tujuan' => $request->bandara_tujuan,
            'maskapai' => $request->maskapai,
            'nomor_penerbangan' => $request->nomor_penerbangan,
            'jam_keberangkatan' => $request->jam_keberangkatan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('keberangkatan.index')
            ->with('success','Data keberangkatan berhasil disimpan');
    }
    
    public function update(Request $request, $id)
    {
        $keberangkatan = Keberangkatan::findOrFail($id);
    
        $keberangkatan->update([
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'bandara_asal' => $request->bandara_asal,
            'bandara_tujuan' => $request->bandara_tujuan,
            'maskapai' => $request->maskapai,
            'nomor_penerbangan' => $request->nomor_penerbangan,
            'jam_keberangkatan' => $request->jam_keberangkatan,
            'keterangan' => $request->keterangan,
        ]);
    
        return redirect()->route('keberangkatan.index')
            ->with('success','Data keberangkatan berhasil diupdate');
    }

}