<section>
    {{-- CARD UTAMA UBAH KATA SANDI --}}
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            {{-- 1. HEADER CARD --}}
            <header class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-bold text-green-900">
                    Ubah Kata Sandi
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Demi keamanan akun, gunakan kata sandi yang kuat dan sulit ditebak. 
                    Disarankan untuk memadukan huruf besar, kecil, angka, dan simbol.
                </p>
            </header>

            {{-- 2. BODY CARD --}}
            <div class="p-6 space-y-6">
                @php
                    $inputClass = 'w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50';
                    $labelClass = 'block mb-1 text-sm font-medium text-gray-700';
                @endphp

                {{-- Kata Sandi Saat Ini --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <div class="md:col-span-1">
                        <label for="update_password_current_password" class="{{ $labelClass }}">
                            Kata Sandi Saat Ini
                        </label>
                    </div>
                    <div class="md:col-span-2">
                        <x-text-input 
                            id="update_password_current_password"
                            name="current_password"
                            type="password"
                            class="{{ $inputClass }}"
                            autocomplete="current-password"
                            placeholder="Masukkan kata sandi lama Anda"
                        />
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>
                </div>

                {{-- Kata Sandi Baru --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <div class="md:col-span-1">
                        <label for="update_password_password" class="{{ $labelClass }}">
                            Kata Sandi Baru
                        </label>
                    </div>
                    <div class="md:col-span-2">
                        <x-text-input 
                            id="update_password_password"
                            name="password"
                            type="password"
                            class="{{ $inputClass }}"
                            autocomplete="new-password"
                            placeholder="Masukkan kata sandi baru"
                        />
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>
                </div>

                {{-- Konfirmasi Kata Sandi --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <div class="md:col-span-1">
                        <label for="update_password_password_confirmation" class="{{ $labelClass }}">
                            Konfirmasi Kata Sandi
                        </label>
                    </div>
                    <div class="md:col-span-2">
                        <x-text-input 
                            id="update_password_password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="{{ $inputClass }}"
                            autocomplete="new-password"
                            placeholder="Ulangi kata sandi baru"
                        />
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>
            </div>

            {{-- 3. FOOTER CARD (TOMBOL AKSI) --}}
            <footer class="flex items-center gap-4 bg-gray-50 p-6 border-t border-gray-200">
                <x-primary-button class="bg-green-600 hover:bg-green-700 focus:ring-green-500">
                    Simpan Perubahan
                </x-primary-button>

                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }"
                       x-show="show"
                       x-transition
                       x-init="setTimeout(() => show = false, 3000)"
                       class="text-sm text-green-600">
                        Kata sandi berhasil diperbarui.
                    </p>
                @endif
            </footer>
        </form>
    </div>
</section>

{{-- Feather Icons --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        if (typeof feather !== 'undefined') feather.replace();
    });
</script>
