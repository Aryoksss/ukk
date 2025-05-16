<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <h2 class="text-xl font-bold text-center mb-4 text-gray-800">Login ke Akun Anda</h2>

        <x-validation-errors class="mb-3" />

        @session('status')
            <div class="mb-3 font-medium text-sm text-green-600 bg-green-50 p-2 rounded-lg">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}" class="space-y-3">
            @csrf

            <div class="transition-all duration-300 ease-in-out hover:translate-x-1">
                <x-label for="email" value="{{ __('Email') }}" class="font-medium" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email Anda" />
            </div>

            <div class="transition-all duration-300 ease-in-out hover:translate-x-1">
                <x-label for="password" value="{{ __('Password') }}" class="font-medium" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password Anda" />
            </div>

            <div class="block transition-all duration-300 ease-in-out hover:translate-x-1">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 hover:text-blue-800 hover:underline transition-colors duration-300" href="{{ route('password.request') }}">
                        {{ __('Lupa password?') }}
                    </a>
                @else
                    <span></span>
                @endif

                <x-button class="bg-gradient-to-r from-blue-600 to-indigo-600">
                    {{ __('Login') }}
                </x-button>
            </div>
            
            <div class="text-center mt-4 pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600">Belum memiliki akun? 
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 hover:underline font-medium transition-colors duration-300">Register sekarang</a>
                </p>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
