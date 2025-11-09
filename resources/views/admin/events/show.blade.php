<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Kolom Utama (Konten Event) --}}
                <div class="md:col-span-2 bg-white shadow-lg rounded-lg overflow-hidden">
                    @if($event->image)
                        <img src="{{ asset('storage/'. $event->image) }}" alt="{{ $event->title }}" class="w-full object-cover">
                    @endif
                    
                    <div class="p-6 md:p-8">
                        {{-- Judul --}}
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>
                        
                        {{-- Deskripsi --}}
                        <div class="prose max-w-none text-gray-700">
                            {!! $event->description !!} {{-- Gunakan {!! !!} jika deskripsi berisi HTML --}}
                        </div>

                        <hr class="my-8">

                        {{-- Bagian Komentar --}}
                        <h3 class="text-2xl font-semibold text-gray-800 mb-6">Komentar ({{ $event->comments_count }})</h3>

                       

                        {{-- Daftar Komentar --}}
                        <div class="space-y-6">
                            @forelse($comments as $comment)
                                <div class="flex items-start gap-4">
                                    {{-- Avatar Placeholder --}}
                                    <div class="flex-shrink-0 w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                         <img class="w-10 h-10 rounded-full object-cover" 
                                            src="{{ asset('storage/' . $comment->user->profile_photo) }}"  
                                            alt="{{ $comment->user->name }}">
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-center">
                                            <span class="font-semibold text-gray-800">{{ $comment->user->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-600 mt-1">{{ $comment->body }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center">Belum ada komentar.</p>
                            @endforelse
                        </div>

                        {{-- Pagination Komentar --}}
                        <div class="mt-8">
                            {{ $comments->links() }}
                        </div>
                    </div>
                </div>

                {{-- Kolom Sidebar (Info & Aksi) --}}
                <div class="md:col-span-1">
                    <div class="bg-white shadow-lg rounded-lg p-6 sticky top-8">
                    

                        {{-- Statistik --}}
                        <div class="flex justify-around text-center my-6">
                            <div>
                                <i data-feather="heart" class="w-6 h-6 text-red-500 mx-auto"></i>
                                <span class="block text-xl font-bold text-gray-800">{{ $event->likes_count }}</span>
                                <span class="text-sm text-gray-500">Suka</span>
                            </div>
                            <div>
                                <i data-feather="message-square" class="w-6 h-6 text-blue-500 mx-auto"></i>
                                <span class="block text-xl font-bold text-gray-800">{{ $event->comments_count }}</span>
                                <span class="text-sm text-gray-500">Komentar</span>
                            </div>
                        </div>

                        <hr class="my-6">

                        {{-- Info Detail Event --}}
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Detail Kegiatan</h4>
                        <div class="space-y-3 text-gray-700">
                            <div class="flex items-center gap-3">
                                <i data-feather="calendar" class="w-5 h-5 text-gray-500 flex-shrink-0"></i>
                                <span>{{ $event->start_date?->format('d M Y') }} - {{ $event->end_date?->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i data-feather="map-pin" class="w-5 h-5 text-gray-500 flex-shrink-0"></i>
                                <span>{{ $event->location }}</span>
                            </div>
                        </div>

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('admin.events.index') }}" class="inline-flex items-center gap-2 mt-8 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm font-medium">
                            <i data-feather="arrow-left" class="w-4 h-4"></i>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>