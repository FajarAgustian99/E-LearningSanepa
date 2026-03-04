<x-guest-layout>
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 text-indigo-600 rounded-2xl mb-4 shadow-sm">
            <img src="{{ asset('images/sanepa.png') }}" alt="Logo Sanepa" class="h-10 w-10">
            <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
            </svg> -->
        </div>
        <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Selamat Datang <br> Di E-Learning <br> SMA NEGERI 1 PABUARAN</h1>
        <p class="mt-2 text-sm text-gray-500">
            Silakan masuk menggunakan akun <span class="font-semibold text-indigo-600">E-Learning</span> anda
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="login" value="User ID / Nomor Induk" class="text-gray-700 font-medium" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <x-text-input id="login"
                    class="block w-full pl-10 rounded-xl border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                    type="text"
                    name="login"
                    placeholder="Masukkan ID Anda"
                    :value="old('login')"
                    required
                    autofocus />
            </div>
            <x-input-error :messages="$errors->get('login')" class="mt-1" />
        </div>

        <div x-data="{ show: false }">
            <div class="flex items-center justify-between">
                <x-input-label for="password" value="Password" class="text-gray-700 font-medium" />
                <!-- @if (Route::has('password.request'))
                <a class="text-xs font-semibold text-indigo-600 hover:text-indigo-500 transition-colors" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
                @endif -->
            </div>

            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input
                    :type="show ? 'text' : 'password'"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    class="block w-full pl-10 pr-10 rounded-xl border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" />

                <button type="button"
                    @click="show = !show"
                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-indigo-600 focus:outline-none transition-colors">
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.362m3.087-2.727A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.969 9.969 0 01-4.132 5.411M15 12a3 3 0 00-3-3m0 0a3 3 0 00-3 3m3-3v6" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded-md border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-1 transition-all"
                    name="remember">
                <span class="ml-2 text-sm text-gray-600">Tetap masuk di perangkat ini</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform active:scale-[0.98] shadow-lg shadow-indigo-200">
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-indigo-400 group-hover:text-indigo-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                </span>
                MASUK SEKARANG
            </button>
        </div>
    </form>

    <div class="mt-8 text-center border-t border-gray-100 pt-6">
        <p class="text-xs text-gray-400">
            Butuh bantuan akses? <a href="https://www.google.com/url?sa=E&source=gmail&q=https://wa.me/6281221775552" class="text-indigo-500 hover:underline font-medium">Hubungi Admin IT Sanepa</a>
        </p>
    </div>
</x-guest-layout>