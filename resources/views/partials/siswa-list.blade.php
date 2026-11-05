{{-- DEBUG: Tampilkan data dari database --}}
<!--
URUTAN DARI DATABASE:
@foreach($job->siswa as $s)
{{ $s->nama_lengkap }} => {{ $s->pivot->urutan }}
@endforeach
-->

@foreach($job->siswa as $index => $siswa)
@php
    $urutan = $siswa->pivot->urutan;
    $total = $job->siswa->count();
    $statusKode = $siswa->status->kode_status ?? null;
    $statusText = 'Tanpa Status';
    $statusColor = 'gray';
    
    if ($statusKode) {
        $statusText = ucwords(str_replace('_', ' ', $statusKode));
        switch($statusKode) {
            case 'kandidat': $statusColor = 'yellow'; break;
            case 'interview': $statusColor = 'blue'; break;
            case 'karantina': $statusColor = 'purple'; break;
            case 'berangkat': $statusColor = 'green'; break;
            default: $statusColor = 'gray';
        }
    }
@endphp
<div class="siswa-item flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 bg-gray-800/50 p-3 rounded-lg border border-gray-700/50 hover:border-blue-500/30 transition-all relative"
     data-siswa-id="{{ $siswa->id }}"
     data-job-id="{{ $job->id }}"
     data-urutan="{{ $urutan }}"
     data-index="{{ $index }}">
    
    <div class="flex items-center gap-3 flex-1 pl-2">
        @if($siswa->foto)
            <img src="{{ asset('storage/' . $siswa->foto) }}" class="w-8 h-8 rounded-full object-cover border border-gray-600">
        @else
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs">
                {{ substr($siswa->nama_lengkap, 0, 1) }}
            </div>
        @endif
        
        <div class="flex-1">
            <div class="flex items-center gap-2">
                <p class="text-white text-sm font-medium">{{ $siswa->nama_lengkap }}</p>
                {{-- TAMPILKAN URUTAN DARI DATABASE --}}
                <span class="urutan-badge bg-blue-600 text-white text-xs px-2 py-0.5 rounded-full font-bold">
                    {{ $urutan }}
                </span>
            </div>
            
            <div class="flex items-center gap-2 mt-1">
                <span class="px-2 py-0.5 rounded-full text-xs bg-{{ $statusColor }}-500/20 text-{{ $statusColor }}-400">
                    {{ $statusText }}
                </span>
                
                @if($siswa->kelas)
                    <span class="px-2 py-0.5 rounded-full text-xs bg-purple-500/20 text-purple-400">
                        Kelas: {{ $siswa->kelas->nama_kelas ?? '-' }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="flex items-center gap-2 ml-0 sm:ml-auto w-full sm:w-auto mt-2 sm:mt-0">
        <div class="flex items-center gap-1 mr-2 border-r border-gray-700 pr-2">
            <!-- Tombol Naik -->
            <button type="button" 
                    class="btn-move-up bg-gray-700/50 hover:bg-gray-600 text-white p-1 rounded
                           {{ $urutan <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                    data-job-id="{{ $job->id }}"
                    data-siswa-id="{{ $siswa->id }}"
                    data-urutan="{{ $urutan }}"
                    {{ $urutan <= 1 ? 'disabled' : '' }}>
                <iconify-icon icon="mdi:arrow-up" width="14" height="14"></iconify-icon>
            </button>
            
            <!-- Tombol Turun -->
            <button type="button" 
                    class="btn-move-down bg-gray-700/50 hover:bg-gray-600 text-white p-1 rounded
                           {{ $urutan >= $total ? 'opacity-50 cursor-not-allowed' : '' }}"
                    data-job-id="{{ $job->id }}"
                    data-siswa-id="{{ $siswa->id }}"
                    data-urutan="{{ $urutan }}"
                    data-total="{{ $total }}"
                    {{ $urutan >= $total ? 'disabled' : '' }}>
                <iconify-icon icon="mdi:arrow-down" width="14" height="14"></iconify-icon>
            </button>
        </div>
        
        @if($statusKode === 'interview')
            <!-- Tombol Lulus -->
            <form method="POST" action="{{ route('job.mark-passed', ['job' => $job->id, 'siswa' => $siswa->id]) }}" 
                  onsubmit="return confirm('Tandai siswa ini LULUS interview?')" class="inline">
                @csrf
                <button class="bg-green-600/20 hover:bg-green-600/40 text-green-400 px-3 py-1.5 rounded-lg text-xs">
                    <iconify-icon icon="mdi:check-circle" width="12" height="12"></iconify-icon>
                    Lulus
                </button>
            </form>
            
            <!-- Tombol Gagal -->
            <form method="POST" action="{{ route('job.mark-failed', ['job' => $job->id, 'siswa' => $siswa->id]) }}" 
                onsubmit="return confirm('Hapus dari job ini?')" class="inline">
                @csrf
                <button class="bg-red-600/20 hover:bg-red-600/40 text-red-400 px-3 py-1.5 rounded-lg text-xs">
                    <iconify-icon icon="mdi:close-circle" width="12" height="12"></iconify-icon>
                    Gagal
                </button>
            </form>
        @endif

        <!-- Tombol Hapus -->
        <form method="POST" action="{{ route('job.remove-siswa', ['job' => $job->id, 'siswa' => $siswa->id]) }}" 
            onsubmit="return confirm('Yakin hapus?')" class="inline">
            @csrf
            @method('DELETE')
            <button class="bg-gray-600/20 hover:bg-red-600/40 text-gray-400 hover:text-red-400 px-3 py-1.5 rounded-lg text-xs">
                <iconify-icon icon="mdi:delete" width="12" height="12"></iconify-icon>
                Hapus
            </button>
        </form>
    </div>
</div>
@endforeach