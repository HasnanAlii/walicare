<x-admin-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-green-900 mb-6">Edit Kegiatan: {{ $event->title }}</h2>

            {{-- Blok Error --}}
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

            {{-- Card Formulir --}}
            <div class="bg-white shadow-lg rounded-lg p-6 md:p-8">
                <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @php
                        $formInputClass = 'w-full p-1.5 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50';
                        $formLabelClass = 'block mb-1.5 text-sm font-medium text-gray-700';
                    @endphp

                    {{-- Kategori --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Kategori Kegiatan</label>
                        <select name="category_id" class="{{ $formInputClass }}">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories ?? [] as $id => $name)
                                <option value="{{ $id }}" {{ old('category_id', $event->category_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Judul --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Judul Kegiatan *</label>
                        <input type="text" name="title" value="{{ old('title', $event->title) }}" class="{{ $formInputClass }}" required placeholder="Masukkan judul kegiatan">
                    </div>

                    {{-- Slug --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Slug (opsional)</label>
                        <input type="text" name="slug" value="{{ old('slug', $event->slug) }}" class="{{ $formInputClass }}" placeholder="Akan dibuat otomatis jika kosong">
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Deskripsi Kegiatan</label>
                        <textarea name="description" rows="4" class="{{ $formInputClass }}" placeholder="Deskripsi lengkap kegiatan">{{ old('description', $event->description) }}</textarea>
                    </div>

                    {{-- Gambar --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Gambar Kegiatan</label>
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-40 h-40 object-cover rounded mb-3 border">
                        @endif
                        <input type="file" name="image" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 
                                      file:rounded-full file:border-0 file:text-sm file:font-semibold 
                                      file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        <p class="text-xs text-gray-500 mt-1">Format: jpeg, png, jpg, gif, webp. Maksimal 5MB.</p>
                    </div>

                    {{-- Tanggal --}}
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="{{ $formLabelClass }}">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ old('start_date', $event->start_date?->format('Y-m-d')) }}" class="{{ $formInputClass }}">
                        </div>
                        <div>
                            <label class="{{ $formLabelClass }}">Tanggal Selesai</label>
                            <input type="date" name="end_date" value="{{ old('end_date', $event->end_date?->format('Y-m-d')) }}" class="{{ $formInputClass }}">
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Lokasi Kegiatan</label>
                        <input type="text" name="location" value="{{ old('location', $event->location) }}" class="{{ $formInputClass }}" placeholder="Masukkan lokasi kegiatan">
                    </div>

                    <hr class="my-6">

                    {{-- Status Aktif --}}
                    <div class="mb-6">
                        <label class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1"
                                   {{ old('is_active', $event->is_active) ? 'checked' : '' }}
                                   class="h-5 w-5 text-green-600 border-gray-300 rounded shadow-sm focus:ring-green-500">
                            <span class="font-medium text-gray-700">Aktifkan kegiatan ini</span>
                        </label>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex gap-3 border-t pt-6 justify-end">
                        <a href="{{ route('admin.events.index') }}" 
                           class="inline-flex items-center gap-2 px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                            <i data-feather="x" class="w-4 h-4"></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                            <i data-feather="save" class="w-4 h-4"></i>
                            Perbarui Kegiatan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Feather Icons --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</x-admin-layout>
