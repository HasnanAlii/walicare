<x-admin-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-green-900 mb-6">Edit Program: {{ $program->title }}</h2>

            {{-- Notifikasi Error --}}
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
                <form action="{{ route('admin.programs.update', $program) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @php
                        $formInputClass = 'w-full p-1.5 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50';
                        $formLabelClass = 'block mb-1.5 text-sm font-medium text-gray-700';
                    @endphp

                    {{-- Judul --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Judul Program *</label>
                        <input type="text" name="title" value="{{ old('title', $program->title) }}" class="{{ $formInputClass }}" required placeholder="Masukkan judul program">
                    </div>

                    {{-- Slug --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Slug (opsional)</label>
                        <input type="text" name="slug" value="{{ old('slug', $program->slug) }}" class="{{ $formInputClass }}" placeholder="Akan dibuat otomatis jika kosong">
                    </div>

                    {{-- Kategori --}}
                    <input type="hidden" name="category_id" value="{{ old('category_id', $program->category_id) }}">

                    {{-- Ringkasan --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Ringkasan</label>
                        <textarea name="summary" class="{{ $formInputClass }}" rows="2" placeholder="Ringkasan singkat program">{{ old('summary', $program->summary) }}</textarea>
                    </div>

                    {{-- Target & Terkumpul --}}
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="{{ $formLabelClass }}">Target Dana (Rp) *</label>
                            <input 
                                type="text" 
                                name="target_amount" 
                                {{-- value="{{ old('target_amount', number_format((float) $program->target_amount, 0, ',', '.')) }}"  --}}
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
                                value="{{ old('collected_amount', number_format((float) $program->collected_amount, 0, ',', '.')) }}" 
                                class="{{ $formInputClass }} format-ribuan" 
                                inputmode="numeric"
                            >
                        </div>
                    </div>

                    {{-- Gambar --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Gambar Program</label>
                        @if($program->image)
                            <img src="{{ asset('storage/' . $program->image) }}" alt="Gambar Program" class="mb-3 w-40 h-40 object-cover rounded-md border border-gray-200">
                        @endif
                        <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti gambar. Maksimal 5MB.</p>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Deskripsi Program</label>
                        <textarea name="description" class="{{ $formInputClass }}" rows="4" placeholder="Deskripsi lengkap program">{{ old('description', $program->description) }}</textarea>
                    </div>

                    <hr class="my-6">

                   
                    {{-- Status --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Status Program *</label>
                        <select name="status" class="{{ $formInputClass }}" required>
                            <option value="draft" {{ old('status', $program->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ old('status', $program->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="completed" {{ old('status', $program->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ old('status', $program->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    {{-- Tanggal --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="{{ $formLabelClass }}">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ old('start_date', optional($program->start_date)->format('Y-m-d')) }}" class="{{ $formInputClass }}">
                        </div>
                        <div>
                            <label class="{{ $formLabelClass }}">Tanggal Selesai</label>
                            <input type="date" name="end_date" value="{{ old('end_date', optional($program->end_date)->format('Y-m-d')) }}" class="{{ $formInputClass }}">
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Lokasi Program</label>
                        <input type="text" name="location" value="{{ old('location', $program->location) }}" class="{{ $formInputClass }}" placeholder="Contoh: Jakarta">
                    </div>

                    {{-- Unggulan --}}
                    <div class="mb-6">
                        <label class="flex items-center gap-3">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $program->is_featured) ? 'checked' : '' }} class="h-5 w-5 text-green-600 border-gray-300 rounded shadow-sm focus:ring-green-500">
                            <span class="font-medium text-gray-700">Tampilkan sebagai program unggulan</span>
                        </label>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex gap-3 border-t pt-6 justify-end">
                       <a href="{{ url()->previous() }}"  class="inline-flex items-center gap-2 px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                            <i data-feather="x" class="w-4 h-4"></i>Batal
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                            <i data-feather="save" class="w-4 h-4"></i>Perbarui Program
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
            const form = document.querySelector('form');
            const container = document.getElementById('breakdown-container');
            const addBtn = document.getElementById('add-breakdown');
            const hiddenInput = document.getElementById('breakdown-json');

            // Format awal semua input angka
            document.querySelectorAll('.format-ribuan').forEach(input => {
                input.addEventListener('input', () => formatInputAsNumber(input));
            });

          
            form.addEventListener('submit', function () {
                // Hilangkan format titik pada semua angka utama
                document.querySelectorAll('.format-ribuan').forEach(input => {
                    input.value = unformatNumber(input.value);
                });

             
            });
        });
    </script>
    @endpush
</x-admin-layout>
