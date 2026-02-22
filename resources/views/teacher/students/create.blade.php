@extends('layouts.teacher')

@section('title', 'Tambah Siswa ke ' . $class->name)

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Judul Halaman --}}
    <h1 class="text-3xl font-bold text-blue-700 mb-6">
        ➕ Tambah Siswa - {{ $class->name }}
    </h1>

    {{-- Form Tambah Siswa --}}
    <form
        action="{{ route('teacher.students.store', $class->id) }}"
        method="POST"
        class="bg-white p-6 rounded-xl shadow-md max-w-md border border-gray-200">
        @csrf

        {{-- Dropdown Pilih Siswa --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Pilih Siswa
            </label>

            <select
                name="student_id"
                class="w-full border border-gray-300 rounded-md px-3 py-2
                       focus:ring focus:ring-blue-200 focus:outline-none">
                <option value="">-- Pilih Siswa --</option>

                @foreach($students as $student)
                <option value="{{ $student->id }}">
                    {{ $student->name }} — {{ $student->email }}
                </option>
                @endforeach
            </select>

            @error('student_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end mt-6 space-x-2">
            <a
                href="{{ route('teacher.students.index', $class->id) }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                Batal
            </a>

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                ➕ Tambah ke Kelas
            </button>
        </div>
    </form>

</div>
@endsection