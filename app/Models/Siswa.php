<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Siswa extends Model
{
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nama_panggilan',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'foto',
        'no_hp',
        'dokumen_akte',
        'dokumen_ktp',

        // PASPOR
        'nomor_paspor',
        'tanggal_pembuatan_paspor',
        'tanggal_keluar_paspor',
        'dokumen_paspor',
        'mcu',
        'student_status_id',

        'kelas_id',
        'nama_lengkap_katakana',
        'nama_panggilan_katakana',
        
        // COE
        'dokumen_coe',
        'nomor_coe',
        'tanggal_coe',
        
        // VISA
        'dokumen_visa',
        'nomor_visa',
        'tanggal_visa',
        'masa_berlaku_visa',
    ];

    protected $casts = [
        'tanggal_pembuatan_paspor' => 'date',
        'tanggal_keluar_paspor' => 'date',
    ];

    // 🔥 Hitung usia otomatis
    public function getUsiaAttribute()
    {
        $lahir = Carbon::parse($this->tanggal_lahir);
        $sekarang = Carbon::now();

        $tahun = $sekarang->diffInYears($lahir);
        $bulan = $sekarang->copy()->subYears($tahun)->diffInMonths($lahir);
        $hari  = $sekarang->copy()->subYears($tahun)->subMonths($bulan)->diffInDays($lahir);

        return "{$tahun} tahun {$bulan} bulan {$hari} hari";
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function biodata()
    {
        return $this->hasOne(BiodataSiswa::class);
    }
    public function keluargas()
    {
        return $this->hasMany(Keluarga::class);
    }
    public function pendidikans()
    {
        return $this->hasMany(Pendidikan::class);
    }
    public function riwayatPekerjaans()
    {
        return $this->hasMany(RiwayatPekerjaan::class);
    }
    public function sertifikats()
    {
        return $this->hasMany(Sertifikat::class);
    }
    public function kartuKeluarga()
    {
        return $this->hasOne(KartuKeluarga::class);
    }
    public function status()
    {
        return $this->belongsTo(StudentStatus::class, 'student_status_id');
    }
    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_siswa')->withTimestamps();
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function interviews()
    {
        return $this->belongsToMany(Interview::class)
                    ->withPivot('hasil')
                    ->withTimestamps();
    }
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
    public function interviewLogs()
    {
        return $this->hasMany(InterviewLog::class);
    }
    public function izinKeluars()
    {
        return $this->hasMany(IzinKeluar::class);
    }
    public function jikoPiaru()
    {
        return $this->hasOne(JikoPiaru::class);
    }
    public function billings()
    {
        return $this->hasMany(Billing::class);
    }
    public function keberangkatan()
    {
        return $this->hasOne(Keberangkatan::class);
    }
}