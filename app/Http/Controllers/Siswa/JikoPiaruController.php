<?php
// app/Http/Controllers/JikoPiaruController.php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\JikoPiaru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;

class JikoPiaruController extends Controller
{
    /**
     * Update or Create Jiko Piaru
     */
    public function update(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'content_jp' => 'nullable|string|max:5000',
        ]);

        // Dapatkan data siswa dari user yang login
        $siswa = Auth::user()->siswa;
        
        if (!$siswa) {
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $data = [
            'content_jp' => $request->content_jp,
        ];

        // Update or create
        $jikoPiaru = JikoPiaru::updateOrCreate(
            ['siswa_id' => $siswa->id],
            $data
        );

        // Log activity
        if ($jikoPiaru->wasRecentlyCreated) {
            LogHelper::log(
                'Tambah Jiko Piaru',
                'Menambah data Jiko Piaru siswa'
            );
        } else {
            LogHelper::log(
                'Update Jiko Piaru',
                'Memperbarui data Jiko Piaru siswa'
            );
        }

        return back()->with('success', 'Jiko Piaru berhasil disimpan!')->with('active_tab', 'jiko-piaru');
    }

    /**
     * Get Jiko Piaru data (untuk AJAX jika diperlukan)
     */
    public function get($siswaId = null)
    {
        if (!$siswaId) {
            $siswa = Auth::user()->siswa;
            $siswaId = $siswa ? $siswa->id : null;
        }
        
        $jikoPiaru = JikoPiaru::where('siswa_id', $siswaId)->first();
        
        return response()->json([
            'success' => true,
            'data' => $jikoPiaru
        ]);
    }
}