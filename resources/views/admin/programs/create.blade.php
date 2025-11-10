<x-admin-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-green-900 mb-6">Tambah Program Baru</h2>

            {{-- Tampilkan error --}}
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
                <form action="{{ route('admin.programs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @php
                        $formInputClass = 'w-full p-1.5 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50';
                        $formLabelClass = 'block mb-1.5 text-sm font-medium text-gray-700';
                    @endphp

                    {{-- Judul --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Judul Program *</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="{{ $formInputClass }}" required placeholder="Masukkan judul program">
                    </div>

                    {{-- Slug --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Slug (opsional)</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" class="{{ $formInputClass }}" placeholder="Akan dibuat otomatis jika kosong">
                    </div>
                    {{-- Kategori --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Kategori Program *</label>
                        <select name="category_id" class="{{ $formInputClass }}" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $id => $name)
                                <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                 

                    {{-- Ringkasan --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Ringkasan</label>
                        <textarea name="summary" class="{{ $formInputClass }}" rows="2" placeholder="Ringkasan singkat program">{{ old('summary') }}</textarea>
                    </div>

                  
                    {{-- Target dan Terkumpul --}}
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="{{ $formLabelClass }}">Target Dana (Rp) *</label>
                            <input 
                                type="text" 
                                name="target_amount" 
                                class="{{ $formInputClass }} format-ribuan" 
                                placeholder="Kosongkan untuk target tanpa batas"
                                inputmode="numeric"
                            >
                        </div>
                        <div>
                            <label class="{{ $formLabelClass }}">Dana Terkumpul (Rp)</label>
                            <input 
                                type="text" 
                                name="collected_amount" 
                                value="{{ old('collected_amount', 0) }}" 
                                class="{{ $formInputClass }}  format-ribuan" 
                                inputmode="numeric"
                            >
                        </div>
                    </div>

                    {{-- Gambar --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Gambar Program *</label>
                        <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" required>
                        <p class="text-xs text-gray-500 mt-1">Format: jpeg, png, jpg, gif, webp. Maksimal 5MB.</p>
                    </div>

                      {{-- Deskripsi --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Deskripsi Program</label>
                        <textarea name="description" class="{{ $formInputClass }}" rows="4" placeholder="Deskripsi lengkap program">{{ old('description') }}</textarea>
                    </div>


                    {{-- Breakdown --}}
                    {{-- <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Rincian Dana</label>
                        <div id="breakdown-container" class="space-y-3">
                            @php
                                $old_names = old('breakdown_name', []);
                                $old_amounts = old('breakdown_amount', []);
                            @endphp

                            @if(!empty($old_names))
                                @foreach($old_names as $index => $name)
                                    <div class="flex gap-2 items-center">
                                        <input type="text" name="breakdown_name[]" value="{{ $name }}" placeholder="Nama Kegiatan" class="{{ $formInputClass }} flex-1">
                                        <input type="text" name="breakdown_amount[]" value="{{ number_format($old_amounts[$index] ?? 0, 0, ',', '.') }}" placeholder="Jumlah (Rp)" class="{{ $formInputClass }} w-40" oninput="formatInputAsNumber(this)" inputmode="numeric">
                                        <button type="button" class="remove-btn p-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <button type="button" id="add-breakdown" class="inline-flex items-center gap-2 mt-3 px-3 py-1.5 bg-green-600 text-white rounded-md hover:bg-green-700 transition text-sm font-medium">
                            <i data-feather="plus" class="w-4 h-4"></i>
                            Tambah Item
                        </button>

                        <input type="hidden" name="breakdown" id="breakdown-json">
                    </div> --}}

                    <hr class="my-6">

                    {{-- Status --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Status Program *</label>
                        <select name="status" class="{{ $formInputClass }}" required>
                            <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    {{-- Tanggal --}}
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="{{ $formLabelClass }}">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}" class="{{ $formInputClass }}">
                        </div>
                        <div>
                            <label class="{{ $formLabelClass }}">Tanggal Selesai</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}" class="{{ $formInputClass }}">
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Lokasi Program</label>
                        <input type="text" name="location" value="{{ old('location') }}" class="{{ $formInputClass }}" placeholder="Contoh: Jakarta">
                    </div>

                    {{-- Unggulan --}}
                    <div class="mb-6">
                        <label class="flex items-center gap-3">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="h-5 w-5 text-green-600 border-gray-300 rounded shadow-sm focus:ring-green-500">
                            <span class="font-medium text-gray-700">Tampilkan sebagai program unggulan</span>
                        </label>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex gap-3 border-t pt-6 justify-end">
                        <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                            <i data-feather="x" class="w-4 h-4"></i>
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                            <i data-feather="save" class="w-4 h-4"></i>
                            Simpan Program
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function formatInputAsNumber(input) {
            let value = input.value.replace(/\D/g, '');
            input.value = value ? new Intl.NumberFormat('id-ID').format(Number(value)) : '';
        }

        function unformatNumber(value) {
            return value.replace(/\D/g, '');
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Format otomatis untuk input angka
            document.querySelectorAll('.format-ribuan').forEach(input => {
                formatInputAsNumber(input);
                input.addEventListener('input', () => formatInputAsNumber(input));
            });
        });

    </script>
    @endpush
</x-admin-layout>
