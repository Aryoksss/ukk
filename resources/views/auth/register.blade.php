<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800">Buat Akun Baru</h2>
            <p class="text-sm text-gray-600 mt-1">Silakan isi data diri Anda untuk mendaftar</p>
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <x-label for="name" value="{{ __('Nama') }}" class="font-medium" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan nama Anda" />
            </div>

            <div class="mb-4">
                <x-label for="email" value="{{ __('Email') }}" class="font-medium" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Masukkan email Anda" />
            </div>

            <div class="mb-4">
                <x-label for="password" value="{{ __('Password') }}" class="font-medium" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            </div>

            <div class="mb-4">
                <x-label for="password_confirmation" value="{{ __('Konfirmasi Password') }}" class="font-medium" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Masukkan password yang sama" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mb-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />
                            <div class="ms-2 text-sm text-gray-600">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="mt-6">
                <x-button class="w-full justify-center bg-blue-600 hover:bg-blue-700 py-3">
                    {{ __('Register') }}
                </x-button>
            </div>
            
            <div class="text-center mt-6 pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600">Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Login disini</a>
                </p>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
