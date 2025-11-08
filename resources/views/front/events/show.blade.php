<x-guest-layout>
    <div class="py-12 bg-gray-50">
        {{-- Lebar diubah menjadi 3xl untuk halaman detail --}}
        <div class="max-w-3xl mx-auto px-4 space-y-6"> 
            
            <div class="mb-4">
                <a href="{{ route('events.index') }}" 
                   class="flex items-center gap-2 text-sm text-gray-500 hover:text-gray-900 transition">
                    <i data-feather="arrow-left" class="w-4 h-4"></i>
                    Kembali ke Semua Kegiatan
                </a>
            </div>

            <div id="event-card-{{ $event->id }}" class="bg-white shadow-lg rounded-xl overflow-hidden flex flex-col w-full">
                
                {{-- Header Postingan --}}
                <div class="p-4 sm:p-5 flex items-center gap-3 border-b border-gray-100">
                    <img class="w-10 h-10 rounded-full object-cover" src="{{ asset('storage/logo.jpg') }}" alt="User Avatar">
                    <div>
                        <p class="font-semibold text-gray-900">Wali Care Official</p>
                        <p class="text-xs text-gray-500">{{ $event->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                {{-- Gambar (Jika ada) dipindah ke bawah header --}}
                @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-auto max-h-[500px] object-cover">
                @endif

                {{-- Konten Postingan --}}
                <div class="p-4 sm:p-6">
                     <h1 class="font-bold text-2xl text-gray-900 mb-4">{{ $event->title }}</h1>
                     
                     {{-- Info Detail (Tanggal & Lokasi) --}}
                     <div class="flex items-center gap-6 text-sm text-gray-500 mb-4">
                        <span class="flex items-center gap-2">
                            <i data-feather="calendar" class="w-4 h-4"></i>
                            {{ $event->start_date?->format('d M Y') }}
                        </span>
                        <span class="flex items-center gap-2">
                            <i data-feather="map-pin" class="w-4 h-4"></i>
                            {{ $event->location ?? 'Online' }}
                        </span>
                     </div>

                     {{-- Deskripsi Lengkap (Gunakan 'prose' untuk styling) --}}
                     <div class="prose max-w-none text-gray-700 mb-6">
                        {!! $event->description !!} {{-- Menggunakan {!! !!} jika deskripsi Anda berisi HTML --}}
                     </div>

                     {{-- Baris Statistik (Like & Komentar) --}}
                    <div class="flex justify-between text-sm text-gray-500 mb-3 pt-4 border-t">
                        <span id="likes-count-{{ $event->id }}">
                            <i data-feather="thumbs-up" class="w-4 h-4 inline-block -mt-px mr-1"></i>
                            {{ $event->likes_count ?? 0 }} Suka
                        </span>
                        <span>
                            <i data-feather="message-square" class="w-4 h-4 inline-block -mt-px mr-1"></i>
                            {{ $event->comments_count ?? 0 }} Komentar
                        </span>
                    </div>

                    {{-- Tombol Aksi (Like & Komentar) --}}
                    <div class="grid grid-cols-2 gap-2 text-center border-t pt-2">
                        <button 
                            data-event-id="{{ $event->id }}"
                            class="like-button w-full flex justify-center items-center gap-2 py-2 font-medium hover:bg-gray-100 rounded-lg transition
                                   {{ $event->is_liked_by_user ? 'text-green-600' : 'text-gray-600' }}">
                            <i data-feather="thumbs-up" class="w-5 h-5"></i>
                            <span class="like-text">{{ $event->is_liked_by_user ? 'Disukai' : 'Suka' }}</span>
                        </button>
                        
                        <a href="#comments" 
                           class="w-full flex justify-center items-center gap-2 py-2 text-gray-600 font-medium hover:bg-gray-100 rounded-lg transition">
                            <i data-feather="message-square" class="w-5 h-5"></i>
                            <span>Komentar</span>
                        </a>
                    </div>
                </div>
            </div> <div id="comments" class="bg-white shadow-lg rounded-xl p-4 sm:p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    Komentar ({{ $event->comments_count ?? 0 }})
                </h2>

                @auth
                <form action="{{ route('events.comment', $event) }}" method="POST" class="flex items-start gap-3 border-b pb-4 mb-4">
                    @csrf
                    <img class="w-10 h-10 rounded-full object-cover" 
                         src="{{ Auth::user()->profile_photo_url ?? asset('storage/logo.jpg') }}" 
                         alt="{{ Auth::user()->name }}">
                    <div class="flex-1">
                        <textarea name="body" rows="3" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500" 
                                  placeholder="Tulis komentar Anda..." required></textarea>
                        @error('body')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <button type="submit" 
                                class="mt-2 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg shadow hover:bg-green-700 transition">
                            Kirim
                        </button>
                    </div>
                </form>
                @else
                <div class="border-b pb-4 mb-4 text-center">
                    <p class="text-gray-600">
                        <a href="{{ route('login') }}" class="text-green-600 font-semibold hover:underline">Masuk</a> untuk menulis komentar.
                    </p>
                </div>
                @endauth
                
                <div class="space-y-5">
                    @forelse ($comments as $comment)
                        <div class="flex items-start gap-3">
                            <img class="w-10 h-10 rounded-full object-cover" 
                                 src="{{ asset('storage/' . $comment->user->profile_photo) }}"  
                                 alt="{{ $comment->user->name }}">
                            <div class="flex-1 bg-gray-50 rounded-lg px-4 py-3">
                                <div class="flex justify-between items-center">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $comment->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                                <p class="text-gray-700 text-sm mt-1">{{ $comment->body }}</p>
                            </div>
                        </div>
                    @empty
                        <p classM="text-gray-500 text-center py-4">Belum ada komentar.</p>
                    @endforelse
                </div>

                @if($comments->hasPages())
                <div class="mt-6">
                    {{ $comments->links() }}
                </div>
                @endif

            </div> </div>
    </div>

    {{-- Script untuk tombol 'Like' (Sama seperti di index) --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const likeButton = document.querySelector('.like-button');
            if (!likeButton) return; // Hentikan jika tombol tidak ada

            likeButton.addEventListener('click', function () {
                const eventId = this.dataset.eventId;
                const url = `/like/event/${eventId}`;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (response.status === 401 || response.status === 403) {
                         window.location.href = '{{ route('login') }}';
                         return;
                    }
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data) {
                        // Update jumlah 'like'
                        const countSpan = document.getElementById(`likes-count-${eventId}`);
                        if (countSpan) {
                            countSpan.innerHTML = `<i data-feather="thumbs-up" class="w-4 h-4 inline-block -mt-px mr-1"></i> ${data.likes_count} Suka`;
                            feather.replace(); 
                        }

                        // Update tampilan tombol
                        const textSpan = this.querySelector('.like-text');
                        if (data.is_liked) {
                            this.classList.remove('text-gray-600');
                            this.classList.add('text-green-600');
                            textSpan.textContent = 'Disukai';
                        } else {
                            this.classList.remove('text-green-600');
                            this.classList.add('text-gray-600');
                            textSpan.textContent = 'Suka';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error toggling like:', error);
                });
            });
        });
    </script>
    @endpush
</x-guest-layout>