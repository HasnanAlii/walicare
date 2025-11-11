<x-guest-layout>
    <div class=" flex flex-col justify-center items-center bg-gray-100 px-4 sm:px-6 lg:px-8 mt-5 mb-10">
        <div class="w-full max-w-md space-y-6">
            {{-- Logo & Judul --}}
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-bold text-gray-800">
                    Masuk ke Akun Anda
                </h2>
            </div>

            {{-- Session Status --}}
            <x-auth-session-status class="mb-4" :status="session('status')" />

            {{-- Form Login --}}
            <form class="mt-8 space-y-4 bg-white p-6 rounded-xl shadow-sm" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="relative">
                    <x-text-input id="email" class="block w-full px-4 py-3 rounded-md focus:ring-2 focus:ring-green-400 focus:outline-none placeholder-gray-400" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
                </div>

                <!-- Password -->
                <div class="relative">
                    <x-text-input id="password" class="block w-full px-4 py-3 rounded-md focus:ring-2 focus:ring-green-400 focus:outline-none placeholder-gray-400" type="password" name="password" required autocomplete="current-password" placeholder="Password"/>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between text-sm text-gray-600">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="remember" class="rounded text-green-500 focus:ring-green-400">
                        <span>Ingat Saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-green-500 hover:underline">Lupa Password?</a>
                    @endif
                </div>

                <!-- Login Button -->
                <x-primary-button class="w-full py-3 mt-4 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-md transition duration-200">
                    Masuk
                </x-primary-button>

                {{-- <!-- Divider -->
                <div class="flex items-center my-4">
                    <hr class="flex-grow border-gray-300">
                    <span class="mx-2 text-gray-400 text-sm">ATAU</span>
                    <hr class="flex-grow border-gray-300">
                </div>

                <!-- Social Login Buttons -->
                <div class="space-y-2">
                    <a href="#" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100 transition">
                        <img src="https://img.icons8.com/color/16/google-logo.png" class="mr-2"> Masuk dengan Google
                    </a>
                    <a href="#" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100 transition">
                        <i class="fab fa-facebook-f mr-2"></i> Masuk dengan Facebook
                    </a>
               
                </div> --}}

                {{-- Register Link --}}
                <p class="mt-4 text-center text-sm text-gray-600">
                    Baru di {{ config('app.name') }}? 
                    <a href="{{ route('register') }}" class="text-green-500 hover:underline">Daftar disini</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
