<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Akun') }}
        </h2>
    </x-slot>

    <div class="py-12">
        
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8" x-data="{ tab: 'profile' }">
            
            <div class="sm:rounded-lg overflow-hidden">

                <nav class="border-b border-gray-200">
                    <div class="px-4 sm:px-8">
                       
                        <div class="flex -mb-px space-x-6 sm:space-x-8">
                            
                            <button @click="tab = 'profile'"
                                    :class="tab === 'profile' 
                                        ? 'border-green-500 text-green-600' 
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-150">
                                Informasi Profil
                            </button>
                            
                            <button @click="tab = 'password'"
                                    :class="tab === 'password' 
                                        ? 'border-green-500 text-green-600' 
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-150">
                                Ubah Kata Sandi
                            </button>
                            
                            <button @click="tab = 'delete'"
                                    :class="tab === 'delete' 
                                        ? 'border-red-500 text-red-600' 
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-150">
                                Hapus Akun
                            </button>
                        </div>
                    </div>
                </nav>

                {{-- 2. KONTEN TAB --}}
              <div class="flex justify-center w-full">
                <div class="p-4 sm:p-8 w-full max-w-5xl mx-auto">

                    <div x-show="tab === 'profile'" x-cloak class="flex justify-center">
                        <div class="w-full">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div x-show="tab === 'password'" x-cloak class="flex justify-center">
                        <div class="w-full">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div x-show="tab === 'delete'" x-cloak class="flex justify-center">
                        <div class="w-full">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>

                </div>
            </div>

                
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { 
            display: none !important; 
        }
    </style>
</x-guest-layout>