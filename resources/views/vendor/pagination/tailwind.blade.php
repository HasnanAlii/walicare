@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex items-center justify-between">
        
        {{-- Mobile View --}}
        <div class="flex justify-between flex-1 sm:hidden">
            {{-- Tombol Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-md cursor-default">
                    ‹ Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-700 bg-white border border-green-200 rounded-md hover:bg-green-50 transition">
                    ‹ Sebelumnya
                </a>
            @endif

            {{-- Tombol Selanjutnya --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" 
                   class="inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-green-700 bg-white border border-green-200 rounded-md hover:bg-green-50 transition">
                    Selanjutnya ›
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-400 bg-gray-100 rounded-md cursor-default">
                    Selanjutnya ›
                </span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between mt-4 sm:mt-0">
            <div>
                <p class="text-sm text-gray-700">
                    Menampilkan 
                    @if ($paginator->firstItem())
                        <span class="font-semibold text-green-700">{{ $paginator->firstItem() }}</span>
                        sampai
                        <span class="font-semibold text-green-700">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    dari
                    <span class="font-semibold text-green-700">{{ $paginator->total() }}</span> hasil
                </p>
            </div>

            {{-- Navigasi Halaman --}}
            <div>
                <span class="relative z-0 inline-flex rounded-md shadow-sm">
                    
                    {{-- Tombol Sebelumnya --}}
                    @if ($paginator->onFirstPage())
                        <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-l-md cursor-not-allowed">
                            <i data-feather="chevron-left" class="w-4 h-4"></i>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-green-700 bg-white border border-green-200 rounded-l-md hover:bg-green-50 transition">
                            <i data-feather="chevron-left" class="w-4 h-4"></i>
                        </a>
                    @endif

                    {{-- Nomor Halaman --}}
                    @foreach ($elements as $element)
                        {{-- Separator “...” --}}
                        @if (is_string($element))
                            <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200">{{ $element }}</span>
                        @endif

                        {{-- Daftar Halaman --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-green-600 border border-green-600 text-white cursor-default">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" 
                                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-green-200 hover:bg-green-50 hover:text-green-600 transition">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Tombol Selanjutnya --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-green-700 bg-white border border-green-200 rounded-r-md hover:bg-green-50 transition">
                            <i data-feather="chevron-right" class="w-4 h-4"></i>
                        </a>
                    @else
                        <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-r-md cursor-not-allowed">
                            <i data-feather="chevron-right" class="w-4 h-4"></i>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>

    {{-- Script Feather Icons --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (typeof feather !== 'undefined') feather.replace();
        });
    </script>
@endif
