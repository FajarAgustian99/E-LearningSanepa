@extends('layouts.teacher')
@section('title','Profil')
@section('content')
<div class="max-w-6xl mx-auto px-4 md:px-0 py-6">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-6 shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-6 shadow-sm">
        {{ session('error') }}
    </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 gap-4">
        <h1 class="text-2xl font-bold text-[#0A1D56] flex items-center gap-2">
            👨‍🏫 Profil
        </h1>
    </div>

    {{-- Grid Profil --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- FOTO PROFIL --}}
        <div class="flex flex-col items-center bg-gray-50 p-6 rounded-xl shadow-sm">
            @php
            $photoPath = 'profile/' . $user->photo;
            $photoUrl = ($user->photo && Storage::disk('public')->exists($photoPath))
            ? asset('storage/' . $photoPath)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=200';
            @endphp

            <img src="{{ $photoUrl }}" alt="Foto {{ $user->name }}"
                class="w-40 h-40 rounded-full object-cover shadow-md border mb-4">

            <form action="{{ route('teacher.profile.update.photo') }}" method="POST" enctype="multipart/form-data" class="w-full">
                @csrf
                <label class="block text-sm font-medium mb-1">Ganti Foto</label>
                <input type="file" name="photo"
                    class="w-full text-sm border rounded px-2 py-1 mb-3 focus:ring focus:ring-blue-200 focus:outline-none"
                    accept="image/*">
                <button class="w-full bg-blue-600 text-white py-2 rounded-lg shadow-sm hover:bg-blue-700 transition">
                    Upload Foto Baru
                </button>
            </form>
        </div>

        {{-- FORM DATA DIRI --}}
        <div class="md:col-span-2 bg-gray-50 p-6 rounded-xl shadow-sm">
            <form action="{{ route('teacher.profile.update') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold mb-1 block">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $user->name }}"
                            class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>
                    <div>
                        <label class="font-semibold mb-1 block">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}"
                            class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>
                    <div>
                        <label class="font-semibold mb-1 block">NIP</label>
                        <input type="text" name="nip" value="{{ $user->nip }}"
                            class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>
                    <div>
                        <label class="font-semibold mb-1 block">Mata Pelajaran</label>
                        <input type="text" name="subject" value="{{ $user->subject }}"
                            class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>
                    <div>
                        <label class="font-semibold mb-1 block">Nomor HP</label>
                        <input type="text" name="phone" value="{{ $user->phone }}"
                            class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="font-semibold mb-1 block">Alamat</label>
                        <textarea name="address" rows="3"
                            class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">{{ $user->address }}</textarea>
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
    <div class="bg-gray-50 p-6 rounded-xl shadow-sm max-w-lg">
        <h2 class="text-2xl font-semibold mb-5 flex items-center gap-2">🔒 Ubah Password</h2>
        <form action="{{ route('teacher.profile.update.password') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="font-semibold mb-1 block">Password Lama</label>
                <input type="password" name="current_password"
                    class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">
            </div>
            <div class="mb-4">
                <label class="font-semibold mb-1 block">Password Baru</label>
                <input type="password" name="new_password"
                    class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">
            </div>
            <div class="mb-4">
                <label class="font-semibold mb-1 block">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation"
                    class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200 focus:outline-none">
            </div>
            <button class="bg-purple-600 text-white px-6 py-2 rounded-lg shadow-sm hover:bg-purple-700 transition">
                🔐 Update Password
            </button>
        </form>
    </div>

</div>
@endsection