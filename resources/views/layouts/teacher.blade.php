<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Judul halaman --}}
    <title>Guru - @yield('title')</title>

    {{-- Vite assets --}}
    @vite(['resources/css/app.css', 'resources/js/admin.js'])

    {{-- Tambahan head jika diperlukan --}}
    @stack('head')

    {{-- Google Icons & Fonts --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/sanepa.png') }}">
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="flex min-h-screen">

        {{-- ========================================= --}}
        {{-- SIDEBAR DESKTOP --}}
        {{-- ========================================= --}}
        <aside class="bg-blue-900 text-white w-64 hidden md:flex flex-col justify-between">

            <div>

                {{-- Sidebar Header --}}
                <div class="p-6 border-b border-blue-800">
                    <h1 class="text-2xl font-bold text-center">E-Learning Sanepa</h1>
                </div>

                {{-- Menu Navigasi --}}

                @php
                use App\Models\Discussion;
                use Illuminate\Support\Facades\Auth;

                $hasNewComments = Discussion::where(
                'updated_at',
                '>',
                session('forum_last_visit_' . Auth::id(), now())
                )->exists();
                @endphp

                <nav class="flex flex-col mt-6 space-y-1">

                    <a href="{{ route('teacher.dashboard') }}" class="px-6 py-3 hover:bg-blue-800 flex items-center gap-3">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
                    </a>

                    <a href="{{ route('teacher.beranda') }}" class="px-6 py-3 hover:bg-blue-800 flex items-center gap-3">
                        <i data-lucide="globe" class="w-5 h-5"></i> Beranda
                    </a>

                    <a href="{{ route('teacher.kelas.index') }}" class="px-6 py-3 hover:bg-blue-800 flex items-center gap-3">
                        <i data-lucide="book-open" class="w-5 h-5"></i> Kelas
                    </a>

                    <a href="{{ route('teacher.attendance.index') }}" class="px-6 py-3 hover:bg-blue-800 flex items-center gap-3">
                        <i data-lucide="clock" class="w-5 h-5"></i> Absensi
                    </a>

                    <a href="{{ route('teacher.grades.index', ['classId' => $class->id ?? 1]) }}"
                        class="px-6 py-3 hover:bg-blue-800 flex items-center gap-3">
                        <i data-lucide="clipboard-list" class="w-5 h-5"></i> Agenda Kelas
                    </a>

                    <a href="{{ route('teacher.discussions.index') }}"
                        class="px-6 py-3 hover:bg-blue-800 flex items-center gap-3 relative">

                        <i data-lucide="messages-square" class="w-5 h-5"></i>
                        <span>Forum Diskusi</span>

                        @if ($hasNewComments)
                        <span class="absolute top-2 right-4 bg-red-500 text-white text-xs rounded-full px-2 py-0.5 animate-pulse">
                            Baru!
                        </span>
                        @endif
                    </a>

                    <a href="{{ route('teacher.profile.index') }}" class="px-6 py-3 hover:bg-blue-800 flex items-center gap-3">
                        <i data-lucide="user" class="w-5 h-5"></i> Profil
                    </a>

                </nav>


                {{-- Tombol Logout --}}
                <div class="p-6 border-t border-blue-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full bg-red-600 hover:bg-red-700 py-2 rounded-lg font-semibold">Keluar</button>
                    </form>
                </div>

            </div>
        </aside>


        {{-- ========================================= --}}
        {{-- SIDEBAR MOBILE --}}
        {{-- ========================================= --}}
        <div id="mobileSidebar"
            class="fixed inset-0 bg-blue-900 text-white w-64 p-6 transform -translate-x-full transition-transform md:hidden z-50 overflow-y-auto">

            <h1 class="text-2xl font-bold mb-4">LMS Guru</h1>

            {{-- Menu Mobile --}}
            <nav class="flex flex-col space-y-2">

                <a href="{{ route('teacher.dashboard') }}" class="py-2 px-4 rounded hover:bg-blue-800 flex gap-2">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                </a>

                <a href="{{ route('teacher.beranda') }}" class="py-2 px-4 rounded hover:bg-blue-800 flex gap-2">
                    <i data-lucide="globe" class="w-4 h-4"></i> Beranda
                </a>

                <a href="{{ route('teacher.attendance.index') }}" class="py-2 px-4 rounded hover:bg-blue-800 flex gap-2">
                    <i data-lucide="clock" class="w-4 h-4"></i> Absensi
                </a>

                <a href="{{ route('teacher.kelas.index') }}" class="py-2 px-4 rounded hover:bg-blue-800 flex gap-2">
                    <i data-lucide="book-open" class="w-4 h-4"></i> Kelas
                </a>

                <a href="{{ route('teacher.grades.index', ['classId' => $class->id ?? 1]) }}" class="py-2 px-4 rounded hover:bg-blue-800 flex gap-2">
                    <i data-lucide="clipboard-list" class="w-4 h-4"></i> Agenda Kelas
                </a>

                <a href="{{ route('teacher.discussions.index') }}" class="py-2 px-4 rounded hover:bg-blue-800 flex gap-2">
                    <i data-lucide="messages-square" class="w-4 h-4"></i> Forum Diskusi
                </a>

                <a href="{{ route('teacher.profile.index') }}" class="py-2 px-4 rounded hover:bg-blue-800 flex gap-2">
                    <i data-lucide="user" class="w-4 h-4"></i> Profil
                </a>

            </nav>


            {{-- Logout Mobile --}}
            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button class="w-full bg-red-600 hover:bg-red-700 py-2 rounded-lg font-semibold">Keluar</button>
            </form>

            <button id="closeSidebar"
                class="mt-3 w-full py-2 rounded-lg bg-gray-700 hover:bg-gray-600 font-semibold">
                Tutup
            </button>
        </div>


        {{-- ========================================= --}}
        {{-- KONTEN UTAMA --}}
        {{-- ========================================= --}}
        <div class="flex-1 flex flex-col">

            {{-- NAVBAR --}}
            <header class="bg-white shadow-md sticky top-0 z-10">
                <div class="flex justify-between items-center px-4 py-3 md:px-8">

                    {{-- Tombol Sidebar Mobile --}}
                    <button id="openSidebar" class="md:hidden text-blue-900 text-2xl">☰</button>

                    {{-- Title Halaman --}}
                    <h2 class="text-lg md:text-xl font-semibold">@yield('title')</h2>

                    {{-- Profil dan Notifikasi --}}
                    @php
                    $user = Auth::user();
                    $photoPath = $user && $user->photo ? 'profile/' . $user->photo : null;
                    $photoUrl = ($photoPath && Storage::disk('public')->exists($photoPath))
                    ? asset('storage/' . $photoPath)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&size=100';
                    @endphp

                    <div class="hidden md:flex items-center gap-4">

                        {{-- NOTIFIKASI --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="relative hover:scale-110 transition flex items-center">

                                <i data-lucide="bell" class="w-6 h-6"></i>

                                @if($unreadCount > 0)
                                <span
                                    class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-600 rounded-full animate-pulse">
                                </span>
                                @endif
                            </button>


                            {{-- DROPDOWN NOTIFIKASI --}}
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-80 bg-white border rounded-lg shadow-lg z-50 overflow-hidden">

                                <div class="px-4 py-2 bg-blue-50 font-semibold text-blue-700">
                                    Notifikasi
                                </div>

                                <ul class="max-h-64 overflow-y-auto divide-y">
                                    @forelse($notifications as $note)
                                    <li class="px-4 py-2 {{ !$note->is_read ? 'bg-blue-50' : '' }}">
                                        <form method="POST" action="{{ route('notifications.read', $note->id) }}">
                                            @csrf
                                            <button class="text-left w-full">
                                                <p class="text-sm text-gray-700">
                                                    {{ $note->message }}
                                                </p>
                                                <span class="text-xs text-gray-400">
                                                    {{ $note->created_at->diffForHumans() }}
                                                </span>
                                            </button>
                                        </form>
                                    </li>
                                    @empty
                                    <li class="px-4 py-3 text-sm text-gray-500">
                                        Tidak ada notifikasi
                                    </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>


                        {{-- Foto Profil --}}
                        <img src="{{ $photoUrl }}" alt="Foto Profil"
                            class="w-10 h-10 rounded-full object-cover border shadow-sm">

                        <span> Halo, {{ $user->name ?? 'Guru' }}</span>
                    </div>

                </div>
            </header>


            {{-- MAIN CONTENT --}}
            <main class="flex-1 p-4 md:p-8 overflow-auto">
                @yield('content')
            </main>


            {{-- FOOTER --}}
            <footer class="bg-white text-gray-600 text-center py-4 border-t">
                <p class="text-sm">
                    &copy; {{ date('Y') }} E-Learning Sanepa — Juara
                </p>
            </footer>

        </div>
    </div>


    {{-- ========================================= --}}
    {{-- SCRIPT: Toggle Sidebar --}}
    {{-- ========================================= --}}
    <script>
        const sidebar = document.getElementById('mobileSidebar');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');

        openBtn?.addEventListener('click', () => sidebar.classList.remove('-translate-x-full'));
        closeBtn?.addEventListener('click', () => sidebar.classList.add('-translate-x-full'));
    </script>

    @stack('scripts')

    {{-- SweetAlert Notifikasi --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session("error") }}'
        });
    </script>
    @endif

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>

</body>

</html>