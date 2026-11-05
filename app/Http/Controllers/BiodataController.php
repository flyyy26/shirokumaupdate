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
    
        // Jika admin nyasar ke sini (karena intended redirect), arahkan ke daftar siswa
        if ($user->role === 'admin') {
            return redirect()->route('siswa.index');
        }
    
        if (!$user->siswa) {
            return redirect()->to('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }
    
        // Load relasi untuk mengecek kelengkapan tab
        $siswa = $user->siswa->load([
            'keluargas',
            'pendidikans',
            'jikoPiaru',
            'riwayatPekerjaans',
            'sertifikats',
        ]);
    
        // Ambil atau buat biodata otomatis
        $biodata = BiodataSiswa::firstOrCreate([
            'siswa_id' => $siswa->id
        ]);
    
        // Definisikan variabel untuk status siswa sebelumnya
        $status = $biodata->status_siswa_sebelumnya;
        $isLPK = ($status === 'LPK');
        $namaLPK = $biodata->nama_lpk ?? '';
        
        // ── LOGIKA PENGECEKAN KELENGKAPAN TAB BIODATA ──
        // Pastikan semua field wajib terisi
        $biodataLengkap = 
            // Cek string
            filled($biodata->status_siswa_sebelumnya) &&
            filled($biodata->level_bahasa_jepang) &&
            filled($biodata->rencana_lama_di_jepang) &&
            filled($biodata->periode_mulai) &&
            filled($biodata->nik) &&
            filled($biodata->wilayah_alamat) &&
            filled($biodata->tangan_dominan) &&
            filled($biodata->golongan_darah) &&
            filled($biodata->buta_warna) &&
            filled($biodata->alergi) &&
            filled($biodata->merokok) &&
            filled($biodata->peminum_alkohol) &&
            filled($biodata->tatto) &&
            filled($biodata->gigi_berlubang) &&
            filled($biodata->patah_tulang) &&
            filled($biodata->riwayat_penyakit) &&
            filled($biodata->kacamata) &&
            filled($biodata->kondisi_mata_kiri) &&
            filled($biodata->kondisi_mata_kanan) &&
            filled($biodata->status_perkawinan) &&
            filled($biodata->keunggulan_diri) &&
            filled($biodata->kekurangan_diri) &&
            
            // Cek angka (0 dianggap valid)
            $biodata->tinggi_badan !== null &&
            $biodata->berat_badan !== null &&
            $biodata->ukuran_sepatu !== null &&
            $biodata->ukuran_pinggang !== null &&
            
            // Cek Hobi (karena bentuknya JSON/Array)
            !empty(json_decode($biodata->hobi ?? '[]', true));
            // Catatan: nomor_paspor & tanggal sengaja tidak dicek di sini karena formnya ada di tab Dokumen
    
        // ── STATUS UNTUK SETIAP TAB ──
        $tabStatus = [
            'biodata'    => $biodataLengkap,
            'keluarga'   => $siswa->keluargas->count() >= 2,
            'pendidikan' => $siswa->pendidikans->count() >= 3,
            'jiko-piaru' => optional($siswa->jikoPiaru)->content_jp
                            && strlen(trim($siswa->jikoPiaru->content_jp)) > 0,
            'pekerjaan'  => $siswa->riwayatPekerjaans->count() > 0,
            'sertifikat' => $siswa->sertifikats->count() > 0,
            'dokumen'    => true,
        ];
    
        LogHelper::log(
            'Lihat Biodata',
            'Melihat data biodata'
        );
    
        $defaultTab = 'biodata'; // Fallback jika semua sudah terisi

        foreach (['biodata', 'keluarga', 'pendidikan', 'jiko-piaru', 'pekerjaan', 'sertifikat', 'dokumen'] as $tab) {
            if (empty($tabStatus[$tab])) {
                $defaultTab = $tab;
                break; // Berhenti di tab pertama yang kosong
            }
        }

        // ✅ Simpan ke session agar dibaca oleh JavaScript
        session(['active_tab' => $defaultTab]);

        // Kirim $tabStatus ke view
        return view('biodata', compact('siswa', 'biodata', 'status', 'isLPK', 'namaLPK', 'tabStatus'));
    }

    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}

        /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
    
        if (!$user || !$user->siswa) {
            abort(403);
        }
    
        $biodata = BiodataSiswa::firstOrCreate([
            'siswa_id' => $user->siswa->id
        ]);
    
        // Tentukan tab asal form yang disubmit
        $activeTab = $request->input('active_tab', 'biodata');

        // Aturan validasi dasar
        $rules = [
            // ── Field Wajib di Tab Biodata ──
            'level_bahasa_jepang'      => 'required|string|max:255',
            'rencana_lama_di_jepang'   => 'required|string|max:255',
            'periode_mulai'            => 'required|string|max:255',
            'nik'                      => 'required|string|max:255',
            'wilayah_alamat'           => 'required|string|max:255',
            'tangan_dominan'           => 'required|in:Kanan,Kiri',
            'golongan_darah'           => 'required|string|max:255',
            'buta_warna'               => 'required|string|max:255',
            'alergi'                   => 'required|in:Ya,Tidak',
            'merokok'                  => 'required|string|max:255',
            'peminum_alkohol'          => 'required|string|max:255',
            'tatto'                    => 'required|string|max:255',
            'gigi_berlubang'           => 'required|string|max:255',
            'patah_tulang'             => 'required|string|max:255',
            'riwayat_penyakit'         => 'required|string|max:255',
            'kacamata'                 => 'required|string|max:255',
            'kondisi_mata_kiri'        => 'required|string|max:255',
            'kondisi_mata_kanan'       => 'required|string|max:255',
            'status_perkawinan'        => 'required|in:Belum Menikah,Menikah,Cerai',
            'tinggi_badan'             => 'required|integer',
            'berat_badan'              => 'required|integer',
            'ukuran_sepatu'            => 'required|integer',
            'ukuran_pinggang'          => 'required|integer',
            'hobi'                     => 'required|array|min:1',
            'keunggulan_diri'          => 'required|string',
            'kekurangan_diri'          => 'required|string',
            'status_siswa_sebelumnya'  => 'required|in:LPK,Mandiri',
            
            // ── Field Kondisional / Opsional ──
            'nama_lpk'                 => 'nullable|string|max:255|required_if:status_siswa_sebelumnya,LPK',
            'jumlah_anak'              => 'nullable|integer',
            'dokumen'                  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        // JIKA yang disubmit adalah form dari tab DOKUMEN, wajibkan isi paspor
        // JIKA dari tab BIODATA, jangan wajibkan paspor (karena formnya tidak ada di sana)
        if ($activeTab === 'dokumen') {
            $rules['nomor_paspor'] = 'required|string|max:255';
            $rules['tanggal_pembuatan_paspor'] = 'required|date';
            $rules['tanggal_paspor_dikeluarkan'] = 'required|date';
        } else {
            // Opsional jika dari tab biodata, agar tidak error
            $rules['nomor_paspor'] = 'nullable|string|max:255';
            $rules['tanggal_pembuatan_paspor'] = 'nullable|date';
            $rules['tanggal_paspor_dikeluarkan'] = 'nullable|date';
        }

        $validated = $request->validate($rules);
    
        // --- PROSES HOBI (Array to JSON) ---
        if (isset($validated['hobi'])) {
            $validated['hobi'] = json_encode($validated['hobi']);
        }
    
        // --- PROSES STATUS SISWA SEBELUMNYA ---
        if ($request->status_siswa_sebelumnya === 'Mandiri') {
            // Jika Mandiri, set nama_lpk menjadi null
            $validated['nama_lpk'] = null;
        } elseif ($request->status_siswa_sebelumnya !== 'LPK') {
            // Jika tidak dipilih atau nilai tidak valid, set keduanya null
            $validated['status_siswa_sebelumnya'] = null;
            $validated['nama_lpk'] = null;
        }
    
        // --- PROSES DOKUMEN (Upload file pendukung) ---
        if ($request->hasFile('dokumen')) {
            // Hapus dokumen lama jika ada
            if ($biodata->dokumen && Storage::disk('public')->exists($biodata->dokumen)) {
                Storage::disk('public')->delete($biodata->dokumen);
            }
            
            // Simpan dokumen baru
            $validated['dokumen'] = $request->file('dokumen')->store('dokumen_siswa', 'public');
        } else {
            // Hapus dokumen dari validated jika tidak ada file baru
            unset($validated['dokumen']);
        }
    
        // Update biodata
        $biodata->update($validated);
    
        // Log aktivitas
        if (class_exists('App\Helpers\LogHelper')) {
            LogHelper::log('Update Biodata', 'Memperbarui data biodata');
        }
    
        // ── LOGIKA REDIRECT OTOMATIS SETELAH SIMPAN ──
        session()->forget('active_tab');

        $nextTab = 'biodata'; 
        
        // PAKSA ke keluarga jika yang disubmit adalah biodata (Abaikan cek data dulu)
        if ($request->input('active_tab') === 'biodata') {
            $nextTab = 'keluarga';
        } elseif ($request->input('active_tab') === 'dokumen') {
            $nextTab = 'dokumen';
        }

        return redirect()
            ->route('biodata.index')
            ->with('success', 'Data berhasil diperbarui.')
            ->with('active_tab', $nextTab);
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