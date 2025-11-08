<x-guest-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> 
            
            <div class="mb-8 text-left">
                <h1 class="text-3xl font-bold text-gray-900">Kegiatan Terbaru</h1>
                <p class="mt-2 text-gray-600">Ikuti dan dukung berbagai kegiatan yang kami laksanakan.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6">
                    @forelse($events as $event)
                        <div classid="event-card-{{ $event->id }}" class="bg-white shadow-lg rounded-xl overflow-hidden flex flex-col w-full">
                            
                            @if($event->image)
                                <a href="{{ route('events.show', $event->slug) }}"> 
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full  object-cover hover:opacity-95 transition-opacity">
                                </a>
                            @endif

                            <div class="p-5 flex flex-col flex-grow">
                                <div class="flex justify-between items-center mb-2">
                                    <p class="font-semibold text-green-600 text-sm">Wali Care Official</p>
                                    <p class="text-xs text-gray-500">{{ $event->start_date?->format('d M Y') }}</p>
                                </div>

                                <h3 class="font-bold text-xl mb-3">
                                    <a href="{{ route('events.show', $event->slug) }}" class="text-gray-900 hover:text-green-700 transition-colors"> {{-- Rute Diperbaiki --}}
                                        {{ $event->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-sm mb-4 flex-grow">{{ Str::limit($event->description, 200) }}</p>

                                <div class="flex justify-between text-sm text-gray-500 mb-3 pt-3 border-t">
                                    <span id="likes-count-{{ $event->id }}"> {{-- Tambahkan ID untuk JS --}}
                                        <i data-feather="thumbs-up" class="w-4 h-4 inline-block -mt-px mr-1"></i>
                                        {{ $event->likes_count ?? 0 }} Suka
                                    </span>
                                    <span>
                                        <i data-feather="message-square" class="w-4 h-4 inline-block -mt-px mr-1"></i>
                                        {{ $event->comments_count ?? 0 }} Komentar
                                    </span>
                                </div>

                                <div class="grid grid-cols-2 gap-2 text-center border-t pt-2">
                                    {{-- TOMBOL LIKE DIFUNGSIKAN DENGAN JS --}}
                                    <button 
                                        data-event-id="{{ $event->id }}" {{-- Kirim ID ke JS --}}
                                        class="like-button w-full flex justify-center items-center gap-2 py-2 font-medium hover:bg-gray-100 rounded-lg transition
                                               {{ $event->is_liked_by_user ? 'text-green-600' : 'text-gray-600' }}"> {{-- Set status awal --}}
                                        <i data-feather="thumbs-up" class="w-5 h-5"></i>
                                        <span class="like-text">{{ $event->is_liked_by_user ? 'Disukai' : 'Suka' }}</span>
                                    </button>
                                    
                                    <a href="{{ route('events.show', $event->slug) }}#comments" {{-- Rute Diperbaiki --}}
                                       class="w-full flex justify-center items-center gap-2 py-2 text-gray-600 font-medium hover:bg-gray-100 rounded-lg transition">
                                        <i data-feather="message-square" class="w-5 h-5"></i>
                                        <span>Komentar</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white shadow-lg rounded-xl p-12 text-center">
                            <i data-feather="calendar" class="w-16 h-16 text-gray-300 mx-auto"></i>
                            <h3 class="mt-4 text-xl font-semibold text-gray-700">
                                {{ request('search') ? 'Kegiatan Tidak Ditemukan' : 'Belum Ada Kegiatan' }}
                            </h3>
                            <p class="text-gray-500 mt-2">
                                {{ request('search') ? 'Coba ubah kata kunci pencarian Anda.' : 'Nantikan update kegiatan kami selanjutnya.' }}
                            </p>
                        </div>
                    @endforelse

                    <div class="mt-8">
                        {{ $events->links() }}
                    </div>
                </div>

                <aside class="lg:col-span-1 space-y-6">
                    
                    <div class="bg-white shadow-lg rounded-xl p-5">
                        <h4 class="font-bold text-lg text-gray-900 mb-3">Cari Kegiatan</h4>
                        <form action="{{ route('events.index') }}" method="GET"> 
                            <div class="relative">
                                <input type="text" name="search" placeholder="Ketik lalu Enter..." 
                                       value="{{ request('search') }}" 
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <button type="submit" class="absolute right-0 top-0 mt-3 mr-3 text-gray-400 hover:text-green-600">
                                    <i data-feather="search" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </form>
                    </div>

               {{-- Widget Kategori --}}
<div class="bg-white shadow-lg rounded-xl p-5">
    <h4 class="font-bold text-lg text-gray-900 mb-4">Kategori</h4>

    @if(isset($categories) && $categories->count())
        <ul class="space-y-2 text-gray-600">
            @foreach($categories as $category)
                <li>
                    <a href="{{ route('events.index', ['category' => $category->id]) }}"
                       class="hover:text-green-600 transition flex justify-between">
                        <span>{{ $category->name }}</span>
                        <span class="text-sm text-gray-400">({{ $category->events_count ?? 0 }})</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500 text-sm">Belum ada kategori.</p>
    @endif
</div>
{{-- Widget Kegiatan Unggulan --}}
<div class="bg-white shadow-lg rounded-xl p-5">
    <h4 class="font-bold text-lg text-gray-900 mb-4">Kegiatan Unggulan</h4>

    @if(isset($featuredPrograms) && $featuredPrograms->count())
        <div class="space-y-4">
            @foreach($featuredPrograms as $program)
                <div class="flex gap-3">
                    <img src="{{ $program->image ? asset('storage/' . $program->image) : asset('storage/logo.jpg') }}"
                         alt="{{ $program->title }}"
                         class="w-16 h-16 rounded-lg object-cover flex-shrink-0">

                    <div>
                        <a href="{{ route('events.show', $program) }}"
                           class="font-semibold text-sm text-gray-800 hover:text-green-600 transition line-clamp-2">
                           {{ $program->title }}
                        </a>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $program->likes_count ?? 0 }} suka
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500 text-sm">Belum ada kegiatan unggulan.</p>
    @endif
</div>




                </aside>
            </div>
        </div>
    </div>

    {{-- 
        PENTING: Pastikan layout Anda (guest-layout) memiliki @stack('scripts')
        tepat sebelum tag </body> agar skrip ini bisa berjalan.
    --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ambil semua tombol 'like'
            const likeButtons = document.querySelectorAll('.like-button');

            likeButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const eventId = this.dataset.eventId;
                    const url = `/like/event/${eventId}`; // Rute yang kita buat di web.php
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
                        // Jika user tidak login, server akan redirect ke /login
                        // 'auth' middleware melakukan ini. Kita tangkap & redirect.
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
                                // Ganti ikon feather setelah innerHTML diubah
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
        });
    </script>
    @endpush

</x-guest-layout>