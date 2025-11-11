<x-guest-layout>
    {{-- Latar belakang diubah menjadi abu-abu muda untuk kontras --}}
    <div class="mt-4 flex flex-col items-center justify-center bg-gray-100 py-10 px-4">
        
        {{-- CARD UTAMA --}}
        <div id="receipt" class="bg-white shadow-xl rounded-2xl p-8 sm:p-10 max-w-2xl w-full border border-gray-200">
            
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/logo.jpg') }}" alt="Logo WaliCare" class="h-16 w-auto">
            </div>

            <div class="text-center border-b border-gray-200 pb-6 mb-6">
                <div class="flex justify-center items-center gap-3">
                    {{-- Ikon Sukses --}}
                    <i data-feather="check-circle" class="w-9 h-9 text-green-500"></i>
                    <h1 class="text-3xl font-bold text-green-700">Donasi Diterima</h1>
                </div>
                <p class="text-gray-500 mt-2">Terima kasih atas kebaikan Anda!</p>
            </div>

            <div class="space-y-3 text-base sm:text-lg text-gray-700">
                <div class="flex justify-between">
                    <span class="text-gray-500">Nama Donatur:</span>
                    <span class="font-semibold text-gray-800">{{ $donation->donor_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Email:</span>
                    <span class="font-semibold text-gray-800">{{ $donation->donor_email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Program:</span>
                    <span class="font-semibold text-gray-800 text-right">{{ $donation->program->title ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal:</span>
                    <span class="font-semibold text-gray-800">{{ $donation->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status:</span>
                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-sm font-semibold
                    @if($donation->status == 'confirmed') bg-green-100 text-green-700 border border-green-300
                    @elseif($donation->status == 'pending') bg-yellow-100 text-yellow-700 border border-yellow-300
                    @else bg-red-100 text-red-700 border border-red-300
                    @endif
                ">
                    @if($donation->status == 'confirmed')
                         Donasi Sukses
                    @elseif($donation->status == 'pending')
                         Menunggu Pembayaran
                    @else
                         Donasi Gagal
                    @endif
                </span>

                        {{-- {{ ucfirst($donation->status) }} --}}
                    </span>
                </div>
            </div>

            <div class="mt-8 bg-green-50 rounded-xl p-6 flex justify-between items-center">
                <h2 class="text-xl sm:text-2xl font-bold text-green-800">Total Donasi:</h2>
                <h2 class="text-2xl sm:text-3xl font-bold text-green-600">
                    Rp {{ number_format($donation->amount, 0, ',', '.') }}
                </h2>
            </div>

            <div class="text-center mt-10 flex flex-col sm:flex-row gap-3 justify-center">
                        
                {{-- Tombol Kembali --}}
                <a href="{{ route('programs.index') }}" 
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition font-semibold">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

        <footer class="text-gray-500 mt-8 text-sm text-center">
            <p>&copy; {{ date('Y') }} WaliCare Foundation. Semua hak dilindungi.</p>
        </footer>
    </div>

</x-guest-layout>