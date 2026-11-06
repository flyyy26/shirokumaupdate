<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogHelper;
use Barryvdh\DomPDF\Facade\Pdf;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::latest()->get();
        LogHelper::log('Lihat Siswa', 'Melihat daftar siswa');
        return view('siswa.index', compact('siswas'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nama_panggilan' => 'nullable|string|max:255',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date_format:d/m/Y',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string|max:50',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'nama_lengkap_katakana' => 'nullable|string|max:255',
            'nama_panggilan_katakana' => 'nullable|string|max:255',
        ]);
    
        $user = \App\Models\User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'siswa',
        ]);
    
        $data = $request->only([
            'nama_lengkap',
            'nama_lengkap_katakana',
            'nama_panggilan',
            'nama_panggilan_katakana',
            'tempat_lahir',
            'jenis_kelamin',
            'agama',
            'alamat',
            'no_hp',
        ]);
    
        $data['tanggal_lahir'] = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir)->format('Y-m-d');
        $data['user_id'] = $user->id;
        $data['student_status_id'] = 1;
    
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }
    
        Siswa::create($data);
    
        LogHelper::log('Tambah Siswa', 'Menambah data siswa baru: ' . $request->nama_lengkap);
    
        return back()->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit(Siswa $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $siswa->user_id,
            'nama_lengkap' => 'required',
            'nama_panggilan' => 'nullable|string|max:255',
            'nama_panggilan_katakana' => 'nullable|string|max:255',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date_format:d/m/Y',
            'jenis_kelamin' => 'required',
            'agama' => 'required|string|max:50',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'nama_lengkap_katakana' => 'nullable|string|max:255',
            'nama_panggilan_katakana' => 'nullable|string|max:255',
        ]);

        if ($siswa->user) {
            $siswa->user->update(['email' => $request->email]);
        }

        $data = $request->except(['foto', 'email']);
        $data['tanggal_lahir'] = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir)->format('Y-m-d');

        if ($request->hasFile('foto')) {
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa->update($data);

        LogHelper::log('Update Siswa', 'Memperbarui data siswa: ' . $siswa->nama_lengkap);

        return redirect()->route('siswa.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->user) {
            $siswa->user->delete();
        }
        $siswa->delete();
        
        LogHelper::log(
            'Hapus Siswa',
            'Menghapus data siswa: ' . $siswa->nama_lengkap . ' beserta user terkait'
        );
        
        return back()->with('success', 'Data siswa dan user berhasil dihapus');
    }

    public function printCv(Siswa $siswa)
    {
        $siswa->load([
            'biodata', 
            'pendidikans', 
            'riwayatPekerjaans', 
            'sertifikats', 
            'keluargas', 
            'jobs.company', 
            'jikoPiaru'
        ]);
        
        $jobPivot = \DB::table('job_siswa')
            ->where('siswa_id', $siswa->id)
            ->orderBy('created_at', 'desc')
            ->first();
        
        $urutanSiswa = $jobPivot ? $jobPivot->urutan : '-';
    
        // ========== FONT ==========
        $fontPath = storage_path('fonts/NotoSansJP-Regular.ttf');
        if (!file_exists($fontPath)) {
            $fontPath = '/home/u143612213/domains/lpkshirokuma.com/backend/storage/fonts/NotoSansJP-Regular.ttf';
        }
        $fontBase64 = file_exists($fontPath) ? base64_encode(file_get_contents($fontPath)) : null;
        
        // ========== LOGO ==========
        $logoBase64 = $this->getLogoBase64();
        
        // ========== FOTO ==========
        $fotoBase64 = $this->getFotoBase64($siswa);
        
        // ========== BACKGROUND CV ==========
        $bgBase64 = $this->getBgBase64();
        
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
        
        return $pdf->stream('CV_' . $siswa->nama_lengkap . '.pdf');
    }
    
    /**
     * Mendapatkan base64 logo dari berbagai kemungkinan lokasi
     */
    private function getLogoBase64()
    {
        $logoBase64 = null;
        
        // Prioritas lokal dulu, fallback ke hosting
        $possiblePaths = [
            public_path('images/logo.png'),
            storage_path('app/public/logo.png'),
            // Fallback hosting
            '/home/u143612213/domains/lpkshirokuma.com/public_html/images/logo.png',
            '/home/u143612213/domains/lpkshirokuma.com/backend/public/images/logo.png',
            base_path('public_html/images/logo.png'),
            base_path('../images/logo.png'),
        ];
        
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                try {
                    $imageData = base64_encode(file_get_contents($path));
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeType = finfo_file($finfo, $path);
                    finfo_close($finfo);
                    $logoBase64 = 'data:' . $mimeType . ';base64,' . $imageData;
                    \Log::info('Logo berhasil dimuat dari: ' . $path);
                    break;
                } catch (\Exception $e) {
                    \Log::error('Gagal memuat logo dari ' . $path . ': ' . $e->getMessage());
                    continue;
                }
            }
        }
        
        if (!$logoBase64) {
            \Log::warning('Logo tidak ditemukan di semua lokasi yang dicoba');
        }
        
        return $logoBase64;
    }
    
    /**
     * Mendapatkan base64 foto siswa
     */
    private function getFotoBase64($siswa)
    {
        if (!$siswa->foto) {
            return null;
        }
    
        // Prioritas lokal dulu, fallback ke hosting
        $possiblePaths = [
            storage_path('app/public/' . $siswa->foto),
            public_path('storage/' . $siswa->foto),
            // Fallback hosting
            '/home/u143612213/domains/lpkshirokuma.com/backend/storage/app/public/' . $siswa->foto,
        ];
    
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                try {
                    $imageContent = file_get_contents($path);
                    $image = imagecreatefromstring($imageContent);
    
                    if ($image === false) {
                        \Log::error('Gagal create image dari: ' . $path);
                        continue;
                    }
    
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
                    \Log::info('Foto berhasil di-convert ke JPG dari: ' . $path);
                    return $fotoBase64;
    
                } catch (\Exception $e) {
                    \Log::error('Gagal proses foto dari ' . $path . ': ' . $e->getMessage());
                    continue;
                }
            }
        }
    
        \Log::warning('Foto tidak ditemukan untuk siswa: ' . $siswa->id . ' - path: ' . $siswa->foto);
        return null;
    }
    
    /**
     * Mendapatkan base64 background CV
     */
    private function getBgBase64()
    {
        $bgBase64 = null;
        
        // Prioritas lokal dulu, fallback ke hosting
        $possiblePaths = [
            public_path('images/bg-cv.png'),
            public_path('img/bg-cv.png'),
            public_path('assets/images/bg-cv.png'),
            storage_path('app/public/bg-cv.png'),
            // Fallback hosting
            '/home/u143612213/domains/lpkshirokuma.com/public_html/images/bg-cv.png',
            '/home/u143612213/domains/lpkshirokuma.com/backend/public/images/bg-cv.png',
            base_path('public_html/images/bg-cv.png'),
            base_path('../images/bg-cv.png'),
            // Format lain
            public_path('background/bg-cv.png'),
            public_path('images/bg-cv.jpg'),
            public_path('images/bg-cv.jpeg'),
        ];
        
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                try {
                    $imageData = base64_encode(file_get_contents($path));
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeType = finfo_file($finfo, $path);
                    finfo_close($finfo);
                    
                    $bgBase64 = 'data:' . $mimeType . ';base64,' . $imageData;
                    \Log::info('Background CV berhasil dimuat dari: ' . $path);
                    break;
                } catch (\Exception $e) {
                    \Log::error('Gagal memuat background CV dari ' . $path . ': ' . $e->getMessage());
                    continue;
                }
            }
        }
        
        if (!$bgBase64) {
            \Log::warning('Background CV tidak ditemukan di semua lokasi yang dicoba');
        }
        
        return $bgBase64;
    }
    
    public function updateBiodataSiswa(Request $request)
    {
        $siswa = auth()->user()->siswa;
    
        if (!$siswa) {
            return back()->with('error', 'Data profil tidak ditemukan.');
        }
    
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nama_lengkap_katakana' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:255',
            'nama_panggilan_katakana' => 'nullable|string|max:255',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date_format:d/m/Y',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string|max:50',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        $data = $request->except(['foto']);
    
        auth()->user()->update(['name' => $request->nama_lengkap]);
    
        $data['tanggal_lahir'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir)->format('Y-m-d');
    
        if (isset($data['alamat'])) {
            $data['alamat'] = strtoupper($data['alamat']);
        }
    
        if ($request->hasFile('foto')) {
            if ($siswa->foto && \Storage::disk('public')->exists($siswa->foto)) {
                \Storage::disk('public')->delete($siswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }
    
        $siswa->update($data);
    
        if (class_exists('App\Helpers\LogHelper')) {
            LogHelper::log('Update Profil', 'Siswa memperbarui biodata mandiri');
        }
    
        return back()->with('success', 'Biodata Anda berhasil diperbarui!');
    }

    public function show(Siswa $siswa)
    {
        // Load semua relasi untuk halaman detail
        $siswa->load([
            'biodata', 
            'keluargas', 
            'pendidikans', 
            'riwayatPekerjaans', 
            'sertifikats', 
            'jikoPiaru',
            'kartuKeluarga'
        ]);
        
        if (class_exists('App\Helpers\LogHelper')) {
            LogHelper::log('Lihat Detail Siswa', 'Admin melihat detail siswa: ' . $siswa->nama_lengkap);
        }

        return view('siswa.show', compact('siswa'));
    }

    public function uploadAkte(Request $request, ?Siswa $siswa = null)
    {
        $request->validate([
            'dokumen_akte' => 'required|file|max:5120|mimes:pdf,jpg,jpeg,png'
        ]);

        // Jika admin mengakses lewat route admin (ada parameter $siswa), gunakan itu.
        // Jika tidak, ambil dari user yang login (siswa).
        $targetSiswa = $siswa ?? Auth::user()->siswa;

        if (!$targetSiswa) {
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        if ($request->hasFile('dokumen_akte')) {
            if ($targetSiswa->dokumen_akte) {
                Storage::disk('public')->delete($targetSiswa->dokumen_akte);
            }
            $path = $request->file('dokumen_akte')->store('dokumen', 'public');
            $targetSiswa->update(['dokumen_akte' => $path]);
        }

        LogHelper::log('Upload Akte', 'Mengupload dokumen akte untuk: ' . $targetSiswa->nama_lengkap);

        return back()
            ->with('success', 'Dokumen akte berhasil diupload.')
            ->with('active_tab', 'admin-dokumen');
    }

    public function uploadKtp(Request $request, ?Siswa $siswa = null)
    {
        $request->validate([
            'dokumen_ktp' => 'required|file|max:5120|mimes:pdf,jpg,jpeg,png'
        ]);

        $targetSiswa = $siswa ?? Auth::user()->siswa;

        if ($targetSiswa->dokumen_ktp) {
            Storage::disk('public')->delete($targetSiswa->dokumen_ktp);
        }

        $path = $request->file('dokumen_ktp')->store('dokumen', 'public');
        $targetSiswa->update(['dokumen_ktp' => $path]);

        LogHelper::log('Upload KTP', 'Mengupload dokumen KTP untuk: ' . $targetSiswa->nama_lengkap);

        return back()
            ->with('success', 'Dokumen KTP berhasil diupload.')
            ->with('active_tab', 'admin-dokumen');
    }

    public function uploadPaspor(Request $request, ?Siswa $siswa = null)
    {
        $targetSiswa = $siswa ?? Auth::user()->siswa;

        $rules = [
            'nomor_paspor' => 'required|string|max:50',
            'tanggal_pembuatan_paspor' => 'required|date',
            'tanggal_keluar_paspor' => 'required|date',
            'dokumen_paspor' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png',
        ];

        if (!$targetSiswa->dokumen_paspor) {
            $rules['dokumen_paspor'] = 'required|file|max:5120|mimes:pdf,jpg,jpeg,png';
        }

        $request->validate($rules);

        // 1. Update data paspor di tabel siswa
        $dataSiswa = [
            'nomor_paspor' => $request->nomor_paspor,
            'tanggal_pembuatan_paspor' => $request->tanggal_pembuatan_paspor,
            'tanggal_keluar_paspor' => $request->tanggal_keluar_paspor,
        ];

        if ($request->hasFile('dokumen_paspor')) {
            if ($targetSiswa->dokumen_paspor) {
                Storage::disk('public')->delete($targetSiswa->dokumen_paspor);
            }
            $dataSiswa['dokumen_paspor'] = $request->file('dokumen_paspor')->store('dokumen', 'public');
        }

        $targetSiswa->update($dataSiswa);

        // 2. Update data paspor di tabel biodata_siswa (jika diakses oleh admin)
        if ($siswa) {
            $biodata = \App\Models\BiodataSiswa::firstOrCreate(['siswa_id' => $siswa->id]);
            $biodata->update([
                'nomor_paspor' => $request->nomor_paspor,
                'tanggal_pembuatan_paspor' => $request->tanggal_pembuatan_paspor,
                'tanggal_paspor_dikeluarkan' => $request->tanggal_keluar_paspor, // Sesuaikan nama field di DB biodata
            ]);
        }

        LogHelper::log('Upload Paspor', 'Mengupload dan menyimpan data paspor untuk: ' . $targetSiswa->nama_lengkap);

        return back()
            ->with('success', 'Data dan File Paspor berhasil disimpan.')
            ->with('active_tab', 'admin-dokumen');
    }

    public function uploadMcu(Request $request, ?Siswa $siswa = null)
    {
        $request->validate([
            'mcu' => 'required|file|max:5120|mimes:pdf,jpg,jpeg,png'
        ]);

        $targetSiswa = $siswa ?? Auth::user()->siswa;

        if ($request->hasFile('mcu')) {
            if ($targetSiswa->mcu && Storage::disk('public')->exists($targetSiswa->mcu)) {
                Storage::disk('public')->delete($targetSiswa->mcu);
            }
            $path = $request->file('mcu')->store('mcu', 'public');
            $targetSiswa->update(['mcu' => $path]);
        }

        LogHelper::log('Upload MCU', 'Mengupload dokumen MCU untuk: ' . $targetSiswa->nama_lengkap);

        return back()->with('success', 'Dokumen MCU berhasil diupload.');
    }

    public function uploadCoe(Request $request, ?Siswa $siswa = null)
    {
        $targetSiswa = $siswa ?? Auth::user()->siswa;
    
        $rules = [
            'nomor_coe' => 'required|string|max:100',
            'tanggal_coe' => 'required|date',
            'dokumen_coe' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png',
        ];
    
        if (!$targetSiswa->dokumen_coe) {
            $rules['dokumen_coe'] = 'required|file|max:5120|mimes:pdf,jpg,jpeg,png';
        }
    
        $request->validate($rules);
    
        $data = [
            'nomor_coe' => $request->nomor_coe,
            'tanggal_coe' => $request->tanggal_coe,
        ];
    
        if ($request->hasFile('dokumen_coe')) {
            if ($targetSiswa->dokumen_coe && Storage::disk('public')->exists($targetSiswa->dokumen_coe)) {
                Storage::disk('public')->delete($targetSiswa->dokumen_coe);
            }
            $data['dokumen_coe'] = $request->file('dokumen_coe')->store('dokumen', 'public');
        }
    
        $targetSiswa->update($data);
    
        LogHelper::log('Upload COE', 'Mengupload dokumen COE untuk: ' . $targetSiswa->nama_lengkap);
    
        return back()
            ->with('success', 'Dokumen COE berhasil diupload.')
            ->with('active_tab', 'admin-dokumen');
    }

    public function uploadVisa(Request $request, ?Siswa $siswa = null)
    {
        $targetSiswa = $siswa ?? Auth::user()->siswa;
    
        $rules = [
            'nomor_visa' => 'required|string|max:100',
            'tanggal_visa' => 'required|date',
            'masa_berlaku_visa' => 'required|string|max:50',
            'dokumen_visa' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png',
        ];
    
        if (!$targetSiswa->dokumen_visa) {
            $rules['dokumen_visa'] = 'required|file|max:5120|mimes:pdf,jpg,jpeg,png';
        }
    
        $request->validate($rules);
    
        $data = [
            'nomor_visa' => $request->nomor_visa,
            'tanggal_visa' => $request->tanggal_visa,
            'masa_berlaku_visa' => $request->masa_berlaku_visa,
        ];
    
        if ($request->hasFile('dokumen_visa')) {
            if ($targetSiswa->dokumen_visa && Storage::disk('public')->exists($targetSiswa->dokumen_visa)) {
                Storage::disk('public')->delete($targetSiswa->dokumen_visa);
            }
            $data['dokumen_visa'] = $request->file('dokumen_visa')->store('dokumen', 'public');
        }
    
        $targetSiswa->update($data);
    
        LogHelper::log('Upload Visa', 'Mengupload dokumen Visa untuk: ' . $targetSiswa->nama_lengkap);
    
        return back()
            ->with('success', 'Dokumen Visa berhasil diupload.')
            ->with('active_tab', 'admin-dokumen');
    }
}