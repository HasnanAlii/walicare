<x-admin-layout>
    <div class="py-6 max-w-7xl mx-auto">
        
        {{-- 1. HEADER HALAMAN --}}
        <div class="flex justify-between items-center mb-6 px-4 sm:px-0">
            <h2 class="text-2xl font-bold text-green-900">
                Daftar Mitra
            </h2>
            <a href="{{ route('admin.mitras.create') }}"
               class="px-5 py-2 bg-green-600 text-white rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all">
                <i data-feather="plus" class="inline-block w-4 h-4 mr-1 -mt-px"></i>
                Tambah Mitra
            </a>
        </div>

        {{-- 2. PESAN SUKSES --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-800 rounded-r-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- 3. CARD GRID --}}
        
        {{-- Cek apakah ada data. Jika tidak, tampilkan pesan 'empty state' --}}
        @if ($mitras->isEmpty())
            
            {{-- TAMPILAN JIKA KOSONG --}}
            <div class="bg-white rounded-lg shadow-md p-12 text-center border border-gray-100">
                <i data-feather="info" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-xl font-medium text-gray-700">Belum Ada Mitra</h3>
                <p class="text-gray-500 text-sm mt-2">
                    Klik tombol "Tambah Mitra" untuk mulai menambahkan data.
                </p>
            </div>

        @else

            {{-- TAMPILAN JIKA ADA DATA --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($mitras as $mitra)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col 
                                transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        
                        {{-- CARD BODY (Logo, Nama, URL) --}}
                        <div class="p-6 flex-1 flex flex-col items-center text-center"> 
                            
                            {{-- Logo Container --}}
                            <div class="h-36 mb-5 flex items-center justify-center">
                                @if ($mitra->logo)
                                    <img src="{{ asset('storage/' . $mitra->logo) }}" alt="{{ $mitra->name }}" 
                                         class="h-full w-full object-contain rounded-xl border-4 border-green-50 shadow-md">
                                @else
                                    {{-- Placeholder jika tidak ada logo --}}
                                    <div class="h-full w-full rounded-full bg-gray-100 flex items-center justify-center border-2 border-dashed border-gray-300">
                                        <i data-feather="briefcase" class="w-10 h-10 text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Nama --}}
                            <h3 class="text-xl font-semibold text-green-900">{{ $mitra->name }}</h3>
                            
                            {{-- URL --}}
                            <div class="mt-2 text-sm">
                                @if ($mitra->url)
                                    <a href="{{ $mitra->url }}" target="_blank" 
                                       class="text-blue-600 hover:underline break-all"
                                       title="Kunjungi {{ $mitra->url }}">
                                       {{ $mitra->url }}
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">Tidak ada URL</span>
                                @endif
                            </div>
                        </div>
                        
                        {{-- CARD FOOTER (Tombol Aksi) --}}
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 
                                    flex justify-center items-center gap-6">
                            
                            <a href="{{ route('admin.mitras.edit', $mitra) }}" 
                               class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                               Edit
                            </a>
                            
                            <span class="text-gray-300">|</span>

                            <form action="{{ route('admin.mitras.destroy', $mitra) }}" method="POST" class="inline m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-sm font-medium text-red-600 hover:text-red-800 transition-colors" 
                                        onclick="return confirm('Yakin hapus mitra ini: {{ $mitra->name }}?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

        @endif


        {{-- 4. PAGINASI --}}
        <div class="mt-8">
            {{ $mitras->links() }}
        </div>
    </div>

    {{-- Script untuk Feather Icons (karena kita menambahkannya) --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</x-admin-layout>