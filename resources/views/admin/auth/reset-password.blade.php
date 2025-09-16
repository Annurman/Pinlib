<x-guest-layout>
    <!-- Logo Pinlib -->
    <div class="flex justify-center mb-6">
        <a href="/">
            <img src="{{ asset('storage/profile_pictures/logo-pinlib.png') }}" 
                 alt="Logo Pinlib" class="h-[170px] w-auto">
        </a>
    </div>

    <form method="POST" action="{{ route('admin.password.update') }}">
        @csrf

        <!-- Token -->
       <input type="hidden" name="token" value="{{ $token }}">

<!-- Email -->
<x-input-label for="email" :value="__('Email')" />
<x-text-input id="email" 
              class="block mt-1 w-full" 
              type="email" 
              name="email" 
              value="{{ $email ?? old('email') }}" 
              required autofocus />
<x-input-error :messages="$errors->get('email')" class="mt-2" />


        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password Baru')" />
            <x-text-input id="password" 
                          class="block mt-1 w-full" 
                          type="password" 
                          name="password" 
                          required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Konfirmasi Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" 
                          class="block mt-1 w-full" 
                          type="password" 
                          name="password_confirmation" 
                          required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('admin.login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Kembali ke Login
            </a>

            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
