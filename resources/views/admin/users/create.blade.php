@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Judul Halaman --}}
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
        Tambah User
    </h2>
    {{-- ===============================
        CARD FORM TAMBAH USER
    ================================ --}}
    <div class="mx-auto w-[560px]">
        {{-- FORM INPUT USER --}}
        <form method="POST"
            action="{{ route('admin.users.store') }}"
            class="space-y-4 bg-white p-6 rounded-lg shadow-md">

            @csrf

            {{-- NAMA USER --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input
                    type="text"
                    name="name"
                    required
                    class="w-full px-4 py-2 border rounded-lg shadow-sm 
                           focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- NIP (Guru) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    NIP (Untuk Guru)
                </label>
                <input
                    type="text"
                    name="nip"
                    class="w-full px-4 py-2 border rounded-lg shadow-sm 
               focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- NISN (Siswa) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    NISN (Untuk Siswa)
                </label>
                <input
                    type="text"
                    name="nisn"
                    class="w-full px-4 py-2 border rounded-lg shadow-sm 
               focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- PILIH KELAS (OPSIONAL) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <select
                    name="class_id"
                    class="w-full px-4 py-2 border rounded-lg shadow-sm 
                           focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Pilih Kelas --</option>

                    @foreach($classes as $class)
                    <option value="{{ $class->id }}">
                        {{ $class->name }}
                    </option>
                    @endforeach

                </select>
            </div>

            {{-- PASSWORD --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full px-4 py-2 border rounded-lg shadow-sm 
                           focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- KONFIRMASI PASSWORD --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    class="w-full px-4 py-2 border rounded-lg shadow-sm 
                           focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- ROLE USER --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select
                    name="role_id"
                    required
                    class="w-full px-4 py-2 border rounded-lg shadow-sm 
                           focus:ring-indigo-500 focus:border-indigo-500">

                    @foreach($roles as $r)
                    <option value="{{ $r->id }}">
                        {{ $r->name }}
                    </option>
                    @endforeach

                </select>
            </div>

            {{-- TOMBOL SUBMIT --}}
            <div class="text-right">
                <button type="submit"
                    class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold 
                           rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-green-300">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection