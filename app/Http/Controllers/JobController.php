<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Siswa;
use App\Models\StudentStatus;
use App\Models\Kelas;
use App\Helpers\LogHelper;
use App\Models\InterviewLog;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'company_id'          => 'required|exists:companies,id',
            'jenis_pekerjaan'     => 'required|string|max:255',
            'jenis_ginou'         => 'nullable|string|max:255',
            'kuota'               => 'nullable|integer',
            'tanggal_interview'   => 'nullable|date',
            'gaji_pokok'          => 'nullable|numeric',
            'tipe_gaji'           => 'nullable|in:jam,bulan',
            'lembur'              => 'nullable|boolean',
            'estimasi_lembur_jam' => 'nullable|integer',
            'kontrak_tahun'       => 'nullable|integer',
            'lokasi_kerja'        => 'nullable|string|max:255',
            'fasilitas'           => 'nullable|string|max:255',
            'deskripsi'           => 'nullable|string',
            'status'              => 'nullable|in:Draft,Interview,Close',
        ]);

        Job::create([
            'company_id'          => $request->company_id,
            'jenis_pekerjaan'     => $request->jenis_pekerjaan,
            'jenis_ginou'         => $request->jenis_ginou,
            'kuota'               => $request->kuota,
            'tanggal_interview'   => $request->tanggal_interview,
            'gaji_pokok'          => $request->gaji_pokok,
            'tipe_gaji'           => $request->tipe_gaji ?? 'bulan',
            'lembur'              => $request->lembur ?? false,
            'estimasi_lembur_jam' => $request->estimasi_lembur_jam,
            'kontrak_tahun'       => $request->kontrak_tahun,
            'lokasi_kerja'        => $request->lokasi_kerja,
            'fasilitas'           => $request->fasilitas,
            'deskripsi'           => $request->deskripsi,
            'status'              => $request->status ?? 'Draft',
        ]);

        return back()->with('success', 'Job berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_pekerjaan'     => 'required|string|max:255',
            'jenis_ginou'         => 'nullable|string|max:255',
            'kuota'               => 'nullable|integer',
            'tanggal_interview'   => 'nullable|date',
            'gaji_pokok'          => 'nullable|numeric',
            'tipe_gaji'           => 'nullable|in:jam,bulan',
            'lembur'              => 'nullable|boolean',
            'estimasi_lembur_jam' => 'nullable|integer',
            'kontrak_tahun'       => 'nullable|integer',
            'lokasi_kerja'        => 'nullable|string|max:255',
            'fasilitas'           => 'nullable|string|max:255',
            'deskripsi'           => 'nullable|string',
            'status'              => 'nullable|in:Draft,Interview,Close',
        ]);

        $job = Job::findOrFail($id);
        $job->update([
            'jenis_pekerjaan'     => $request->jenis_pekerjaan,
            'jenis_ginou'         => $request->jenis_ginou,
            'kuota'               => $request->kuota,
            'tanggal_interview'   => $request->tanggal_interview,
            'gaji_pokok'          => $request->gaji_pokok,
            'tipe_gaji'           => $request->tipe_gaji ?? 'bulan',
            'lembur'              => $request->has('lembur'), // Checkbox handling
            'estimasi_lembur_jam' => $request->estimasi_lembur_jam,
            'kontrak_tahun'       => $request->kontrak_tahun,
            'lokasi_kerja'        => $request->lokasi_kerja,
            'fasilitas'           => $request->fasilitas,
            'deskripsi'           => $request->deskripsi,
            'status'              => $request->status,
        ]);

        return back()->with('success', 'Job berhasil diperbarui');
    }

    public function destroy($id)
    {
        Job::destroy($id);
        return back()->with('success', 'Job berhasil dihapus');
    }
    public function assignSiswa(Request $request, $job_id)
    {
        $job = Job::withCount('siswa')->findOrFail($job_id);
        $studentIds = $request->siswas ?? [];
    
        if (empty($studentIds)) {
            return back()->with('error', 'Pilih minimal 1 siswa.');
        }
    
        // Validasi Kuota
        if ($job->kuota !== null) {
            $remainingQuota = $job->kuota - $job->siswa_count;
    
            if (count($studentIds) > $remainingQuota) {
                return back()->with('error',
                    'Jumlah siswa yang dipilih (' . count($studentIds) .
                    ') melebihi sisa kuota (' . $remainingQuota . ').'
                );
            }
        }
    
        // Hitung urutan terakhir untuk job ini
        $lastUrutan = DB::table('job_siswa')
            ->where('job_id', $job->id)
            ->max('urutan');
    
        // Jika null (belum ada data), set ke 0
        $lastUrutan = $lastUrutan ?? 0;
    
        // Tambahkan siswa dengan urutan
        foreach ($studentIds as $index => $siswaId) {
            $exists = DB::table('job_siswa')
                ->where('job_id', $job->id)
                ->where('siswa_id', $siswaId)
                ->exists();
    
            if (!$exists) {
                DB::table('job_siswa')->insert([
                    'job_id' => $job->id,
                    'siswa_id' => $siswaId,
                    'urutan' => $lastUrutan + $index + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    
        // Catat ke log interview
        foreach ($studentIds as $id) {
            InterviewLog::updateOrCreate(
                ['siswa_id' => $id, 'job_id' => $job->id],
                [
                    'company_id' => $job->company_id,
                    'tanggal_interview' => $job->tanggal_interview,
                    'hasil' => null
                ]
            );
        }
    
        // Update status ke Interview
        $secondStatus = StudentStatus::orderBy('urutan', 'asc')
                            ->skip(1)
                            ->first();
    
        if ($secondStatus) {
            Siswa::whereIn('id', $studentIds)
                ->update(['student_status_id' => $secondStatus->id]);
        }
    
        // Cek apakah sudah ada kelas untuk job ini
        $kelas = Kelas::where('job_id', $job->id)->latest()->first();
    
        if ($kelas) {
            Siswa::whereIn('id', $studentIds)
                ->update(['kelas_id' => $kelas->id]);
        }
    
        return back()->with('success',
            'Siswa berhasil ditambahkan ke job, status diperbarui & otomatis masuk kelas jika tersedia.'
        );
    }

    // Tandai lulus → Karantina
    public function markPassed($job_id, $siswa_id)
    {
        $job = Job::find($job_id);
        $siswa = Siswa::find($siswa_id);
    
        if (!$job || !$siswa) {
            return back()->with('error', 'Job atau Siswa tidak ditemukan.');
        }
    
        // Pastikan siswa memang assigned ke job ini
        $exists = DB::table('job_siswa')
            ->where('job_id', $job->id)
            ->where('siswa_id', $siswa_id)
            ->exists();
    
        if (!$exists) {
            return back()->with('error', 'Siswa ini belum di-assign ke job.');
        }
    
        // Update status siswa menjadi status urutan ke-3
        $thirdStatus = \App\Models\StudentStatus::orderBy('urutan', 'asc')->skip(2)->first();
    
        if (!$thirdStatus) {
            return back()->with('error', 'Status urutan ke-3 belum diatur di pengaturan.');
        }
    
        $siswa->student_status_id = $thirdStatus->id;
    
        // Auto-assign ke Kelas
        $kelas = \App\Models\Kelas::where('job_id', $job_id)->latest()->first();
        if ($kelas) {
            $siswa->kelas_id = $kelas->id;
        }
    
        $siswa->save();
    
        // Update log interview menjadi Lulus
        InterviewLog::where('siswa_id', $siswa_id)
            ->where('job_id', $job_id)
            ->update(['hasil' => 'lulus']);
    
        return back()->with('success', 'Siswa berhasil lulus dan status diperbarui.');
    }

    // Tandai Gagal Interview -> Kembali ke status awal & Detach
    public function markFailed($job_id, $siswa_id)
    {
        $job = Job::findOrFail($job_id);
        
        // Hapus dari tabel pivot
        DB::table('job_siswa')
            ->where('job_id', $job->id)
            ->where('siswa_id', $siswa_id)
            ->delete();
    
        // Reorder siswa yang tersisa
        $this->reorderSiswa($job->id);
    
        // Update log interview menjadi Gagal
        InterviewLog::where('siswa_id', $siswa_id)
            ->where('job_id', $job_id)
            ->update(['hasil' => 'gagal']);
    
        // Kembalikan status siswa ke urutan ke-1
        $firstStatus = \App\Models\StudentStatus::orderBy('urutan', 'asc')->first();
        
        if ($firstStatus) {
            \App\Models\Siswa::where('id', $siswa_id)
                ->update(['student_status_id' => $firstStatus->id]);
        }
    
        return back()->with('success', 'Siswa ditandai gagal dan status dikembalikan ke awal.');
    }

    public function removeSiswa(Job $job, Siswa $siswa)
    {
        // Hapus dari tabel pivot
        DB::table('job_siswa')
            ->where('job_id', $job->id)
            ->where('siswa_id', $siswa->id)
            ->delete();
    
        // Reorder siswa yang tersisa
        $this->reorderSiswa($job->id);
    
        // Hapus dari log interview
        InterviewLog::where('siswa_id', $siswa->id)
            ->where('job_id', $job->id)
            ->delete();
    
        // Keluarkan dari kelas
        if ($siswa->kelas && $siswa->kelas->job_id == $job->id) {
            $siswa->kelas_id = null;
            $siswa->save();
        }
    
        return back()->with('success', 'Siswa berhasil dihapus dari job');
    }
    
    public function updateUrutan(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'siswa_id' => 'required|exists:siswas,id',
            'new_urutan' => 'required|integer|min:1'
        ]);
    
        try {
            DB::beginTransaction();
    
            // Ambil semua data pivot untuk job ini
            $pivots = DB::table('job_siswa')
                ->where('job_id', $request->job_id)
                ->orderBy('urutan')
                ->get();
    
            $currentPivot = $pivots->where('siswa_id', $request->siswa_id)->first();
            
            if (!$currentPivot) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa tidak ditemukan'
                ]);
            }
    
            $currentUrutan = $currentPivot->urutan;
            $targetUrutan = $request->new_urutan;
    
            // Validasi target
            if ($targetUrutan < 1 || $targetUrutan > $pivots->count()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Urutan tidak valid'
                ]);
            }
    
            if ($targetUrutan == $currentUrutan) {
                return response()->json(['success' => true]);
            }
    
            // Logika update urutan
            if ($targetUrutan > $currentUrutan) {
                // Geser ke bawah
                DB::table('job_siswa')
                    ->where('job_id', $request->job_id)
                    ->whereBetween('urutan', [$currentUrutan + 1, $targetUrutan])
                    ->decrement('urutan');
            } else {
                // Geser ke atas
                DB::table('job_siswa')
                    ->where('job_id', $request->job_id)
                    ->whereBetween('urutan', [$targetUrutan, $currentUrutan - 1])
                    ->increment('urutan');
            }
    
            // Update urutan siswa yang dipindah
            DB::table('job_siswa')
                ->where('job_id', $request->job_id)
                ->where('siswa_id', $request->siswa_id)
                ->update(['urutan' => $targetUrutan]);
    
            DB::commit();
    
            return response()->json(['success' => true]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating urutan: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    
    public function batchUpdateUrutan(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'urutan' => 'required|array',
        ]);
    
        try {
            DB::beginTransaction();
    
            foreach ($request->urutan as $siswaId => $newUrutan) {
                DB::table('job_siswa')
                    ->where('job_id', $request->job_id)
                    ->where('siswa_id', $siswaId)
                    ->update([
                        'urutan' => $newUrutan,
                        'updated_at' => now()
                    ]);
            }
    
            DB::commit();
            return response()->json(['success' => true]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    private function reorderSiswa($jobId)
    {
        // Ambil semua siswa di job ini, urutkan berdasarkan created_at atau id
        $siswas = DB::table('job_siswa')
            ->where('job_id', $jobId)
            ->orderBy('id', 'asc') // atau orderBy('created_at', 'asc')
            ->get();
    
        // Re-assign urutan berurutan (1,2,3,...)
        $urutan = 1;
        foreach ($siswas as $siswa) {
            DB::table('job_siswa')
                ->where('job_id', $jobId)
                ->where('siswa_id', $siswa->siswa_id)
                ->update(['urutan' => $urutan]);
            $urutan++;
        }
    }
    public function getSiswaList(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id'
        ]);
        
        // Ambil job dengan siswa - PASTIKAN URUTAN
        $job = Job::with(['siswa' => function($query) {
            // ORDER BY URUTAN ASC
            $query->orderBy('job_siswa.urutan', 'asc');
        }])->with('siswa.status')->findOrFail($request->job_id);
        
        // Log untuk debugging
        \Log::info('=== GET SISWA LIST ===');
        \Log::info('Job ID: ' . $job->id);
        foreach ($job->siswa as $index => $s) {
            \Log::info('  ' . ($index+1) . '. ' . $s->nama_lengkap . ' - Urutan: ' . $s->pivot->urutan);
        }
        
        $html = view('partials.siswa-list', compact('job'))->render();
        
        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $job->siswa->count()
        ]);
    }
    public function debugUrutan($job_id)
    {
        $job = Job::with(['siswa' => function($query) {
            $query->orderBy('job_siswa.urutan', 'asc');
        }])->findOrFail($job_id);
        
        $data = [];
        foreach ($job->siswa as $siswa) {
            $data[] = [
                'id' => $siswa->id,
                'nama' => $siswa->nama_lengkap,
                'urutan' => $siswa->pivot->urutan
            ];
        }
        
        return response()->json($data);
}
}