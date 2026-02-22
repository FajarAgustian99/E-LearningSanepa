@extends('layouts.student')

@section('title', 'Hasil Kuis')
@section('page-title', 'Hasil Kuis')

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
                🎉 Nilai Anda: <span class="font-extrabold">{{ $submission->score }}</span>
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

                    <p class="text-gray-500 text-sm mt-2 italic">
                        ⏳ Menunggu penilaian guru
                    </p>
                </div>
                @endif

            </div>
            @endforeach
        </div>

    </div>

</div>
@endsection