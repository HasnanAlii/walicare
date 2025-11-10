<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 1. Pesan Selamat Datang --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    Selamat datang kembali, 
                    <strong class="text-green-700">{{ Auth::user()->name }}</strong> 👋
                </div>
            </div>

            {{-- 2. Statistik Donasi --}}
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Overview Donasi</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    {{-- Total Donasi --}}
                    <div class="bg-white rounded-xl shadow-lg p-6 flex items-center gap-6">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-green-100 text-green-600">
                            <i data-feather="dollar-sign" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Donasi</p>
                            <p class="text-2xl font-bold text-gray-900">
                                Rp {{ number_format($totalDonation ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Program Aktif --}}
                    <div class="bg-white rounded-xl shadow-lg p-6 flex items-center gap-6">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 text-blue-600">
                            <i data-feather="grid" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Program Aktif</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $activeProgramsCount ?? 0 }}</p>
                        </div>
                    </div>

                    {{-- Total Donatur --}}
                    <div class="bg-white rounded-xl shadow-lg p-6 flex items-center gap-6">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 text-yellow-600">
                            <i data-feather="users" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Donatur</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalDonors ?? 0 }}</p>
                        </div>
                    </div>

                    {{-- Total Mitra --}}
                    <div class="bg-white rounded-xl shadow-lg p-6 flex items-center gap-6">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600">
                            <i data-feather="briefcase" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Mitra</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalMitras ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. Konten Utama --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Program Terbaru --}}
                <div class="lg:col-span-2 bg-white rounded-xl shadow-lg overflow-hidden">
                    <h3 class="text-lg font-semibold text-gray-900 p-6 border-b border-gray-200">
                        Program Terbaru Ditambahkan
                    </h3>

                    <div class="divide-y divide-gray-200">
                        @forelse($recentPrograms ?? [] as $program)
                            <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-4">
                                    <img src="{{ asset('storage/' . $program->image) }}" 
                                         alt="{{ $program->title }}" 
                                         class="w-16 h-16 object-cover rounded-lg">
                                    <div>
                                        <p class="font-semibold text-green-700">{{ $program->title }}</p>
                                       <p class="text-sm text-gray-500 flex items-center gap-1 leading-none">
    <span>Target:</span>

    @if ($program->target_amount == 0)
        {{-- Ikon tanpa batas (infinity) --}}
        <svg xmlns="http://www.w3.org/2000/svg" 
            fill="none" viewBox="0 0 24 24" 
            stroke-width="2" stroke="currentColor" 
            class="w-4 h-4 text-green-600">
            <path stroke-linecap="round" stroke-linejoin="round" 
                d="M18.364 5.636a9 9 0 010 12.728M5.636 5.636a9 9 0 000 12.728m0 0L18.364 5.636m0 12.728L5.636 5.636" />
        </svg>
        <span class="text-green-600">Tanpa Batas</span>
    @else
        <span>Rp {{ number_format($program->target_amount, 0, ',', '.') }}</span>
    @endif
</p>

                                    </div>
                                </div>
                                <a href="{{ route('admin.programs.show', $program->slug) }}" 
                                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition">
                                    Lihat
                                </a>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500">
                                Belum ada program terbaru.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Aksi Cepat --}}
                <div class="lg:col-span-1 bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.programs.create') }}" 
                           class="flex items-center gap-3 p-4 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition font-medium">
                            <i data-feather="plus-circle" class="w-5 h-5"></i>
                            Tambah Program Baru
                        </a>
                        <a href="{{ route('admin.events.create') }}" 
                           class="flex items-center gap-3 p-4 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium">
                            <i data-feather="calendar" class="w-5 h-5"></i>
                            Tambah Kegiatan Baru
                        </a>
                        <a href="{{ route('admin.mitras.index') }}" 
                           class="flex items-center gap-3 p-4 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition font-medium">
                            <i data-feather="briefcase" class="w-5 h-5"></i>
                            Kelola Mitra
                        </a>
                        <a href="{{ route('admin.categories.index') }}" 
                           class="flex items-center gap-3 p-4 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition font-medium">
                            <i data-feather="layers" class="w-5 h-5"></i>
                            Kelola Kategori
                        </a>
                        <a href="{{ route('admin.program_uses.export.pdf') }}"  target="_blank"
                           class="flex items-center gap-3 p-4 bg-yellow-50 text-yellow-700 rounded-lg hover:bg-yellow-100 transition font-medium">
                            <i data-feather="bar-chart-2" class="w-5 h-5"></i>
                            Laporan Donasi
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (typeof feather !== 'undefined') feather.replace();
        });
    </script>
    @endpush
</x-admin-layout>
