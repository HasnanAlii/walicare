<x-admin-layout>
    <div class="py-6 max-w-2xl mx-auto">

        {{-- Header --}}
        <h2 class="text-2xl font-bold text-green-900 mb-6">Tambah Kategori Program</h2>

        {{-- Errors --}}
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded shadow-sm">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded px-3 py-2" placeholder="Masukkan nama kategori">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">Slug (opsional)</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border rounded px-3 py-2" placeholder="Akan dibuat otomatis jika kosong">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</a>
            </div>
        </form>
    </div>
</x-admin-layout>
