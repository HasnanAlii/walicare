<x-admin-layout>
    <div class="py-6 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Penerima Bantuan</h2>
            <a href="{{ route('admin.beneficiaries.create') }}" 
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Tambah Penerima</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg">
                <thead class="bg-gray-100">
                    <tr class="text-left">
                        <th class="px-4 py-2 border-b">No</th>
                        <th class="px-4 py-2 border-b">Program</th>
                        <th class="px-4 py-2 border-b">Nama</th>
                        <th class="px-4 py-2 border-b">Alamat</th>
                        <th class="px-4 py-2 border-b">Catatan</th>
                        <th class="px-4 py-2 border-b">Foto</th>
                        <th class="px-4 py-2 border-b">Terkirim</th>
                        <th class="px-4 py-2 border-b">Tanggal Kirim</th>
                        <th class="px-4 py-2 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($beneficiaries as $beneficiary)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">{{ $loop->iteration + ($beneficiaries->currentPage()-1)*$beneficiaries->perPage() }}</td>
                            <td class="px-4 py-2 border-b">{{ $beneficiary->program->title ?? '-' }}</td>
                            <td class="px-4 py-2 border-b">{{ $beneficiary->name }}</td>
                            <td class="px-4 py-2 border-b">{{ $beneficiary->address ?? '-' }}</td>
                            <td class="px-4 py-2 border-b">{{ $beneficiary->notes ?? '-' }}</td>
                            <td class="px-4 py-2 border-b">
                                @if($beneficiary->photo_path)
                                    <img src="{{ asset('storage/' . $beneficiary->photo_path) }}" alt="Foto" class="w-16 h-16 object-cover rounded">
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-2 border-b">{{ $beneficiary->delivered ? 'Ya' : 'Belum' }}</td>
                            <td class="px-4 py-2 border-b">{{ $beneficiary->delivered_at ?? '-' }}</td>
                            <td class="px-4 py-2 border-b flex gap-2">
                                <a href="{{ route('admin.beneficiaries.edit', $beneficiary) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.beneficiaries.destroy', $beneficiary) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-2 text-center text-gray-500">Belum ada data penerima bantuan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $beneficiaries->links() }}
        </div>
    </div>
</x-admin-layout>
