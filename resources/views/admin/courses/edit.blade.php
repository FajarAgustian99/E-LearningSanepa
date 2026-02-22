@extends('layouts.admin')

@section('title', 'Edit Mata Pelajaran')

@section('content')

<h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
    Edit Mata Pelajaran
</h2>
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mt-6">
    {{-- Tampilkan Error Validasi --}}
    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Form Edit Course --}}
    <form
        action="{{ route('admin.courses.update', $course->id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-4">
        @csrf
        @method('PUT')

        {{-- Judul Mapel --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                Judul
            </label>
            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title', $course->title) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm
                focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- Judul Kelas --}}
        <div>
            <label for="grade" class="block text-sm font-medium text-gray-700 mb-1">
                Kelas <span class="text-gray-400">(Opsional)</span>
            </label>

            <select
                id="grade"
                name="grade"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm
        focus:outline-none focus:ring-blue-500 focus:border-blue-500">

                <option value="">-- Pilih Kelas --</option>

                <option value="X" {{ old('grade', $course->grade) == 'X' ? 'selected' : '' }}>X</option>
                <option value="XI" {{ old('grade', $course->grade) == 'XI' ? 'selected' : '' }}>XI</option>
                <option value="XII" {{ old('grade', $course->grade) == 'XII' ? 'selected' : '' }}>XII</option>

            </select>
        </div>


        {{-- Deskripsi Mapel --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                Deskripsi
            </label>
            <textarea
                id="description"
                name="description"
                rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm
                focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description', $course->description) }}</textarea>
        </div>

        {{-- Pilih Guru Pengampu --}}
        <div>
            <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-1">
                Guru Pengampu
            </label>
            <select
                id="teacher_id"
                name="teacher_id"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm
                focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Pilih Guru --</option>
                @foreach ($teachers as $teacher)
                <option
                    value="{{ $teacher->id }}"
                    {{ old('teacher_id', $course->teacher_id) == $teacher->id ? 'selected' : '' }}>
                    {{ $teacher->name }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Kode Gabung --}}
        <div>
            <label for="join_code" class="block text-sm font-medium text-gray-700 mb-1">
                Kode Gabung
            </label>
            <input
                type="text"
                id="join_code"
                name="join_code"
                value="{{ old('join_code', $course->join_code) }}"
                placeholder="Contoh: ABC123"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm
                focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            <small class="text-gray-500 text-xs">Siswa harus memasukkan kode ini saat gabung kelas.</small>
        </div>

        {{-- Foto Profil Mapel --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Foto Profil Mapel
            </label>

            {{-- Preview Gambar Jika Sudah Ada --}}
            @if (!empty($course->image))
            <div class="mb-2">
                <img
                    src="{{ Storage::url($course->image) }}"
                    alt="Course Image"
                    class="h-20 rounded shadow-sm">
            </div>
            @endif

            <input
                type="file"
                name="image"
                accept="image/*"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm
                focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end mt-4">
            <a
                href="{{ route('admin.courses.index') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg mr-2
                hover:bg-gray-600 transition-colors">
                Batal
            </a>

            <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg
                hover:bg-blue-700 transition-colors">
                Update
            </button>
        </div>

    </form>
</div>
@endsection