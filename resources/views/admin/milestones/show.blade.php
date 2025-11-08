<x-admin-layout>
    <div class="py-6">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-green-900">Daftar Tonggak Program</h2>
            <a href="{{ route('admin.milestones.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500 transition">Tambah Tonggak</a>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow-sm">{{ session('success') }}</div>
        @endif

        {{-- Grid Cards --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($milestones as $milestone)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-5 flex flex-col justify-between">

                    {{-- Judul & Program --}}
                    <div class="mb-3">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $milestone->title }}</h3>
                        <p class="text-sm text-gray-500">Program: {{ $milestone->program->title ?? '-' }}</p>
                    </div>

                    {{-- Tanggal Target --}}
                    <div class="mb-3 text-gray-700 text-sm">
                        <p>Tanggal Target: <strong>{{ $milestone->target_date?->format('d M Y') ?? '-' }}</strong></p>
                    </div>

                    {{-- Status Tonggak --}}
                    <div class="mb-3">
                        <span class="font-semibold">Status:</span>
                        @if($milestone->status == 'draft')
                            <span class="px-2 py-1 bg-gray-200 text-gray-800 rounded-full text-xs">Draft</span>
                        @elseif($milestone->status == 'active')
                            <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full text-xs">Aktif</span>
                        @elseif($milestone->status == 'completed')
                            <span class="px-2 py-1 bg-blue-200 text-blue-800 rounded-full text-xs">Selesai</span>
                        @elseif($milestone->status == 'cancelled')
                            <span class="px-2 py-1 bg-red-200 text-red-800 rounded-full text-xs">Dibatalkan</span>
                        @endif
                    </div>

                    {{-- Tonggak Tercapai --}}
                    <div class="mb-3">
                        <span class="font-semibold">Tercapai:</span>
                        @if($milestone->is_reached)
                            <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full text-xs">Ya</span>
                        @else
                            <span class="px-2 py-1 bg-gray-200 text-gray-800 rounded-full text-xs">Belum</span>
                        @endif
                    </div>

                    {{-- Aksi --}}
                    <div class="flex gap-2 mt-3 flex-wrap">
                        <a href="{{ route('admin.milestones.show', $milestone) }}" class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-500 text-sm transition">Detail</a>
                        <a href="{{ route('admin.milestones.edit', $milestone) }}" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-500 text-sm transition">Edit</a>
                        <form action="{{ route('admin.milestones.destroy', $milestone) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tonggak ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-500 text-sm transition">Hapus</button>
                        </form>
                    </div>

                </div>
            @empty
                <p class="text-center col-span-full text-gray-500">Belum ada tonggak program.</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center">
            {{ $milestones->links() }}
        </div>

    </div>
</x-admin-layout>
