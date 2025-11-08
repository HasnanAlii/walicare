<x-guest-layout>

    <div class="relative overflow-hidden" style="background: linear-gradient(135deg, #16a862, #28c76f);">
        <div class="absolute inset-0 opacity-15" style="background-image: url('{{ asset('storage/hero-background.jpg') }}'); background-size: cover; background-position: center;"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#16a862] via-transparent to-transparent opacity-50"></div>
        
        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-24 sm:py-32 text-center text-white z-10">
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight drop-shadow-md">
                Bantu Wujudkan Harapan Mereka
            </h1>
            <p class="mt-6 text-lg sm:text-xl max-w-2xl mx-auto drop-shadow-sm">
                Salurkan donasi Anda secara aman, transparan, dan mudah melalui Wali Care untuk membantu mereka yang membutuhkan.
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="{{ route('programs.index') }}" 
                   class="rounded-lg bg-white px-5 py-3 text-sm font-semibold text-[#16a862] shadow-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-[#16a862] transition">
                   Donasi Sekarang
                </a>
                <a href="#featured-programs" class="text-sm font-semibold leading-6 text-white hover:text-gray-200">
                    Lihat Program <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white py-12 sm:py-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center px-6">
                <div class="flex flex-col items-center">
                    <i data-feather="gift" class="w-12 h-12 text-yellow-500"></i>
                    <h3 class="mt-4 text-3xl font-bold text-gray-900">
                        Rp {{ number_format($totalDonation, 0, ',', '.') }}
                    </h3>
                    <p class="text-gray-600 mt-2 font-medium">Total Donasi Terkumpul</p>
                </div>
                <div class="flex flex-col items-center">
                    {{-- Ikon hijau diubah menjadi biru agar netral & serasi --}}
                    <i data-feather="users" class="w-12 h-12 text-blue-500"></i> 
                    <h3 class="mt-4 text-3xl font-bold text-gray-900">{{ $totalDonors }}</h3>
                    <p class="text-gray-600 mt-2 font-medium">Total Donatur</p>
                </div>
                <div class="flex flex-col items-center">
                    <i data-feather="target" class="w-12 h-12 text-blue-500"></i>
                    <h3 class="mt-4 text-3xl font-bold text-gray-900">{{ $totalPrograms }}</h3>
                    <p class="text-gray-600 mt-2 font-medium">Total Program Kebaikan</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 py-16 sm:py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            
            <div class="text-center mb-14">
                <h2 class="text-3xl font-bold text-gray-900">
                    Donasi Aman dan Mudah
                </h2>
                <div class="w-32 h-1 bg-gradient-to-r from-[#a8e6cf] to-[#dcedc1] mx-auto mt-3 rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col items-center text-center transition-transform duration-300 hover:scale-105">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-green-100 text-green-700 mb-5">
                        <i data-feather="search" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">1. Pilih Program</h3>
                    <p class="mt-2 text-gray-600 text-sm">Cari dan pilih program donasi yang ingin Anda bantu.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col items-center text-center transition-transform duration-300 hover:scale-105">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-green-100 text-green-700 mb-5">
                        <i data-feather="credit-card" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">2. Lakukan Donasi</h3>
                    <p class="mt-2 text-gray-600 text-sm">Isi nominal dan lakukan pembayaran dengan metode pilihan Anda.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col items-center text-center transition-transform duration-300 hover:scale-105">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-green-100 text-green-700 mb-5">
                        <i data-feather="check-circle" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">3. Lihat Laporan</h3>
                    <p class="mt-2 text-gray-600 text-sm">Pantau progres donasi Anda secara transparan melalui update kami.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-16 sm:py-20 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-16">
            
            <div id="featured-programs" class="px-4 sm:px-0">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">
                        Program Unggulan
                    </h2>
                    <div class="w-32 h-1 bg-gradient-to-r from-[#a8e6cf] to-[#dcedc1] mx-auto mt-3 rounded-full"></div>
                </div>

                @if($featuredPrograms->count())
                    <div class="grid md:grid-cols-3 gap-8">
                        @foreach($featuredPrograms as $program)
                            @php
                                $target = $program->target_amount ?? 0;
                                $collected = $program->collected_amount ?? 0;
                                $percentage = ($target > 0) ? min(100, ($collected / $target) * 100) : 0;
                            @endphp

                            <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col transition-transform duration-300 hover:scale-[1.03]">
                                <a href="{{ route('programs.show', $program->slug) }}">
                                    <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="w-full h-52 object-cover">
                                </a>
                                <div class="p-5 flex flex-col flex-grow">
                                    <h4 class="font-bold text-lg text-gray-800 leading-snug">
                                        <a href="{{ route('programs.show', $program->slug) }}" class="hover:text-green-700">
                                            {{ $program->title }}
                                        </a>
                                    </h4>
                                    
                                    <div class="mt-4">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="flex justify-between mt-2 text-sm">
                                            <span class="font-medium text-gray-700">Terkumpul:
                                                <span class="text-green-700 font-bold">Rp {{ number_format($collected, 0, ',', '.') }}</span>
                                            </span>
                                            <span class="font-medium text-gray-500">Target:
                                                <span>Rp {{ number_format($target, 0, ',', '.') }}</span>
                                            </span>
                                        </div>
                                    </div>

                                    <p class="text-sm text-gray-600 mt-3 line-clamp-3 flex-grow">{{ $program->summary ?? $program->description }}</p>
                                    
                                    <a href="{{ route('programs.show', $program->slug) }}" 
                                       class="block w-full text-center mt-6 bg-green-600 text-white font-semibold rounded-lg px-4 py-2.5 shadow hover:bg-green-700 transition">
                                        Donasi Sekarang
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-10">Belum ada program unggulan saat ini.</p>
                @endif
            </div>

            <div class="px-4 sm:px-0">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">
                        Program Terbaru
                    </h2>
                    <div class="w-32 h-1 bg-gradient-to-r from-[#a8e6cf] to-[#dcedc1] mx-auto mt-3 rounded-full"></div>
                </div>

                @if($latestPrograms->count())
                    <div class="grid md:grid-cols-3 gap-8">
                        @foreach($latestPrograms as $program)
                            @php
                                $target = $program->target_amount ?? 0;
                                $collected = $program->collected_amount ?? 0;
                                $percentage = ($target > 0) ? min(100, ($collected / $target) * 100) : 0;
                            @endphp

                            <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col transition-transform duration-300 hover:scale-[1.03]">
                                <a href="{{ route('programs.show', $program->slug) }}">
                                    <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="w-full h-52 object-cover">
                                </a>
                                <div class="p-5 flex flex-col flex-grow">
                                    <h4 class="font-bold text-lg text-gray-800 leading-snug">
                                        <a href="{{ route('programs.show', $program->slug) }}" class="hover:text-green-700">
                                            {{ $program->title }}
                                        </a>
                                    </h4>
                                    
                                    <div class="mt-4">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="flex justify-between mt-2 text-sm">
                                            <span class="font-medium text-gray-700">Terkumpul:
                                                <span class="text-green-700 font-bold">Rp {{ number_format($collected, 0, ',', '.') }}</span>
                                            </span>
                                            <span class="font-medium text-gray-500">Target:
                                                <span>Rp {{ number_format($target, 0, ',', '.') }}</span>
                                            </span>
                                        </div>
                                    </div>

                                    <p class="text-sm text-gray-600 mt-3 line-clamp-3 flex-grow">{{ $program->summary ?? $program->description }}</p>
                                    
                                    <a href="{{ route('programs.show', $program->slug) }}" 
                                       class="block w-full text-center mt-6 bg-green-600 text-white font-semibold rounded-lg px-4 py-2.5 shadow hover:bg-green-700 transition">
                                        Donasi Sekarang
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-10">Belum ada program terbaru.</p>
                @endif
            </div>

        </div>
    </div>

  
     <div class="py-16 sm:py-20 bg-white">
        <div class="relative max-w-7xl mx-auto py-16 px-6 sm:py-24 lg:px-8 text-center z-10">
            <h2 class="text-3xl font-extrabold text-green-600 drop-shadow-md">
                Siap Menjadi Bagian dari Kebaikan?
            </h2>
            <p class="mt-4 text-lg leading-6 text-green-600 drop-shadow-sm">
                Setiap donasi Anda, berapapun nilainya, sangat berarti untuk mengubah kehidupan mereka.
            </p>
            <a href="{{ route('programs.index') }}" 
               class="mt-8 inline-flex w-full sm:w-auto items-center justify-center rounded-lg bg-green-600 px-6 py-3 text-base font-medium text-white shadow-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-green-600 transition">
                Lihat Semua Program
            </a>
        </div>
    </div>
    
</x-guest-layout>