<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <h2 class="text-xl font-bold text-center mb-4 text-gray-800">Buat Akun Baru</h2>

        <x-validation-errors class="mb-3" />

        <form method="POST" action="{{ route('register') }}" class="space-y-3">
            @csrf

            <div class="transition-all duration-300 ease-in-out hover:translate-x-1">
                <x-label for="name" value="{{ __('Nama') }}" class="font-medium" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan nama Anda" />
            </div>

            <div class="transition-all duration-300 ease-in-out hover:translate-x-1">
                <x-label for="email" value="{{ __('Email') }}" class="font-medium" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Masukkan email Anda" />
            </div>

            <div class="transition-all duration-300 ease-in-out hover:translate-x-1">
                <x-label for="password" value="{{ __('Password') }}" class="font-medium" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            </div>

            <div class="transition-all duration-300 ease-in-out hover:translate-x-1">
                <x-label for="password_confirmation" value="{{ __('Konfirmasi Password') }}" class="font-medium" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Masukkan password yang sama" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="transition-all duration-300 ease-in-out hover:translate-x-1">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <x-button class="w-full justify-center bg-gradient-to-r from-blue-600 to-indigo-600">
                    {{ __('Register') }}
                </x-button>
            </div>
            
            <div class="text-center mt-4 pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600">Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 hover:underline font-medium transition-colors duration-300">Login disini</a>
                </p>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
