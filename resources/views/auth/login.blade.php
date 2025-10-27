<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-700 px-6">

        <div class="w-full max-w-5xl bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-12 border border-white/20">

            <!-- Judul -->
            <h2 class="text-4xl font-extrabold text-center text-white mb-8 drop-shadow-lg">
                Welcome Back
            </h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-6 text-center text-green-300" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="grid grid-cols-1 gap-6">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-white" />
                    <x-text-input id="email"
                        class="block mt-1 w-full bg-white/20 text-white placeholder-gray-300 border-gray-500 focus:border-pink-400 focus:ring-pink-400 rounded-lg"
                        type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-white" />
                    <x-text-input id="password"
                        class="block mt-1 w-full bg-white/20 text-white placeholder-gray-300 border-gray-500 focus:border-purple-400 focus:ring-purple-400 rounded-lg"
                        type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center text-white">
                    <input id="remember_me" type="checkbox"
                           class="rounded border-gray-400 text-pink-400 focus:ring-pink-400 bg-white/20" 
                           name="remember">
                    <label for="remember_me" class="ml-2 text-sm">Remember me</label>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="underline text-sm text-gray-300 hover:text-white">
                            Forgot your password?
                        </a>
                    @endif

                    <x-primary-button
                        class="px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-500 text-white font-bold rounded-lg shadow-lg hover:scale-105 transform transition-all">
                        Log in
                    </x-primary-button>
                </div>

                <p class="text-center text-gray-200 mt-4">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="underline text-pink-400 hover:text-pink-300">Register</a>
                </p>

            </form>
        </div>
    </div>
</x-guest-layout>
