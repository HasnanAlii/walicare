<x-admin-layout>
    <div class="py-6" x-data="mediaPage()">

        <div class="max-w-7xl mx-auto flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-green-900 truncate pr-4">
                Detail: {{ $program->title }}
            </h2>
            
            <div class="flex-shrink-0 flex items-center gap-2">
                <button @click="openAddModal()" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                    <i data-feather="plus" class="w-4 h-4"></i>
                    Kabar Baru
                </button>
                <a href="{{ route('admin.programs.edit', $program) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                   <i data-feather="edit-2" class="w-4 h-4"></i>
                   Edit
                </a>
                <form id="delete-form-{{ $program->id }}" action="{{ route('admin.programs.destroy', $program) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" 
                            @click.prevent="confirmDelete({{ $program->id }})"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                        <i data-feather="trash-2" class="w-4 h-4"></i>
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        <div class="max-w-7xl mx-auto">
            <div class="bg-white shadow-lg rounded-xl overflow-hidden grid md:grid-cols-3 gap-0">
                <div class="md:col-span-2 relative min-h-[300px] md:min-h-0">
                    @if($program->image)
                        <img src="{{ asset('storage/'.$program->image) }}" 
                             alt="{{ $program->title }}" 
                             class="w-full">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-8">
                        <h2 class="text-3xl font-bold text-white drop-shadow-md leading-tight">
                            {{ $program->title }}
                        </h2>
                        <p class="text-white/90 mt-2 text-lg drop-shadow-sm">
                            {{ $program->description }}
                        </p>
                    </div>
                </div>

                <div class="p-6 flex flex-col">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Ringkasan Program</h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Oleh <span class="font-semibold text-green-700">{{ $program->organizer ?? 'Walicare' }}</span>
                    </p>

                    @php
                        $collected = $program->collected_amount ?? 0;
                        $target = $program->target_amount;
                        $percent = ($target > 0) ? min(100, ($collected / $target) * 100) : 0;
                        $daysLeft = (int) now()->diffInDays($program->end_date, false);
                        if ($program->status === 'completed') {
                            $timeLeft = 'Telah Selesai';
                            $timeLeftColor = 'text-blue-600';
                        } elseif ($daysLeft < 0) {
                            $timeLeft = 'Waktu Habis';
                            $timeLeftColor = 'text-red-600';
                        } else {
                            $timeLeft = $daysLeft . ' hari lagi';
                            $timeLeftColor = 'text-gray-800';
                        }
                    @endphp

                    <div class="mb-3">
                        <p class="text-2xl font-bold text-green-700">
                            Rp {{ number_format($collected,0,',','.') }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Terkumpul dari target Rp {{ number_format($target,0,',','.') }}
                        </p>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                        <div class="bg-green-600 h-3 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                    </div>
                    <p class="text-sm font-semibold text-gray-600 mb-6 text-right">
                        {{ number_format($percent, 1) }}% Tercapai
                    </p>

                    <div class="border-t pt-4 space-y-3 text-sm">
                        <div class="flex items-center text-gray-700">
                            <i data-feather="clock" class="w-4 h-4 mr-3 text-gray-500"></i>
                            Sisa waktu: 
                            <span class="font-semibold {{ $timeLeftColor }} ml-1">{{ $timeLeft }}</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i data-feather="tag" class="w-4 h-4 mr-3 text-gray-500"></i>
                            Kategori: <span class="font-semibold text-gray-800 ml-1">{{ $program->category->name ?? '-' }}</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i data-feather="info" class="w-4 h-4 mr-3 text-gray-500"></i>
                            Status: 
                            <span class="font-semibold text-gray-800 ml-1 capitalize">{{ $program->status ?? 'Aktif' }}</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i data-feather="map-pin" class="w-4 h-4 mr-3 text-gray-500"></i>
                            Lokasi: <span class="font-semibold text-gray-800 ml-1">{{ $program->location ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px space-x-6" aria-label="Tabs">
                        <button @click="tab = 'kabar'" 
                                :class="tab === 'kabar' ? 'border-green-600 text-green-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-base transition-colors duration-200">
                            Kabar Program
                        </button>
                        <button @click="tab = 'rincian'" 
                                :class="tab === 'rincian' ? 'border-green-600 text-green-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-base transition-colors duration-200">
                            Rincian Dana
                        </button>
                        <button @click="tab = 'donatur'" 
                                :class="tab === 'donatur' ? 'border-green-600 text-green-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-base transition-colors duration-200">
                            Donatur
                        </button>
                    </nav>
                </div>

                <div class="mt-6">
                    <div x-show="tab === 'kabar'" x-transition>
                        @if($program->media->count())
                            <div class="flow-root">
                                <ul role="list" class="-mb-8">
                                    @foreach($program->media->sortByDesc('created_at') as $index => $item)
                                    <li>
                                        <div class="relative pb-8">
                                            @if(!$loop->last)
                                                <span class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            @endif
                                            
                                            <div class="relative flex items-start space-x-4">
                                                <div>
                                                    <span class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center ring-8 ring-white">
                                                        @if($item->type === 'image')
                                                            <i data-feather="image" class="w-5 h-5 text-green-700"></i>
                                                        @elseif($item->type === 'video')
                                                            <i data-feather="video" class="w-5 h-5 text-green-700"></i>
                                                        @else
                                                            <i data-feather="file-text" class="w-5 h-5 text-green-700"></i>
                                                        @endif
                                                    </span>
                                                </div>
                                                
                                               <div class="bg-white p-5 rounded-lg shadow border border-gray-100">
                                                    @if($item->type === 'image' && $item->path)
                                                        <div class="flex justify-center items-center mb-3">
                                                            <img src="{{ asset('storage/'.$item->path) }}" 
                                                                alt="{{ $item->caption }}" 
                                                                class="max-w-3xl w-full md:w-auto rounded-lg shadow-sm object-contain">
                                                        </div>
                                                    @elseif($item->type === 'video' && $item->path)
                                                        <div class="flex justify-center items-center mb-3">
                                                            <video controls class="max-w-3xl w-full rounded-lg shadow-sm">
                                                                <source src="{{ asset('storage/'.$item->path) }}" type="video/mp4">
                                                                Browser Anda tidak mendukung pemutaran video.
                                                            </video>
                                                        </div>
                                                    @endif

                                                    @if($item->type === 'text')
                                                        <blockquote class="border-l-4 border-green-500 bg-green-50 p-4 text-gray-700 rounded-md">
                                                            <p class="italic">{!! nl2br(e($item->caption)) !!}</p>
                                                        </blockquote>
                                                    @else
                                                        <p class="text-center text-gray-700 mt-2">{!! nl2br(e($item->caption)) !!}</p>
                                                    @endif
                                                    <form action="{{ route('admin.programsmedia.destroy', $item->id) }}" method="POST" 
                                                          onsubmit="return confirm('Yakin ingin menghapus kabar ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                            class="inline-flex items-center px-3 py-1 text-sm text-red-600 font-semibold hover:text-red-800 hover:bg-red-50 rounded-lg transition">
                                                            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="mt-4 text-right">
</div>

                            </div>
                        @else
                            <div class="text-center bg-white p-12 rounded-lg shadow border border-gray-200">
                                <i data-feather="info" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-700">Belum Ada Kabar Program</h3>
                                <p class="text-gray-500 mt-2">Anda bisa menambahkan kabar (update) untuk program ini.</p>
                            </div>
                        @endif
                    </div>

                    <div x-show="tab === 'rincian'" x-transition x-cloak>
                        <div class="bg-white p-8 rounded-lg shadow border border-gray-200">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-bold text-gray-800">Rincian Alokasi Dana</h3>
                                <button @click="openUse = true" 
                                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm font-medium transition">
                                    <i data-feather="plus" class="w-4 h-4"></i>
                                    Tambah Penggunaan Dana
                                </button>
                            </div>

                            <div class="border-t pt-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Penggunaan Dana</h3>

                                @if($program->uses->count())
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                                            <thead class="bg-gray-100 text-gray-700 font-medium">
                                                <tr>
                                                    <th class="px-4 py-2 text-left">Tanggal</th>
                                                    <th class="px-4 py-2 text-left">Catatan</th>
                                                    <th class="px-4 py-2 text-right">Jumlah (Rp)</th>
                                                    <th class="px-4 py-2 text-center w-20">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                @foreach($program->uses as $use)
                                                    <tr>
                                                        <td class="px-4 py-2 text-gray-700">
                                                            {{ $use->tanggal ? \Carbon\Carbon::parse($use->tanggal)->format('d M Y') : '-' }}
                                                        </td>
                                                        <td class="px-4 py-2 text-gray-600">
                                                            {{ $use->note ?? '-' }}
                                                        </td>
                                                        <td class="px-4 py-2 text-right font-semibold text-gray-800">
                                                            Rp {{ number_format($use->amount, 0, ',', '.') }}
                                                        </td>
                                                        <td class="px-4 py-2 text-center">
                                                          <form action="{{ route('admin.program_uses.destroy', $use->id) }}" 
                                                            method="POST" 
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus penggunaan dana ini?');" 
                                                            class="inline-block">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 
                                                                    bg-red-50 hover:bg-red-100 hover:text-red-800 rounded-md transition
                                                                    focus:outline-none focus:ring-2 focus:ring-red-300">
                                                                <svg xmlns="http://www.w3.org/2000/svg" 
                                                                    class="w-4 h-4 mr-1" 
                                                                    fill="none" 
                                                                    viewBox="0 0 24 24" 
                                                                    stroke="currentColor" 
                                                                    stroke-width="2">
                                                                    <path stroke-linecap="round" 
                                                                        stroke-linejoin="round" 
                                                                        d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                                Hapus
                                                            </button>
                                                        </form>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr class="bg-gray-50 font-semibold">
                                                    <td colspan="2" class="px-4 py-2 text-right text-gray-700">Total Penggunaan</td>
                                                    <td class="px-4 py-2 text-right text-green-700">
                                                        Rp {{ number_format($program->uses->sum('amount'), 0, ',', '.') }}
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-gray-500 text-sm">Belum ada data penggunaan dana untuk program ini.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div x-show="tab === 'donatur'" 
                        x-transition 
                        x-cloak
                        class="bg-white shadow-lg rounded-xl p-6 md:p-8">

                        <h2 class="text-2xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-3">
                            Donatur ({{ $recentDonations->count() }})
                        </h2>

                        @if($recentDonations->count())
                            <ul class="space-y-4 max-h-96 overflow-y-auto pr-2">
                                @foreach($recentDonations as $donation)
                                    <li class="flex items-center space-x-4 p-2 hover:bg-gray-50 rounded-lg transition">
                                        <div class="flex-shrink-0">
                                            @if($donation->user && $donation->user->profile_photo)
                                                <img src="{{ asset('storage/' . $donation->user->profile_photo) }}" 
                                                    alt="{{ $donation->user->name }}" 
                                                    class="h-10 w-10 rounded-full object-cover border border-gray-200 shadow-sm">
                                            @elseif($donation->user && method_exists($donation->user, 'profile_photo_url'))
                                                <img src="{{ $donation->user->profile_photo_url }}" 
                                                    alt="{{ $donation->user->name }}" 
                                                    class="h-10 w-10 rounded-full object-cover border border-gray-200 shadow-sm">
                                            @else
                                                <div class="bg-gray-100 rounded-full h-10 w-10 flex items-center justify-center">
                                                    <i data-feather="user" class="w-5 h-5 text-gray-500"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex-1 text-left">
                                            <p class="font-semibold text-gray-800">
                                                {{ $donation->is_anonymous ? 'Donatur Anonim' : $donation->donor_name }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $donation->created_at->diffForHumans() }}
                                            </p>
                                        </div>

                                        <span class="text-lg font-bold text-green-600 whitespace-nowrap">
                                            Rp {{ number_format($donation->amount, 0, ',', '.') }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-12">
                                <i data-feather="users" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-700">Belum Ada Donatur</h3>
                                <p class="text-gray-500 mt-2">Jadilah donatur pertama untuk program ini!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div x-show="openUse" x-cloak
             class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 p-4"
             @keydown.escape.window="openUse = false">

            <div class="bg-white rounded-lg w-full max-w-lg p-6 shadow-2xl" @click.away="openUse = false">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800" 
                        x-text="useId ? 'Edit Penggunaan Dana' : 'Tambah Penggunaan Dana'"></h3>
                    <button @click="openUse = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                </div>

                <form 
                    :action="useId 
                        ? '/admin/programs/{{ $program->id }}/uses/' + useId 
                        : '{{ route('admin.program_uses.store', $program) }}'"
                    method="POST">
                    
                    @csrf
                    <template x-if="useId">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <input type="hidden" name="program_id" value="{{ $program->id }}">

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Keterangan</label>
                        <textarea name="note" rows="3" x-model="useNote"
                            class="w-full border-gray-300 p-2 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"
                            placeholder="Masukan Keterangan."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Jumlah (Rp) *</label>
                        <input type="number" name="amount" x-model="useAmount" required min="0"
                            class="w-full border-gray-300 p-2 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"
                            placeholder="Masukan Jumlah">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Tanggal</label>
                        <input type="date" name="tanggal" x-model="useDate"
                            class="w-full border-gray-300 p-2 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" @click="openUse = false"
                                class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium"
                                x-text="useId ? 'Perbarui' : 'Simpan'">
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="open" x-cloak
             class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 p-4" 
             @keydown.escape.window="open = false">
            
            <div class="bg-white rounded-lg w-full max-w-lg p-6 shadow-2xl" @click.away="open = false">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800" x-text="mediaId ? 'Edit Media' : 'Tambah Kabar Program'"></h3>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                </div>

                <form :action="mediaId ? '/admin/programs/{{ $program->id }}/media/' + mediaId : '{{ route('admin.programsmedia.store', $program) }}'" 
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    <template x-if="mediaId">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <input type="hidden" name="program_id" value="{{ $program->id }}">

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Jenis Media *</label>
                        <select name="type" x-model="type" class="w-full border-gray-300 p-2 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="image">Gambar</option>
                            <option value="video">Video</option>
                            <option value="text">Teks Update</option> 
                        </select>
                    </div>

                    <div class="mb-4" x-show="type !== 'text'" x-transition>
                        <label class="block text-sm font-medium mb-1">File Media 
                            <span class="text-red-500" x-show="!mediaId && type !== 'text'">*</span>
                        </label>
                        
                        <input type="file" @change="previewFile" name="path" 
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" 
                            :required="!mediaId && type !== 'text'">
                        
                        <template x-if="mediaId">
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti file</p>
                        </template>

                        <template x-if="preview">
                            <div class="mt-3 relative">
                                <button @click.prevent="preview = null; $event.target.closest('form').querySelector('input[type=file]').value = ''" 
                                        class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full p-1 shadow-md z-10">
                                    <i data-feather="x" class="w-3 h-3"></i>
                                </button>
                                <template x-if="type === 'image'">
                                    <img :src="preview" class="w-full h-48 object-cover rounded shadow-sm">
                                </template>
                                <template x-if="type === 'video'">
                                    <video :src="preview" controls class="w-full h-48 rounded shadow-sm"></video>
                                </template>
                            </div>
                        </template>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1" x-text="type === 'text' ? 'Isi Teks Update *' : 'Caption / Deskripsi'">Caption</label>
                        <textarea name="caption" x-model="caption" class="w-full border-gray-300 p-2 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500" rows="5" 
                                  :placeholder="type === 'text' ? 'Tulis update atau deskripsi keadaan di sini...' : 'Masukkan caption media'"
                                  :required="type === 'text'"></textarea>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" @click="open = false" class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">Batal</button>
                        <button type="submit" class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium" 
                                x-text="mediaId ? 'Perbarui' : 'Tambahkan'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
     function mediaPage() {
        return {
            tab: 'kabar',
            open: false,
            openUse: false,
            mediaId: null,
            useId: null,
            type: '',
            caption: '',
            preview: null,
            useAmount: '',
            useDate: '',
            useNote: '',
            openAddModal() {
                this.open = true;
                this.mediaId = null;
                this.type = '';
                this.caption = '';
                this.preview = null;
                const fileInput = document.querySelector('input[type="file"]');
                if (fileInput) fileInput.value = '';
            },
            openUseModal(use = null) {
                this.openUse = true;
                if (use) {
                    this.useId = use.id;
                    this.useAmount = use.amount;
                    this.useDate = use.tanggal;
                    this.useNote = use.note;
                } else {
                    this.useId = null;
                    this.useAmount = '';
                    this.useDate = '';
                    this.useNote = '';
                }
            },
            previewFile(event) {
                const file = event.target.files[0];
                if (!file) {
                    this.preview = null;
                    return;
                }
                this.preview = URL.createObjectURL(file);
            },
            closeAllModals() {
                this.open = false;
                this.openUse = false;
            }
        };
    }

    function confirmDelete(programId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Program ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#10B981',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + programId).submit();
            }
        });
    }
    </script>
    @endpush
</x-admin-layout>
