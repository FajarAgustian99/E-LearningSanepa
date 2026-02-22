@extends('layouts.student')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-md">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-6">
        {{ session('error') }}
    </div>
    @endif

    {{-- Judul Profil --}}
    <h1 class="text-3xl font-semibold mb-8 flex items-center gap-2">
        <span>🎓</span> Profil Siswa
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- FOTO PROFIL --}}
        <div class="flex flex-col items-center bg-gray-50 p-6 rounded-lg shadow-sm">
            @php
            $photoPath = 'profile/' . $user->photo;
            $photoUrl = ($user->photo && Storage::disk('public')->exists($photoPath))
            ? asset('storage/' . $photoPath)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=200';
            @endphp

            <img src="{{ $photoUrl }}"
                class="w-40 h-40 rounded-full object-cover shadow mb-4 border"
                alt="Foto {{ $user->name }}">

            <form action="{{ route('student.profile.update.photo') }}" method="POST" enctype="multipart/form-data" class="w-full">
                @csrf
                <label class="block text-sm font-medium mb-1">Ganti Foto:</label>
                <input type="file" name="photo" accept="image/*"
                    class="w-full text-sm border rounded px-2 py-1 mb-3 focus:ring focus:ring-blue-200 focus:outline-none">
                <button class="w-full bg-blue-600 text-white py-2 rounded-lg shadow-sm hover:bg-blue-700 transition">
                    Upload Foto Baru
                </button>
            </form>
        </div>

        {{-- FORM DATA DIRI --}}
        <div class="md:col-span-2">
            <form action="{{ route('student.profile.update') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="font-semibold mb-1 block">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">
                        @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="font-semibold mb-1 block">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">
                        @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- NISN --}}
                    <div>
                        <label class="font-semibold mb-1 block">NISN</label>
                        <input type="text" name="nisn" value="{{ old('nisn', $user->nisn) }}"
                            class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">
                        @error('nisn') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nomor HP --}}
                    <div>
                        <label class="font-semibold mb-1 block">Nomor HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">
                        @error('phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="md:col-span-2">
                        <label class="font-semibold mb-1 block">Alamat</label>
                        <textarea name="address" rows="3"
                            class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">{{ old('address', $user->address) }}</textarea>
                        @error('address') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>

                <button class="mt-6 bg-green-600 text-white px-6 py-2 rounded-lg shadow-sm hover:bg-green-700 transition">
                    💾 Simpan Perubahan
                </button>
            </form>
        </div>

    </div>

    {{-- Divider --}}
    <hr class="my-10">

    {{-- FORM UBAH PASSWORD --}}
    <h2 class="text-2xl font-semibold mb-5 flex items-center gap-2">
        <span>🔒</span> Ubah Password
    </h2>

    <form action="{{ route('student.profile.update.password') }}" method="POST" class="max-w-lg">
        @csrf

        {{-- Password Lama --}}
        <div class="mb-5">
            <label class="font-semibold mb-1 block">Password Lama</label>
            <input type="password" name="current_password"
                class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">
            @error('current_password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Password Baru --}}
        <div class="mb-5">
            <label class="font-semibold mb-1 block">Password Baru</label>
            <input type="password" name="new_password"
                class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">
            @error('new_password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mb-5">
            <label class="font-semibold mb-1 block">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation"
                class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">
        </div>

        <button class="bg-purple-600 text-white px-6 py-2 rounded-lg shadow-sm hover:bg-purple-700 transition">
            🔐 Update Password
        </button>
    </form>

</div>
@endsection