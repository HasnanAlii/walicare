<x-guest-layout>
    <div class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-6">

            {{-- 1. HEADER HALAMAN --}}
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-extrabold text-green-700 mb-4 tracking-wide">
                    Kontak Kami
                </h1>
                <div class="w-32 h-1 bg-green-600 mx-auto rounded-full my-2"></div>

                <p class="text-lg text-gray-600 max-w-lg mx-auto">
                    “Terhubung bersama untuk menebar kebaikan.”
                </p>
            </div>

            {{-- 2. GRID KONTAK 2x2 --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- KARTU 1: TELEPON --}}
                <a href="tel:081283388451"
                   class="block bg-white p-8 rounded-2xl shadow-lg text-center 
                          transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    
                    <div class="w-16 h-16 bg-green-100 text-green-700 rounded-full 
                                flex items-center justify-center mx-auto mb-5">
                        <i data-feather="phone" class="w-8 h-8"></i>
                    </div>
                    
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Telepon</h3>
                    <p class="text-lg text-green-700 font-medium">0812 8338 8451</p>
                </a>

                {{-- KARTU 2: EMAIL --}}
                <a href="mailto:walicare.file@gmail.com"
                   class="block bg-white p-8 rounded-2xl shadow-lg text-center 
                          transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    
                    <div class="w-16 h-16 bg-green-100 text-green-700 rounded-full 
                                flex items-center justify-center mx-auto mb-5">
                        <i data-feather="mail" class="w-8 h-8"></i>
                    </div>
                    
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Email</h3>
                    <p class="text-lg text-green-700 font-medium break-all">walicare.file@gmail.com</p>
                </a>

                {{-- KARTU 3: INSTAGRAM --}}
                <a href="https://instagram.com/walicare" target="_blank"
                   class="block bg-white p-8 rounded-2xl shadow-lg text-center 
                          transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    
                    <div class="w-16 h-16 bg-green-100 text-green-700 rounded-full 
                                flex items-center justify-center mx-auto mb-5">
                        <i data-feather="instagram" class="w-8 h-8"></i>
                    </div>
                    
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Instagram</h3>
                    <p class="text-lg text-green-700 font-medium">@walicare</p>
                </a>

                {{-- KARTU 4: ALAMAT --}}
                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode('Jl. Masjid Al-Latief No. 99 Kademangan Setu') }}" 
                   target="_blank"
                   class="block bg-white p-8 rounded-2xl shadow-lg text-center 
                          transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    
                    <div class="w-16 h-16 bg-green-100 text-green-700 rounded-full 
                                flex items-center justify-center mx-auto mb-5">
                        <i data-feather="map-pin" class="w-8 h-8"></i>
                    </div>
                    
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Alamat</h3>
                    <p class="text-base text-gray-700 leading-relaxed">
                        Jl. Masjid Al-Latief No. 99<br>
                        RT 06/02 Kel. Kademangan, Kec. Setu,<br>
                        Kota Tangerang Selatan
                    </p>
                </a>

            </div>
            
        </div>
    </div>

    {{-- Feather Icons --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</x-guest-layout>