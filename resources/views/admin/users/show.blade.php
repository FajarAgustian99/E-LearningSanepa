@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Detail User</h2>

    <div class="bg-white shadow rounded-xl p-6 border">
        <form>
            {{-- Nama --}}
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-1">Nama</label>
                <input type="text"
                    value="{{ $user->name }}"
                    class="w-full px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed"
                    readonly>
            </div>

            {{-- Email --}}
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email"
                    value="{{ $user->email }}"
                    class="w-full px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed"
                    readonly>
            </div>

            {{-- Role --}}
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-1">Role</label>
                <input type="text"
                    value="{{ $user->role?->name ?? 'Tidak ada role' }}"
                    class="w-full px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed"
                    readonly>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.users.index') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg transition">
                    Kembali
                </a>
            </div>

        </form>
    </div>
</div>
@endsection