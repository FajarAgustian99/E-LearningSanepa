@extends('layouts.teacher')

{{-- Judul halaman --}}
@section('title', 'Buat Asesmen Baru')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-md mt-8">

    {{-- Judul utama halaman --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-6">🧠 Buat Asesmen Baru</h1>

    {{-- Form membuat asesmen baru --}}
    <form action="{{ route('teacher.quiz.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- ID Kelas (hidden) --}}
        <input type="hidden" name="class_id" value="{{ $class_id }}">

        {{-- Input Judul Asesmen --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Judul Asesmen</label>
            <input
                type="text"
                name="title"
                required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-yellow-200"
                placeholder="Masukkan judul asesmen">
        </div>

        {{-- Input Deskripsi Asesmen --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Deskripsi</label>
            <textarea
                name="description"
                rows="3"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-yellow-200"
                placeholder="Tuliskan deskripsi atau petunjuk asesmen"></textarea>
        </div>

        {{-- Input Batas Waktu Pengerjaan --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Batas Waktu</label>
            <input
                type="datetime-local"
                name="due_date"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-yellow-200">
        </div>

        {{-- Input Durasi Asesmen --}}
        <div class="mb-4">
            <label for="duration" class="block text-sm font-medium text-gray-700">Durasi Quiz (menit)</label>
            <input
                type="number"
                name="duration"
                id="duration"
                placeholder="Contoh: 30"
                min="1"
                required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>

        {{-- Tombol Submit & Kembali --}}
        <div class="flex items-center gap-3">
            <button
                type="submit"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg font-medium shadow-sm">
                🚀 Simpan
            </button>

            <a
                href="{{ route('teacher.kelas.show', $class->id) }}"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-5 py-2.5 rounded-lg shadow-sm">
                ← Kembali
            </a>
        </div>
    </form>
</div>
@endsection