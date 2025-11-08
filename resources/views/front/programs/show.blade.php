<x-guest-layout>
    {{-- 
      CATATAN: Pastikan layout Anda (guest-layout atau app-layout) 
      memuat Alpine.js agar tab ini berfungsi. 
    --}}
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6" x-data="{ tab: 'detail' }">

                    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                        <img src="{{ asset('storage/' . $program->image) }}" 
                             alt="{{ $program->title }}" 
                             class="w-full h-auto md:h-96 object-cover">
                    </div>

                    <div class="bg-white shadow-lg rounded-xl p-3 flex space-x-2">
                        <button 
                            @click="tab = 'detail'"
                            :class="{ 'bg-green-600 text-white': tab === 'detail', 'bg-gray-100 text-gray-700 hover:bg-gray-200': tab !== 'detail' }"
                            class="w-1/2 py-3 px-4 rounded-lg font-bold transition-all duration-200">
                            <i data-feather="info" class="w-4 h-4 inline-block -mt-1 mr-1"></i>
                            Detail Program
                        </button>
                        <button 
                            @click="tab = 'donors'"
                            :class="{ 'bg-green-600 text-white': tab === 'donors', 'bg-gray-100 text-gray-700 hover:bg-gray-200': tab !== 'donors' }"
                            class="w-1/2 py-3 px-4 rounded-lg font-bold transition-all duration-200">
                            <i data-feather="users" class="w-4 h-4 inline-block -mt-1 mr-1"></i>
                            Donatur ({{ $program->donations->count() }}) {{-- Total donatur --}}
                        </button>
                    </div>

                    <div x-show="tab === 'detail'" x-transition 
                         class="bg-white shadow-lg rounded-xl p-6 md:p-8">
                        
                        <span class="inline-block bg-green-100 text-green-700 font-medium px-3 py-1 rounded-full text-sm">
                            {{ $program->category->name }}
                        </span>

                        <h1 class="text-3xl font-bold text-gray-900 mt-3">{{ $program->title }}</h1>
                        
                        <div class="prose max-w-none text-gray-700 mt-6">
                            {!! $program->description !!}
                        </div>

                        {{-- @if($breakdown)
                        <div class="mt-8 border-t pt-6">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Rincian Penggunaan Dana</h3>
                            <ul class="space-y-3">
                                @foreach($breakdown as $item)
                                <li class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                    <span class="text-gray-700">{{ $item['item'] ?? 'Item tidak diketahui' }}</span>
                                    <span class="font-bold text-gray-900">Rp {{ number_format($item['amount'] ?? 0, 0, ',', '.') }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif --}}

                    @if($program->media->count() > 0)
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Kabar Terbaru</h3>
                        <div class="space-y-8">
                            
                            @forelse($program->media as $item)
                                
                                @if($item->type === 'image')
                                    <div class="space-y-2">
                                        <img src="{{ asset('storage/'.$item->path) }}" alt="{{ $item->caption ?? 'Media Program' }}" 
                                            class="rounded-lg w-full h-auto object-cover shadow-md">
                                        @if($item->caption)
                                            <p class="text-sm text-center text-gray-600 italic">"{{ $item->caption }}"</p>
                                        @endif
                                    </div>
                                
                                @elseif($item->type === 'video')
                                    <div class="space-y-2">
                                        <video controls class="w-full rounded-lg shadow-md">
                                            <source src="{{ asset('storage/'.$item->path) }}" type="video/mp4">
                                        </video>
                                        @if($item->caption)
                                            <p class="text-sm text-center text-gray-600 italic">"{{ $item->caption }}"</p>
                                        @endif
                                    </div>
                                
                                {{-- INI ADALAH BLOK BARU UNTUK MENAMPILKAN TEKS --}}
                                @elseif($item->type === 'text')
                                    <div class="p-5 ">
                                        <div class="prose max-w-none text-gray-700">
                                            <p>{!! nl2br(e($item->caption)) !!}</p>
                                        </div>
                                    </div>
                                @endif

                            @empty
                                <p class="text-gray-500">Belum ada Kabar terbaru untuk program ini.</p>
                            @endforelse

                        </div>
                    </div>
                        @endif

                    </div>

                    <div x-show="tab === 'donors'" x-transition 
                         class="bg-white shadow-lg rounded-xl p-6 md:p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3">
                            Donatur ({{ $recentDonations->count() }})
                        </h2>
                        @if($recentDonations->count())
                            <ul class="space-y-4 max-h-96 overflow-y-auto pr-2">
                                @foreach($recentDonations as $donation)
                                    <li class="flex items-center space-x-4">
                                        <div class="flex-shrink-0 bg-gray-100 rounded-full h-10 w-10 flex items-center justify-center">
                                            <i data-feather="user" class="w-5 h-5 text-gray-500"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-800">
                                                {{ $donation->is_anonymous ? 'Donatur Anonim' : $donation->donor_name }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $donation->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <span class="text-lg font-bold text-green-600">
                                            Rp {{ number_format($donation->amount, 0, ',', '.') }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">Jadilah donatur pertama untuk program ini!</p>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="sticky top-28"> 
                        
                        <div class="bg-white shadow-lg rounded-xl p-6">
                            <h3 class="text-xl font-bold text-gray-900">Progres Donasi</h3>
                            
                            <div class="mt-4">
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-green-500 h-3 rounded-full" style="width: {{ $progress }}%"></div>
                                </div>
                                <div class="flex justify-between mt-2 text-sm">
                                    <span class="font-medium text-gray-700">Terkumpul:
                                        <span class="text-green-700 font-bold">Rp {{ number_format($totalDonations, 0, ',', '.') }}</span>
                                    </span>
                                    <span class="font-bold text-gray-800">{{ $progress }}%</span>
                                </div>
                                <div class="mt-1 text-sm text-gray-500">
                                    Target: Rp {{ number_format($program->target_amount, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-lg rounded-xl p-6 mt-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-5 text-center">Donasi Sekarang</h2>

                            @if ($errors->any())
                                <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded">
                                    <ul class="list-disc list-inside text-sm">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('donations.store', $program->slug) }}" method="POST">
    @csrf
    <input type="hidden" name="program_id" value="{{ $program->id }}">

    <div class="space-y-4">
        <div>
            <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah Donasi (Rp)</label>
            <input type="number" name="amount" id="amount" 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                   placeholder="Minimal Donasi 10.000" required>
        </div>

        <div>
            <label for="donor_name" class="block text-sm font-medium text-gray-700">Nama Anda</label>
            <input type="text" name="donor_name" id="donor_name" 
                   value="{{ auth()->check() ? auth()->user()->name : old('donor_name') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                   placeholder="Nama lengkap Anda" required>
        </div>

        <div>
            <label for="donor_email" class="block text-sm font-medium text-gray-700">Email Anda</label>
            <input type="email" name="donor_email" id="donor_email" 
                   value="{{ auth()->check() ? auth()->user()->email : old('donor_email') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                   placeholder="Email untuk notifikasi" required>
        </div>
        
        <div>
            <label for="method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
            <select name="method" id="method" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                <option value="">Pilih Pembayaran</option>
                <option value="bank_transfer">Bank Transfer (BCA/Mandiri/dll)</option>
                {{-- <option value="ewallet">E-Wallet (GoPay/OVO/dll)</option>
                <option value="va">Virtual Account</option> --}}
            </select>
        </div>

        <div>
            <label for="note" class="block text-sm font-medium text-gray-700">Pesan (Opsional)</label>
            <textarea name="note" id="note" rows="3" 
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                      placeholder="Tulis doa atau dukungan Anda di sini..."></textarea>
        </div>

        <button type="submit" 
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
            LANJUTKAN PEMBAYARAN
        </button>
    </div>
</form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>