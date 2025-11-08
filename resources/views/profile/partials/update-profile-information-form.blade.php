<section>
    {{-- Form untuk mengirim verifikasi email (tidak terlihat) --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- CARD UTAMA PROFIL --}}
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            {{-- 1. HEADER CARD --}}
            <header class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-bold text-green-900">
                    Informasi Profil
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Perbarui data profil Anda dan foto akun di bawah ini.
                </p>
            </header>

            {{-- 2. BODY CARD (ISI FORMULIR) --}}
            <div class="p-6 space-y-6">

                {{-- Foto Profil --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <div class="md:col-span-1">
                        <x-input-label for="profile_photo" value="Foto Profil" />
                    </div>
                    <div class="md:col-span-2">
                        <div class="flex items-center gap-6">
                            {{-- Foto saat ini --}}
                            @if ($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                    alt="Foto Profil"
                                    class="w-24 h-24 object-cover rounded-full border-4 border-green-100 shadow-sm">
                            @else
                                <div class="w-24 h-24 rounded-full bg-green-50 flex items-center justify-center border border-green-200">
                                    <i data-feather="user" class="w-10 h-10 text-green-400"></i>
                                </div>
                            @endif

                            
                            {{-- Tombol upload baru --}}
                            <div>
                                <label for="profile_photo" 
                                     class="cursor-pointer rounded-md font-medium text-green-600 hover:text-green-700 focus-within:outline-none focus-within:ring-2 focus-within:ring-green-500 focus-within:ring-offset-2">
                                    <span>Ganti Foto</span>
                                    <input id="profile_photo" name="profile_photo" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP. Maks 12MB.</p>
                            </div>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
                    </div>
                </div>

                {{-- Nama --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <div class="md:col-span-1">
                        <x-input-label for="name" value="Nama Lengkap" />
                    </div>
                    <div class="md:col-span-2">
                        <x-text-input id="name" name="name" type="text" 
                            class="mt-1 block w-full" 
                            :value="old('name', $user->name)" 
                            required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                </div>

                {{-- Email --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                    <div class="md:col-span-1">
                        <x-input-label for="email" value="Alamat Email" />
                    </div>
                    <div class="md:col-span-2">
                        <x-text-input id="email" name="email" type="email" 
                            class="mt-1 block w-full" 
                            :value="old('email', $user->email)" 
                            required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        {{-- Kotak Peringatan Verifikasi --}}
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-4 p-4 rounded-md bg-yellow-50 border border-yellow-200">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        {{-- Icon Peringatan (Heroicon) --}}
                                        <svg class="h-5 w-5 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                          <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM10 13a1 1 0 110-2 1 1 0 010 2zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm font-medium text-yellow-800">
                                            Email Anda belum diverifikasi.
                                        </p>
                                        <button form="send-verification" 
                                                class="mt-1 underline text-sm font-medium text-yellow-700 hover:text-yellow-800 focus:outline-none">
                                            Klik di sini untuk mengirim ulang tautan verifikasi.
                                        </button>
                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 font-medium text-sm text-green-600">
                                                Tautan verifikasi baru telah dikirim ke email Anda.
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- 3. FOOTER CARD (TOMBOL AKSI) --}}
            <footer class="flex items-center gap-4 bg-gray-50 p-6 border-t border-gray-200">
                <x-primary-button class="bg-green-600 hover:bg-green-700 focus:ring-green-500">
                    Simpan Perubahan
                </x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }"
                       x-show="show"
                       x-transition
                       x-init="setTimeout(() => show = false, 3000)"
                       class="text-sm text-green-600">
                        Profil berhasil diperbarui.
                    </p>
                @endif
            </footer>

        </form>
    </div>
</section>

{{-- Pastikan script Feather Icons tetap dimuat --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        if (typeof feather !== 'undefined') feather.replace();
    });
</script>