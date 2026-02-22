@extends('layouts.admin')
@section('title', 'Tambah Kelas')
@section('content')
<!-- <div class="container mx-auto p-4 bg-white rounded-lg shadow-md max-w-lg mt-8">
    <h1 class="text-3xl font-bold mb-6 text-blue-700">Tambah Kelas</h1>

    <form action="{{ route('admin.classes.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-800 mb-1">Nama Kelas</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full border border-blue-300 rounded-lg shadow-sm p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
        </div>
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-800 mb-1">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="mt-1 block w-full border border-blue-300 rounded-lg shadow-sm p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"></textarea>
        </div>
        <div class="flex space-x-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">Simpan</button>
            <a href="{{ route('admin.classes.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg font-semibold transition">Batal</a>
        </div>
    </form>
</div> -->
<h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
    Tambah Kelas
</h2>

<div class="container mx-auto p-6 bg-white rounded-lg shadow-md max-w-xl mt-8">

    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.classes.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Nama Kelas --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-800 mb-1">Nama Kelas</label>
            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name') }}"
                class="block w-full border border-gray-300 rounded-lg p-3 shadow-sm focus:ring focus:ring-blue-300 focus:outline-none"
                required>
        </div>

        {{-- Grade --}}
        <div>
            <label for="grade" class="block text-sm font-semibold text-gray-800 mb-1">Tingkat Kelas</label>
            <select
                type="text"
                name="grade"
                id="grade"
                value="{{ old('grade') }}"
                class="block w-full border border-gray-300 rounded-lg p-3 shadow-sm focus:ring focus:ring-blue-300 focus:outline-none"
                required>
                <option value="">-- Pilih Tingkat Kelas --</option>
                <option value="X" {{ old('grade') == 'X' ? 'selected' : '' }}>X</option>
                <option value="XI" {{ old('grade') == 'XI' ? 'selected' : '' }}>XI</option>
                <option value="XII" {{ old('grade') == 'XII' ? 'selected' : '' }}>XII</option>
            </select>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-800 mb-1">Deskripsi</label>
            <textarea
                name="description"
                id="description"
                rows="4"
                class="block w-full border border-gray-300 rounded-lg p-3 shadow-sm focus:ring focus:ring-blue-300 focus:outline-none">{{ old('description') }}</textarea>
        </div>

        {{-- Action Buttons --}}
        <div class="flex space-x-3">
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                Simpan
            </button>

            <a
                href="{{ route('admin.classes.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                Batal
            </a>
        </div>

    </form>
</div>
@endsection