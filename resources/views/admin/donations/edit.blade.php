<x-admin-layout>
    <div class="py-6 max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Donasi</h2>

        <form action="{{ route('admin.donations.update', $donation) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium">Program (opsional)</label>
                <select name="program_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Program --</option>
                    @foreach(\App\Models\Program::pluck('title','id') as $id => $title)
                        <option value="{{ $id }}" {{ old('program_id', $donation->program_id)==$id?'selected':'' }}>{{ $title }}</option>
                    @endforeach
                </select>
                @error('program_id') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Nama Donor</label>
                <input type="text" name="donor_name" value="{{ old('donor_name', $donation->donor_name) }}" class="w-full border rounded px-3 py-2">
                @error('donor_name') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Email Donor</label>
                <input type="email" name="donor_email" value="{{ old('donor_email', $donation->donor_email) }}" class="w-full border rounded px-3 py-2">
                @error('donor_email') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Jumlah Donasi</label>
                <input type="number" name="amount" value="{{ old('amount', $donation->amount) }}" class="w-full border rounded px-3 py-2" min="1">
                @error('amount') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Metode Donasi</label>
                <select name="method" class="w-full border rounded px-3 py-2">
                    @foreach(['bank_transfer','ewallet','va','manual'] as $method)
                        <option value="{{ $method }}" {{ old('method', $donation->method)==$method?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$method)) }}</option>
                    @endforeach
                </select>
                @error('method') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Status Donasi</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    @foreach(['pending','confirmed','failed','refunded'] as $status)
                        <option value="{{ $status }}" {{ old('status', $donation->status)==$status?'selected':'' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                @error('status') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">ID Transaksi</label>
                <input type="text" name="transaction_id" value="{{ old('transaction_id', $donation->transaction_id) }}" class="w-full border rounded px-3 py-2">
                @error('transaction_id') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Bukti Donasi (jpg, png, pdf)</label>
                @if($donation->proof_path)
                    <a href="{{ asset('storage/'.$donation->proof_path) }}" target="_blank" class="text-blue-600 hover:underline mb-2 block">Lihat Bukti</a>
                @endif
                <input type="file" name="proof_path" class="w-full">
                @error('proof_path') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Tanggal Bayar</label>
                <input type="date" name="paid_at" value="{{ old('paid_at', $donation->paid_at?->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2">
                @error('paid_at') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Catatan</label>
                <textarea name="note" class="w-full border rounded px-3 py-2">{{ old('note', $donation->note) }}</textarea>
                @error('note') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.donations.index') }}" class="px-4 py-2 border rounded hover:bg-gray-100">Batal</a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Perbarui</button>
            </div>
        </form>
    </div>
</x-admin-layout>
