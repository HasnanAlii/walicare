<x-guest-layout>

    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 space-y-8">

            <div>
              <h2 class="text-3xl font-bold text-green-800">Program Kebaikan Kami</h2>
              <p class="mt-2 text-gray-600">Jelajahi berbagai program sosial yang dapat Anda dukung untuk menciptakan perubahan nyata.</p>


                
                {{-- <form action="{{ route('programs.index') }}" method="GET" class="mt-6">
                    <div class="relative w-full md:w-1/2">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Ketik lalu Enter..." 
                            class="w-full pr-10 pl-4 py-3 rounded-lg border border-gray-300 shadow-sm 
                                focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none"
                        >

                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i data-feather="search" class="w-5 h-5 text-gray-400"></i>
                        </div>
                    </div>

                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                </form> --}}
            </div>


            <div class="flex flex-wrap gap-2">
                <a href="{{ route('programs.index', ['search' => request('search')]) }}" 
                   class="px-4 py-1.5 rounded-full font-medium transition
                          {{ !request('category') ? 'bg-green-600 text-white shadow-sm' : 'bg-white text-gray-700 border hover:bg-gray-50' }}">
                    Semua Kategori
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('programs.index', ['category' => $category->slug, 'search' => request('search')]) }}" 
                       class="px-4 py-1.5 rounded-full font-medium transition
                              {{ request('category') == $category->slug ? 'bg-green-600 text-white shadow-sm' : 'bg-white text-gray-700 border hover:bg-gray-50' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            @if($programs->count())
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($programs as $program)
                        
                        @php
                            $target = $program->target_amount ?? 0;
                            $collected = $program->collected_amount ?? 0;
                            $percentage = $target > 0 ? (($collected / $target) * 100) : 0;
                            $percentage = min($percentage, 100);
                        @endphp


                        {{-- Ini adalah Kartu Program yang baru (sama seperti di Landing Page) --}}
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col transition-transform duration-300 hover:scale-[1.03]">
                            
                            <a href="{{ route('programs.show', $program->slug) }}" class="block">
                                <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="w-full h-80 ">
                            </a>
                            
                            <div class="p-5 flex flex-col flex-grow">
                                <h4 class="font-bold text-lg text-gray-800 leading-snug">
                                    <a href="{{ route('programs.show', $program->slug) }}" class="hover:text-green-700">{{ $program->title }}</a>
                                </h4>
                                
                                <div class="mt-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <div class=" mt-2 text-md">
                                        <span class="font-medium text-gray-500 flex items-center gap-1 leading-none py-1">
                                        <span>Target:</span>
                                        @if ($target == 0)
                                            {{-- Ikon tanpa batas (infinity) --}}
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor"
                                                class="w-4 h-4 text-green-600 ">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M18.364 5.636a9 9 0 010 12.728M5.636 5.636a9 9 0 000 12.728m0 0L18.364 5.636m0 12.728L5.636 5.636" />
                                            </svg>
                                            <span class="text-green-600">Tanpa Batas</span>
                                        @else
                                            <span>Rp {{ number_format($target, 0, ',', '.') }}</span>
                                        @endif
                                    </span>
                                    <span class="font-medium text-gray-700 mt-3">Terkumpul:
                                            <span class="text-green-700 font-bold text-lg">Rp {{ number_format($collected, 0, ',', '.') }}</span>
                                    </span>

                                    </div>
                                </div>

                                <p class="text-sm text-gray-600 mt-3 line-clamp-3 flex-grow">{{ $program->summary ?? $program->description }}</p>
                                
                                <a href="{{ route('programs.show', $program->slug) }}" 
                                   class="block w-full text-center mt-5 bg-green-600 text-white font-semibold rounded-lg px-4 py-2.5 shadow hover:bg-green-700 transition">
                                    Donasi Sekarang
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $programs->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center bg-white p-10 rounded-lg shadow-sm col-span-1 md:col-span-2 lg:col-span-3">
                    <div class="flex justify-center mb-4">
                        <i data-feather="search" class="w-16 h-16 text-gray-300"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700">Program Tidak Ditemukan</h3>
                    <p class="text-gray-500 mt-2">Maaf, kami tidak dapat menemukan program yang Anda cari. <br> Coba ubah kata kunci atau filter kategori Anda.</p>
                </div>
            @endif
        </div>
    </div>

        

</x-guest-layout>