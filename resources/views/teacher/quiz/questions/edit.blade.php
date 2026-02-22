@extends('layouts.teacher')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md mt-6">
    <h1 class="text-xl font-bold mb-4">✏️ Edit Pertanyaan untuk: {{ $quiz->title }}</h1>

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded">
        {{ session('success') }}
    </div>
    @endif

    {{-- Form Edit Soal --}}
    <form action="{{ route('teacher.quiz.questions.update', [$quiz->id, $question->id]) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Pilih tipe soal --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Tipe Soal</label>
            <select name="is_essay" class="border rounded-md w-full p-2" id="is_essay_select">
                <option value="0" {{ $question->is_essay == 0 ? 'selected' : '' }}>Pilihan Ganda</option>
                <option value="1" {{ $question->is_essay == 1 ? 'selected' : '' }}>Essay</option>
            </select>
        </div>

        {{-- Pertanyaan --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Pertanyaan</label>
            <textarea name="question_text" class="border rounded-md w-full p-2" required>{{ old('question_text', $question->question_text) }}</textarea>
        </div>

        {{-- Pilihan Ganda --}}
        <div id="multiple-choice-fields" class="{{ $question->is_essay ? 'hidden' : '' }}">
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

        {{-- Essay --}}
        <div id="essay-field" class="{{ $question->is_essay ? '' : 'hidden' }} mb-4">
            <label class="block font-medium mb-1">Contoh Jawaban (Opsional)</label>
            <textarea name="essay_answer" class="border rounded-md w-full p-2" placeholder="Tuliskan contoh jawaban...">{{ old('essay_answer', $question->essay_answer) }}</textarea>
        </div>

        {{-- Skor --}}
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-medium mb-1">Skor Jawaban Benar</label>
                <input type="number" name="score_correct" value="{{ old('score_correct', $question->score_correct) }}" class="border rounded-md w-full p-2" required>
            </div>
            <div>
                <label class="block font-medium mb-1">Skor Jawaban Salah</label>
                <input type="number" name="score_incorrect" value="{{ old('score_incorrect', $question->score_incorrect) }}" class="border rounded-md w-full p-2" required>
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                💾 Perbarui Pertanyaan
            </button>
            <a href="{{ route('teacher.quiz.show', $quiz->id) }}" class="text-gray-600 hover:text-gray-800">⬅ Kembali ke Quiz</a>
        </div>
    </form>
</div>

<script>
    const selectType = document.getElementById('is_essay_select');
    const mcFields = document.getElementById('multiple-choice-fields');
    const essayField = document.getElementById('essay-field');

    selectType.addEventListener('change', () => {
        if (selectType.value === '1') {
            mcFields.classList.add('hidden');
            essayField.classList.remove('hidden');
        } else {
            mcFields.classList.remove('hidden');
            essayField.classList.add('hidden');
        }
    });
</script>
@endsection