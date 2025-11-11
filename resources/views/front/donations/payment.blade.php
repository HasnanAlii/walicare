<x-guest-layout>
    <div class="container mx-auto text-center py-10">
        <h2 class="text-2xl font-semibold mb-6">Konfirmasi Donasi</h2>
        <p>Halo <strong>{{ $donation->donor_name }}</strong>, silakan lanjutkan pembayaran sebesar:</p>
        <h3 class="text-3xl font-bold my-3 text-green-700">
            Rp {{ number_format($donation->amount, 0, ',', '.') }}
        </h3>

        <p class="text-gray-600 mb-6">
            Donasi Anda akan disalurkan untuk program <strong>{{ $donation->program->title }}</strong>.
        </p>

        <button id="pay-button"
            class="bg-green-600 text-white px-8 py-3 rounded-xl hover:bg-green-700 transition">
            Bayar Sekarang
        </button>

        <p class="text-sm text-gray-400 mt-4">
            Setelah pembayaran berhasil, Anda akan diarahkan ke halaman konfirmasi.
        </p>
    </div>

    {{-- ✅ Snap JS Midtrans (otomatis menyesuaikan environment Production / Sandbox) --}}
    <script 
        type="text/javascript"
        src="{{ env('MIDTRANS_IS_PRODUCTION') 
                ? 'https://app.midtrans.com/snap/snap.js' 
                : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
    </script>

<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $snapToken }}', {
            // ✅ Jika sukses (pembayaran berhasil)
            onSuccess: function(result) {
                window.location.href = "/payment/success/{{ $donation->id }}";
            },

            // ✅ Jika masih pending (misalnya belum transfer VA)
            onPending: function(result) {
                window.location.href = "/payment/pending/{{ $donation->id }}";
            },

            // ✅ Jika error / gagal
            onError: function(result) {
                window.location.href = "/payment/failed";
            },

            // ✅ Jika ditutup tanpa menyelesaikan pembayaran
            onClose: function() {
                alert("Anda menutup halaman pembayaran tanpa menyelesaikan transaksi.");
            }
        });
    };
</script>

</x-guest-layout>
