<x-guest-layout>
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- PERUBAHAN: Header di-tengah untuk keseimbangan --}}
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-extrabold text-green-700 leading-tight">
                    Partner & Mitra Kami
                </h1>
                <div class="w-32 h-1 bg-green-600 mx-auto rounded-full my-2"></div>

                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Kami berterima kasih atas dukungan para mitra yang bekerja sama untuk membangun kebaikan bersama.
                </p>
            </div>


            @if ($mitras->isEmpty())
                <div class="text-center text-gray-500 py-20 bg-white rounded-lg shadow-md">
                    <i data-feather="box" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                    <p class="text-xl font-medium">Belum ada mitra yang terdaftar.</p>
                    <p class="text-gray-500 mt-2">Nantikan kehadiran partner-partner hebat kami lainnya!</p>
                </div>
            @else
                {{-- PERUBAHAN: Grid dibuat tidak terlalu padat (lg:grid-cols-4) --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($mitras as $mitra)
                        <a @if ($mitra->url) href="{{ $mitra->url }}" target="_blank" @endif
                           class="bg-white shadow-md rounded-xl p-6 flex flex-col items-center justify-center text-center
                                  relative overflow-hidden group
                                  transform transition-all duration-300
                                  @if ($mitra->url) hover:shadow-xl hover:-translate-y-1 @else cursor-default @endif">
                            
                            {{-- PERUBAHAN: Container logo sedikit lebih kecil (h-20) --}}
                            <div class="h-36 w-full  flex items-center justify-center mb-5">
                                @if ($mitra->logo)
                                    <img src="{{ asset('storage/' . $mitra->logo) }}"
                                         alt="{{ $mitra->name }}"
                                         class="h-full w-full object-contain rounded-xl
                                                transform transition-transform duration-300 group-hover:scale-105">
                                @else
                                    {{-- PERUBAHAN: Ikon placeholder diganti --}}
                                    <div class="h-20 w-20 flex items-center justify-center bg-gray-100 rounded-lg text-gray-400 border border-dashed border-gray-300">
                                        <i data-feather="briefcase" class="w-10 h-10"></i>
                                    </div>
                                @endif
                            </div>

                            <h3 class="text-base font-semibold text-gray-800 line-clamp-2"> 
                                {{ $mitra->name }}
                            </h3>

                            {{-- Overlay tetap ada, ini adalah sentuhan yang bagus --}}
                            @if ($mitra->url)
                                <div class="absolute inset-0 bg-green-700 bg-opacity-80 flex items-center justify-center p-4 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="text-white text-sm font-medium">Kunjungi Situs</span>
                                D. h-20 </div>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    
    {{-- Pastikan Feather Icons dimuat --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</x-guest-layout>