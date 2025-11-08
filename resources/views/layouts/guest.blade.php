{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Perumdam Tirta Mukti') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- CATATAN: Untuk performa lebih baik, pindahkan ini ke halaman yang menggunakannya (misal: home) menggunakan @push('styles') --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased">

    {{-- Wrapper utama untuk sticky footer --}}
    <div class="min-h-screen flex flex-col bg-gray-100">

        {{-- Navigation --}}
        @include('layouts.navigation')

        {{-- Page Heading (Untuk halaman Dashboard, Profile, dll.) --}}
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Page Content --}}
        {{-- 'flex-grow' akan mendorong footer ke bawah pada halaman yang pendek --}}
        <main class="flex-grow">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        @include('layouts.footer')

    </div> {{-- /End .min-h-screen --}}


    {{-- Semua skrip dipindahkan ke sini untuk rendering yang lebih cepat --}}

    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>

    {{-- CATATAN: Untuk performa lebih baik, pindahkan ini ke halaman yang menggunakannya (misal: home) menggunakan @push('scripts') --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Hanya inisialisasi Swiper jika elemen .mySwiper ada di halaman ini
            // Ini mencegah error di halaman lain (spt Dashboard)
            if (document.querySelector(".mySwiper")) {
                new Swiper(".mySwiper", {
                    loop: true,
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false,
                    },
                    slidesPerView: 1,
                    spaceBetween: 0,
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                });
            }
        });
    </script>

    @stack('scripts')

</body>
</html>