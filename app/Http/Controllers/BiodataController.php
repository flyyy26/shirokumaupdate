<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BiodataSiswa;
use App\Helpers\LogHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;

class BiodataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
    
        if ($user->role === 'admin') {
            return redirect()->route('siswa.index');
        }
    
        if (!$user->siswa) {
            return redirect()->to('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }
    
        $siswa = $user->siswa;
    
        $biodata = BiodataSiswa::firstOrCreate([
            'siswa_id' => $siswa->id
        ]);
    
        $status = $biodata->status_siswa_sebelumnya;
        $isLPK = ($status === 'LPK');
        $namaLPK = $biodata->nama_lpk ?? '';
    
        LogHelper::log('Lihat Biodata', 'Melihat data biodata');
    
        return view('biodata', compact('siswa', 'biodata', 'status', 'isLPK', 'namaLPK'));
    }

    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}

    public function update(Request $request)
    {
        $user = Auth::user();
    
        if (!$user || !$user->siswa) {
            abort(403);
        }
    
        $biodata = BiodataSiswa::firstOrCreate([
            'siswa_id' => $user->siswa->id
        ]);
    
        $validated = $request->validate([
            'level_bahasa_jepang' => 'nullable|string|max:255',
            'rencana_lama_di_jepang' => 'nullable|string|max:255',
            'periode_mulai' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:255',
            'nomor_paspor' => 'nullable|string|max:255',
            'wilayah_alamat' => 'nullable|string|max:255',
            'tangan_dominan' => 'nullable|in:Kanan,Kiri',
            'golongan_darah' => 'nullable|string|max:255',
            'buta_warna' => 'nullable|string|max:255',
            'alergi' => 'nullable|in:Ya,Tidak',
            'merokok' => 'nullable|string|max:255',
            'peminum_alkohol' => 'nullable|string|max:255',
            'tatto' => 'nullable|string|max:255',
            'gigi_berlubang' => 'nullable|string|max:255',
            'riwayat_penyakit' => 'nullable|string|max:255',
            'kacamata' => 'nullable|string|max:255',
            'kondisi_mata_kiri' => 'nullable|string|max:255',
            'kondisi_mata_kanan' => 'nullable|string|max:255',
            'status_perkawinan' => 'nullable|in:Belum Menikah,Menikah,Cerai',
            'tinggi_badan' => 'nullable|integer',
            'berat_badan' => 'nullable|integer',
            'jumlah_anak' => 'nullable|integer',
            'tanggal_pembuatan_paspor' => 'nullable|date',
            'tanggal_paspor_dikeluarkan' => 'nullable|date',
            'hobi' => 'nullable|array',
            'keunggulan_diri' => 'nullable|string',
            'kekurangan_diri' => 'nullable|string',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status_siswa_sebelumnya' => 'nullable|in:LPK,Mandiri',
            'nama_lpk' => 'nullable|string|max:255|required_if:status_siswa_sebelumnya,LPK',
        ]);
    
        if (isset($validated['hobi'])) {
            $validated['hobi'] = json_encode($validated['hobi']);
        }
    
        if ($request->status_siswa_sebelumnya === 'Mandiri') {
            $validated['nama_lpk'] = null;
        } elseif ($request->status_siswa_sebelumnya !== 'LPK') {
            $validated['status_siswa_sebelumnya'] = null;
            $validated['nama_lpk'] = null;
        }
    
        if ($request->hasFile('dokumen')) {
            if ($biodata->dokumen && Storage::disk('public')->exists($biodata->dokumen)) {
                Storage::disk('public')->delete($biodata->dokumen);
            }
            $validated['dokumen'] = $request->file('dokumen')->store('dokumen_siswa', 'public');
        } else {
            unset($validated['dokumen']);
        }
    
        $biodata->update($validated);
    
        if (class_exists('App\Helpers\LogHelper')) {
            LogHelper::log('Update Biodata', 'Memperbarui data biodata');
        }
    
        return redirect()
            ->route('biodata.index')
            ->with('success', 'Biodata berhasil diperbarui.')
            ->with('active_tab', 'biodata');
    }

    public function destroy(string $id) {}

    public function printCv()
    {
        $user = Auth::user();
    
        $siswa = $user->siswa->load([
            'biodata',
            'keluargas',
            'pendidikans',
            'riwayatPekerjaans',
            'sertifikats',
            'jikoPiaru'
        ]);
        
        $jobPivot = \DB::table('job_siswa')
            ->where('siswa_id', $siswa->id)
            ->orderBy('created_at', 'desc')
            ->first();
            
        $urutanSiswa = $jobPivot ? $jobPivot->urutan : '-';
    
        // ========== FONT ==========
        // Prioritas: storage/fonts (lokal), fallback ke path hosting jika ada
        $fontPath = storage_path('fonts/NotoSansJP-Regular.ttf');
        if (!file_exists($fontPath)) {
            $fontPath = base_path('storage/fonts/NotoSansJP-Regular.ttf');
        }
        $fontBase64 = file_exists($fontPath) ? base64_encode(file_get_contents($fontPath)) : null;
        
        // ========== LOGO ==========
        // Prioritas: public_path/images/logo.png (lokal)
        $logoBase64 = null;
        $logoPath = public_path('images/logo.png');
        
        if (!file_exists($logoPath)) {
            // Fallback ke path hosting jika file lokal tidak ada
            $logoPath = '/home/u143612213/domains/lpkshirokuma.com/public_html/images/logo.png';
        }
        
        if (file_exists($logoPath)) {
            $imageData = base64_encode(file_get_contents($logoPath));
            $mimeType = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $logoPath);
            $logoBase64 = 'data:' . $mimeType . ';base64,' . $imageData;
        }
        
        // ========== BACKGROUND CV ==========
        $bgBase64 = null;
        $bgPath = public_path('images/bg-cv.png');
        
        if (!file_exists($bgPath)) {
            $bgPath = '/home/u143612213/domains/lpkshirokuma.com/public_html/images/bg-cv.png';
        }
        
        if (file_exists($bgPath)) {
            $imageDataBg = base64_encode(file_get_contents($bgPath));
            $mimeTypeBg = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $bgPath);
            $bgBase64 = 'data:' . $mimeTypeBg . ';base64,' . $imageDataBg;
            \Log::info('Background CV ditemukan! Path: ' . $bgPath);
        } else {
            // Coba beberapa path alternatif (lokal)
            \Log::error('Background CV TIDAK ditemukan di: ' . $bgPath);
            
            $alternativePathsBg = [
                public_path('images/bg-cv.png'),
                public_path('img/bg-cv.png'),
                storage_path('app/public/bg-cv.png'),
                base_path('public/images/bg-cv.png'),
            ];
            
            foreach ($alternativePathsBg as $pathBg) {
                if (file_exists($pathBg)) {
                    $imageDataBg = base64_encode(file_get_contents($pathBg));
                    $mimeTypeBg = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $pathBg);
                    $bgBase64 = 'data:' . $mimeTypeBg . ';base64,' . $imageDataBg;
                    \Log::info('Background CV DITEMUKAN di alternatif: ' . $pathBg);
                    break;
                }
            }
        }
        
        // ========== FOTO SISWA ==========
        $fotoBase64 = null;

        if ($siswa->foto) {
            // Prioritas: storage/app/public/ (lokal)
            $fotoPath = storage_path('app/public/' . $siswa->foto);
            
            // Fallback ke path hosting
            if (!file_exists($fotoPath)) {
                $fotoPath = '/home/u143612213/domains/lpkshirokuma.com/backend/storage/app/public/' . $siswa->foto;
            }
        
            if (file_exists($fotoPath)) {
                $imageContent = file_get_contents($fotoPath);
        
                $image = imagecreatefromstring($imageContent);
        
                if ($image !== false) {
                    $width = imagesx($image);
                    $height = imagesy($image);
        
                    $canvas = imagecreatetruecolor($width, $height);
                    $white = imagecolorallocate($canvas, 255, 255, 255);
                    imagefill($canvas, 0, 0, $white);
                    imagecopy($canvas, $image, 0, 0, 0, 0, $width, $height);
        
                    ob_start();
                    imagejpeg($canvas, null, 90);
                    $jpgData = ob_get_clean();
        
                    imagedestroy($image);
                    imagedestroy($canvas);
        
                    $fotoBase64 = 'data:image/jpeg;base64,' . base64_encode($jpgData);
                }
            }
        }
        
        $html = view('cv_pdf', compact('siswa', 'fontBase64', 'logoBase64', 'fotoBase64', 'bgBase64', 'urutanSiswa'))->render();
        
        $pdf = Pdf::loadHTML($html)
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'defaultFont' => 'Noto Sans JP',
                    'isRemoteEnabled' => true,
                    'isHtml5ParserEnabled' => true,
                    'fontDir' => storage_path('fonts'),
                    'fontCache' => storage_path('fonts'),
                ]);
        
        return $pdf->stream('CV_' . str_replace(' ', '_', $siswa->nama_lengkap) . '.pdf');
    }

    public function printCvJepang()
    {
        $user = Auth::user();
        $siswa = $user->siswa->load([
            'biodata', 'keluargas', 'pendidikans', 
            'riwayatPekerjaans', 'sertifikats', 'kartuKeluarga', 
            'jobs.company', 'jikoPiaru'
        ]);

        LogHelper::log('Cetak CV Jepang', 'Mencetak CV Versi Jepang PDF');

        $pdf = Pdf::loadView('cv_jepang_pdf', compact('siswa'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isFontSubsettingEnabled' => true,
                'fontDir' => storage_path('fonts'),
                'fontCache' => storage_path('fonts'),
            ]);
        
        return $pdf->stream('CV_Jepang_' . str_replace(' ', '_', $siswa->nama_lengkap) . '.pdf');
    }
}