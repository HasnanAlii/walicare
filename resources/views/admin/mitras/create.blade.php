<x-admin-layout>
    <div class="max-w-2xl mx-auto py-6 mt-4">

        <h2 class="text-2xl font-bold text-green-900 mb-6">Tambah Mitra Baru</h2>

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

        <div class="bg-white shadow-lg rounded-lg p-6 md:p-8">
            <form method="POST" action="{{ route('admin.mitras.store') }}" enctype="multipart/form-data">
                @csrf

                @php
                    $formInputClass = 'w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50';
                    $formLabelClass = 'block mb-1.5 text-sm font-medium text-gray-700';
                @endphp

                <div class="space-y-5">
                    <div>
                        <label for="name" class="{{ $formLabelClass }}">Nama Mitra *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="{{ $formInputClass }}"
                               placeholder="Masukkan nama mitra">
                    </div>

                    <div>
                        <label for="url" class="{{ $formLabelClass }}">URL Website (opsional)</label>
                        <input type="url" id="url" name="url" value="{{ old('url') }}"
                               class="{{ $formInputClass }}"
                               placeholder="https://contoh.com">
                    </div>

                    <div>
                        <label for="logo" class="{{ $formLabelClass }}">Logo Mitra (opsional)</label>
                        <input type="file" id="logo" name="logo" accept="image/*"
                               class="block w-full text-sm text-gray-700
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-green-100 file:text-green-700
                                      hover:file:bg-green-200 transition-colors">
                        <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, atau WEBP (maks 2MB)</p>
                    </div>
                </div>


                <div class="flex gap-3 border-t pt-6 justify-end mt-8">
                    <a href="{{ route('admin.mitras.index') }}" 
                       class="inline-flex items-center gap-2 px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium text-sm">
                        <i data-feather="x" class="w-4 h-4"></i>
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium text-sm">
                        <i data-feather="save" class="w-4 h-4"></i>
                        Simpan Mitra
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</x-admin-layout>