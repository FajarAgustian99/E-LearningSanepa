@extends('layouts.admin')

@section('title', 'Edit Kelas')

@section('content')
<h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
    Edit Kelas
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

    <form action="{{ route('admin.classes.update', $class->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Nama Kelas --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-800 mb-1">
                Nama Kelas
            </label>
            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name', $class->name) }}"
                class="block w-full border border-gray-300 rounded-lg p-3 shadow-sm focus:ring focus:ring-blue-300 focus:outline-none"
                required>
        </div>

        {{-- Tingkat Kelas --}}
        <div>
            <label for="grade" class="block text-sm font-semibold text-gray-800 mb-1">
                Tingkat Kelas
            </label>
            <select
                name="grade"
                id="grade"
                value="{{ old('grade', $class->grade) }}"
                class="block w-full border border-gray-300 rounded-lg p-3 shadow-sm focus:ring focus:ring-blue-300 focus:outline-none"
                required>
                <option value="">-- Pilih Tingkat Kelas --</option>
                <option value="X" {{ old('grade', $class->grade) == 'X' ? 'selected' : '' }}>X</option>
                <option value="XI" {{ old('grade', $class->grade) == 'XI' ? 'selected' : '' }}>XI</option>
                <option value="XII" {{ old('grade', $class->grade) == 'XII' ? 'selected' : '' }}>XII</option>
            </select>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-800 mb-1">
                Deskripsi
            </label>
            <textarea
                name="description"
                id="description"
                rows="4"
                class="block w-full border border-gray-300 rounded-lg p-3 shadow-sm focus:ring focus:ring-blue-300 focus:outline-none">{{ old('description', $class->description) }}</textarea>
        </div>

        {{-- Tombol --}}
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