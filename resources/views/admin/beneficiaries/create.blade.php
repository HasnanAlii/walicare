<x-admin-layout>
    <div class="py-6 max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Penerima Bantuan</h2>

        <form action="{{ route('admin.beneficiaries.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6 space-y-4">
            @csrf

            <div>
                <label class="block font-medium">Program</label>
                <select name="program_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Program --</option>
                    @foreach($programs as $id => $title)
                        <option value="{{ $id }}" {{ old('program_id') == $id ? 'selected' : '' }}>{{ $title }}</option>
                    @endforeach
                </select>
                @error('program_id') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2">
                @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Alamat</label>
                <textarea name="address" class="w-full border rounded px-3 py-2">{{ old('address') }}</textarea>
                @error('address') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Catatan</label>
                <textarea name="notes" class="w-full border rounded px-3 py-2">{{ old('notes') }}</textarea>
                @error('notes') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Foto</label>
                <input type="file" name="photo_path" class="w-full">
                @error('photo_path') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="delivered" value="1" {{ old('delivered') ? 'checked' : '' }}>
                    <span class="ml-2">Sudah Terkirim</span>
                </label>
            </div>

            <div>
                <label class="block font-medium">Tanggal Terkirim</label>
                <input type="date" name="delivered_at" value="{{ old('delivered_at') }}" class="w-full border rounded px-3 py-2">
                @error('delivered_at') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.beneficiaries.index') }}" class="px-4 py-2 border rounded hover:bg-gray-100">Batal</a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
            </div>
        </form>
    </div>
</x-admin-layout>
