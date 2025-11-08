<x-admin-layout>
    <div class="py-6 max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Donasi</h2>

        <div class="bg-white shadow-md rounded-lg p-6 space-y-3">
            <div><strong>Program:</strong> {{ $donation->program->title ?? '-' }}</div>
            <div><strong>Donor:</strong> {{ $donation->user->name ?? $donation->donor_name }}</div>
            <div><strong>Email Donor:</strong> {{ $donation->donor_email ?? '-' }}</div>
            <div><strong>Jumlah:</strong> Rp {{ number_format($donation->amount,0,',','.') }}</div>
            <div><strong>Metode:</strong> {{ ucfirst(str_replace('_',' ', $donation->method)) }}</div>
            <div><strong>Status:</strong> {{ ucfirst($donation->status) }}</div>
            <div><strong>ID Transaksi:</strong> {{ $donation->transaction_id ?? '-' }}</div>
            <div><strong>Tanggal Bayar:</strong> {{ $donation->paid_at ?? '-' }}</div>
            <div><strong>Catatan:</strong> {{ $donation->note ?? '-' }}</div>
            <div>
                <strong>Bukti Donasi:</strong>
                @if($donation->proof_path)
                    <a href="{{ asset('storage/'.$donation->proof_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a>
                @else
                    -
                @endif
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.donations.index') }}" class="px-4 py-2 border rounded hover:bg-gray-100">Kembali</a>
        </div>
    </div>
</x-admin-layout>
