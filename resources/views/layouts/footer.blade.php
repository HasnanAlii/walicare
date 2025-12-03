<footer class="relative bg-[#16a862] text-white overflow-hidden " aria-labelledby="footer-heading">
    
    {{-- Batik overlay (disamakan dengan header) --}}
    <div class="absolute inset-0 opacity-10" style="background-image: url('{{ asset('storage/batik.jpg') }}'); background-size: cover; background-repeat: repeat;"></div>
    
    <div class="relative max-w-7xl mx-auto py-16 px-6 lg:px-8 z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            
            <div class="md:col-span-2 lg:col-span-1">
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('storage/logo.jpg') }}" 
                             alt="Wali Care" 
                             class="h-14 w-auto shadow-md border-2 border-white">
                        <div>
                            <h3 class="text-2xl font-bold text-white">Wali Care</h3>
                            <p class="text-sm text-gray-200">Platform Donasi Aman</p>
                        </div>
                    </a>
                </div>
                <p class="mt-4 text-sm text-gray-200 leading-relaxed">
                    Membantu mewujudkan kebaikan melalui donasi online yang mudah, aman, dan terpercaya untuk mereka yang membutuhkan.
                </p>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-white tracking-wider uppercase">Navigasi</h4>
                <ul class="mt-4 space-y-3">
                    <li>
                        <a href="{{ route('home') }}" class="text-base text-gray-200 hover:text-white transition">Beranda</a>
                    </li>
                    <li>
                        <a href="{{ route('programs.index') }}" class="text-base text-gray-200 hover:text-white transition">Program Donasi</a>
                    </li>
                    <li>
                        <a href="{{ route('events.index') }}" class="text-base text-gray-200 hover:text-white transition">Kegiatan</a>
                    </li>
                    <li>
                        <a href="#" class="text-base text-gray-200 hover:text-white transition">Tentang Kami</a>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-white tracking-wider uppercase">Bantuan</h4>
                <ul class="mt-4 space-y-3">
                    <li>
                        <a class="text-base text-gray-200 hover:text-white transition">Pusat Bantuan (FAQ)</a>
                    </li>
                    <li>
                        <a class="text-base text-gray-200 hover:text-white transition">Kebijakan Privasi</a>
                    </li>
                    <li>
                        <a class="text-base text-gray-200 hover:text-white transition">Syarat & Ketentuan</a>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-white tracking-wider uppercase">Tetap Terhubung</h4>
                <p class="mt-4 text-base text-gray-200">
                    Ikuti kami di media sosial:
                </p>
                <div class="mt-4 flex space-x-4">
                    {{-- <a href="#" class="text-gray-200 hover:text-white transition">
                        <span class="sr-only">Facebook</span>
                        <i data-feather="facebook" class="w-6 h-6"></i>
                    </a> --}}
                    <a href="https://www.instagram.com/walicare/"  target="_blank"  class="text-gray-200 hover:text-white transition">
                        <span class="sr-only">Instagram</span>
                        <i data-feather="instagram" class="w-6 h-6"></i>
                    </a>
                    <a href="https://x.com/walicare"  target="_blank"  class="text-gray-200 hover:text-white transition">
                        <span class="sr-only">Twitter</span>
                        <i data-feather="twitter" class="w-6 h-6"></i>
                    </a>
                    <a href="https://www.youtube.com/channel/UCtyTY8d_YHFUEGKv-hmWkRQ/videos?view=0&sort=dd&shelf_id=0"   target="_blank"  class="text-gray-200 hover:text-white transition">
                        <span class="sr-only">YouTube</span>
                        <i data-feather="youtube" class="w-6 h-6"></i>
                    </a>
                </div>
                <p class="mt-6 text-sm text-gray-200">
                    Email: <a href="mailto:walicare.file@gmail.com"  class="hover:text-white hover:underline">walicare.file@gmail.com</a>
                </p>
            </div>

        </div>

        <div class="mt-12 border-t border-[#25b86d] pt-8 text-center">
            <p class="text-base text-gray-200">
                &copy; {{ date('Y') }} Wali Care. Dibuat dengan ❤️ untuk kebaikan.
            </p>
        </div>
    </div>
</footer>