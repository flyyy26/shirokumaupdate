@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Pengaturan Alur Siswa</h1>
        <button onclick="openModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Tambah Status
        </button>
    </div>

    <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <table class="w-full text-left text-gray-300">
            <thead class="bg-gray-900 text-gray-400 uppercase text-sm">
                <tr>
                    <th class="p-4">Urutan</th>
                    <th>Nama Status</th>
                    <th class="text-right pr-6">Aksi</th>
                </tr>
            </thead>
            <tbody id="sortable">
                @foreach($statuses as $status)
                <tr data-id="{{ $status->id }}" class="border-b border-gray-700 hover:bg-gray-700 cursor-move">
                    <td class="p-4 font-bold">{{ $status->urutan }}</td>
                    <td>{{ $status->nama_status }}</td>
                    <td class="text-right pr-6 space-x-2">
                        <button onclick="editStatus({{ $status->id }}, '{{ $status->nama_status }}')" class="text-yellow-400 hover:underline">Edit</button>
                        <form action="{{ route('alur.destroy', $status->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- Modal --}}
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 w-full h-screen hidden items-center justify-center">
    <div class="bg-gray-900 p-6 rounded-xl w-96 m-auto">
        <h2 class="text-lg font-bold mb-4 text-white" id="modalTitle">Tambah Status</h2>

        <form id="statusForm" method="POST">
            @csrf
            <input type="hidden" id="methodField" name="_method" value="POST">
            <input type="text" name="nama_status" id="nama_status"
                class="w-full p-2 rounded bg-gray-800 text-white mb-4"
                placeholder="Nama Status" required>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-600 rounded">Batal</button>
                <button class="px-4 py-2 bg-blue-600 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- SortableJS --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
let sortable = new Sortable(document.getElementById('sortable'), {
    animation: 150,
    onEnd: function () {

        let order = [];

        document.querySelectorAll('#sortable tr').forEach((row, index) => {
            order.push(row.dataset.id);

            // 🔥 Update nomor urutan langsung di tampilan
            row.querySelector('td:first-child').innerText = index + 1;
        });

        fetch("{{ route('alur.updateOrder') }}", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ order: order })
        });
    }
});

function openModal() {
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
    document.getElementById('statusForm').action = "{{ route('alur.store') }}";
    document.getElementById('methodField').value = "POST";
    document.getElementById('modalTitle').innerText = "Tambah Status";
}

function editStatus(id, nama) {
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
    document.getElementById('statusForm').action = "/pengaturan/alur-siswa/" + id;
    document.getElementById('methodField').value = "PUT";
    document.getElementById('nama_status').value = nama;
    document.getElementById('modalTitle').innerText = "Edit Status";
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}
</script>
@endsection