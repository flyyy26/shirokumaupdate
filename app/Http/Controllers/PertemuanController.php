<?php

namespace App\Http\Controllers;

use App\Models\Pertemuan;
use Illuminate\Http\Request;

class PertemuanController extends Controller
{
    // --- ADMIN METHODS ---
    public function index()
    {
        $pertemuans = Pertemuan::latest()->get();
        return view('admin.pertemuan.index', compact('pertemuans'));
    }

    public function show(Pertemuan $pertemuan)
    {
        return view('admin.pertemuan.show', compact('pertemuan'));
    }

    public function destroy(Pertemuan $pertemuan)
    {
        $pertemuan->delete();
        return back()->with('success', 'Data pertemuan berhasil dihapus');
    }

    // --- PUBLIC METHODS ---
    public function create()
    {
        return view('pertemuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'alamat_lengkap' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        Pertemuan::create([
            'nama_lengkap' => $request->nama_lengkap,
            'program' => $request->program,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat_lengkap' => $request->alamat_lengkap,
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Data pertemuan berhasil disimpan. Tim kami akan menghubungi Anda segera.');
    }
}