<x-admin-layout>
    <div class="py-6 max-w-7xl mx-auto">
        
        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-green-900">Daftar Kegiatan</h2>
            <a href="{{ route('admin.events.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-sm text-sm font-medium">
                <i data-feather="plus" class="w-4 h-4"></i>
                Tambah Kegiatan
            </a>
        </div>

        {{-- PERUBAHAN: Cards Grid --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($events as $event)
                {{-- Kartu Event --}}
                <div class="bg-white rounded-xl shadow border border-gray-200 hover:shadow-xl transition-shadow duration-300 flex flex-col overflow-hidden">
                    
                    {{-- Gambar --}}
                    <div class="w-full">
                        {{-- Ganti 'event->image' jika Anda memiliki field gambar --}}
                        @if(false) 
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover aspect-video">
                        @else
                            {{-- Placeholder jika tidak ada gambar --}}
                            <div class="w-full h-48 aspect-video bg-green-50 flex items-center justify-center">
                                <i data-feather="calendar" class="w-16 h-16 text-green-300"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Konten Kartu --}}
                    <div class="p-5 flex-1 flex flex-col">
                        
                        {{-- Judul --}}
                        <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2">{{ $event->title }}</h3>

                        {{-- Tanggal & Lokasi (dipaksa ke bawah) --}}
                        <div class="text-sm text-gray-500 mb-4 border-t pt-3 mt-auto">
                            <div class="flex items-center gap-2 mb-1">
                                <i data-feather="calendar" class="w-4 h-4"></i>
                                <span>{{ $event->start_date?->format('d M Y') ?? 'N/A' }} - {{ $event->end_date?->format('d M Y') ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-feather="map-pin" class="w-4 h-4"></i>
                                <span>{{ $event->location ?? '-' }}</span>
                            </div>
                        </div>

                        {{-- Aksi --}}
                        <div class="flex gap-2 mt-2 flex-wrap">
                            <a href="{{ route('admin.events.show', $event) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-xs font-medium transition">
                                <i data-feather="eye" class="w-4 h-4"></i> Detail
                            </a>
                            <a href="{{ route('admin.events.edit', $event) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-xs font-medium transition">
                                <i data-feather="edit-2" class="w-4 h-4"></i> Edit
                            </a>
                            <form id="delete-form-{{ $event->id }}" action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        onclick="confirmDelete({{ $event->id }})" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 text-xs font-medium transition">
                                    <i data-feather="trash-2" class="w-4 h-4"></i> Hapus
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @empty
                {{-- Status Kosong --}}
                <div class="col-span-full bg-white p-12 rounded-lg shadow border border-gray-200 text-center">
                    <i data-feather="calendar" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700">Belum Ada Kegiatan</h3>
                    <p class="text-gray-500 mt-2">Anda bisa membuat kegiatan baru dengan menekan tombol "Tambah Kegiatan".</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $events->links() }}
        </div>

    </div>

    {{-- Script untuk konfirmasi Hapus --}}
    @push('scripts')
    <script>
        // Fungsi untuk SweetAlert konfirmasi hapus
        function confirmDelete(eventId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Kegiatan ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Merah
                cancelButtonColor: '#3085d6', // Biru
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form jika dikonfirmasi
                    document.getElementById('delete-form-' + eventId).submit();
                }
            });
        }
    </script>
    @endpush
</x-admin-layout>