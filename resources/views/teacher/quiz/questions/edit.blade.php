@extends('layouts.teacher')

@section('content')

<h1 class="text-xl font-bold mb-4 text-center">✏️ Ubah Pertanyaan untuk: {{ $quiz->title }}</h1>
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md mt-6">


    {{-- Alert Success --}}
    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('teacher.quiz.questions.update', [$quiz->id, $question->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Tipe Soal --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Tipe Soal</label>
            <select name="question_type" class="border rounded-md w-full p-2" id="question_type_select">
                <option value="multiple_choice" {{ $question->question_type == 'multiple_choice' ? 'selected' : '' }}>
                    Pilihan Ganda
                </option>

                <option value="essay" {{ $question->question_type == 'essay' ? 'selected' : '' }}>
                    Essay
                </option>
            </select>
        </div>

        {{-- Pertanyaan --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Pertanyaan</label>
            <textarea name="question_text" class="border rounded-md w-full p-2" required>{{ old('question_text', $question->question_text) }}</textarea>
        </div>

        {{-- Upload Gambar --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Gambar (Opsional)</label>

            @if($question->image)
            <div class="mb-2">
                <img src="{{ asset('storage/'.$question->image) }}" class="w-40 rounded border">
            </div>
            @endif

            <input type="file" name="image" class="border rounded-md w-full p-2">
        </div>

        {{-- PILIHAN GANDA --}}
        <div id="multiple-choice-fields" class="{{ $question->question_type == 'essay' ? 'hidden' : '' }}">

            <div class="grid grid-cols-2 gap-4 mb-4">
                <input type="text" name="option_a" value="{{ old('option_a', $question->option_a) }}" placeholder="Pilihan A" class="border rounded-md p-2">

                <input type="text" name="option_b" value="{{ old('option_b', $question->option_b) }}" placeholder="Pilihan B" class="border rounded-md p-2">

                <input type="text" name="option_c" value="{{ old('option_c', $question->option_c) }}" placeholder="Pilihan C" class="border rounded-md p-2">

                <input type="text" name="option_d" value="{{ old('option_d', $question->option_d) }}" placeholder="Pilihan D" class="border rounded-md p-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Jawaban Benar</label>

                <select name="correct_answer" class="border rounded-md w-full p-2">
                    <option value="">Pilih Jawaban</option>

                    <option value="A" {{ $question->correct_answer == 'A' ? 'selected' : '' }}>A</option>
                    <option value="B" {{ $question->correct_answer == 'B' ? 'selected' : '' }}>B</option>
                    <option value="C" {{ $question->correct_answer == 'C' ? 'selected' : '' }}>C</option>
                    <option value="D" {{ $question->correct_answer == 'D' ? 'selected' : '' }}>D</option>
                </select>
            </div>

        </div>

        {{-- ESSAY --}}
        <div id="essay-field" class="{{ $question->question_type == 'essay' ? '' : 'hidden' }} mb-4">

            <label class="block font-medium mb-1">Contoh Jawaban (Opsional)</label>

            <textarea name="essay_answer"
                class="border rounded-md w-full p-2"
                placeholder="Tuliskan contoh jawaban...">{{ old('essay_answer', $question->essay_answer) }}</textarea>

        </div>

        {{-- SKOR --}}
        <div class="grid grid-cols-2 gap-4 mb-4">

            <div>
                <label class="block font-medium mb-1">Skor Jawaban Benar</label>

                <input type="number"
                    name="score_correct"
                    value="{{ old('score_correct', $question->score_correct) }}"
                    class="border rounded-md w-full p-2"
                    required>
            </div>

            <div>
                <label class="block font-medium mb-1">Skor Jawaban Salah</label>

                <input type="number"
                    name="score_incorrect"
                    value="{{ old('score_incorrect', $question->score_incorrect) }}"
                    class="border rounded-md w-full p-2"
                    required>
            </div>

        </div>

        <div class="flex items-center justify-between mt-6">

            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                💾 Perbarui
            </button>

            <a href="{{ route('teacher.quiz.show', $quiz->id) }}"
                class="text-gray-600 hover:text-gray-800">
                ⬅ Kembali
            </a>

        </div>

    </form>
</div>

<script>
    const selectType = document.getElementById('question_type_select');
    const mcFields = document.getElementById('multiple-choice-fields');
    const essayField = document.getElementById('essay-field');

    selectType.addEventListener('change', function() {

        if (this.value === 'essay') {

            mcFields.classList.add('hidden');
            essayField.classList.remove('hidden');

        } else {

            mcFields.classList.remove('hidden');
            essayField.classList.add('hidden');

        }

    });
</script>

@endsection