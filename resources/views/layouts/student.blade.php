<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- Title dan Favicon -->
    <title>@yield('title', 'E-Learning Sanepa')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/sanepa.png') }}">

    <!-- Styles & Scripts (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-gray-100 font-sans min-h-screen">

    {{-- ==================================
            NAVBAR
    =================================== --}}
    <nav class="backdrop-blur-sm bg-white/70 border-b border-gray-200 fixed w-full z-50 shadow">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">

            {{-- LOGO KIRI --}}
            <div class="flex items-center gap-3">
                <div class="text-white w-10 h-10 rounded-xl flex items-center justify-center text-xl font-bold ">
                    <img src="{{ asset('images/sanepa.png') }}" alt="Logo Sanepa" class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="font-bold text-lg text-gray-800">E-Learning Sanepa</h1>
                    <p class="text-[11px] text-gray-600 -mt-1">Sanepa Juara</p>
                </div>
            </div>

            {{-- MENU DESKTOP --}}
            <div class="hidden md:flex gap-6 text-lg font-medium">
                <a href="{{ route('student.dashboard') }}"
                    class="{{ activeMenu(request()->routeIs('student.dashboard')) }}">Beranda</a>

                <a href="{{ route('student.kelas.index') }}"
                    class="{{ activeMenu(request()->routeIs('student.kelas.*')) }}">Kelas</a>

                <a href="{{ route('student.announcements.index') }}"
                    class="{{ activeMenu(request()->routeIs('student.announcements.*')) }}">Pengumuman</a>

                <a href="{{ route('student.forum.index') }}"
                    class="{{ activeMenu(request()->routeIs('student.forum.*')) }}">Forum</a>

                <a href="{{ route('student.profile.show') }}"
                    class="{{ activeMenu(request()->routeIs('student.profile.*')) }}">Profil</a>
            </div>

            {{-- FOTO PROFIL DAN NOTIF --}}
            @php
            $user = Auth::user();
            $photo = $user && $user->photo ? 'profile/' . $user->photo : null;
            $photoUrl = ($photo && Storage::disk('public')->exists($photo))
            ? asset('storage/' . $photo)
            : 'https://ui-avatars.com/api/?background=4F46E5&color=fff&name=' . urlencode($user->name ?? 'User');
            @endphp

            <div class="flex items-center gap-4">

                {{-- NOTIFICATION BUTTON --}}
                <div class="relative" x-data="{ open: false }">

                    <button @click="open = !open" class="relative hover:scale-110 transition">
                        <span class="text-xl">🔔</span>

                        @if(!empty($unreadCount) && $unreadCount > 0)
                        <span
                            class="absolute -top-1 -right-1 min-w-[18px] h-[18px] bg-red-600 text-white text-[10px] rounded-full flex items-center justify-center">
                            {{ $unreadCount }}
                        </span>
                        @endif
                    </button>

                    {{-- DROPDOWN --}}
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-80 bg-white shadow-xl border rounded-lg overflow-hidden z-50">

                        <div class="px-4 py-2 bg-indigo-50 text-indigo-700 font-semibold">
                            Notifikasi
                        </div>

                        <ul class="divide-y divide-gray-200 max-h-72 overflow-y-auto">

                            @forelse($notifications ?? [] as $note)
                            <li class="px-4 py-3 {{ !$note->is_read ? 'bg-indigo-50' : '' }}">
                                <p class="text-sm text-gray-700 leading-snug">
                                    {{ $note->message }}
                                </p>

                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-xs text-gray-400">
                                        {{ $note->created_at->diffForHumans() }}
                                    </span>

                                    @if(!$note->is_read)
                                    <form action="{{ route('notifications.read', $note->id) }}" method="POST">
                                        @csrf
                                        <button class="text-xs text-indigo-600 hover:underline">
                                            Tandai dibaca
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </li>
                            @empty
                            <li class="px-4 py-3 text-sm text-gray-500">
                                Tidak ada notifikasi.
                            </li>
                            @endforelse

                        </ul>
                    </div>
                </div>

                {{-- PROFILE DROPDOWN DESKTOP --}}
                <div class="hidden md:flex items-center gap-3 relative group">
                    <img src="{{ $photoUrl }}"
                        class="w-10 h-10 rounded-full object-cover ring-2 ring-indigo-200 cursor-pointer" />

                    <span class="font-medium text-gray-700 cursor-pointer">
                        Halo, {{ $user->name }}
                    </span>

                    {{-- DROPDOWN PROFIL --}}
                    <div
                        class="absolute right-0 mt-12 w-40 bg-white rounded-md shadow-lg border border-gray-200 opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all">

                        <a href="{{ route('student.profile.show') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">
                            Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>

                {{-- HAMBURGER MENU (MOBILE) --}}
                <button id="menuBtn"
                    class="md:hidden text-3xl ml-2 focus:outline-none relative flex flex-col justify-between w-6 h-6">

                    <span id="line1"
                        class="block h-0.5 w-full bg-gray-800 transition-transform duration-300 origin-top-left"></span>

                    <span id="line2"
                        class="block h-0.5 w-full bg-gray-800 transition-opacity duration-300"></span>

                    <span id="line3"
                        class="block h-0.5 w-full bg-gray-800 transition-transform duration-300 origin-bottom-left"></span>
                </button>
            </div>
        </div>

        {{-- MENU MOBILE --}}
        <div id="mobileMenu"
            class="md:hidden hidden flex-col bg-white/80 backdrop-blur-sm border-t shadow-lg p-4 text-sm transition-all">

            <a href="{{ route('student.dashboard') }}"
                class="py-2 {{ activeMenu(request()->routeIs('student.dashboard')) }}">Beranda</a>

            <a href="{{ route('student.profile.show') }}"
                class="py-2 {{ activeMenu(request()->routeIs('student.profile.*')) }}">Profil</a>

            <a href="{{ route('student.announcements.index') }}"
                class="py-2 {{ activeMenu(request()->routeIs('student.announcements.*')) }}">Pengumuman</a>

            <a href="{{ route('student.kelas.index') }}"
                class="py-2 {{ activeMenu(request()->routeIs('student.kelas.*')) }}">Kelas</a>

            <a href="{{ route('student.forum.index') }}"
                class="py-2 {{ activeMenu(request()->routeIs('student.forum.*')) }}">Forum</a>

            {{-- LOGOUT MOBILE --}}
            <form method="POST" action="{{ route('logout') }}" class="pt-3 border-t mt-3">
                @csrf
                <button class="text-red-600 font-semibold w-full text-left">Keluar</button>
            </form>
        </div>

    </nav>


    {{-- ==================================
            MAIN CONTENT
    =================================== --}}
    <main class="pt-28 pb-16 px-6 max-w-7xl mx-auto">
        @yield('page-title')
        @yield('content')
    </main>


    {{-- ==================================
                FOOTER
    =================================== --}}
    <footer class="bg-white/70 backdrop-blur-sm border-t border-gray-200 py-6 mt-10 shadow-inner">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-gray-600 text-sm">
            <p>&copy; {{ date('Y') }} <strong>E-Learning Sanepa</strong>. Hak Dilindungi.</p>
            <p class="mt-1 md:mt-0 text-xs">Dikembangkan untuk SMAN 1 Pabuaran oleh Fajar Agustian.</p>
        </div>
    </footer>


    {{-- ==================================
                SCRIPT
    =================================== --}}
    <script>
        // Script Animasi Hamburger Menu
        const btn = document.getElementById('menuBtn');
        const menu = document.getElementById('mobileMenu');

        const line1 = document.getElementById('line1');
        const line2 = document.getElementById('line2');
        const line3 = document.getElementById('line3');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');

            // Animasi garis hamburger
            line1.classList.toggle('rotate-45');
            line1.classList.toggle('translate-y-1.5');

            line2.classList.toggle('opacity-0');

            line3.classList.toggle('-rotate-45');
            line3.classList.toggle('-translate-y-1.5');
        });
    </script>

    @stack('scripts')
</body>

</html>