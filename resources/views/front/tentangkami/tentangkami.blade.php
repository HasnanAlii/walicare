<x-guest-layout>
    <div class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6">

            {{-- =========================
                 HEADER / PROFIL
            ========================== --}}
            <div class="text-center mb-12">
                <h1 class="text-5xl font-extrabold text-green-700 mb-4 tracking-wide">TENTANG WALI CARE</h1>
                <div class="w-24 h-1 bg-green-600 mx-auto rounded-full"></div>
                <p class="mt-6 text-gray-700 text-lg leading-relaxed max-w-4xl mx-auto">
                    <strong>Wali Care Foundation</strong> adalah lembaga sosial dan kemanusiaan yang didirikan oleh 
                    personil <strong>Wali Band</strong> pada tanggal <strong>3 April 2012</strong>. 
                    Kami berkomitmen untuk menebar kebaikan melalui aksi sosial, kemanusiaan, dan keagamaan.
                </p>
            </div>

            {{-- FOTO PERSONIL --}}
            <div class="flex justify-center mt-10">
                <img src="{{ asset('storage/image.png') }}" alt="Wali Care Founders"
                     class="rounded-2xl shadow-lg border-4 border-green-200 w-full md:w-2/3 object-cover">
            </div>

            {{-- =========================
                 VISI & MISI
            ========================== --}}
            <div class="mt-20 grid md:grid-cols-2 gap-10">
                <div>
                    <h2 class="text-3xl font-extrabold text-green-700 mb-4">VISI</h2>
                    <p class="text-gray-800 text-lg leading-relaxed bg-green-50 rounded-xl p-6 shadow-sm">
                        Terwujudnya masyarakat berdaya dan mandiri yang bersumber pada kepedulian sesama.
                    </p>
                </div>
                <div>
                    <h2 class="text-3xl font-extrabold text-green-700 mb-4">MISI</h2>
                    <ul class="text-gray-800 text-lg bg-green-50 rounded-xl p-6 list-decimal list-inside space-y-2 shadow-sm">
                        <li>Membangun dan meningkatkan nilai kepedulian serta partisipasi masyarakat.</li>
                        <li>Mengembangkan nilai zakat, infaq, shodaqoh, hibah, dan wakaf dalam pengentasan kemiskinan.</li>
                        <li>Mendorong kerjasama program antara organisasi sosial dan non-profit.</li>
                    </ul>
                </div>
            </div>

            {{-- =========================
                 PROGRAM UTAMA
            ========================== --}}
            <div class="mt-20 text-center">
                <h2 class="text-4xl font-extrabold text-green-700 mb-6">PROGRAM UTAMA</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        $programs = [
                            ['MUIN (Mushola Indah)', 'Renovasi mushola rusak bagi masyarakat tidak mampu.'],
                            ['Sunatan Massal Bareng WALI', 'Khitan gratis untuk anak yatim dan dhuafa.'],
                            ['Ramadhan Bareng WALI', 'Berbagi dan kegiatan edukatif selama bulan Ramadhan.'],
                            ['QBW (Qurban Bareng WALI)', 'Pemotongan hewan qurban yang amanah & akuntabel.'],
                            ['Tanggap Bencana', 'Posko bantuan dan distribusi logistik untuk korban bencana.'],
                            ['Salami School', 'Pendidikan keterampilan gratis bagi anak-anak tidak mampu.']
                        ];
                    @endphp
                    @foreach ($programs as $p)
                        <div class="bg-white border border-green-200 rounded-xl shadow-md p-6 hover:shadow-lg transition">
                            <h3 class="font-semibold text-lg text-green-800">{{ $p[0] }}</h3>
                            <p class="text-gray-600 text-sm mt-2">{{ $p[1] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- =========================
                 MISI KEMANUSIAAN PALESTINA
            ========================== --}}
            <div class="mt-24">
                <h2 class="text-4xl font-extrabold text-green-700 mb-8 text-center">
                    RELAWAN MISI KEMANUSIAAN UNTUK PALESTINA
                </h2>
                <p class="text-gray-700 text-lg leading-relaxed text-center max-w-3xl mx-auto mb-10">
                    Walicare bekerjasama dengan berbagai NGO baik dalam maupun luar negeri untuk menjalankan misi kemanusiaan 
                    membantu saudara-saudara kita di Palestina.
                </p>
            <div class="grid md:grid-cols-3 gap-4">
                <img src="{{ asset('storage/1.png') }}" class="rounded-xl shadow object-cover w-full h-72">
                <img src="{{ asset('storage/2.png') }}" class="rounded-xl shadow object-cover w-full h-72">
                <img src="{{ asset('storage/3.png') }}" class="rounded-xl shadow object-cover w-full h-72">
            </div>
            </div>

            {{-- =========================
                SERTIFIKAT NGO
            ========================== --}}
            <div class="mt-24 text-center">
                <h2 class="text-4xl font-extrabold text-green-700 mb-8">SERTIFIKAT PROGRAM NGO</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <img src="{{ asset('storage/s1.png') }}" alt="Certificate 1" class="rounded-xl shadow-lg object-cover w-full h-96">
                    <img src="{{ asset('storage/s2.png') }}" alt="Certificate 2" class="rounded-xl shadow-lg object-cover w-full h-96">
                </div>
            </div>


          
            {{-- CTA --}}
            <div class="mt-20 text-center">
                <a href="{{ route('programs.index') }}"
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                    <i data-feather="heart" class="w-5 h-5 mr-2"></i> Lihat Program Kami
                </a>
            </div>
        </div>
    </div>

    {{-- Feather Icons --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</x-guest-layout>
