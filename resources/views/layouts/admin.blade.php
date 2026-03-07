<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin - @yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/admin.js'])

    @stack('head')

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('images/sanepa.png') }}">
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="flex min-h-screen">

        {{-- =================================================== --}}
        {{-- SIDEBAR DESKTOP --}}
        {{-- =================================================== --}}
        <aside class="bg-blue-900 text-white w-64 hidden md:flex flex-col justify-between">

            <div>

                {{-- Header --}}
                <div class="p-6 border-b border-blue-800">
                    <h1 class="text-2xl font-bold text-center">
                        Admin Panel
                    </h1>
                </div>

                {{-- MENU --}}
                <nav class="flex flex-col mt-6 space-y-1">

                    <a href="{{ route('admin.dashboard') }}"
                        class="px-6 py-3 hover:bg-blue-800 flex items-center gap-3">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('admin.announcements.index') }}"
                        class="px-6 py-3 hover:bg-blue-800 flex items-center gap-3">
                        <i data-lucide="megaphone" class="w-5 h-5"></i>
                        <span>Pengumuman</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                        class="px-6 py-3 hover:bg-blue-800 flex items-center gap-3">
                        <i data-lucide="users" class="w-5 h-5"></i>
                        <span>Kelola User</span>
                    </a>

                    <a href="{{ route('admin.classes.index') }}"
                        class="px-6 py-3 hover:bg-blue-800 flex items-center gap-3">
                        <i data-lucide="school" class="w-5 h-5"></i>
                        <span>Kelola Kelas</span>
                    </a>

                    <a href="{{ route('admin.courses.index') }}"
                        class="px-6 py-3 hover:bg-blue-800 flex items-center gap-3">
                        <i data-lucide="book-open" class="w-5 h-5"></i>
                        <span>Kelola Mapel</span>
                    </a>

                    <a href="{{ route('admin.students.index') }}"
                        class="px-6 py-3 hover:bg-blue-800 flex items-center gap-3">
                        <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                        <span>Kelola Siswa</span>
                    </a>

                    <a href="{{ route('admin.attendance.index') }}"
                        class="px-6 py-3 hover:bg-blue-800 flex items-center gap-3">
                        <i data-lucide="clipboard-check" class="w-5 h-5"></i>
                        <span>Kelola Absensi</span>
                    </a>

                    <a href="{{ route('admin.grade.index') }}"
                        class="px-6 py-3 hover:bg-blue-800 flex items-center gap-3">
                        <i data-lucide="clipboard-check" class="w-5 h-5"></i>
                        <span>Kelola Nilai</span>
                    </a>

                </nav>


                {{-- Logout --}}
                <div class="p-6 border-t border-blue-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full bg-red-600 hover:bg-red-700 py-2 rounded-lg font-semibold">
                            Keluar
                        </button>
                    </form>
                </div>

            </div>

        </aside>


        {{-- =================================================== --}}
        {{-- SIDEBAR MOBILE --}}
        {{-- =================================================== --}}


        <div id="mobileSidebar"
            class="fixed inset-0 bg-blue-900 text-white w-64 p-6 transform -translate-x-full transition-transform md:hidden z-50 overflow-y-auto">

            <h1 class="text-2xl font-bold mb-4">Admin Panel</h1>

            <nav class="flex flex-col space-y-2">

                <a href="{{ route('admin.dashboard') }}" class="py-2 px-4 hover:bg-blue-800 rounded">📊 Dashboard</a>

                <a href="{{ route('admin.announcements.index') }}" class="py-2 px-4 hover:bg-blue-800 rounded">📢 Pengumuman</a>

                <a href="{{ route('admin.students.index') }}" class="py-2 px-4 hover:bg-blue-800 rounded">👨‍🎓 Kelola Siswa</a>

                <!-- <a href="{{ route('admin.teachers.index') }}" class="py-2 px-4 hover:bg-blue-800 rounded">👨‍🏫 Kelola Guru</a> -->

                <a href="{{ route('admin.courses.index') }}" class="py-2 px-4 hover:bg-blue-800 rounded">📘 Kelola Mapel</a>

                <a href="{{ route('admin.classes.index') }}" class="py-2 px-4 hover:bg-blue-800 rounded">🏫 Kelola Kelas</a>

                <a href="{{ route('admin.attendance.index') }}" class="py-2 px-4 hover:bg-blue-800 rounded">📝 Kelola Absensi</a>

                <a href="{{ route('admin.grade.index') }}" class="py-2 px-4 hover:bg-blue-800 rounded">📊 Kelola Nilai</a>

                <a href="{{ route('admin.users.index') }}" class="py-2 px-4 hover:bg-blue-800 rounded">🧑‍💻 Kelola User</a>

            </nav>

            {{-- Logout Mobile --}}
            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button class="w-full bg-red-600 hover:bg-red-700 py-2 rounded-lg font-semibold">
                    Keluar
                </button>
            </form>

            <button id="closeSidebar"
                class="mt-4 w-full py-2 rounded-lg bg-gray-700 hover:bg-gray-600 font-semibold">
                Tutup
            </button>
        </div>


        {{-- =================================================== --}}
        {{-- KONTEN UTAMA --}}
        {{-- =================================================== --}}
        <div class="flex-1 flex flex-col">

            {{-- NAVBAR --}}
            <header class="bg-white shadow-md sticky top-0 z-10">
                <div class="flex justify-between items-center px-4 py-3 md:px-8">

                    {{-- Toggle Sidebar Mobile --}}
                    <button id="openSidebar" class="md:hidden text-blue-900 text-2xl">☰</button>

                    {{-- Title --}}
                    <h2 class="text-lg md:text-xl font-semibold">@yield('title')</h2>

                    {{-- Profile --}}
                    @php
                    $user = Auth::user();
                    $photo = $user && $user->photo ? 'profile/' . $user->photo : null;
                    $photoUrl = ($photo && Storage::disk('public')->exists($photo))
                    ? asset('storage/'.$photo)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name);
                    @endphp

                    <div class="hidden md:flex items-center gap-3">

                        <img src="{{ $photoUrl }}" class="w-10 h-10 rounded-full border object-cover shadow-sm">
                        <span>Halo, {{ $user->name ?? 'Admin' }}</span>

                    </div>

                </div>
            </header>


            {{-- MAIN CONTENT --}}
            <main class="flex-1 p-2 md:p-3 overflow-auto">
                @yield('content')
            </main>


            {{-- FOOTER --}}
            <footer class="bg-white text-gray-600 text-center py-4 border-t">
                <p class="text-sm">&copy; {{ date('Y') }} E-Learning Sanepa — All Rights Reserved.</p>
            </footer>

        </div>
    </div>


    <script>
        const sidebar = document.getElementById('mobileSidebar');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');

        openBtn?.addEventListener('click', () =>
            sidebar.classList.remove('-translate-x-full')
        );

        closeBtn?.addEventListener('click', () =>
            sidebar.classList.add('-translate-x-full')
        );
    </script>

    {{-- ================= CHART.JS ================= --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- ================= PAGE SCRIPTS ================= --}}
    @stack('scripts')

    {{-- ================= SWEETALERT2 ================= --}}

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session("success") }}',
            timer: 1800,
            showConfirmButton: false
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
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