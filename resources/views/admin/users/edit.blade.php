@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container mx-auto px-4 py-6">

    <!-- Judul Halaman -->
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Edit User</h2>

    <div class="mx-auto w-full max-w-lg bg-white p-6 rounded-lg shadow-md">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- ============================
                 FIELD: NAMA USER
            ============================= --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name"
                    value="{{ old('name', $user->name) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg
                           focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    required>
            </div>

            {{-- ============================
     FIELD: IDENTITAS USER
============================= --}}

            {{-- NIP (Guru) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    NIP (Untuk Guru)
                </label>
                <input type="text" name="nip"
                    value="{{ old('nip', $user->nip) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg
               focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- NISN (Siswa) --}}
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    NISN (Untuk Siswa)
                </label>
                <input type="text" name="nisn"
                    value="{{ old('nisn', $user->nisn) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg
               focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>


            {{-- ============================
                 FIELD: ROLE USER
                 Admin / Guru / Siswa
            ============================= --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg
                           focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                    @foreach($roles as $r)
                    <option value="{{ $r->id }}" {{ $user->role_id == $r->id ? 'selected' : '' }}>
                        {{ $r->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- ============================
                 FIELD: KELAS (KHUSUS SISWA)
                 Tampil hanya jika role = Siswa
            ============================= --}}
            @if($user->role?->name === 'Siswa')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <select name="class_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg
                               focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Pilih Kelas --</option>

                    @foreach($classes as $class)
                    <option value="{{ $class->id }}"
                        {{ $user->class_id == $class->id ? 'selected' : '' }}>
                        {{ $class->description }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif

            {{-- ============================
                 TOMBOL UPDATE
            ============================= --}}
            <div class="text-right">
                <button type="submit"
                    class="px-6 py-2 bg-green-500 text-white font-semibold rounded-lg shadow
                           hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                    Update
                </button>
            </div>

        </form>
    </div>
</div>
@endsection