<x-guest-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white shadow-lg rounded-xl p-6 md:p-10 text-center">

                <div class="flex justify-center mb-5">
                    <i data-feather="check-circle" class="w-20 h-20 text-green-500"></i>
                </div>

                <h1 class="text-3xl font-bold text-gray-900">Donasi Anda Segera Diproses!</h1>
                <p class="text-gray-600 mt-3 text-lg">
                    Terima kasih, <span class="font-bold">{{ $donation->donor_name }}</span>.
                    Satu langkah lagi untuk menyelesaikan donasi Anda.
                </p>

                <div class="mt-8 bg-green-50 border-2 border-green-200 rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-700">Jumlah yang harus dibayar (termasuk kode unik):</p>
                    <p class="text-4xl font-extrabold text-green-700 my-2 tracking-tight">
                        Rp {{ number_format($donation->amount, 0, ',', '.') }}
                    </p>
                    <p class="text-red-600 font-medium text-sm">
                        *Mohon transfer dengan jumlah yang **sama persis** untuk verifikasi otomatis.
                    </p>
                </div>

                @if($paymentInfo)
                <div class="mt-8 text-left border-t pt-8">
                    <h2 class="text-xl font-semibold text-gray-800">Instruksi Pembayaran</h2>
                    <p class="mt-2 text-gray-600">
                        Silakan lakukan pembayaran ke rekening berikut:
                    </p>
                    <div class="mt-4 bg-gray-50 rounded-lg p-5 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Metode</span>
                            <span class="font-bold text-gray-900">{{ $paymentInfo['bank'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Nomor Rekening/HP</span>
                            <span class="font-bold text-gray-900">{{ $paymentInfo['number'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Atas Nama</span>
                            <span class="font-bold text-gray-900">{{ $paymentInfo['name'] }}</span>
                        </div>
                    </div>
                </div>
                @endif

                <div class="mt-10">
                    <p class="text-gray-500 text-sm">
                        Kami akan mengirimkan notifikasi ke email Anda di <br> <span class="font-medium text-gray-800">{{ $donation->donor_email }}</span> setelah donasi terverifikasi.
                    </p>
                    <a href="{{ route('home') }}" 
                       class="inline-block mt-6 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition">
                       Kembali ke Halaman Utama
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>