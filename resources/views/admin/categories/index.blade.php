<x-admin-layout>
    <div class="py-6 flex justify-center">

        <div class="w-full max-w-4xl"> {{-- Batasi lebar tabel --}}
            
            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-green-900">Daftar Kategori Program</h2>
                <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500 transition">Tambah Kategori</a>
            </div>

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow-sm">{{ session('success') }}</div>
            @endif

            {{-- Tabel Card --}}
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 uppercase">Nama Kategori</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 uppercase">Slug</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($categories as $category)
                            <tr class="hover:bg-green-50 transition">
                                <td class="px-4 py-3 text-gray-800 font-medium">{{ $category->name }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $category->slug }}</td>
                                <td class="px-4 py-3 flex gap-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-500 text-sm transition">Edit</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-500 text-sm transition">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-gray-500">Belum ada kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6 flex justify-center">
                {{ $categories->links() }}
            </div>

        </div>

    </div>
</x-admin-layout>
