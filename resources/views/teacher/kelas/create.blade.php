@extends('layouts.teacher')

@section('title', 'Tambah Kelas')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-md mt-6">

    <h1 class="text-2xl font-bold mb-6 text-gray-800">➕ Tambah Kelas</h1>

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('teacher.kelas.store') }}" method="POST">
        @csrf

        {{-- Pilih Nama Kelas --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Nama Kelas</label>
            <select name="name" class="w-full border rounded-lg px-4 py-2 bg-gray-50" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach($availableClasses as $availableClass)
                <option value="{{ $availableClass->name }}" {{ old('name') == $availableClass->name ? 'selected' : '' }}>
                    {{ $availableClass->name }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Mata Pelajaran --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Mata Pelajaran</label>
            <select name="courses[]" multiple class="w-full border rounded-lg px-4 py-2 bg-gray-50" required>
                @foreach ($courses as $course)
                <option value="{{ $course->id }}" {{ (collect(old('courses'))->contains($course->id)) ? 'selected' : '' }}>
                    {{ $course->title }}
                </option>
                @endforeach
            </select>
            <p class="text-sm text-gray-500">Tekan Ctrl/Cmd untuk memilih lebih dari satu</p>
        </div>

        {{-- Deskripsi --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Deskripsi</label>
            <textarea name="description" rows="3"
                class="w-full border rounded-lg px-4 py-2"
                placeholder="Deskripsi kelas">{{ old('description') }}</textarea>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end">
            <a href="{{ route('teacher.kelas.index') }}" class="bg-gray-300 px-4 py-2 rounded-lg mr-2">Batal</a>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Simpan</button>
        </div>
    </form>
</div>
@endsection