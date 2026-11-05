<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'jenis_pekerjaan',
        'jenis_ginou',
        'kuota',
        'tanggal_interview',
        'gaji_pokok',
        'tipe_gaji',
        'lembur',
        'estimasi_lembur_jam',
        'kontrak_tahun',
        'lokasi_kerja',
        'fasilitas',
        'deskripsi',
        'status',
    ];

    /**
     * Casts untuk tipe data spesifik
     */
    protected $casts = [
        'tanggal_interview' => 'date',
        'lembur' => 'boolean',
        'gaji_pokok' => 'decimal:2',
    ];

    /**
     * Relasi: job hanya milik satu perusahaan
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'job_siswa')
                    ->withPivot('urutan') // Wajib agar kolom bisa diakses
                    ->withTimestamps()
                    ->orderByPivot('urutan', 'asc'); // Ini kunci utamanya
    }
    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }
    protected static function booted()
    {
        static::deleting(function ($job) {

            // Ambil semua siswa di job ini
            $siswas = $job->siswa;

            foreach ($siswas as $siswa) {
                $siswa->kelas_id = null;
                $siswa->save();
            }

            // Hapus relasi pivot
            $job->siswa()->detach();

            // Optional: hapus kelas yang terkait
            $job->kelas()->delete();
        });
    }
}