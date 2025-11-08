<x-admin-layout>
    <div class="py-6 max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Tambah Event</h2>

        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow">
            @csrf

            <input type="text" name="title" placeholder="Judul Event" class="w-full border px-3 py-2 rounded" value="{{ old('title') }}" required>
            <textarea name="description" placeholder="Deskripsi Event" class="w-full border px-3 py-2 rounded">{{ old('description') }}</textarea>
            <input type="file" name="image" class="w-full">
            <input type="date" name="start_date" class="w-full border px-3 py-2 rounded" value="{{ old('start_date') }}">
            <input type="date" name="end_date" class="w-full border px-3 py-2 rounded" value="{{ old('end_date') }}">
            <input type="text" name="location" placeholder="Lokasi" class="w-full border px-3 py-2 rounded" value="{{ old('location') }}">

            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
        </form>
    </div>
</x-admin-layout>
