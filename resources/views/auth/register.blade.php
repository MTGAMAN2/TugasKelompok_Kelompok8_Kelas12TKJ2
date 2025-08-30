<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-700 px-6">

        <div class="w-full max-w-5xl bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-12 border border-white/20">

            <!-- Judul -->
            <h2 class="text-4xl font-extrabold text-center text-white mb-8 drop-shadow-lg">
                Create Account ✨
            </h2>

            <form method="POST" action="{{ route('register') }}" class="grid grid-cols-1 gap-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" class="text-white" />
                    <x-text-input id="name"
                        class="block mt-1 w-full bg-white/20 text-white placeholder-gray-300 border-gray-500 focus:border-pink-400 focus:ring-pink-400 rounded-lg"
                        type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-300" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-white" />
                    <x-text-input id="email"
                        class="block mt-1 w-full bg-white/20 text-white placeholder-gray-300 border-gray-500 focus:border-purple-400 focus:ring-purple-400 rounded-lg"
                        type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-white" />
                    <x-text-input id="password"
                        class="block mt-1 w-full bg-white/20 text-white placeholder-gray-300 border-gray-500 focus:border-pink-400 focus:ring-pink-400 rounded-lg"
                        type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white" />
                    <x-text-input id="password_confirmation"
                        class="block mt-1 w-full bg-white/20 text-white placeholder-gray-300 border-gray-500 focus:border-purple-400 focus:ring-purple-400 rounded-lg"
                        type="password" name="password_confirmation" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-300" />
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between mt-6">
                    <p class="text-gray-200 text-sm">
                        Already registered? 
                        <a href="{{ route('login') }}" class="underline text-pink-400 hover:text-pink-300">Login</a>
                    </p>

                    <x-primary-button class="px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-500 text-white font-bold rounded-lg shadow-lg hover:scale-105 transform transition-all">
                        Register
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
