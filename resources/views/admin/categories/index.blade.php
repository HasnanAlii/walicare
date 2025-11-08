<x-admin-layout>
    <div class="py-6 max-w-4xl mx-auto">

        {{-- PERUBAHAN: Navigasi Tab --}}
        <div class="mb-4 border-b border-gray-200">
            <nav class="flex -mb-px space-x-6" aria-label="Tabs">
            <a href="{{ route('admin.categories.index') }}"
               class="{{ request()->routeIs('admin.categories.*') ? 'border-green-600 text-green-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}
                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                Kategori Program
            </a>
                <a href="{{ route('admin.categoriesevents.index') }}"
                   class="{{ request()->routeIs('admin.categoriesevents.*') ? 'border-green-600 text-green-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}
                          whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Kategori Kegiatan
                </a>
            </nav>
        </div>

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-green-900">Daftar Kategori Program</h2>
            {{-- PERUBAHAN: Tombol dengan Ikon --}}
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-sm text-sm font-medium">
                <i data-feather="plus" class="w-4 h-4"></i>
                Tambah Kategori
            </a>
        </div>


        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full w-full">
                    {{-- PERUBAHAN: Styling Thead --}}
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $category->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $category->slug }}
                                </td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                {{-- Tombol Aksi (di tengah) --}}
                                <div class="flex justify-center items-center gap-2">
                                  <a href="{{ route('admin.categories.edit', $category) }}" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-100 text-blue-600 rounded-md hover:bg-blue-200 transition text-sm font-medium" 
                                    title="Edit">
                                        <i data-feather="edit-2" class="w-4 h-4"></i>
                                        Edit
                                    </a>


                                    <form id="delete-form-{{ $category->id }}" 
                                        action="{{ route('admin.categories.destroy', $category) }}" 
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDelete({{ $category->id }})" 
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-100 text-red-600 rounded-md hover:bg-red-200 transition text-sm font-medium" 
                                                title="Hapus">
                                                <i data-feather="trash-2" class="w-4 h-4"></i> Hapus
                                            </button>
                                    </form>
                                </div>
                            </td>

                            </tr>
                        @empty
                            {{-- PERUBAHAN: Empty State --}}
                            <tr>
                                <td colspan="3" class="text-center py-12">
                                    <div class="flex flex-col items-center">
                                        <i data-feather="grid" class="w-16 h-16 text-gray-400 mb-4"></i>
                                        <h3 class="text-xl font-semibold text-gray-700">Belum Ada Kategori</h3>
                                        <p class="text-gray-500 mt-2">Buat kategori baru dengan menekan tombol "Tambah Kategori".</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($categories->hasPages())
                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>

    </div>

    {{-- Script untuk konfirmasi Hapus --}}
    @push('scripts')
    <script>
        // Fungsi untuk SweetAlert konfirmasi hapus
        function confirmDelete(categoryId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Kategori ini akan dihapus! Program yang terkait tidak akan terhapus, hanya kategorinya saja.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Merah
                cancelButtonColor: '#3085d6', // Biru
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form jika dikonfirmasi
                    document.getElementById('delete-form-' + categoryId).submit();
                }
            });
        }
    </script>
    @endpush
</x-admin-layout>