<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center text-center bg-red-50">
        <div class="bg-white shadow-lg rounded-2xl p-10 max-w-lg">
            <div class="text-red-600 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m-6 6a9 9 0 11-18 0a9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-red-700 mb-3">Pembayaran Gagal ❌</h1>
            <p class="text-gray-600 mb-6">
                Maaf, transaksi donasi Anda gagal diproses. Silakan coba lagi atau gunakan metode pembayaran lain.
            </p>
            <a href="{{ route('home') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg transition">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</x-guest-layout>
