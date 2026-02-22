<header class="bg-white border-b border-gray-200 p-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <button @click="$root.__x.$data.toggle()" class="md:hidden p-2 rounded-md bg-gray-100">☰</button>
        <h1 class="text-lg font-semibold">@yield('title', 'Dashboard')</h1>
    </div>

    <!-- <div class="flex items-center gap-4">
        {{-- Nama user --}}
        <div class="text-sm text-gray-600 hidden sm:block">
            {{ auth()->user()->name ?? 'Admin' }}
        </div>

        {{-- Avatar user --}}
        <div>
            <img
                src="{{ auth()->user()->avatar 
                ? asset('storage/profile/' . auth()->user()->avatar) 
                : asset('images/1763118273.jpg') }}"
                alt="{{ auth()->user()->name ?? 'Admin' }}"
                class="w-8 h-8 rounded-full object-cover border-2 border-gray-200">
        </div>
    </div> -->

</header>