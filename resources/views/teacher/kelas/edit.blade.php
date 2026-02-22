@extends('layouts.teacher')

@section('title', 'Edit Kelas')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-lg border border-gray-100">

        <h1 class="text-3xl font-bold text-center text-green-700 mb-6">✏️ Edit Kelas</h1>

        <form action="{{ route('teacher.kelas.update', $class->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama Kelas --}}
            <div class="mb-4">
                <label class="block font-medium mb-2">Nama Kelas</label>
                <input type="text" name="name" value="{{ $class->name }}"
                    class="w-full border rounded-lg px-3 py-2" required>
            </div>

            {{-- Pilih Course --}}
            <div class="mb-4">
                <label class="block font-medium mb-2">Pilih Mapel</label>
                <select name="courses[]" multiple class="w-full border rounded-lg px-3 py-2">
                    @foreach ($availableCourses as $course)
                    <option value="{{ $course->id }}"
                        {{ $class->courses->contains('id', $course->id) ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500">Tekan Ctrl/Cmd untuk memilih lebih dari satu</p>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label class="block font-medium mb-2">Deskripsi</label>
                <textarea name="description" rows="4"
                    class="w-full border rounded-lg px-3 py-2">{{ $class->description }}</textarea>
            </div>

            {{-- Tombol --}}
            <div class="text-center">
                <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">Simpan</button>
                <a href="{{ route('teacher.kelas.index') }}"
                    class="ml-4 bg-gray-600 text-white px-6 py-2 rounded-lg">Batal</a>
            </div>

        </form>
    </div>
</div>
@endsection