<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\RiwayatPekerjaanController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\KartuKeluargaController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\UserLogController;
use App\Http\Controllers\Admin\AdminBillingController;
use App\Http\Controllers\SiswaBillingController;
use App\Http\Controllers\StudentStatusController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KelasSesiController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\RekapAbsensiController;
use App\Http\Controllers\SiswaInterviewController;
use App\Http\Controllers\SiswaKarantinaController;
use App\Http\Controllers\Siswa\IzinKeluarController;
use App\Http\Controllers\Siswa\JikoPiaruController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PertemuanController;
use App\Http\Controllers\KeberangkatanController;
use App\Http\Controllers\Siswa\KeberangkatanSiswaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GalleryCategoryController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Customer\CustomerFaqController;
use App\Http\Controllers\Admin\JobVacancyController;
use App\Http\Controllers\Customer\JobVacancyController as CustomerJobController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\SitemapController;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/sitemap-index.xml', [SitemapController::class, 'indexSitemap'])->name('sitemap.index');

Route::get('/register',[AuthController::class,'showRegister'])->name('register');
Route::post('/register',[AuthController::class,'register']);

Route::get('/download-formulir', [DownloadController::class, 'index'])->name('download.formulir');
Route::get('/download-formulir/{file}', [DownloadController::class, 'download'])->name('download.formulir.file');

// ============================================
// 🟢 HALAMAN FRONTEND
// ============================================


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jp', [HomeController::class, 'indexJP'])->name('home-jp');

Route::get('/tentang-kami', function () {
    return view('about');
})->name('about');
Route::get('/jp/tentang-kami', function () {
    return view('about-jp');
})->name('about-jp');

Route::get('/legalitas', function () {
    return view('legalitas');
})->name('legalitas');
Route::get('/jp/legalitas', function () {
    return view('legalitas-jp');
})->name('legalitas-jp');

Route::get('/engineering', function () {
    return view('engineering');
})->name('engineering');
Route::get('/jp/engineering', function () {
    return view('engineering-jp');
})->name('engineering-jp');

Route::get('/ginoujisshusei', function () {
    return view('ginoujisshusei');
})->name('ginoujisshusei');
Route::get('/jp/ginoujisshusei', function () {
    return view('ginoujisshusei-jp');
})->name('ginoujisshusei-jp');

Route::get('/tg', function () {
    return view('tg');
})->name('tg');
Route::get('/jp/tg', function () {
    return view('tg-jp');
})->name('tg-jp');

Route::get('/kaigo', function () {
    return view('kaigo');
})->name('kaigo');
Route::get('/jp/kaigo', function () {
    return view('kaigo-jp');
})->name('kaigo-jp');

Route::get('/nihongo-gakkou', function () {
    return view('nihongo-gakkou');
})->name('nihongo-gakkou');
Route::get('/jp/nihongo-gakkou', function () {
    return view('nihongo-gakkou-jp');
})->name('nihongo-gakkou-jp');

Route::get('/pertanyaan-umum', [CustomerFaqController::class, 'index'])->name('pertanyaan-umum.index');
Route::get('/jp/pertanyaan-umum', [CustomerFaqController::class, 'indexJP'])->name('pertanyaan-umum.indexJP');
Route::get('/pertanyaan-umum/search', [CustomerFaqController::class, 'search'])->name('pertanyaan-umum.search');

Route::get('/lowongan-kerja', [CustomerJobController::class, 'index'])->name('customer.job-vacancy');
Route::get('/jp/lowongan-kerja', [CustomerJobController::class, 'indexJP'])->name('customer.job-vacancy-jp');
Route::get('/lowongan-kerja/{job:slug}', [CustomerJobController::class, 'show'])->name('customer.job-vacancy.show');

Route::get('/kontak', function () {
    return view('contact');
})->name('contact');
Route::get('/jp/kontak', function () {
    return view('contact-jp');
})->name('contact-jp');

// 🔥 TAMBAHKAN ROUTE POST UNTUK KIRIM PESAN
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');

use App\Http\Controllers\GalleryFrontController;

Route::get('/galeri', [GalleryFrontController::class, 'index'])->name('gallery');
Route::get('/jp/galeri', [GalleryFrontController::class, 'indexJP'])->name('gallery-jp');

Route::get('/syarat-ketentuan', function () {
    return view('syarat-ketentuan');
})->name('syarat-ketentuan');
Route::get('/jp/syarat-ketentuan', function () {
    return view('syarat-ketentuan-jp');
})->name('syarat-ketentuan-jp');

Route::get('/kebijakan-privasi', function () {
    return view('kebijakan-privasi');
})->name('kebijakan-privasi');
Route::get('/jp/kebijakan-privasi', function () {
    return view('kebijakan-privasi-jp');
})->name('kebijakan-privasi-jp');

// ============================================
// AUTH ROUTES
// ============================================

Route::get('/login',[AuthController::class,'showLogin'])->name('login');
Route::post('/login',[AuthController::class,'login']);

// ============================================
// AUTHENTICATED ROUTES
// ============================================

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::resource('guru', GuruController::class);
        Route::resource('siswa', SiswaController::class);
        Route::post('/siswa/{siswa}/login-as', [AuthController::class, 'loginAsSiswa'])->name('siswa.login-as');
        Route::get('/siswa/{siswa}/cetak-cv', [SiswaController::class, 'printCv'])->name('siswa.print-cv');
        Route::resource('tagihan', AdminBillingController::class);
        Route::put('/tagihan/{tagihan}/verify', [AdminBillingController::class, 'verify'])
            ->name('tagihan.verify');
            
        // Pendaftaran Admin Routes
        Route::get('/admin/pendaftaran', [PendaftaranController::class, 'index'])->name('admin.pendaftaran.index');
        Route::get('/admin/pendaftaran/{pendaftaran}', [PendaftaranController::class, 'show'])->name('admin.pendaftaran.show');
        Route::delete('/admin/pendaftaran/{pendaftaran}', [PendaftaranController::class, 'destroy'])->name('admin.pendaftaran.destroy');

        // Pertemuan Admin Routes
        Route::get('/admin/pertemuan', [PertemuanController::class, 'index'])->name('admin.pertemuan.index');
        Route::get('/admin/pertemuan/{pertemuan}', [PertemuanController::class, 'show'])->name('admin.pertemuan.show');
        Route::delete('/admin/pertemuan/{pertemuan}', [PertemuanController::class, 'destroy'])->name('admin.pertemuan.destroy');
    });

    Route::put('/update-my-biodata', [SiswaController::class, 'updateBiodataSiswa'])
        ->name('siswa.updateMyBiodata');

    // Route untuk kembali ke Admin (Impersonation)
    Route::get('/back-to-admin', [AuthController::class, 'backToAdmin'])->name('back-to-admin');

    Route::get('/biodata', [BiodataController::class, 'index'])
        ->name('biodata.index');

    Route::put('/biodata', [BiodataController::class, 'update'])
        ->name('biodata.update');

    Route::get('/biodata/cetak-cv', [BiodataController::class, 'printCv'])
        ->name('biodata.print');
        
    Route::get('/keberangkatan-saya', [KeberangkatanSiswaController::class, 'index'])
        ->name('siswa.keberangkatan-saya');

    Route::resource('keluarga', KeluargaController::class)->except(['index','create','show']);

    Route::resource('pendidikan', PendidikanController::class)
    ->only(['store','update','destroy', 'index']);

    Route::resource('riwayat-pekerjaan', RiwayatPekerjaanController::class)
    ->only(['store','update','destroy']);

    Route::resource('sertifikat', SertifikatController::class)
    ->only(['store','update','destroy']);

    Route::post('/upload-akte', [SiswaController::class,'uploadAkte'])->name('upload.akte');
    Route::post('/upload-ktp', [SiswaController::class,'uploadKtp'])->name('upload.ktp');
    Route::post('/upload-paspor', [SiswaController::class,'uploadPaspor'])->name('upload.paspor');
    Route::post('/upload-mcu', [SiswaController::class,'uploadMcu'])->name('upload.mcu');
    Route::post('/upload-coe',[SiswaController::class,'uploadCoe'])->name('upload.coe');
    Route::post('/upload-visa',[SiswaController::class,'uploadVisa'])->name('upload.visa');

    Route::get('/kartu-keluarga', [KartuKeluargaController::class, 'index'])
        ->name('kartu-keluarga.index');
    Route::post('/kartu-keluarga', [KartuKeluargaController::class, 'store'])
    ->name('kartu-keluarga.store');
    Route::put('/kartu-keluarga', [KartuKeluargaController::class, 'update'])
    ->name('kartu-keluarga.update');

    Route::get('/pembayaran', [SiswaBillingController::class, 'index'])
        ->name('pembayaran.index');
    Route::post('/pembayaran/{id}', [SiswaBillingController::class, 'pay'])
        ->name('pembayaran.pay');
    Route::get('/pembayaran/{id}/print', [SiswaBillingController::class, 'print'])
        ->name('pembayaran.print');

    Route::get('/logs', [UserLogController::class, 'index'])
    ->name('admin.logs');

    Route::prefix('pengaturan')->group(function () {
        Route::get('/alur-siswa', [StudentStatusController::class, 'index'])->name('alur.index');
        Route::post('/alur-siswa', [StudentStatusController::class, 'store'])->name('alur.store');
        Route::put('/alur-siswa/{id}', [StudentStatusController::class, 'update'])->name('alur.update');
        Route::delete('/alur-siswa/{id}', [StudentStatusController::class, 'destroy'])->name('alur.destroy');
        Route::post('/alur-siswa/update-order', [StudentStatusController::class, 'updateOrder'])->name('alur.updateOrder');
    });

    Route::resource('perusahaan', CompanyController::class);
    Route::post('/job/store', [JobController::class,'store'])->name('job.store');
    Route::delete('/job/{id}', [JobController::class,'destroy'])->name('job.destroy');
    Route::post('job/{job}/assign-siswa', [JobController::class, 'assignSiswa'])->name('job.assign-siswa');
    Route::post('job/{job}/mark-passed/{siswa}', [JobController::class, 'markPassed'])->name('job.mark-passed');
    Route::post('job/{job}/mark-failed/{siswa}', [JobController::class, 'markFailed'])->name('job.mark-failed');
    Route::delete('/job/{job}/siswa/{siswa}', [JobController::class, 'removeSiswa'])
    ->name('job.remove-siswa');
    Route::put('/job/{id}', [JobController::class, 'update'])->name('job.update');

    Route::get('/karantina', [KelasController::class,'index'])->name('kelas.index');
    Route::post('/karantina/store', [KelasController::class,'store'])->name('kelas.store');
    Route::delete('/karantina/{id}', [KelasController::class, 'destroy'])
    ->name('kelas.destroy');
    Route::get('/get-jobs/{company}', [KelasController::class,'getJobs']);
    Route::post('/kelas/{kelas}/siswa/{siswa}/tidak-lulus',
        [KelasController::class, 'tidakLulusKarantina']
    )->name('kelas.tidak-lulus-karantina');
    Route::post('/kelas/{kelas}/siswa/{siswa}/lulus',
        [KelasController::class, 'lulusKarantina']
    )->name('kelas.lulus-karantina');
    Route::get('/karantina-siswa', [App\Http\Controllers\SiswaKarantinaController::class, 'index'])->name('siswa.karantina');

    Route::post('/kelas/{kelas}/sesi', 
        [KelasSesiController::class, 'store']
    )->name('kelas.sesi.store');

    Route::get('/kelas/{kelas}/absensi/{sesi}', 
        [AbsensiController::class, 'index']
    )->name('kelas.absensi');

    Route::post('/kelas/{kelas}/absensi/{sesi}', 
        [AbsensiController::class, 'store']
    )->name('kelas.absensi.store');

    Route::get('/kelas/{kelas}/rekap', 
        [AbsensiController::class, 'rekap']
    )->name('kelas.rekap');
    Route::delete('/kelas/sesi/{id}', [KelasSesiController::class, 'destroy'])
    ->name('kelas.sesi.destroy');

    Route::get('/rekap-absensi', [RekapAbsensiController::class, 'index'])
    ->name('rekap.absensi');

    Route::get('/interview', 
        [SiswaInterviewController::class, 'index']
    )->name('siswa.interview');

    Route::get('/izin-keluar', [IzinKeluarController::class,'index'])
        ->name('siswa.izin.index');

    Route::post('/izin-keluar', [IzinKeluarController::class,'store'])
        ->name('siswa.izin.store');

    Route::get('/izin-keluar/{id}/print', [IzinKeluarController::class,'print'])->name('siswa.izin.print');

    Route::get('/admin/izin-keluar',
        [IzinKeluarController::class,'indexAdmin'])
        ->name('admin.izin.index');

    Route::get('/biodata/print-jepang', [BiodataController::class, 'printCvJepang'])->name('biodata.print_jepang');

    Route::post('/jiko-piaru/update', [JikoPiaruController::class, 'update'])->name('jiko-piaru.update');
    Route::get('/jiko-piaru/get/{siswaId?}', [JikoPiaruController::class, 'get'])->name('jiko-piaru.get');

    Route::get('/settings', [AuthController::class, 'showSettings'])->name('settings.show');
    Route::put('/settings', [AuthController::class, 'updateSettings'])->name('settings.update');
    
    Route::get('/keberangkatan', [KeberangkatanController::class,'index'])
        ->name('keberangkatan.index');

    Route::get('/keberangkatan/{id}/create', [KeberangkatanController::class,'create'])
        ->name('keberangkatan.create');

    Route::post('/keberangkatan/store', [KeberangkatanController::class,'store'])
        ->name('keberangkatan.store');
        
    Route::put('/keberangkatan/{id}/update', [KeberangkatanController::class,'update'])
        ->name('keberangkatan.update');
        
    Route::get('/siswa/keberangkatan', [SiswaController::class, 'keberangkatan'])
    ->name('siswa.keberangkatan');
    
    Route::post('/job/update-urutan', [JobController::class, 'updateUrutan'])->name('job.update-urutan');
    Route::post('/job/batch-update-urutan', [JobController::class, 'batchUpdateUrutan'])->name('job.batch-update-urutan');
    Route::get('/job/get-siswa-list', [JobController::class, 'getSiswaList'])->name('job.get-siswa-list');
    Route::get('/job/debug-urutan/{job_id}', [JobController::class, 'debugUrutan'])->name('job.debug-urutan');

    Route::get('/gallery', [GalleryController::class, 'index'])->name('admin.gallery.index');
    Route::get('/gallery/load-more', [GalleryController::class, 'loadMore'])->name('admin.gallery.load-more');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('admin.gallery.store');
    Route::put('/gallery/{gallery}', [GalleryController::class, 'update'])->name('admin.gallery.update');
    Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');
    Route::post('/gallery/update-order', [GalleryController::class, 'updateOrder'])->name('admin.gallery.update-order');
    Route::post('/gallery/{gallery}/toggle-active', [GalleryController::class, 'toggleActive'])->name('admin.gallery.toggle-active');
    Route::post('/gallery/video', [GalleryController::class, 'storeVideo'])->name('admin.gallery.video.store');
    Route::put('/gallery/video/{gallery}', [GalleryController::class, 'updateVideo'])->name('admin.gallery.video.update');

    // Gallery Category Routes
    Route::get('/gallery/categories', [GalleryCategoryController::class, 'index'])->name('admin.gallery.categories');
    Route::post('/gallery/categories', [GalleryCategoryController::class, 'store'])->name('admin.gallery.categories.store');
    Route::put('/gallery/categories/{category}', [GalleryCategoryController::class, 'update'])->name('admin.gallery.categories.update');
    Route::delete('/gallery/categories/{category}', [GalleryCategoryController::class, 'destroy'])->name('admin.gallery.categories.destroy');
    Route::post('/gallery/categories/update-order', [GalleryCategoryController::class, 'updateOrder'])->name('admin.gallery.categories.update-order');
    Route::post('/gallery/categories/{category}/toggle-active', [GalleryCategoryController::class, 'toggleActive'])->name('admin.gallery.categories.toggle-active');

    Route::prefix('faq')->group(function () {
        Route::get('/', [FaqController::class, 'index'])->name('admin.faq.index');
        Route::get('/load-more', [FaqController::class, 'loadMore'])->name('admin.faq.load-more');
        Route::post('/', [FaqController::class, 'store'])->name('admin.faq.store');
        Route::put('/{faq}', [FaqController::class, 'update'])->name('admin.faq.update');
        Route::delete('/{faq}', [FaqController::class, 'destroy'])->name('admin.faq.destroy');
        Route::post('/update-order', [FaqController::class, 'updateOrder'])->name('admin.faq.update-order');
        Route::post('/{faq}/toggle-active', [FaqController::class, 'toggleActive'])->name('admin.faq.toggle-active');

        // FAQ Category Routes
        Route::prefix('categories')->group(function () {
            Route::get('/', [FaqCategoryController::class, 'index'])->name('admin.faq.categories');
            Route::post('/', [FaqCategoryController::class, 'store'])->name('admin.faq.categories.store');
            Route::put('/{category}', [FaqCategoryController::class, 'update'])->name('admin.faq.categories.update');
            Route::delete('/{category}', [FaqCategoryController::class, 'destroy'])->name('admin.faq.categories.destroy');
            Route::post('/update-order', [FaqCategoryController::class, 'updateOrder'])->name('admin.faq.categories.update-order');
            Route::post('/{category}/toggle-active', [FaqCategoryController::class, 'toggleActive'])->name('admin.faq.categories.toggle-active');
        });
    });

    Route::prefix('job-vacancy')->group(function () {
        Route::get('/', [JobVacancyController::class, 'index'])->name('admin.job-vacancy.index');
        Route::post('/', [JobVacancyController::class, 'store'])->name('admin.job-vacancy.store');
        Route::put('/{job}', [JobVacancyController::class, 'update'])->name('admin.job-vacancy.update');
        Route::delete('/{job}', [JobVacancyController::class, 'destroy'])->name('admin.job-vacancy.destroy');
        Route::post('/update-order', [JobVacancyController::class, 'updateOrder'])->name('admin.job-vacancy.update-order');
        Route::post('/{job}/toggle-active', [JobVacancyController::class, 'toggleActive'])->name('admin.job-vacancy.toggle-active');
        Route::post('/{job}/toggle-featured', [JobVacancyController::class, 'toggleFeatured'])->name('admin.job-vacancy.toggle-featured');
    });

    Route::prefix('inbox')->group(function () {
        Route::get('/', [AdminContactController::class, 'index'])->name('admin.contact.index');
        Route::get('/load-more', [AdminContactController::class, 'loadMore'])->name('admin.contact.load-more');
        Route::get('/{contact}', [AdminContactController::class, 'show'])->name('admin.contact.show');
        Route::delete('/{contact}', [AdminContactController::class, 'destroy'])->name('admin.contact.destroy');
        Route::post('/{contact}/mark-read', [AdminContactController::class, 'markAsRead'])->name('admin.contact.mark-read');
        Route::post('/{contact}/mark-replied', [AdminContactController::class, 'markAsReplied'])->name('admin.contact.mark-replied');
        Route::post('/bulk-delete', [AdminContactController::class, 'bulkDelete'])->name('admin.contact.bulk-delete');
    });
});

// ============================================
// API WILAYAH
// ============================================

Route::prefix('wilayah')->group(function () {
    Route::get('/provinces', [WilayahController::class, 'provinces']);
    Route::get('/regencies/{province}', [WilayahController::class, 'regencies']);
    Route::get('/districts/{regency}', [WilayahController::class, 'districts']);
    Route::get('/villages/{district}', [WilayahController::class, 'villages']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::post('/logout',[AuthController::class,'logout']);

Route::get('/test-email', function () {
    Mail::raw('Test Email Laravel', function ($message) {
        $message->to('mraflyyy26@gmail.com')
                ->subject('Test Email');
    });

    return "Email terkirim";
});

// ============================================
// PENDAFTARAN & PERTEMUAN (PUBLIC)
// ============================================

Route::get('/daftar', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/daftar', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/pertemuan', [PertemuanController::class,'create'])->name('pertemuan.create');
Route::post('/pertemuan', [PertemuanController::class,'store'])->name('pertemuan.store');