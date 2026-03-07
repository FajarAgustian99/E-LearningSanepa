@extends('layouts.student')

@section('title', 'Hasil Asesmen')
@section('page-title', 'Hasil Asesmen')

@section('content')
<div class="container mx-auto px-4 py-10">

    <div class="bg-white p-8 rounded-xl shadow-lg">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-3xl font-bold text-[#0A1D56]">
                📝 {{ $quiz->title }}
            </h2>
        </div>

        {{-- SCORE --}}
        <div class="bg-green-100 border-l-4 border-green-600 p-4 rounded-lg mb-6">
            <p class="text-xl font-bold text-green-700">
                🎉 Total Nilai Anda: <span class="font-extrabold">{{ $submission->score }}</span>
            </p>
        </div>

        {{-- TITLE --}}
        <h3 class="text-xl font-semibold mb-4 text-gray-800">📘 Jawaban Anda</h3>

        {{-- ANSWER LIST --}}
        <div class="space-y-5">
            @foreach ($answers as $answer)
            <div class="p-5 rounded-xl border shadow-sm hover:shadow-md transition">

                {{-- PERTANYAAN --}}
                <p class="font-semibold text-gray-900 mb-2 text-lg">
                    {{ $answer->question->question_text }}
                </p>

                {{-- MULTIPLE CHOICE --}}
                @if ($answer->question->question_type == 'multiple_choice')

                <div class="mt-1 text-gray-700 space-y-1">
                    <p class="text-sm">
                        Jawaban Anda:
                        <span class="font-bold text-blue-600">
                            {{ strtoupper(str_replace('option_', '', $answer->selected_option)) }}
                        </span>
                    </p>
                    <p class="text-sm">
                        Jawaban Benar:
                        <span class="font-bold text-green-700">
                            {{ strtoupper(str_replace('option_', '', $answer->question->correct_answer)) }}
                        </span>
                    </p>
                    @if ($answer->is_correct)
                    <p class="text-green-600 font-bold text-sm mt-2">
                        ✔ Benar
                    </p>
                    @else
                    <p class="text-red-600 font-bold text-sm mt-2">
                        ✘ Salah
                    </p>
                    @endif
                </div>
                @endif

                {{-- ESSAY --}}
                @if ($answer->question->question_type == 'essay')
                <div class="mt-3 text-gray-700">
                    <p class="font-medium">Jawaban Anda:</p>
                    <div class="bg-gray-50 p-3 rounded border text-sm mt-1">
                        {{ $answer->answer_text }}
                    </div>

                    <td class="px-4 py-3">
                        @php
                        $hasEssay = $quiz->questions->where('question_type','essay')->count() > 0;
                        $essayCompleted = !empty($submission->essay_scores) && array_sum($submission->essay_scores) > 0;
                        @endphp

                        @if($hasEssay)
                        @if($essayCompleted)
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">
                            ✅ Selesai Dinilai
                        </span>
                        @else
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">
                            ⏳ Menunggu penilaian guru
                        </span>
                        @endif
                        @else
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">
                            Selesai
                        </span>
                        @endif
                    </td>
                </div>
                @endif

            </div>
            @endforeach
        </div>
        <div class="mt-6">
            <a href="{{ route('student.quiz.show', $quiz->id) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                ← Kembali ke Daftar Asesmen
            </a>
        </div>
    </div>


</div>
@endsection