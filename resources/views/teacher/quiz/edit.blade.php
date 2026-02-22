@extends('layouts.teacher')

@section('content')
<div class="max-w-3xl mx-auto mt-8 bg-white shadow-md rounded-xl p-6">

    {{-- Judul Halaman --}}
    <h1 class="text-2xl font-bold text-yellow-700 mb-6">✏️ Edit Quiz</h1>

    {{-- Form Update Quiz --}}
    <form action="{{ route('teacher.quiz.update', $quiz->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Input Judul Quiz --}}
        <div>
            <label class="block font-semibold mb-1 text-gray-700">Judul Quiz</label>
            <input
                type="text"
                name="title"
                value="{{ old('title', $quiz->title) }}"
                required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 
                       focus:ring-2 focus:ring-yellow-500 focus:outline-none"
                placeholder="Masukkan judul quiz">
        </div>

        {{-- Input Deskripsi Quiz --}}
        <div>
            <label class="block font-semibold mb-1 text-gray-700">Deskripsi</label>
            <textarea
                name="description"
                rows="3"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 
                       focus:ring-2 focus:ring-yellow-500 focus:outline-none"
                placeholder="Tuliskan deskripsi atau petunjuk quiz">{{ old('description', $quiz->description) }}</textarea>
        </div>

        {{-- Input Batas Waktu --}}
        <div>
            <label class="block font-semibold mb-1 text-gray-700">Batas Waktu</label>
            <input
                type="datetime-local"
                name="due_date"
                value="{{ old('due_date', $quiz->due_date) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 
                       focus:ring-2 focus:ring-yellow-500 focus:outline-none">
        </div>

        {{-- Input Durasi Quiz --}}
        <div>
            <label class="block font-semibold mb-1 text-gray-700">Durasi (menit)</label>
            <input
                type="number"
                name="duration"
                value="{{ old('duration', $quiz->duration) }}"
                min="1"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 
                       focus:ring-2 focus:ring-yellow-500 focus:outline-none"
                placeholder="Contoh: 30">
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end space-x-2">
            {{-- Tombol kembali ke halaman sebelumnya --}}
            <a href="{{ url()->previous() }}"
                class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                Batal
            </a>

            {{-- Tombol simpan perubahan --}}
            <button
                type="submit"
                class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg shadow-md">
                💾 Simpan Perubahan
            </button>
        </div>

    </form>
</div>
@endsection