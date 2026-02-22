<aside
    class="bg-gray-900 text-gray-100 h-full md:h-auto flex flex-col transition-all duration-300"
    :class="collapsed ? 'w-20' : 'w-64'"
    x-bind:class="{ 'fixed inset-0 z-40 md:static md:translate-x-0': mobileSidebarOpen }"
    style="min-width: 5rem;">

    {{-- Mobile overlay --}}
    <div x-show="mobileSidebarOpen"
        class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"
        @click="closeMobile()"></div>

    {{-- Mobile header --}}
    <div class="md:hidden flex items-center justify-between p-4 border-b border-gray-800">
        <div class="text-lg font-bold">E-Learning</div>
        <button @click="closeMobile()" class="text-xl">✕</button>
    </div>

    {{-- Sidebar content --}}
    <div class="flex-1 flex flex-col h-full">

        {{-- Header --}}
        <div class="hidden md:flex items-center justify-center p-4 border-b border-gray-800 font-bold text-center text-lg">
            <span x-show="!collapsed">E-LEARNING SANEPA</span>
            <span x-show="collapsed">LMS</span>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 flex flex-col p-4 space-y-2 overflow-y-auto">

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800' : '' }}">
                <span class="material-icons">dashboard</span>
                <span x-show="!collapsed" class="truncate">Dashboard</span>
            </a>

            {{-- Pengumuman --}}
            <a href="{{ route('admin.announcements.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->routeIs('admin.announcements.*') ? 'bg-gray-800' : '' }}">
                <span class="material-icons">campaign</span>
                <span x-show="!collapsed">Pengumuman</span>
            </a>

            {{-- Kelas --}}
            <a href="{{ route('admin.classes.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->routeIs('admin.classes.*') ? 'bg-gray-800' : '' }}">
                <span class="material-icons">class</span>
                <span x-show="!collapsed">Kelola Kelas</span>
            </a>

            {{-- Siswa --}}
            <a href="{{ route('admin.students.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->routeIs('admin.students.*') ? 'bg-gray-800' : '' }}">
                <span class="material-icons">people</span>
                <span x-show="!collapsed">Kelola Siswa</span>
            </a>

            {{-- Mata Pelajaran --}}
            <a href="{{ route('admin.courses.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->routeIs('admin.courses.*') ? 'bg-gray-800' : '' }}">
                <span class="material-icons">menu_book</span>
                <span x-show="!collapsed">Kelola Mapel</span>
            </a>

            {{-- Absensi --}}
            <a href="{{ route('admin.attendance.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->routeIs('admin.attendance.*') ? 'bg-gray-800' : '' }}">
                <span class="material-icons">calendar_today</span>
                <span x-show="!collapsed">Kelola Absensi</span>
            </a>

            {{-- User --}}
            <a href="{{ route('admin.users.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->routeIs('admin.users.*') ? 'bg-gray-800' : '' }}">
                <span class="material-icons">manage_accounts</span>
                <span x-show="!collapsed">Kelola User</span>
            </a>
        </nav>

        {{-- Footer --}}
        <div class="p-4 border-t border-gray-800">
            {{-- Toggle sidebar --}}
            <button @click="toggle()"
                class="w-full text-sm bg-gray-800 px-3 py-2 rounded-md flex justify-center items-center gap-2 hover:bg-gray-700 transition">
                <span x-show="!collapsed">Sembunyikan Sidebar</span>
                <span x-show="collapsed" class="material-icons">menu</span>
            </button>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit"
                    class="w-full text-left px-3 py-2 rounded-md bg-red-600 hover:bg-red-500 flex items-center gap-2">
                    <span class="material-icons">logout</span>
                    <span x-show="!collapsed">Keluar</span>
                </button>
            </form>
        </div>
    </div>

    {{-- Mobile toggle --}}
    <div class="md:hidden p-3">
        <button @click="openMobile()" class="w-full text-white bg-gray-800 px-3 py-2 rounded-md">Menu</button>
    </div>

</aside>