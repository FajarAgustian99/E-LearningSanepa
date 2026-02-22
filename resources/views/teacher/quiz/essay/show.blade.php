@extends('layouts.teacher')

@section('title', 'Penilaian Jawaban Siswa')

@section('content')
<div class="max-w-4xl mx-auto p-6">

    {{-- Judul --}}
    <h1 class="text-2xl font-bold text-blue-700 mb-6">
        📝 Penilaian Jawaban Siswa
    </h1>

    {{-- Info Siswa & Quiz --}}
    <div class="bg-white p-4 rounded-xl shadow mb-6">
        <p class="text-lg"><strong>Siswa:</strong> {{ $submission->user->name }}</p>
        <p class="text-lg"><strong>Quiz:</strong> {{ $quiz->title }}</p>
    </div>

    {{-- Form Penilaian --}}
    <form action="{{ route('teacher.quiz.essay.grade', [$quiz->id, $submission->id]) }}" method="POST">
        @csrf

        @foreach ($answers as $ans)
        @if ($ans->is_essay)
        <div class="mb-6 p-5 bg-gray-50 border rounded-xl shadow-sm">

            {{-- Pertanyaan --}}
            <p class="font-semibold text-gray-800">
                ❓ Pertanyaan:
            </p>
            <p class="mt-1 text-gray-700">
                {{ $ans->question->question_text }}
            </p>

            {{-- Jawaban Siswa --}}
            <div class="mt-4">
                <p class="font-semibold text-gray-800">✏️ Jawaban Siswa:</p>
                <div class="mt-2 bg-white border rounded-lg p-3 text-gray-700 whitespace-pre-line">
                    {{ $ans->answer }}
                </div>
            </div>

            {{-- Input Nilai --}}
            <div class="mt-4">
                <label class="block font-semibold text-gray-800 mb-1">
                    Berikan Nilai (0–100):
                </label>
                <input
                    type="number"
                    name="scores[{{ $ans->question->id }}]"
                    min="0"
                    max="100"
                    required
                    class="border rounded-lg px-3 py-2 w-32 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

        </div>
        @endif
        @endforeach

        {{-- Tombol Submit --}}
        <button
            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow transition">
            💾 Simpan Penilaian
        </button>

    </form>
</div>
@endsection