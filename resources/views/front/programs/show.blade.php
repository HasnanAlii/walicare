<x-guest-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6" x-data="{ tab: 'detail' }">

                    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                        <img src="{{ asset('storage/' . $program->image) }}" 
                             alt="{{ $program->title }}" 
                             class="w-full  object-cover">
                    </div>

                    {{-- Tombol Tab --}}
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
                            Donatur ({{ $program->donations->count() }})
                        </button>
                    </div>

                    {{-- TAB DETAIL --}}
                    <div x-show="tab === 'detail'" x-transition class="bg-white shadow-lg rounded-xl p-6 md:p-8">
                        
                        <span class="inline-block bg-green-100 text-green-700 font-medium px-3 py-1 rounded-full text-sm">
                            {{ $program->category->name }}
                        </span>

                        <h1 class="text-3xl font-bold text-gray-900 mt-3">{{ $program->title }}</h1>
                        
                        <div class="prose max-w-none text-gray-700 mt-6">
                            {!! $program->description !!}
                        </div>

                        {{-- Tombol Bagikan --}}
                        <div class="mt-8 border-t pt-6 text-center">
                            <button 
                                onclick="shareProgram(
                                    '{{ route('programs.show', $program->slug) }}', 
                                    '{{ $program->title }}', 
                                    '{{ Str::limit(strip_tags($program->description), 150) }}', 
                                    '{{ asset('storage/' . $program->image) }}'
                                )"
                                class="inline-flex items-center gap-2 px-5 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold shadow">
                                <i data-feather='share-2' class='w-5 h-5'></i> Bagikan Program Ini
                            </button>
                        </div>

                        {{-- Media / Kabar Terbaru --}}
                        @if($program->media->count() > 0)
                            <div class="mt-8 border-t pt-6">
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">Kabar Terbaru</h3>
                                <div class="space-y-8">
                                    @foreach($program->media as $item)
                                        @if($item->type === 'image')
                                            <div class="space-y-2">
                                                <img src="{{ asset('storage/'.$item->path) }}" alt="{{ $item->caption ?? 'Media Program' }}" 
                                                     class="rounded-lg w-full h-auto object-cover shadow-md">
                                                @if($item->caption)
                                                    <p class="text-sm text-center text-gray-600 italic">{{ $item->caption }}</p>
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
                                        @elseif($item->type === 'text')
                                            <div class="p-5">
                                                <div class="prose max-w-none text-gray-700">
                                                    <p>{!! nl2br(e($item->caption)) !!}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- TAB DONATUR --}}
                    <div x-show="tab === 'donors'" x-transition class="bg-white shadow-lg rounded-xl p-6 md:p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3">
                            Donatur ({{ $recentDonations->count() }})
                        </h2>
                        @if($recentDonations->count())
                            <ul class="space-y-4 max-h-96 overflow-y-auto pr-2">
                                @foreach($recentDonations as $donation)
                                    <li class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            @if($donation->user && $donation->user->profile_photo)
                                                <img src="{{ asset('storage/' . $donation->user->profile_photo) }}" 
                                                    alt="{{ $donation->user->name }}" 
                                                    class="h-10 w-10 rounded-full object-cover border border-gray-200 shadow-sm">
                                            @else
                                                <div class="bg-gray-100 rounded-full h-10 w-10 flex items-center justify-center">
                                                    <i data-feather="user" class="w-5 h-5 text-gray-500"></i>
                                                </div>
                                            @endif
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

                {{-- SIDEBAR --}}
                <div class="lg:col-span-1 space-y-6">
                       <div class="sticky top-56 space-y-6">
                        
                        {{-- Progres Donasi --}}
                            @php
                                $target = $program->target_amount ?? 0;
                                $totalDonations = $totalDonations ?? 0;

                                $progress = $target > 0 ? ($totalDonations / $target) * 100 : 0;
                                $progress = min($progress, 100);
                            @endphp

                            <div class="bg-white shadow-lg rounded-xl p-6">
                                <h3 class="text-xl font-bold text-gray-900">Progres Donasi</h3>
                                
                                <div class="mt-4">
                                    <!-- Progress Bar -->
                                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                        <div class="bg-green-500 h-3 rounded-full transition-all duration-500" 
                                            style="width: {{ $progress }}%;">
                                        </div>
                                    </div>

                                    <!-- Info Donasi -->
                                    <div class="flex justify-between mt-2 text-lg">
                                        <span class="font-medium text-gray-700 py-2">
                                            Terkumpul:
                                            <span class="text-green-700 font-bold text-xl">
                                                Rp {{ number_format($totalDonations, 0, ',', '.') }}
                                            </span>
                                        </span>
                                        <span class="font-bold text-gray-800">
                                            {{ number_format($progress, 0) }}%
                                        </span>
                                    </div>
                                    <div class="mt-1 text-sm text-gray-500 flex items-center gap-1 leading-none">
                                    <span>Target:</span>

                                    @if ($program->target_amount == 0)
                                        {{-- Ikon tanpa batas (infinity) --}}
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor"
                                            class="w-4 h-4 text-green-600">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M18.364 5.636a9 9 0 010 12.728M5.636 5.636a9 9 0 000 12.728m0 0L18.364 5.636m0 12.728L5.636 5.636" />
                                        </svg>
                                        <span class="text-green-600">Tanpa Batas</span>
                                    @else
                                        <span>Rp {{ number_format($program->target_amount, 0, ',', '.') }}</span>
                                    @endif
                                </div>

                                </div>
                            </div>


                        {{-- Form Donasi --}}
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
                                        <input 
                                            type="text" 
                                            id="amount_display"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                                            placeholder="Minimal Donasi 10.000" required>
                                        <input type="hidden" name="amount" id="amount">
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

                                    {{-- ✅ Checkbox Donasi Anonim --}}
                                    <div class="flex items-center">
                                        <input type="checkbox" id="is_anonymous" name="is_anonymous" value="1" 
                                            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                        <label for="is_anonymous" class="ml-2 block text-sm text-gray-700">
                                            Donasi sebagai Anonim
                                    </div>

                                    <div>
                                        <label for="method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                                        <select name="method" id="method" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                                            <option value="bank_transfer">Bank Transfer (BCA)</option>
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

                            {{-- ✅ SCRIPT OTOMATIS --}}
                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                const checkbox = document.getElementById('is_anonymous');
                                const nameInput = document.getElementById('donor_name');
                                const emailInput = document.getElementById('donor_email');

                                // Simpan nilai asli untuk dikembalikan nanti
                                const originalName = nameInput.value;
                                const originalEmail = emailInput.value;

                                checkbox.addEventListener('change', function() {
                                    if (this.checked) {
                                        nameInput.value = 'Anonim';
                                        emailInput.value = 'anonim@example.com';
                                        nameInput.setAttribute('readonly', true);
                                        emailInput.setAttribute('readonly', true);
                                        nameInput.classList.add('bg-gray-100');
                                        emailInput.classList.add('bg-gray-100');
                                    } else {
                                        nameInput.value = originalName;
                                        emailInput.value = originalEmail;
                                        nameInput.removeAttribute('readonly');
                                        emailInput.removeAttribute('readonly');
                                        nameInput.classList.remove('bg-gray-100');
                                        emailInput.classList.remove('bg-gray-100');
                                    }
                                });
                            });
                            </script>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputDisplay = document.getElementById('amount_display');
        const inputHidden = document.getElementById('amount');

        inputDisplay.addEventListener('input', function (e) {
            // Hapus semua karakter non-digit
            let value = e.target.value.replace(/\D/g, '');
            if (!value) {
                inputHidden.value = '';
                e.target.value = '';
                return;
            }

            // Simpan nilai asli (tanpa titik)
            inputHidden.value = value;

            // Format angka ribuan dengan titik
            e.target.value = new Intl.NumberFormat('id-ID').format(value);
        });
    });
    </script>

    {{-- SCRIPT BAGIKAN --}}
    <script>
        function shareProgram(url, title, description, imageUrl) {
            const defaultTitle = 'Program Wali Care';
            const defaultDesc = 'Dukung program sosial inspiratif dari Wali Care!';
            const shareTitle = title || defaultTitle;
            const shareDesc = description || defaultDesc;

            if (navigator.canShare && navigator.canShare({ files: [] }) && imageUrl) {
                fetch(imageUrl)
                    .then(res => res.blob())
                    .then(blob => {
                        const file = new File([blob], 'walicare-program.jpg', { type: blob.type });
                        navigator.share({
                            title: shareTitle,
                            text: shareDesc,
                            files: [file],
                            url: url
                        }).catch(err => console.log('Gagal membagikan file:', err));
                    })
                    .catch(err => {
                        console.log('Gagal fetch gambar:', err);
                        shareTextOnly(url, shareTitle, shareDesc);
                    });
            } else if (navigator.share) {
                shareTextOnly(url, shareTitle, shareDesc);
            } else {
                showDesktopShareModal(url, shareTitle, shareDesc);
            }
        }

        function shareTextOnly(url, title, text) {
            navigator.share({
                title: title,
                text: text,
                url: url
            }).catch(err => console.log('Gagal membagikan teks:', err));
        }

        function showDesktopShareModal(url, title, description) {
            closeShareModal(); 
            const modal = `
                <div id="share-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 p-4">
                    <div class="bg-white rounded-xl shadow-lg w-full max-w-sm p-6 text-center">
                        <h3 class="text-lg font-semibold mb-4">Bagikan Program Ini</h3>
                        <div class="flex justify-around text-green-600 mb-5">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}&quote=${encodeURIComponent(description)}" target="_blank" class="p-2 hover:bg-gray-100 rounded-full" title="Bagikan ke Facebook">
                                <i data-feather='facebook' class="w-6 h-6"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(description)}" target="_blank" class="p-2 hover:bg-gray-100 rounded-full" title="Bagikan ke X (Twitter)">
                                <i data-feather='twitter' class="w-6 h-6"></i>
                            </a>
                            <button onclick="copyLink('${url}')" class="p-2 hover:bg-gray-100 rounded-full" title="Salin tautan">
                                <i data-feather='copy' class="w-6 h-6"></i>
                            </button>
                        </div>
                        <button onclick="closeShareModal()" class="mt-4 text-sm text-gray-500 hover:text-gray-700">Tutup</button>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modal);
            feather.replace();
        }

        function closeShareModal() {
            document.getElementById('share-modal')?.remove();
        }

        function copyLink(url) {
            navigator.clipboard.writeText(url).then(() => {
                alert('📋 Link berhasil disalin ke clipboard!');
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof feather !== 'undefined') feather.replace();
        });
    </script>
</x-guest-layout>
