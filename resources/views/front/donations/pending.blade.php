<x-guest-layout>
    <div class="flex flex-col items-center justify-center mt-9 text-center">
        <div class="bg-white p-8 rounded-xl shadow-lg max-w-md">
            <h2 class="text-2xl font-semibold text-yellow-600 mb-3">
                ⏳ Pembayaran Sedang Diproses
            </h2>
            <p class="text-gray-700 mb-4">
                Halo <strong>{{ $donation->donor_name }}</strong>, kami masih menunggu konfirmasi pembayaran Anda.
            </p>
            <div class="animate-spin rounded-full h-10 w-10 border-4 border-yellow-400 border-t-transparent mx-auto mb-4"></div>
            <p class="text-sm text-gray-500">Halaman akan otomatis diperbarui...</p>
        </div>
    </div>

    <script>
        const donationId = "{{ $donation->id }}";
        const checkUrl = "/api/donations/status/" + donationId;
        const successUrl = "/payment/success/" + donationId;

        function checkStatus() {
            fetch(checkUrl)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'confirmed') {
                        window.location.href = successUrl;
                    }
                })
                .catch(err => console.error('Gagal cek status:', err));
        }

        setInterval(checkStatus, 5000);
        checkStatus();
    </script>
</x-guest-layout>
