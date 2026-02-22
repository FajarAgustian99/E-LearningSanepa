@extends('layouts.student')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4">

    {{-- Header --}}
    <div class="mb-8 flex items-center gap-3">
        <div class="bg-indigo-100 text-indigo-600 p-2 rounded-full">
            <i class="fas fa-plus text-lg"></i>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-800">Buat Diskusi Baru</h2>
    </div>

    {{-- Error Alert --}}
    @if($errors->any())
    <div class="bg-red-50 border border-red-300 text-red-700 px-5 py-4 rounded-xl mb-6">
        <p class="font-semibold mb-2">Terjadi kesalahan:</p>
        <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('student.forum.store') }}" method="POST"
        class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">

        @csrf

        {{-- Title --}}
        <div class="mb-5">
            <label for="title" class="block mb-1 text-gray-700 font-semibold">Judul Diskusi</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                placeholder="Masukkan judul diskusi..." required>
        </div>

        {{-- Content --}}
        <div class="mb-5">
            <label for="content" class="block mb-1 text-gray-700 font-semibold">Konten Diskusi</label>
            <textarea name="content" id="content" rows="6"
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                placeholder="Tuliskan isi diskusi..." required>{{ old('content') }}</textarea>
        </div>

        {{-- Class --}}
        <div class="mb-6">
            <label for="class_id" class="block mb-1 text-gray-700 font-semibold">Pilih Kelas</label>
            <select name="class_id" id="class_id"
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-400 focus:outline-none bg-white"
                required>
                <option value="">-- Pilih Kelas --</option>
                @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                    {{ $class->description }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('student.forum.index') }}"
                class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                Kembali
            </a>

            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-5 rounded-lg shadow transition">
                Buat Diskusi
            </button>
        </div>

    </form>

</div>
@endsection