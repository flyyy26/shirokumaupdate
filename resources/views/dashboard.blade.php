@extends('layouts.app')

@section('content')

@php
    $role = auth()->user()->role;
    $user = auth()->user();
@endphp

@if($role === 'admin')
    {{-- Fallback Data Fetching jika Controller belum diupdate --}}
    @php
        if(!isset($totalSiswa)) {
            $totalSiswa = \App\Models\Siswa::count();
            $totalGuru = \App\Models\Guru::count();
            $totalKelas = \App\Models\Kelas::count();
            $totalPerusahaan = \App\Models\Company::count();
            
            $tagihanBelumBayar = \App\Models\Billing::where('status', 'belum_bayar')->count();
            $totalUangPending = \App\Models\Billing::where('status', 'belum_bayar')->sum('nominal');
            $tagihanMenungguVerifikasi = \App\Models\Billing::where('status', 'menunggu_verifikasi')->count();
            $tagihanLunasBulanIni = \App\Models\Billing::where('status', 'lunas')->whereMonth('updated_at', now()->month)->sum('nominal');

            $statusStats = \App\Models\Siswa::select('student_statuses.nama_status', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->join('student_statuses', 'siswas.student_status_id', '=', 'student_statuses.id')
                ->groupBy('student_statuses.nama_status')
                ->get();
            $statusLabels = $statusStats->pluck('nama_status');
            $statusData = $statusStats->pluck('total');

            $recentLogs = \App\Models\UserLog::with('user')->latest()->take(6)->get();
            $latestSiswa = \App\Models\Siswa::with('status')->latest()->take(5)->get();
        }
    @endphp

<div class="space-y-6 p-4 md:p-0">
    <!-- Welcome Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Dashboard Admin</h1>
            <p class="text-slate-400 text-sm">Ringkasan data dan aktivitas sistem akademik</p>
        </div>
        <div class="text-right hidden md:block">
            <p class="text-white font-medium">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Siswa -->
        <div class="bg-slate-800 p-5 rounded-2xl shadow-lg border border-slate-700 hover:border-blue-500/50 transition-all group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wider">Total Siswa</p>
                    <h3 class="text-2xl font-bold text-white mt-1">{{ $totalSiswa }}</h3>
                </div>
                <div class="p-2 bg-blue-500/10 rounded-lg group-hover:bg-blue-500/20 transition-colors">
                    <iconify-icon icon="mdi:account-group" width="24" height="24" class="text-blue-400"></iconify-icon>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-slate-400">
                <span class="text-blue-400 font-medium flex items-center gap-1">
                    <iconify-icon icon="mdi:plus" width="12"></iconify-icon> {{ $latestSiswa->count() }}
                </span>
                <span class="ml-1">baru ditambahkan</span>
            </div>
        </div>

        <!-- Total Guru -->
        <div class="bg-slate-800 p-5 rounded-2xl shadow-lg border border-slate-700 hover:border-purple-500/50 transition-all group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wider">Total Guru</p>
                    <h3 class="text-2xl font-bold text-white mt-1">{{ $totalGuru }}</h3>
                </div>
                <div class="p-2 bg-purple-500/10 rounded-lg group-hover:bg-purple-500/20 transition-colors">
                    <iconify-icon icon="mdi:teach" width="24" height="24" class="text-purple-400"></iconify-icon>
                </div>
            </div>
            <div class="mt-4 text-xs text-slate-400">
                Pengajar aktif
            </div>
        </div>

        <!-- Total Kelas -->
        <div class="bg-slate-800 p-5 rounded-2xl shadow-lg border border-slate-700 hover:border-emerald-500/50 transition-all group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wider">Kelas Karantina</p>
                    <h3 class="text-2xl font-bold text-white mt-1">{{ $totalKelas }}</h3>
                </div>
                <div class="p-2 bg-emerald-500/10 rounded-lg group-hover:bg-emerald-500/20 transition-colors">
                    <iconify-icon icon="mdi:google-classroom" width="24" height="24" class="text-emerald-400"></iconify-icon>
                </div>
            </div>
            <div class="mt-4 text-xs text-slate-400">
                Kelas aktif berjalan
            </div>
        </div>

        <!-- Total Perusahaan -->
        <div class="bg-slate-800 p-5 rounded-2xl shadow-lg border border-slate-700 hover:border-orange-500/50 transition-all group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wider">Mitra Perusahaan</p>
                    <h3 class="text-2xl font-bold text-white mt-1">{{ $totalPerusahaan }}</h3>
                </div>
                <div class="p-2 bg-orange-500/10 rounded-lg group-hover:bg-orange-500/20 transition-colors">
                    <iconify-icon icon="mdi:office-building" width="24" height="24" class="text-orange-400"></iconify-icon>
                </div>
            </div>
            <div class="mt-4 text-xs text-slate-400">
                Mitra kerja sama
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Keuangan & Chart -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Financial Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-red-900/40 to-slate-800 p-4 rounded-xl border border-red-500/20">
                    <p class="text-red-400 text-xs font-medium mb-1">Tagihan Belum Lunas</p>
                    <h4 class="text-xl font-bold text-white">{{ $tagihanBelumBayar }} <span class="text-xs font-normal text-slate-400">Siswa</span></h4>
                    <p class="text-xs text-slate-400 mt-1">Total: Rp {{ number_format($totalUangPending, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gradient-to-br from-yellow-900/40 to-slate-800 p-4 rounded-xl border border-yellow-500/20">
                    <p class="text-yellow-400 text-xs font-medium mb-1">Menunggu Verifikasi</p>
                    <h4 class="text-xl font-bold text-white">{{ $tagihanMenungguVerifikasi }} <span class="text-xs font-normal text-slate-400">Transaksi</span></h4>
                    <a href="/tagihan" class="text-xs text-yellow-400 hover:underline mt-1 inline-block">Lihat data &rarr;</a>
                </div>
                <div class="bg-gradient-to-br from-green-900/40 to-slate-800 p-4 rounded-xl border border-green-500/20">
                    <p class="text-green-400 text-xs font-medium mb-1">Pemasukan Bulan Ini</p>
                    <h4 class="text-xl font-bold text-white">Rp {{ number_format($tagihanLunasBulanIni, 0, ',', '.') }}</h4>
                    <p class="text-xs text-slate-400 mt-1">Terverifikasi</p>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg">
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <iconify-icon icon="mdi:chart-pie" class="text-blue-400"></iconify-icon>
                    Distribusi Status Siswa
                </h3>
                <div class="h-64 w-full">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Log & Siswa Terbaru -->
        <div class="space-y-6">

            <!-- Latest Students -->
            <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-lg overflow-hidden">
                <div class="p-4 border-b border-slate-700 bg-slate-900/30 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                        <iconify-icon icon="mdi:account-plus" class="text-emerald-400"></iconify-icon>
                        Siswa Terbaru
                    </h3>
                    <a href="/siswa" class="text-xs text-blue-400 hover:text-blue-300">Lihat Semua</a>
                </div>
                <div class="p-2">
                    @foreach($latestSiswa as $s)
                    <div class="flex items-center gap-3 p-2 hover:bg-slate-700/30 rounded-lg transition-colors">
                        @if($s->foto)
                            <img src="{{ asset('storage/' . $s->foto) }}" class="w-8 h-8 rounded-full object-cover border border-slate-600">
                        @else
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                {{ substr($s->nama_lengkap, 0, 1) }}
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-white truncate">{{ $s->nama_lengkap }}</p>
                            <p class="text-[10px] text-slate-400">{{ $s->status->nama_status ?? 'Tanpa Status' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js for Admin -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('statusChart').getContext('2d');
        
        // Data dari PHP
        const labels = @json($statusLabels);
        const data = @json($statusData);

        new Chart(ctx, {
            type: 'bar', // Bisa diganti 'pie' atau 'doughnut'
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: data,
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.5)', // Blue
                        'rgba(16, 185, 129, 0.5)', // Green
                        'rgba(245, 158, 11, 0.5)', // Yellow
                        'rgba(239, 68, 68, 0.5)',  // Red
                        'rgba(139, 92, 246, 0.5)'  // Purple
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(239, 68, 68, 1)',
                        'rgba(139, 92, 246, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { color: '#94a3b8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8' }
                    }
                }
            }
        });
    });
</script>

@elseif($role === 'siswa')
@php
    $siswa = $user->siswa;
    $status = $siswa->status->nama_status ?? 'Calon Siswa';
    $kelas = $siswa->kelas->nama_kelas ?? 'Belum Ada Kelas';
    $unpaidCount = $siswa->billings()->where('status', 'belum_bayar')->count();
    $interviews = $siswa->interviewLogs()->with('job.company')->latest()->take(4)->get();

    // Logika Pengecekan Data Kosong
    $missingItems = [];
    if (!$siswa->foto) $missingItems[] = ['title' => 'Foto Profil', 'url' => '/biodata?tab=biodata', 'icon' => 'mdi:account-box-outline'];
    if (!$siswa->biodata?->nik) $missingItems[] = ['title' => 'NIK (Biodata)', 'url' => '/biodata?tab=biodata', 'icon' => 'mdi:identifier'];
    if ($siswa->keluargas->count() == 0) $missingItems[] = ['title' => 'Data Keluarga', 'url' => '/biodata?tab=keluarga', 'icon' => 'mdi:family-tree'];
    if ($siswa->pendidikans->count() == 0) $missingItems[] = ['title' => 'Riwayat Pendidikan', 'url' => '/biodata?tab=pendidikan', 'icon' => 'mdi:school-outline'];
    if ($siswa->riwayatPekerjaans->count() == 0) $missingItems[] = ['title' => 'Riwayat Pekerjaan', 'url' => '/biodata?tab=pekerjaan', 'icon' => 'mdi:briefcase-outline'];
    if (!$siswa->dokumen_akte) $missingItems[] = ['title' => 'Upload Akte Kelahiran', 'url' => '/biodata?tab=dokumen', 'icon' => 'mdi:file-document-outline'];
    if (!$siswa->dokumen_ktp) $missingItems[] = ['title' => 'Upload KTP', 'url' => '/biodata?tab=dokumen', 'icon' => 'mdi:card-account-details-outline'];
    if (!$siswa->kartuKeluarga) $missingItems[] = ['title' => 'Data Kartu Keluarga', 'url' => '/kartu-keluarga', 'icon' => 'mdi:home-group'];
    if (!$siswa->jikoPiaru) $missingItems[] = ['title' => 'Jiko Piaru', 'url' => '/biodata?tab=jiko-piaru', 'icon' => 'mdi:translate'];

    $totalChecks = 9;
    $completedChecks = $totalChecks - count($missingItems);
    $completionPercentage = round(($completedChecks / $totalChecks) * 100);
@endphp

<div class="space-y-6">
    <!-- Welcome Hero -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 to-indigo-800 rounded-0 md:rounded-3xl p-8 text-white shadow-2xl">
        <div class="relative z-10">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Selamat Datang, {{ $user->name }}! 👋</h1>
            <p class="text-blue-100 text-lg opacity-90">Senang melihatmu kembali. Terus semangat belajarnya ya!</p>
            
            <div class="mt-8 flex flex-wrap gap-4">
                <div class="bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl border border-white/20 flex items-center gap-2">
                    <iconify-icon icon="mdi:shield-check" class="text-blue-200"></iconify-icon>
                    <span class="text-sm font-medium">Status: {{ $status }}</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl border border-white/20 flex items-center gap-2">
                    <iconify-icon icon="mdi:google-classroom" class="text-blue-200"></iconify-icon>
                    <span class="text-sm font-medium">Kelas: {{ $kelas }}</span>
                </div>
            </div>
        </div>
        <!-- Decorative Circles -->
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/4 w-48 h-48 bg-indigo-400/20 rounded-full blur-2xl"></div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Attendance Card -->
        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-emerald-500/10 rounded-2xl">
                    <iconify-icon icon="mdi:calendar-check" width="28" height="28" class="text-emerald-400"></iconify-icon>
                </div>
                <div>
                    <p class="text-slate-400 text-sm">Kehadiran</p>
                    <h3 class="text-2xl font-bold text-white">95%</h3>
                </div>
            </div>
            <div class="mt-4 w-full bg-slate-700 rounded-full h-2">
                <div class="bg-emerald-500 h-2 rounded-full" style="width: 95%"></div>
            </div>
        </div>

        <!-- Billing Card -->
        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-amber-500/10 rounded-2xl">
                    <iconify-icon icon="mdi:credit-card-clock" width="28" height="28" class="text-amber-400"></iconify-icon>
                </div>
                <div>
                    <p class="text-slate-400 text-sm">Tagihan Pending</p>
                    <h3 class="text-2xl font-bold text-white">{{ $unpaidCount }} Item</h3>
                </div>
            </div>
            <a href="/pembayaran" class="mt-4 text-amber-400 text-sm font-medium flex items-center gap-1 hover:underline">
                Cek rincian tagihan <iconify-icon icon="mdi:arrow-right"></iconify-icon>
            </a>
        </div>

        <!-- Interview Card -->
        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-500/10 rounded-2xl">
                    <iconify-icon icon="mdi:chat-processing" width="28" height="28" class="text-blue-400"></iconify-icon>
                </div>
                <div>
                    <p class="text-slate-400 text-sm">Total Interview</p>
                    <h3 class="text-2xl font-bold text-white">{{ $siswa->interviewLogs()->count() }}</h3>
                </div>
            </div>
            <p class="mt-4 text-slate-500 text-sm">Terakhir: {{ $interviews->first()->job->jenis_pekerjaan ?? '-' }}</p>
        </div>
    </div>

    <!-- Profile Completion Warning -->
    @if(count($missingItems) > 0)
    <div class="bg-slate-800 rounded-2xl border border-amber-500/30 overflow-hidden shadow-xl">
        <div class="p-6 border-b border-slate-700 bg-amber-500/5 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-amber-500/20 rounded-lg">
                    <iconify-icon icon="mdi:alert-circle" width="24" height="24" class="text-amber-500"></iconify-icon>
                </div>
                <div>
                    <h3 class="text-white font-bold">Lengkapi Profil Anda</h3>
                    <p class="text-slate-400 text-sm">Beberapa data penting belum diisi. Mohon segera lengkapi untuk keperluan administrasi.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right hidden md:block">
                    <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Kelengkapan</p>
                    <p class="text-lg font-black text-amber-500">{{ $completionPercentage }}%</p>
                </div>
                <div class="w-32 bg-slate-700 rounded-full h-3 overflow-hidden">
                    <div class="bg-amber-500 h-full transition-all duration-1000" style="width: {{ $completionPercentage }}%"></div>
                </div>
            </div>
        </div>
        <div class="p-4 bg-slate-800/50">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                @foreach($missingItems as $item)
                <a href="{{ $item['url'] }}" class="flex items-center gap-3 p-3 rounded-xl bg-slate-700/30 border border-slate-700 hover:border-amber-500/50 hover:bg-amber-500/5 transition-all group">
                    <iconify-icon icon="{{ $item['icon'] }}" width="20" class="text-slate-500 group-hover:text-amber-500"></iconify-icon>
                    <span class="text-sm text-slate-300 group-hover:text-white">{{ $item['title'] }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Attendance Chart -->
        <div class="lg:col-span-2 bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <iconify-icon icon="mdi:chart-line" class="text-blue-400"></iconify-icon>
                    Statistik Kehadiran
                </h3>
                <select class="bg-slate-700 border-none text-slate-300 text-xs rounded-lg focus:ring-blue-500">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                </select>
            </div>
            <div class="h-64">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>

        <!-- Recent Interviews -->
        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-xl">
            <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                <iconify-icon icon="mdi:history" class="text-purple-400"></iconify-icon>
                Riwayat Interview
            </h3>
            <div class="space-y-4">
                @forelse($interviews as $log)
                <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-700/30 border border-slate-700">
                    <div class="p-2 bg-slate-800 rounded-lg">
                        <iconify-icon icon="mdi:office-building" class="text-slate-400"></iconify-icon>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-sm font-semibold truncate">{{ $log->job->company->nama_perusahaan }}</p>
                        <p class="text-slate-400 text-xs">{{ $log->job->jenis_pekerjaan }}</p>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="text-[10px] text-slate-500">{{ \Carbon\Carbon::parse($log->tanggal_interview)->format('d M Y') }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase 
                                {{ $log->hasil == 'lulus' ? 'bg-emerald-500/10 text-emerald-500' : ($log->hasil == 'gagal' ? 'bg-red-500/10 text-red-500' : 'bg-blue-500/10 text-blue-500') }}">
                                {{ $log->hasil ?? 'Pending' }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <iconify-icon icon="mdi:clipboard-text-off" width="48" class="text-slate-600 mb-2"></iconify-icon>
                    <p class="text-slate-500 text-sm">Belum ada riwayat interview</p>
                </div>
                @endforelse
            </div>
            <a href="{{ route('siswa.interview') }}" class="block text-center mt-6 text-sm text-blue-400 font-medium hover:text-blue-300 transition-colors">
                Lihat Semua Riwayat
            </a>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Kehadiran (%)',
                data: [100, 100, 90, 100, 95, 100, 100],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#fff',
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { color: '#94a3b8', font: { size: 10 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8', font: { size: 10 } }
                }
            }
        }
    });
</script>
@endif

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .space-y-6 > div {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>

@endsection