<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Donatur') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Pesan Selamat Datang --}}
            <div class="bg-white shadow-lg sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900">
                    Selamat datang, <span class="text-green-700">{{ Auth::user()->name }}</span> 👋
                </h3>
                <p class="mt-1 text-gray-600">
                    Terima kasih telah berdonasi dan mendukung berbagai program kebaikan kami.
                </p>
            </div>

            {{-- Statistik Donasi Pribadi --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Total Donasi --}}
                <div class="bg-white rounded-xl shadow-lg p-6 flex items-center gap-6">
                    <div class="flex-shrink-0 h-16 w-16 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                        <i data-feather="dollar-sign" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Donasi Anda</p>
                        <p class="text-2xl font-bold text-gray-900">
                            Rp {{ number_format($totalDonationUser ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- Jumlah Transaksi --}}
                <div class="bg-white rounded-xl shadow-lg p-6 flex items-center gap-6">
                    <div class="flex-shrink-0 h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                        <i data-feather="credit-card" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Transaksi</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalTransactions ?? 0 }}</p>
                    </div>
                </div>

                {{-- Program Didukung --}}
                <div class="bg-white rounded-xl shadow-lg p-6 flex items-center gap-6">
                    <div class="flex-shrink-0 h-16 w-16 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                        <i data-feather="heart" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Program yang Didukung</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $supportedPrograms ?? 0 }}</p>
                    </div>
                </div>

            </div>

            {{-- Donasi Terakhir --}}
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <h3 class="text-lg font-semibold text-gray-900 p-6 border-b border-gray-200">
                    Riwayat Donasi Terakhir
                </h3>

                @if(isset($recentDonations) && $recentDonations->count())
                    <div class="divide-y divide-gray-200">
                        @foreach($recentDonations as $donation)
                            <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition">
                                <div>
                                    <p class="font-semibold text-green-700">
                                        {{ $donation->program->title ?? 'Program Tidak Ditemukan' }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Rp {{ number_format($donation->amount, 0, ',', '.') }} &middot; 
                                        {{ $donation->created_at->format('d M Y') }}
                                    </p>
                                </div>
                                <span class="px-3 py-1 text-sm rounded-lg font-semibold
                                    {{ $donation->status === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-6 text-center text-gray-500">
                        Belum ada donasi yang tercatat.
                    </div>
                @endif
            </div>

            {{-- Aksi Cepat --}}
            <div class="bg-white shadow-lg rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('programs.index') }}" 
                       class="flex items-center gap-2 px-4 py-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition font-medium">
                        <i data-feather="gift" class="w-5 h-5"></i> Donasi Sekarang
                    </a>
                    <a href="{{ route('events.index') }}" 
                       class="flex items-center gap-2 px-4 py-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium">
                        <i data-feather="calendar" class="w-5 h-5"></i> Lihat Semua Kegitan
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- Script Feather Icons --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof feather !== 'undefined') feather.replace();
        });
    </script>
    @endpush
</x-guest-layout>
