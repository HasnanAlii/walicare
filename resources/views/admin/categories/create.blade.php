<x-admin-layout>
    <div class=" max-w-2xl mx-auto mt-10">

        {{-- Header --}}
        <h2 class="text-2xl font-bold text-green-900 mb-6">Tambah Kategori Program</h2>

        {{-- PERUBAHAN: Blok Error Konsisten --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                <div class="flex items-center">
                    <i data-feather="alert-circle" class="w-5 h-5 mr-3 text-red-600"></i>
                    <h4 class="font-semibold">Terjadi Kesalahan</h4>
                </div>
                <ul class="list-disc pl-10 mt-2 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- PERUBAHAN: Card Formulir --}}
        <div class="bg-white shadow-lg rounded-lg p-6 md:p-8">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                @php
                    $formInputClass = 'w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50';
                    $formLabelClass = 'block mb-1.5 text-sm font-medium text-gray-700';
                @endphp

                <div class="mb-4">
                    <label class="{{ $formLabelClass }}">Nama Kategori *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           class="{{ $formInputClass }}" 
                           placeholder="Masukkan nama kategori">
                </div>

                {{-- <div class="mb-6">
                    <label class="{{ $formLabelClass }}">Slug (opsional)</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" 
                           class="{{ $formInputClass }}" 
                           placeholder="Akan dibuat otomatis jika kosong">
                </div> --}}

                {{-- PERUBAHAN: Tombol Aksi Konsisten --}}
                <div class="flex gap-3 border-t pt-6 justify-end" >
                    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                        <i data-feather="x" class="w-4 h-4"></i>
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                        <i data-feather="save" class="w-4 h-4"></i>
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>