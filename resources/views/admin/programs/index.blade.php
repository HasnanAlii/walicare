<x-admin-layout>
    <div class="py-6">
        
        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-green-900">Daftar Program</h2>
            <a href="{{ route('admin.programs.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-sm text-sm font-medium">
                <i data-feather="plus" class="w-4 h-4"></i>
                Tambah Program
            </a>
        </div>

        {{-- Grid Daftar Program --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @php
                $statusClasses = [
                    'draft' => 'bg-gray-200 text-gray-800',
                    'active' => 'bg-green-200 text-green-800',
                    'completed' => 'bg-blue-200 text-blue-800',
                    'cancelled' => 'bg-red-200 text-red-800',
                ];
            @endphp

            @forelse($programs as $program)
                @php
                    $collected = $program->collected_amount ?? 0;
                    $target = $program->target_amount ?? 0;
                    $percentage = ($target > 0) ? min(100, ($collected / $target) * 100) : 0;
                @endphp

                {{-- Card Program --}}
                <div class="bg-white rounded-xl shadow border border-gray-200 hover:shadow-xl transition-shadow duration-300 flex flex-col overflow-hidden relative">
                    
                    {{-- Label Unggulan --}}
                    @if($program->is_featured)
                        <div class="absolute top-0 right-0 z-10">
                            <span class="inline-flex items-center gap-1 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-bl-lg">
                                <i data-feather="star" class="w-3 h-3 fill-current"></i> Unggulan
                            </span>
                        </div>
                    @endif

                    {{-- Gambar Program --}}
                    <div class="w-full">
                        @if($program->image)
                            <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="w-full h-96 object-cover aspect-video">
                        @else
                            <div class="w-full h-48 bg-green-50 flex items-center justify-center">
                                <i data-feather="image" class="w-16 h-16 text-green-300"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Konten --}}
                    <div class="p-5 flex-1 flex flex-col">
                        {{-- Kategori & Status --}}
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-green-700">
                                {{ $program->category->name ?? 'Tanpa Kategori' }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold capitalize {{ $statusClasses[$program->status] ?? 'bg-gray-200 text-gray-800' }}">
                                {{ $program->status }}
                            </span>
                        </div>

                        {{-- Judul --}}
                        <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2">{{ $program->title }}</h3>

                        {{-- Progress Donasi --}}
                        <div class="mb-4">
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-1.5 overflow-hidden">
                                <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <div class="flex justify-between text-sm font-medium text-gray-700">
                                <span>Rp {{ number_format($collected, 0, ',', '.') }}</span>
                                <span class="text-green-800 font-semibold">{{ number_format($percentage, 0) }}%</span>
                            </div>
                            <div class="text-xs text-gray-500 mt-0.5">
                                Target: Rp {{ number_format($target, 0, ',', '.') }}
                            </div>
                        </div>

                        {{-- Info Tanggal & Lokasi --}}
                        <div class="text-sm text-gray-500 mb-4 border-t pt-3 mt-auto">
                            <div class="flex items-center gap-2 mb-1">
                                <i data-feather="calendar" class="w-4 h-4"></i>
                                <span>{{ $program->start_date?->format('d M Y') ?? 'N/A' }} - {{ $program->end_date?->format('d M Y') ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-feather="map-pin" class="w-4 h-4"></i>
                                <span>{{ $program->location ?? '-' }}</span>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex gap-2 mt-2 flex-wrap">
                            <a href="{{ route('admin.programs.show', $program) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-xs font-medium transition">
                                <i data-feather="eye" class="w-4 h-4"></i> Detail
                            </a>
                            <a href="{{ route('admin.programs.edit', $program) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-xs font-medium transition">
                                <i data-feather="edit-2" class="w-4 h-4"></i> Edit
                            </a>
                            <form id="delete-form-{{ $program->id }}" action="{{ route('admin.programs.destroy', $program) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $program->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 text-xs font-medium transition">
                                    <i data-feather="trash-2" class="w-4 h-4"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Jika kosong --}}
                <div class="col-span-full bg-white p-12 rounded-lg shadow border border-gray-200 text-center">
                    <i data-feather="alert-circle" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700">Belum Ada Program</h3>
                    <p class="text-gray-500 mt-2">Anda bisa membuat program baru dengan menekan tombol "Tambah Program".</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $programs->links() }}
        </div>

    </div>

    {{-- Script Konfirmasi Hapus --}}
    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof feather !== 'undefined') feather.replace();
        });

        function confirmDelete(programId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Program ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + programId).submit();
                }
            });
        }
    </script>
    @endpush
</x-admin-layout>
