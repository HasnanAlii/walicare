<x-admin-layout>
    <div class="py-6 max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Edit Event</h2>

        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <input type="text" name="title" placeholder="Judul Event" class="w-full border px-3 py-2 rounded" value="{{ old('title', $event->title) }}" required>
            <textarea name="description" placeholder="Deskripsi Event" class="w-full border px-3 py-2 rounded">{{ old('description', $event->description) }}</textarea>
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-32 h-32 object-cover mb-2 rounded">
            @endif
            <input type="file" name="image" class="w-full">
            <input type="date" name="start_date" class="w-full border px-3 py-2 rounded" value="{{ old('start_date', $event->start_date?->format('Y-m-d')) }}">
            <input type="date" name="end_date" class="w-full border px-3 py-2 rounded" value="{{ old('end_date', $event->end_date?->format('Y-m-d')) }}">
            <input type="text" name="location" placeholder="Lokasi" class="w-full border px-3 py-2 rounded" value="{{ old('location', $event->location) }}">

            <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded">Update</button>
        </form>
    </div>
</x-admin-layout>
