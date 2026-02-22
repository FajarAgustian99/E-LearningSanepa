@extends('layouts.student')

@section('title', 'Kerjakan Kuis')
@section('page-title', 'Kerjakan Kuis')

@section('content')

<div x-data="{ 
        total: {{ $quiz->questions->count() }}, 
        answered: 0 
    }"
    x-init="
        answered = document.querySelectorAll('input[type=radio]:checked, textarea:not(:placeholder-shown)').length
    "
    class="bg-white p-6 rounded-xl shadow-lg">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-[#0A1D56]">{{ $quiz->title }}</h2>

        <a href="{{ route('student.quiz.detail', $quiz->id) }}"
            class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium transition">
            ⬅ Kembali
        </a>
    </div>

    {{-- PROGRESS BAR --}}
    <div class="w-full bg-gray-200 h-3 rounded-full mb-6">
        <div
            class="bg-blue-600 h-3 rounded-full transition-all"
            :style="'width: ' + (answered / total * 100) + '%;'">
        </div>
    </div>
    <p class="text-sm text-gray-600 mb-6">
        Terjawab: <span x-text="answered"></span> / <span x-text="total"></span> soal
    </p>

    {{-- FORM --}}
    <form action="{{ route('student.quiz.submit', $quiz->id) }}" method="POST">
        @csrf

        @foreach ($quiz->questions as $index => $question)
        <div class="mb-6 pb-5 border-b border-gray-200">

            {{-- SOAL --}}
            <p class="text-lg font-semibold text-gray-800 mb-3">
                {{ $index + 1 }}. {{ $question->question_text }}
            </p>

            {{-- PILIHAN GANDA --}}
            @if ($question->question_type == 'multiple_choice')
            <div class="space-y-3">
                @foreach (['option_a','option_b','option_c','option_d'] as $option)
                @if ($question->$option)
                <label class="flex items-center gap-3 p-3 border rounded-lg hover:bg-blue-50 cursor-pointer transition">
                    <input type="radio"
                        name="answers[{{ $question->id }}]"
                        value="{{ $option }}"
                        class="text-blue-600"
                        required
                        x-on:change="answered = document.querySelectorAll('input[type=radio]:checked, textarea:not(:placeholder-shown)').length">
                    <span class="text-gray-700">{{ $question->$option }}</span>
                </label>
                @endif
                @endforeach
            </div>
            @endif

            {{-- ESSAY --}}
            @if ($question->question_type == 'essay')
            <textarea
                name="answers[{{ $question->id }}]"
                rows="4"
                class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-200"
                placeholder="Tuliskan jawaban Anda..."
                required
                x-on:input="answered = document.querySelectorAll('input[type=radio]:checked, textarea:not(:placeholder-shown)').length"></textarea>
            @endif

        </div>
        @endforeach

        {{-- SUBMIT --}}
        <div class="flex justify-end mt-6">
            <button class="bg-blue-600 text-white px-6 py-3 text-lg rounded-lg shadow hover:bg-blue-700 transition">
                Kumpulkan Kuis
            </button>
        </div>
    </form>

</div>

@endsection