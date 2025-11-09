<section class="space-y-6 bg-white shadow-lg rounded-lg overflow-hidden p-5">
    <header>
        <h2 class="text-lg font-bold text-green-900">
            Hapus Akun
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Setelah akun Anda dihapus, semua data dan informasi yang terkait akan <span class="font-semibold text-red-600">dihapus secara permanen</span>.
            Pastikan Anda telah mengunduh atau menyimpan data penting sebelum melanjutkan.
        </p>
    </header>

    {{-- Tombol Hapus --}}
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-700 focus:ring-red-500"
    >
        <i data-feather="trash-2" class="w-4 h-4 mr-2"></i> Hapus Akun
    </x-danger-button>

    {{-- Modal Konfirmasi --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="mb-4">
                <h2 class="text-lg font-semibold text-gray-900">
                    Apakah Anda yakin ingin menghapus akun ini?
                </h2>

                <p class="mt-2 text-sm text-gray-600">
                    Setelah dihapus, akun Anda <span class="font-semibold text-red-600">tidak dapat dipulihkan</span>.  
                    Mohon masukkan kata sandi Anda untuk konfirmasi.
                </p>
            </div>

            {{-- Input Password --}}
            <div class="mt-6">
                <x-input-label for="password" value="Kata Sandi" class="text-sm font-medium text-gray-700" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"
                    placeholder="Masukkan kata sandi Anda"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-8 flex justify-end gap-3 border-t pt-6">
                <x-secondary-button 
                    x-on:click="$dispatch('close')" 
                    class="px-5 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition"
                >
                    <i data-feather="x" class="w-4 h-4 mr-1"></i> Batal
                </x-secondary-button>

                <x-danger-button 
                    class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition flex items-center gap-2"
                >
                    <i data-feather="trash-2" class="w-4 h-4"></i> Hapus Akun
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        if (typeof feather !== 'undefined') feather.replace();
    });
</script>
