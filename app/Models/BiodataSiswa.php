<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BiodataSiswa extends Model
{
    protected $table = 'biodata_siswa';

    protected $fillable = [
        'siswa_id',
        'level_bahasa_jepang',
        'rencana_lama_di_jepang',
        'periode_mulai',
        'nik',
        'nomor_paspor',
        'wilayah_alamat',
        'tinggi_badan',
        'berat_badan',
        'tangan_dominan',
        'golongan_darah',
        'buta_warna',
        'alergi',
        'merokok',
        'peminum_alkohol',
        'tatto',
        'gigi_berlubang',
        'patah_tulang',
        'ukuran_sepatu',
        'ukuran_pinggang',
        'riwayat_penyakit',
        'kacamata',
        'kondisi_mata_kiri',
        'kondisi_mata_kanan',
        'status_perkawinan',
        'jumlah_anak',
        'keunggulan_diri',
        'kekurangan_diri',
        'dokumen',
        'hobi',
        'tanggal_pembuatan_paspor',
        'tanggal_paspor_dikeluarkan',
        'status_siswa_sebelumnya',
        'nama_lpk', // ✅ Tambahkan ini
    ];

    protected $casts = [
        'hobi' => 'array',
        'tanggal_pembuatan_paspor' => 'date',
        'tanggal_paspor_dikeluarkan' => 'date',
    ];

    /**
     * Relasi ke siswa
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}