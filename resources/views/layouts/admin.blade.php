<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    <link rel="icon" href="{{ asset('storage/logo.jpg') }}" type="image/png">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>


    <!-- Feather Icons -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <!-- jQuery & Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- FontAwesome (opsional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-green-50 flex min-h-screen font-sans">

    <aside class="w-64 bg-green-600 text-white flex flex-col shadow-lg">
       <div class="p-6 flex flex-col items-center gap-2 border-b border-green-500">
          <a href="{{ route('home') }}">
         <img src="{{ asset('storage/logo.jpg') }}" alt="Logo" class="h-20 w-20 shadow-md">
        </a>
            <span class="text-xl font-bold tracking-wide text-center text-white mt-2">Walicare Admin</span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="nav-item @if(request()->routeIs('admin.dashboard')) active @endif">
                <i data-feather="home"></i> Beranda
            </a>
            <a href="{{ route('admin.programs.index') }}" class="nav-item @if(request()->routeIs('admin.programs.*')) active @endif">
                <i data-feather="layers"></i> Program
            </a>
            {{-- <a href="{{ route('admin.milestones.index') }}" class="nav-item @if(request()->routeIs('admin.milestones.*')) active @endif">
                <i data-feather="flag"></i> Tonggak Pencapaian
            </a> --}}
            {{-- <a href="{{ route('admin.donations.index') }}" class="nav-item @if(request()->routeIs('admin.donations.*')) active @endif">
                <i data-feather="dollar-sign"></i> Donasi
            </a> --}}
            <a href="{{ route('admin.beneficiaries.index') }}" class="nav-item @if(request()->routeIs('admin.beneficiaries.*')) active @endif">
                <i data-feather="users"></i> Penerima Donasi
            </a>
            <a href="{{ route('admin.events.index') }}" class="nav-item @if(request()->routeIs('admin.events.*')) active @endif">
                <i data-feather="calendar"></i> Kegiatan
            </a>
           <a href="{{ route('admin.categories.index') }}" class="nav-item 
                    @if(request()->routeIs('admin.categories.*') || request()->routeIs('admin.categoriesvents.*')) 
                        active 
                    @endif">
                <i data-feather="grid"></i> Kategori
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-h-screen">
        <header class="bg-white shadow-sm border-b border-gray-200 p-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
            
                <h1 class="text-xl font-bold text-gray-800 ml-5">@yield('title', 'Dashboard Admin')</h1>
            </div>
            <div class="flex items-center gap-4 mr-5">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-gray-700 font-medium hover:text-green-600 focus:outline-none gap-2">
                            <i data-feather="user"></i> {{ auth()->user()->name }}
                            <i data-feather="chevron-down" class="w-4 h-4"></i>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                            <i data-feather="user" class="w-4 h-4"></i> Profil
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    class="flex items-center gap-2"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                <i data-feather="log-out" class="w-4 h-4"></i> Keluar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </header>
        <main class="p-6 flex-1 bg-green-50">
            {{ $slot }}
        </main>
    </div>

    <style>
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            color: white;
            transition: all 0.2s ease;
        }
        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }
        .nav-item.active {
            background-color: #d9f5e1; /* hijau muda lembut */
            color: #16a862;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if(typeof feather !== 'undefined') feather.replace();
        });
    </script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });

        @if(Session::has('message'))
            let type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
                case 'info':
                    Toast.fire({ icon: 'info', title: "{{ Session::get('message') }}" }); break;
                case 'success':
                    Toast.fire({ icon: 'success', title: "{{ Session::get('message') }}" }); break;
                case 'warning':
                    Toast.fire({ icon: 'warning', title: "{{ Session::get('message') }}" }); break;
                case 'error':
                    Toast.fire({ icon: 'error', title: "{{ Session::get('message') }}" }); break;
            }
        @endif

        @if ($errors->any())
            let errors = `<ul class="text-left">`;
            @foreach ($errors->all() as $error)
                errors += `<li>{{ $error }}</li>`;
            @endforeach
            errors += `</ul>`;
            Swal.fire({ icon: 'error', title: "Ooops!", html: errors });
        @endif
    </script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });

        @if(Session::has('message'))
            let type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
                case 'info':
                    Toast.fire({ icon: 'info', title: "{{ Session::get('message') }}" }); break;
                case 'success':
                    Toast.fire({ icon: 'success', title: "{{ Session::get('message') }}" }); break;
                case 'warning':
                    Toast.fire({ icon: 'warning', title: "{{ Session::get('message') }}" }); break;
                case 'error':
                    Toast.fire({ icon: 'error', title: "{{ Session::get('message') }}" }); break;
            }
        @endif

        @if ($errors->any())
            let errors = `<ul class="text-left">`;
            @foreach ($errors->all() as $error)
                errors += `<li>{{ $error }}</li>`;
            @endforeach
            errors += `</ul>`;
            Swal.fire({ icon: 'error', title: "Ooops!", html: errors });
        @endif
    </script>
    @stack('scripts')
</body>
</html>
