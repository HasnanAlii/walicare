<x-admin-layout>
    <div class="py-6 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Donasi</h2>
          
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg">
                <thead class="bg-gray-100">
                    <tr class="text-left">
                        <th class="px-4 py-2 border-b">No</th>
                        <th class="px-4 py-2 border-b">Program</th>
                        <th class="px-4 py-2 border-b">Donor</th>
                        <th class="px-4 py-2 border-b">Email</th>
                        <th class="px-4 py-2 border-b">Jumlah</th>
                        <th class="px-4 py-2 border-b">Metode</th>
                        <th class="px-4 py-2 border-b">Status</th>
                        <th class="px-4 py-2 border-b">Tanggal Bayar</th>
                        <th class="px-4 py-2 border-b">Bukti</th>
                        <th class="px-4 py-2 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $donation)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">{{ $loop->iteration + ($donations->currentPage()-1)*$donations->perPage() }}</td>
                            <td class="px-4 py-2 border-b">{{ $donation->program->title ?? '-' }}</td>
                            <td class="px-4 py-2 border-b">{{ $donation->user->name ?? $donation->donor_name }}</td>
                            <td class="px-4 py-2 border-b">{{ $donation->donor_email ?? '-' }}</td>
                            <td class="px-4 py-2 border-b">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border-b">{{ ucfirst(str_replace('_',' ', $donation->method)) }}</td>
                            <td class="px-4 py-2 border-b">{{ ucfirst($donation->status) }}</td>
                            <td class="px-4 py-2 border-b">{{ $donation->paid_at ?? '-' }}</td>
                            <td class="px-4 py-2 border-b">
                                @if($donation->proof_path)
                                    <a href="{{ asset('storage/'.$donation->proof_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-2 border-b flex gap-2">
                                <a href="{{ route('admin.donations.show', $donation) }}" class="text-blue-600 hover:underline">Detail</a>
                                <a href="{{ route('admin.donations.edit', $donation) }}" class="text-green-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.donations.destroy', $donation) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-2 text-center text-gray-500">Belum ada data donasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $donations->links() }}
        </div>
    </div>
</x-admin-layout>
