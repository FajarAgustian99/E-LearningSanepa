@extends('layouts.teacher')

{{-- Judul halaman --}}
@section('title', 'Tambah Diskusi')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md">

    {{-- Header Form --}}
    <h2 class="text-2xl font-semibold text-blue-700 mb-5">➕ Tambah Diskusi Baru</h2>

    {{-- Form Tambah Diskusi --}}
    <form action="{{ route('teacher.discussions.store') }}" method="POST">
        @csrf {{-- Token keamanan Laravel --}}

        {{-- Pilihan Kelas --}}
        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Pilih Kelas</label>

            <select name="class_id" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                <option value="">-- Pilih Kelas --</option>

                {{-- Loop daftar kelas --}}
                @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->description }}</option>
                @endforeach
            </select>
        </div>

        {{-- Input Judul Diskusi --}}
        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Judul Diskusi</label>
            <input
                type="text"
                name="title"
                class="w-full border border-gray-300 rounded-lg px-4 py-2"
                required>
        </div>

        {{-- Input Isi Diskusi --}}
        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Isi Diskusi</label>
            <textarea
                name="content"
                rows="5"
                class="w-full border border-gray-300 rounded-lg px-4 py-2"
                required></textarea>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex gap-2">
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                💾 Simpan
            </button>

            <a
                href="{{ route('teacher.discussions.index') }}"
                class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg">
                ← Kembali
            </a>
        </div>

    </form>
</div>

@endsection