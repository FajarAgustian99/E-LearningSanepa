@extends('layouts.teacher')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow-md mt-6">

    {{-- Header Quiz --}}
    <h1 class="text-2xl font-bold mb-2">📋 {{ $quiz->title }}</h1>

    {{-- 📝 Deskripsi & Informasi Quiz --}}
    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm mb-6">
        <h3 class="text-lg font-semibold text-blue-600 mb-3 flex items-center gap-2">
            📘 Informasi Quiz
        </h3>

        <div class="space-y-2 text-gray-700">
            <p>
                <span class="font-medium text-gray-800">Deskripsi:</span>
                {{ $quiz->description ?? '-' }}
            </p>
            <p>
                <span class="font-medium text-gray-800">Durasi:</span>
                {{ $quiz->duration ? $quiz->duration . ' menit' : '-' }}
            </p>
            <p>
                <span class="font-medium text-gray-800"> Waktu Pengerjaan:</span>
                {{ $quiz->due_date ? \Carbon\Carbon::parse($quiz->due_date)->translatedFormat('d F Y H:i') : '-' }} WIB
            </p>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-4 flex justify-center">
            <a href="{{ route('teacher.quiz.edit', $quiz->id) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm shadow-md transition-all duration-200">
                ✏️ Edit Quiz
            </a>
        </div>
    </div>

    <hr class="my-4">

    {{-- Tombol Tambah Pertanyaan --}}
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Daftar Pertanyaan</h2>
        <a href="{{ route('teacher.quiz.questions.create', $quiz->id) }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-all">
            + Tambah Pertanyaan
        </a>
    </div>

    {{-- Daftar Pertanyaan --}}
    @if($questions->count())
    <ol class="list-decimal list-inside space-y-5">
        @foreach($questions as $q)
        <li>
            <p class="font-semibold text-gray-800">{{ $q->question_text }}</p>

            {{-- Pilihan Ganda --}}
            @if(!$q->is_essay)
            <ul class="ml-5 mt-2 text-gray-700">
                <li>A. {{ $q->option_a }}</li>
                <li>B. {{ $q->option_b }}</li>
                <li>C. {{ $q->option_c }}</li>
                <li>D. {{ $q->option_d }}</li>
            </ul>
            <p class="mt-1 text-green-700 text-sm">Jawaban Benar: {{ $q->correct_answer }}</p>

            {{-- Essay --}}
            @else
            <p class="mt-2 text-blue-700 italic text-sm">📝 Soal Essay</p>
            @if($q->essay_answer)
            <p class="mt-1 text-gray-700">Contoh Jawaban: {{ $q->essay_answer }}</p>
            @endif
            @endif

            {{-- Tombol Aksi --}}
            <div class="mt-3 flex gap-2">
                <a href="{{ route('teacher.quiz.questions.edit', [$quiz->id, $q->id]) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                    ✏️ Edit
                </a>
                <form action="{{ route('teacher.quiz.questions.delete', [$quiz->id, $q->id]) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus pertanyaan ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                        🗑️ Hapus
                    </button>
                </form>
            </div>
        </li>
        @endforeach
    </ol>
    @else
    <p class="text-gray-500 italic">Belum ada pertanyaan ditambahkan.</p>
    @endif
</div>
@endsection