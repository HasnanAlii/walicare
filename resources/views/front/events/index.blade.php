<x-guest-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> 
            
            <div class="mb-8 text-left">
                <h1 class="text-3xl font-bold text-gray-900">Kegiatan Terbaru</h1>
                <p class="mt-2 text-gray-600">Ikuti dan dukung berbagai kegiatan yang kami laksanakan.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- BAGIAN UTAMA --}}
                <div class="lg:col-span-2 space-y-6">
                    @forelse($events as $event)
                        <div id="event-card-{{ $event->id }}" class="bg-white shadow-lg rounded-xl overflow-hidden flex flex-col w-full">
                            
                            {{-- Gambar --}}
                            @if($event->image)
                                <a href="{{ route('events.show', $event->slug) }}"> 
                                    <img src="{{ asset('storage/' . $event->image) }}" 
                                         alt="{{ $event->title }}" 
                                         class="w-full object-cover aspect-video hover:opacity-95 transition-opacity">
                                </a>
                            @endif

                            {{-- Konten --}}
                            <div class="p-5 flex flex-col flex-grow">
                                <div class="flex justify-between items-center mb-2">
                                    <p class="font-semibold text-green-600 text-sm">Wali Care Official</p>
                                    <p class="text-xs text-gray-500">{{ $event->start_date?->format('d M Y') }}</p>
                                </div>

                                <h3 class="font-bold text-xl mb-3">
                                    <a href="{{ route('events.show', $event->slug) }}" class="text-gray-900 hover:text-green-700 transition-colors">
                                        {{ $event->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-sm mb-4 flex-grow">{{ Str::limit($event->description, 200) }}</p>

                                {{-- Statistik --}}
                                <div class="flex justify-between text-sm text-gray-500 mb-3 pt-3 border-t">
                                    <span id="likes-count-{{ $event->id }}">
                                        <i data-feather="thumbs-up" class="w-4 h-4 inline-block -mt-px mr-1"></i>
                                        {{ $event->likes_count ?? 0 }} Suka
                                    </span>
                                    <span>
                                        <i data-feather="message-square" class="w-4 h-4 inline-block -mt-px mr-1"></i>
                                        {{ $event->comments_count ?? 0 }} Komentar
                                    </span>
                                </div>

                                {{-- Tombol --}}
                               <div class="grid grid-cols-3 gap-2 text-center border-t pt-2">
                                {{-- Tombol Suka --}}
                                <button 
                                    data-event-id="{{ $event->id }}"
                                    class="like-button w-full flex justify-center items-center gap-2 py-2 font-medium hover:bg-gray-100 rounded-lg transition
                                        {{ $event->is_liked_by_user ? 'text-green-600' : 'text-gray-600' }}">
                                    <i data-feather="thumbs-up" class="w-5 h-5"></i>
                                    <span class="like-text">{{ $event->is_liked_by_user ? 'Disukai' : 'Suka' }}</span>
                                </button>

                                {{-- Tombol Komentar --}}
                                <a href="{{ route('events.show', $event->slug) }}#comments"
                                class="w-full flex justify-center items-center gap-2 py-2 text-gray-600 font-medium hover:bg-gray-100 rounded-lg transition">
                                    <i data-feather="message-square" class="w-5 h-5"></i>
                                    <span>Komentar</span>
                                </a>

                                {{-- Tombol Bagikan --}}
                                 <button 
                                    onclick="shareEvent(
                                        '{{ route('events.show', $event->slug) }}', 
                                        '{{ $event->title }}', 
                                        '{{ Str::limit($event->summary, 150) }}', 
                                        '{{ asset('storage/' . $event->image) }}'
                                    )"
                                    class="w-full flex justify-center items-center gap-2 py-2 text-gray-600 font-medium hover:bg-gray-100 rounded-lg transition">
                                    <i data-feather="share-2" class="w-5 h-5"></i>
                                    Bagikan
                                </button>
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

                {{-- SIDEBAR --}}
                <aside class="lg:col-span-1 space-y-6">
                    <div class="sticky top-56 space-y-6"> {{-- membuat sidebar tetap di tempat --}}
                        
                        {{-- Pencarian --}}
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

                        {{-- Kategori --}}
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

                        {{-- Kegiatan Unggulan --}}
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

                    </div>
                </aside>
            </div>
        </div>
    </div>

    {{-- SCRIPT LIKE --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const likeButtons = document.querySelectorAll('.like-button');

            likeButtons.forEach(button => {
                button.addEventListener('click', function () {
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
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        if (data) {
                            const countSpan = document.getElementById(`likes-count-${eventId}`);
                            if (countSpan) {
                                countSpan.innerHTML = `<i data-feather="thumbs-up" class="w-4 h-4 inline-block -mt-px mr-1"></i> ${data.likes_count} Suka`;
                                feather.replace();
                            }
                            const textSpan = this.querySelector('.like-text');
                            this.classList.toggle('text-green-600', data.is_liked);
                            this.classList.toggle('text-gray-600', !data.is_liked);
                            textSpan.textContent = data.is_liked ? 'Disukai' : 'Suka';
                        }
                    })
                    .catch(error => console.error('Error toggling like:', error));
                });
            });
        });
    </script>
    @endpush


     <script>
                    function shareEvent(url, title, description, imageUrl) {
                        const defaultTitle = 'Kegiatan Wali Care';
                        const defaultDesc = 'Lihat kegiatan inspiratif dari Wali Care yang penuh kepedulian!';
                        
                        // Gunakan default jika title/desc kosong
                        const shareTitle = title || defaultTitle;
                        const shareDesc = description || defaultDesc;

                        // 📱 A. Jika browser mendukung file sharing (image)
                        if (navigator.canShare && navigator.canShare({ files: [] }) && imageUrl) {
                            fetch(imageUrl)
                                .then(res => res.blob())
                                .then(blob => {
                                    const file = new File([blob], 'walicare-event.jpg', { type: blob.type });
                                    navigator.share({
                                        title: shareTitle,
                                        text: shareDesc,
                                        files: [file],
                                        url: url
                                    }).catch(err => console.log('Gagal membagikan file:', err));
                                })
                                .catch(err => {
                                    console.log('Gagal fetch gambar, fallback ke share teks:', err);
                                    shareTextOnly(url, shareTitle, shareDesc);
                                });

                        // 📱 B. Jika hanya bisa share teks
                        } else if (navigator.share) {
                            shareTextOnly(url, shareTitle, shareDesc);

                        // 💻 C. Fallback untuk Desktop (Modal)
                        } else {
                            showDesktopShareModal(url, shareTitle, shareDesc);
                        }
                    }

                    // Fungsi helper untuk share teks saja
                    function shareTextOnly(url, title, text) {
                        navigator.share({
                            title: title,
                            text: text,
                            url: url
                        }).catch(err => console.log('Gagal membagikan teks:', err));
                    }

                    // Fungsi modal untuk Desktop
                    function showDesktopShareModal(url, title, description) {
                        closeShareModal(); // pastikan modal lama ditutup

                        const modal = `
                            <div id="share-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 p-4">
                                <div class="bg-white rounded-xl shadow-lg w-full max-w-sm p-6 text-center">
                                    <h3 class="text-lg font-semibold mb-4">Bagikan Event Ini</h3>
                                    <div class="flex justify-around text-green-600 mb-5">
                                        <!-- Facebook -->
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}&quote=${encodeURIComponent(description)}" target="_blank" class="p-2 hover:bg-gray-100 rounded-full" title="Bagikan ke Facebook">
                                            <i data-feather='facebook' class="w-6 h-6"></i>
                                        </a>
                                        <!-- Twitter / X -->
                                        <a href="https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(description)}" target="_blank" class="p-2 hover:bg-gray-100 rounded-full" title="Bagikan ke X (Twitter)">
                                            <i data-feather='twitter' class="w-6 h-6"></i>
                                        </a>
                                        <!-- Copy Link -->
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

                    // Jalankan Feather Icons setelah halaman dimuat
                    document.addEventListener('DOMContentLoaded', () => {
                        if (typeof feather !== 'undefined') feather.replace();
                    });
                    </script>
</x-guest-layout>
