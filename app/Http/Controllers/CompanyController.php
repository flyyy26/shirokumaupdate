<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Job;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->get();
        return view('companies.index', compact('companies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'nama_pic'        => 'nullable|string|max:255',
            'nama_pic_jepang' => 'nullable|string|max:255',
            'jabatan_pic'     => 'nullable|string|max:255',
            'no_hp_pic'       => 'nullable|string|max:20',
            'email_pic'       => 'nullable|email|max:255',
            'logo'            => 'nullable|image|max:2048',
            'bidang_usaha'    => 'nullable|array',
        ]);

        $companyData = [
            'nama_perusahaan' => $request->nama_perusahaan,
            'nama_jepang'     => $request->nama_jepang,
            'prefektur'       => $request->prefektur,
            'alamat'          => $request->alamat,
            'nama_pic'        => $request->nama_pic,
            'nama_pic_jepang' => $request->nama_pic_jepang,
            'jabatan_pic'     => $request->jabatan_pic,
            'no_hp_pic'       => $request->no_hp_pic,
            'email_pic'       => $request->email_pic,
            'website'         => $request->website,
            'bidang_usaha'    => $request->bidang_usaha,
        ];

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('logos', $filename, 'public');
            $companyData['logo'] = $path;
        }

        Company::create($companyData);

        return redirect()->route('perusahaan.index')
            ->with('success', 'Perusahaan berhasil ditambahkan');
    }

    public function show($id)
    {
        // Ambil company
        $company = Company::findOrFail($id);
        
        // Ambil jobs dengan siswa yang diurutkan - PAKAI JOIN LANGSUNG
        $jobs = Job::where('company_id', $id)
            ->with(['siswa' => function($query) {
                // Menggunakan orderByPivot lebih akurat untuk tabel many-to-many
                $query->orderByPivot('urutan', 'asc'); 
            }])
            ->with('siswa.status')
            ->get();
        
        // Assign ke company
        $company->jobs = $jobs;
        
        // DEBUG - Tampilkan di log
        \Log::info('=== COMPANY SHOW ===');
        \Log::info('Company ID: ' . $id);
        foreach ($jobs as $job) {
            \Log::info('Job: ' . $job->id . ' - ' . $job->jenis_pekerjaan);
            foreach ($job->siswa as $siswa) {
                \Log::info('  Siswa: ' . $siswa->nama_lengkap . ' - Urutan: ' . $siswa->pivot->urutan);
            }
        }
    
        // Ambil status "kandidat"
        $firstStatus = \App\Models\StudentStatus::orderBy('urutan', 'asc')->first();
    
        // Ambil siswa yang belum punya job dan berstatus kandidat
        $all_siswa = \App\Models\Siswa::whereDoesntHave('jobs')
            ->where('student_status_id', $firstStatus?->id)
            ->with('status:id,nama_status,kode_status')
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap', 'student_status_id', 'foto']);
    
        return view('companies.show', compact('company', 'all_siswa'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $data = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'nama_pic'        => 'nullable|string|max:255',
            'nama_pic_jepang' => 'nullable|string|max:255',
            'jabatan_pic'     => 'nullable|string|max:255',
            'no_hp_pic'       => 'nullable|string|max:20',
            'email_pic'       => 'nullable|email|max:255',
            'logo'            => 'nullable|image|max:2048',
            'bidang_usaha'    => 'nullable|array',
        ]);

        $company->update([
            'nama_perusahaan' => $request->nama_perusahaan,
            'nama_jepang'     => $request->nama_jepang,
            'prefektur'       => $request->prefektur,
            'alamat'          => $request->alamat,
            'nama_pic'        => $request->nama_pic,
            'nama_pic_jepang' => $request->nama_pic_jepang,
            'jabatan_pic'     => $request->jabatan_pic,
            'no_hp_pic'       => $request->no_hp_pic,
            'email_pic'       => $request->email_pic,
            'website'         => $request->website,
            'bidang_usaha'    => $request->bidang_usaha,
        ]);

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada untuk menghemat storage
            if ($company->logo && \Storage::disk('public')->exists($company->logo)) {
                \Storage::disk('public')->delete($company->logo);
            }

            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('logos', $filename, 'public');
            $company->logo = $path;
            $company->save();
        }

        return redirect()->route('perusahaan.index')
            ->with('success', 'Perusahaan berhasil diperbarui');
    }

    public function destroy($id)
    {
        Company::destroy($id);

        return redirect()->route('perusahaan.index')
            ->with('success', 'Perusahaan berhasil dihapus');
    }
}