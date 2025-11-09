<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WaliCare') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    

    @stack('styles')

    @php
        $defaultTitle = 'Wali Care - Platform Donasi Aman dan Transparan';
        $defaultDesc = 'Bantu wujudkan harapan mereka melalui donasi online yang mudah dan terpercaya bersama Wali Care.';
        $defaultImage = asset('storage/logo.jpg'); 
    @endphp

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="{{ $ogTitle ?? $defaultTitle }}">
    <meta property="og:description" content="{{ $ogDescription ?? $defaultDesc }}">
    <meta property="og:image" content="{{ $ogImage ?? $defaultImage }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ request()->url() }}">
    <meta name="twitter:title" content="{{ $ogTitle ?? $defaultTitle }}">
    <meta name="twitter:description" content="{{ $ogDescription ?? $defaultDesc }}">
    <meta name="twitter:image" content="{{ $ogImage ?? $defaultImage }}">
</head>
<body class="font-sans antialiased">

    <div class="min-h-screen flex flex-col bg-gray-100">

        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-grow">
            {{ $slot }}
        </main>

        @include('layouts.footer')

    </div>



    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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