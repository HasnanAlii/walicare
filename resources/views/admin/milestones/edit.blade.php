<x-admin-layout>
    <div class="py-6 max-w-2xl mx-auto">

        {{-- Header --}}
        <h2 class="text-2xl font-bold text-green-900 mb-6">Edit Tonggak Program</h2>

        {{-- Notifikasi Error --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded shadow-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.milestones.update', $milestone) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-1">Judul Tonggak</label>
                <input type="text" name="title" id="title" value="{{ old('title', $milestone->title) }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>

            {{-- Program --}}
            <div class="mb-4">
                <label for="program_id" class="block text-gray-700 font-medium mb-1">Program</label>
                <select name="program_id" id="program_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    <option value="">Pilih Program</option>
                    @foreach($programs as $id => $title)
                        <option value="{{ $id }}" {{ old('program_id', $milestone->program_id) == $id ? 'selected' : '' }}>{{ $title }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Jumlah Target --}}
            <div class="mb-4">
                <label for="amount" class="block text-gray-700 font-medium mb-1">Jumlah Target (Rp)</label>
                <input type="number" name="amount" id="amount" value="{{ old('amount', $milestone->amount) }}" min="0"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-1">Deskripsi (Opsional)</label>
                <textarea name="description" id="description" rows="3" 
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('description', $milestone->description) }}</textarea>
            </div>

            {{-- Tanggal Target --}}
            <div class="mb-4">
                <label for="target_date" class="block text-gray-700 font-medium mb-1">Tanggal Target (Opsional)</label>
                <input type="date" name="target_date" id="target_date" value="{{ old('target_date', $milestone->target_date?->format('Y-m-d')) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            {{-- Status Tercapai --}}
            <div class="mb-4 flex items-center gap-2">
                <input type="checkbox" name="is_reached" id="is_reached" value="1" {{ old('is_reached', $milestone->is_reached) ? 'checked' : '' }} class="h-4 w-4 text-green-600">
                <label for="is_reached" class="text-gray-700 font-medium">Tonggak sudah tercapai?</label>
            </div>

            {{-- Status --}}
            <div class="mb-4">
                <label for="status" class="block text-gray-700 font-medium mb-1">Status</label>
                <select name="status" id="status" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    <option value="draft" {{ old('status', $milestone->status)=='draft' ? 'selected' : '' }}>Draft</option>
                    <option value="active" {{ old('status', $milestone->status)=='active' ? 'selected' : '' }}>Aktif</option>
                    <option value="completed" {{ old('status', $milestone->status)=='completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ old('status', $milestone->status)=='cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end gap-2 mt-6">
                <a href="{{ route('admin.milestones.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-200 transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500 transition">Perbarui</button>
            </div>
        </form>

    </div>
</x-admin-layout>
