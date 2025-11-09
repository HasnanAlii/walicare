<nav class="bg-white border-gray-100 sticky top-0 w-full z-50">
    <div class="relative shadow-lg overflow-hidden pb-5" style="background: linear-gradient(135deg,#16a862,#28c76f);">
        <div class="absolute inset-0 opacity-10" style="background-image: url('{{ asset('storage/batik.jpg') }}'); background-size: cover; background-repeat: repeat;"></div>
        <div class="absolute inset-0 bg-black opacity-20"></div>

        <div class="relative max-w-7xl mx-auto px-4 py-4">
            <div class="flex flex-row items-center justify-between sm:hidden">
               <div class="flex items-center gap-3 flex-shrink-0">
                <img src="{{ asset('storage/logo.jpg') }}" 
                    alt="Wali Care" 
                    class="h-16 w-auto shadow-md border-2 border-white rounded-md">
                <div class="flex flex-col">
                    <h1 class="text-xl font-extrabold text-white drop-shadow-md">Wali Care</h1>
                    <div class="w-24 h-[3px] bg-gradient-to-r from-[#a8e6cf] to-[#dcedc1] my-1 rounded-full"></div>
                </div>
            </div>

                <div class="flex gap-1">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('admin.dashboard') }}" 
                               class="px-3 py-1.5 bg-white text-[#16a862] text-xs  font-semibold rounded-lg shadow hover:bg-[#f0fdf4] transition">
                               Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="px-3 py-1.5 bg-transparent border text-xs  border-white text-white font-semibold rounded-lg shadow hover:bg-white hover:text-[#16a862] transition">
                               Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                   class="px-3 py-1.5 bg-white text-[#16a862]  text-xs font-semibold rounded-lg shadow hover:bg-[#f0fdf4] transition">
                                   Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>

            <div class="sm:hidden mt-3 text-left">
                <p class="text-xs text-white drop-shadow-sm">Platform Donasi Aman dan Transparan</p>
                <p class="text-[10px] mt-1 text-white drop-shadow-sm">Bergabunglah untuk mewujudkan kebaikan melalui donasi online yang mudah</p>
            </div>

         <div class="hidden sm:flex sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex flex-row items-center gap-4 flex-1">
                    <div class="flex-shrink-0 z-10">
                        <img src="{{ asset('storage/logo.jpg') }}" 
                             alt="Wali Care" 
                             class="h-24 w-auto shadow-md rounded-md border-2 border-white">
                    </div>
                    <div class="flex-1 z-10 text-left">
                        <h1 class="text-3xl font-extrabold text-white drop-shadow-md">Wali Care</h1>
                        <div class="w-72 h-[3px] bg-gradient-to-r from-[#a8e6cf] to-[#dcedc1] my-2 rounded-full"></div>
                        <p class="text-sm text-white drop-shadow-sm">Platform Donasi Aman dan Transparan untuk Membantu Sesama</p>
                        <p class="text-xs mt-1 text-white drop-shadow-sm">Bergabunglah bersama kami untuk mewujudkan kebaikan melalui donasi online yang mudah dan terpercaya</p>
                    </div>
                </div>

                <div class="flex-shrink-0 z-10 flex items-center gap-2">
                    @if(Route::has('login'))
                        @auth
                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <div class="ml-3 relative">
                             <x-dropdown align="right" width="auto">
                                <x-slot name="trigger">
                                    <button class="flex items-center text-sm font-medium text-white hover:text-gray-200 focus:outline-none">
                                        <div>{{ Auth::user()->name }}</div>
                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="absolute right-0 mt-2 flex flex-row space-x-2 bg-white border border-gray-200 rounded-md shadow-lg z-50 px-2 py-1">
                                        <x-dropdown-link :href="route('admin.dashboard')">{{ __('Dashboard') }}</x-dropdown-link>
                                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                                        <form method="POST" action="{{ route('logout') }}" class="inline">@csrf
                                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Logout') }}</x-dropdown-link>
                                        </form>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-transparent border border-white text-white font-semibold rounded-lg shadow hover:bg-white hover:text-[#16a862] transition">Log in</a>
                            @if(Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-white text-[#16a862] font-semibold rounded-lg shadow hover:bg-[#f0fdf4] transition">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="bg-[#25b86d] text-white shadow-md" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto py-2 flex justify-between items-center px-4">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="sm:hidden p-2 rounded-lg hover:bg-[#a8e6cf] hover:text-black transition">
                <span class="sr-only">Buka menu</span>
                <i data-feather="menu" class="w-5 h-5" x-show="!mobileMenuOpen"></i>
                <i data-feather="x" class="w-5 h-5" x-show="mobileMenuOpen" x-cloak></i>
            </button>
            <div class="hidden sm:flex flex-wrap items-center space-x-2 sm:space-x-3">
                <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')" class="flex items-center gap-2 px-3 py-1 sm:px-4 sm:py-2 rounded-lg hover:bg-[#a8e6cf] hover:text-black transition duration-150 ease-in-out">
                    <i data-feather="home" class="w-4 h-4 sm:w-5 sm:h-5"></i><span class="text-xs sm:text-sm">Beranda</span>
                </x-nav-link>
                <x-nav-link href="{{ route('programs.index') }}" :active="request()->routeIs('programs.*')" class="flex items-center gap-2 px-3 py-1 sm:px-4 sm:py-2 rounded-lg hover:bg-[#dcedc1] hover:text-black transition duration-150 ease-in-out">
                    <i data-feather="grid" class="w-4 h-4 sm:w-5 sm:h-5"></i><span class="text-xs sm:text-sm">Program</span>
                </x-nav-link>
                <x-nav-link href="{{ route('events.index') }}" :active="request()->routeIs('events.*')" class="flex items-center gap-2 px-3 py-1 sm:px-4 sm:py-2 rounded-lg hover:bg-[#dcedc1] hover:text-black transition duration-150 ease-in-out">
                    <i data-feather="calendar" class="w-4 h-4 sm:w-5 sm:h-5"></i><span class="text-xs sm:text-sm">Kegiatan</span>
                </x-nav-link>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-[#dcedc1] hover:text-black transition duration-150 ease-in-out">
                        <i data-feather="info" class="w-4 h-4"></i><span class="text-sm font-medium">Tentang Kami</span><i data-feather="chevron-down" class="w-4 h-4"></i>
                    </button>
                    <div x-show="open" x-transition class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 z-50" x-cloak>
                        <ul class="py-2 text-sm text-gray-700">
                            <li><a href="{{ route('tentang') }}" class="block px-4 py-2 hover:bg-[#dcedc1]">Tentang Kami</a></li>
                            <li><a href="{{ route('sejarah') }}" class="block px-4 py-2 hover:bg-[#dcedc1]">Sejarah WaliCare</a></li>
                            <li><a href="{{ route('kontak') }}" class="block px-4 py-2 hover:bg-[#dcedc1]">Kontak Kami</a></li>
                            <li><a href="{{ route('mitra.index') }}" class="block px-4 py-2 hover:bg-[#dcedc1]">Mitra Kami</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <form action="{{ route('programs.index') }}" method="GET" class="ml-auto flex items-center justify-end w-auto md:w-auto">
                <div class="relative w-44 md:w-64 ">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Program..." class="w-full pl-4 pr-10 py-1.5 text-sm rounded-lg border border-transparent focus:border-green-400 focus:ring-2 focus:ring-green-300 focus:outline-none text-gray-700 placeholder-gray-400">
                    <button type="submit" class="absolute right-0 top-0 h-full flex items-center pr-3 text-gray-400 hover:text-green-600">
                        <i data-feather="search" class="w-4 h-4"></i>
                    </button>
                </div>
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
            </form>
        </div>

        <div x-show="mobileMenuOpen" x-cloak class="sm:hidden w-full flex flex-col px-4 pb-4 space-y-2">
            <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#a8e6cf] hover:text-black transition duration-150 ease-in-out">
                <i data-feather="home" class="w-5 h-5"></i><span class="text-sm font-medium">Beranda</span>
            </x-nav-link>
            <x-nav-link href="{{ route('programs.index') }}" :active="request()->routeIs('programs.*')" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#dcedc1] hover:text-black transition duration-150 ease-in-out">
                <i data-feather="layers" class="w-5 h-5"></i><span class="text-sm font-medium">Program</span>
            </x-nav-link>
            <x-nav-link href="{{ route('events.index') }}" :active="request()->routeIs('events.*')" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#dcedc1] hover:text-black transition duration-150 ease-in-out">
                <i data-feather="calendar" class="w-5 h-5"></i><span class="text-sm font-medium">Kegiatan</span>
            </x-nav-link>
            <x-nav-link href="{{ route('tentang') }}" :active="request()->routeIs('tentang')" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#dcedc1] hover:text-black transition duration-150 ease-in-out">
                <i data-feather="info" class="w-5 h-5"></i><span class="text-sm font-medium">Tentang Kami</span>
            </x-nav-link>
            <x-nav-link href="{{ route('sejarah') }}" :active="request()->routeIs('sejarah')" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#dcedc1] hover:text-black transition duration-150 ease-in-out">
                <i data-feather="book" class="w-5 h-5"></i><span class="text-sm font-medium">Sejarah WaliCare</span>
            </x-nav-link>
            <x-nav-link href="{{ route('mitra.index') }}" :active="request()->routeIs('mitra.*')" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#dcedc1] hover:text-black transition duration-150 ease-in-out">
                <i data-feather="users" class="w-5 h-5"></i><span class="text-sm font-medium">Mitra Kami</span>
            </x-nav-link>
            <x-nav-link href="{{ route('kontak') }}" :active="request()->routeIs('kontak')" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#dcedc1] hover:text-black transition duration-150 ease-in-out">
                <i data-feather="phone" class="w-5 h-5"></i><span class="text-sm font-medium">Kontak Kami</span>
            </x-nav-link>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (typeof feather !== 'undefined') feather.replace();
        });
    </script>

    <div class="w-full h-1 bg-[#a8e6cf]"></div>
</nav>
