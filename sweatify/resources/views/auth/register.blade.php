<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Weight -->
        <div class="mt-4">
            <x-input-label for="weight" :value="__('Weight (kg)')" />
            <x-text-input id="weight" class="block mt-1 w-full" type="number" name="weight" :value="old('weight')" min="0" step="any" required />
            <x-input-error :messages="$errors->get('weight')" class="mt-2" />
        </div>

        <!-- Height -->
        <div class="mt-4">
            <x-input-label for="height" :value="__('Height (cm)')" />
            <x-text-input id="height" class="block mt-1 w-full" type="number" name="height" :value="old('height')" min="0" step="any" required />
            <x-input-error :messages="$errors->get('height')" class="mt-2" />
        </div>

        <!-- Age -->
        <div class="mt-4">
            <x-input-label for="age" :value="__('Age (years)')" />
            <x-text-input id="age" class="block mt-1 w-full" type="number" name="age" :value="old('age')" min="0" required />
            <x-input-error :messages="$errors->get('age')" class="mt-2" />
        </div>

        <!-- Gender -->
        <div class="mt-4">
            <x-input-label for="gender" :value="__('Gender')" />
            <select id="gender" name="gender" class="block mt-1 w-full bg-gray-800 text-white border border-gray-700 rounded-md focus:ring-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800" required>
                <option value="">Select your gender</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
