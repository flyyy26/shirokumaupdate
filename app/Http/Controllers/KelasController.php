<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Company;
use App\Models\Guru;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\StudentStatus;
use Illuminate\Support\Facades\DB;
use App\Models\Absensi;
use Carbon\Carbon;

class KelasController extends Controller
{
    public function index()
    {
        $tanggal = request('tanggal') ?? Carbon::today()->toDateString();
    
        // Ambil ID status "karantina" dari tabel student_statuses
        $statusKarantina = \App\Models\StudentStatus::where('nama_status', 'like', '%karantina%')->first();
        
        $kelas = Kelas::with([
            'company',
            'job',
            'guru',
            'sesi' => function($q) {
                $q->orderBy('jam_mulai', 'asc');
            },
            'siswas' => function($q) use ($statusKarantina) {
                // Filter siswa yang berstatus karantina
                if ($statusKarantina) {
                    $q->where('student_status_id', $statusKarantina->id);
                }
            },
            'siswas.status'
        ])->latest()->get();
    
        $companies = Company::all();
        $gurus = Guru::all();
    
        // Ambil semua ID sesi yang sudah diabsen pada tanggal terpilih
        $absensiSesiIds = Absensi::where('tanggal', $tanggal)
            ->pluck('kelas_sesi_id')
            ->toArray();
    
        foreach ($kelas as $item) {
            foreach ($item->sesi as $sesi) {
                $sesi->sudah_absen = in_array($sesi->id, $absensiSesiIds);
            }
        }
    
        return view('karantina.index', compact(
            'kelas',
            'companies',
            'gurus',
            'tanggal'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required',
            'nama_kelas' => 'required',
            'periode_bulan' => 'required',
            'periode_tahun' => 'required',
            'guru_id' => 'required|exists:gurus,id',
            'company_id' => 'required|exists:companies,id',
            'job_id' => 'required|exists:jobs,id',
        ]);

        DB::beginTransaction();

        try {

            // 1️⃣ Buat kelas
            $kelas = Kelas::create($request->all());

            // 2️⃣ Ambil status karantina berdasarkan urutan (lebih aman)
            $statusKarantina = StudentStatus::orderBy('urutan','asc')->skip(2)->first();

            if ($statusKarantina) {

                // 3️⃣ Ambil siswa karantina yang ada di job ini
                $siswas = Siswa::where('student_status_id', $statusKarantina->id)
                    ->whereHas('jobs', function($q) use ($request) {
                        $q->where('jobs.id', $request->job_id);
                    })
                    ->get();

                // 4️⃣ Assign ke kelas
                foreach ($siswas as $siswa) {
                    $siswa->update([
                        'kelas_id' => $kelas->id
                    ]);
                }
            }

            DB::commit();

            return back()->with('success', 'Kelas berhasil dibuat & siswa otomatis dimasukkan');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    // API untuk ambil job berdasarkan perusahaan
    public function getJobs($company_id)
    {
        $jobs = Job::where('company_id',$company_id)->get();
        return response()->json($jobs);
    }
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);

        $kelas->delete();

        return back()->with('success', 'Kelas berhasil dihapus');
    }
    public function lulusKarantina($kelas_id, $siswa_id)
    {
        $siswa = Siswa::findOrFail($siswa_id);

        $statusBerangkat = StudentStatus::where('kode_status', 'berangkat')->first();

        if ($statusBerangkat) {
            $siswa->student_status_id = $statusBerangkat->id;
        }

        $siswa->kelas_id = null;
        $siswa->save();

        return back()->with('success', 'Siswa lulus karantina.');
    }
    public function tidakLulusKarantina($kelas_id, $siswa_id)
    {
        $siswa = Siswa::findOrFail($siswa_id);

        $statusInterview = StudentStatus::where('kode_status', 'interview')->first();

        if ($statusInterview) {
            $siswa->student_status_id = $statusInterview->id;
        }

        $siswa->kelas_id = null;
        $siswa->save();

        return back()->with('success', 'Siswa tidak lulus karantina.');
    }
}