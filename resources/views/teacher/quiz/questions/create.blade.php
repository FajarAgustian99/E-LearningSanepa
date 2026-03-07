@extends('layouts.teacher')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md mt-6">
    <h1 class="text-xl font-bold mb-4">➕ Tambah Pertanyaan untuk: {{ $quiz->title }}</h1>

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded">
        {{ session('success') }}
    </div>
    @endif

    {{-- Form Tambah Soal --}}
    <form action="{{ route('teacher.quiz.questions.store', $quiz->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Pilih tipe soal --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Tipe Soal</label>

            <select name="question_type" id="question_type"
                class="border rounded-md w-full p-2">

                <option value="multiple_choice">Pilihan Ganda</option>
                <option value="essay">Essay</option>

            </select>
        </div>

        {{-- Pertanyaan --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Pertanyaan</label>
            <textarea name="question_text" class="border rounded-md w-full p-2" required></textarea>
        </div>

        {{-- Image --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Gambar (Opsional)</label>
            <input type="file" name="image" class="border rounded-md w-full p-2">
        </div>

        {{-- Pilihan Ganda --}}
        <div id="multiple_choice_fields">

            <div class="mb-4">
                <label>Option A</label>
                <input type="text" name="option_a" class="border w-full p-2">
            </div>

            <div class="mb-4">
                <label>Option B</label>
                <input type="text" name="option_b" class="border w-full p-2">
            </div>

            <div class="mb-4">
                <label>Option C</label>
                <input type="text" name="option_c" class="border w-full p-2">
            </div>

            <div class="mb-4">
                <label>Option D</label>
                <input type="text" name="option_d" class="border w-full p-2">
            </div>

            <div class="mb-4">
                <label>Jawaban Benar</label>

                <select name="correct_answer" class="border w-full p-2">
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>

        </div>

        {{-- Essay --}}

        <div id="essay_fields" style="display:none">

            <div class="mb-4">
                <label>Contoh Jawaban (Opsional)</label>

                <textarea name="essay_answer"
                    class="border rounded-md w-full p-2"
                    rows="4"></textarea>

            </div>

        </div>
        <div id="essay-field" class="hidden mb-4">
            <label class="block font-medium mb-1">Contoh Jawaban (Opsional)</label>
            <textarea name="essay_answer" class="border rounded-md w-full p-2" placeholder="Tuliskan contoh jawaban..."></textarea>
        </div>

        {{-- Skor --}}
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-medium mb-1">Skor Jawaban Benar</label>
                <input type="number" name="score_correct" value="10" class="border rounded-md w-full p-2" required>
            </div>
            <div>
                <label class="block font-medium mb-1">Skor Jawaban Salah</label>
                <input type="number" name="score_incorrect" value="0" class="border rounded-md w-full p-2" required>
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                💾 Simpan
            </button>
            <a href="{{ route('teacher.quiz.create', $quiz->class_id) }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">⬅ Kembali</a>
            <a href="{{ route('teacher.quiz.show', $quiz->id) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">⬅ Lihat Soal</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const typeSelect = document.getElementById("question_type");

        const mcFields = document.getElementById("multiple_choice_fields");

        const essayFields = document.getElementById("essay_fields");

        function toggleFields() {

            if (typeSelect.value === "essay") {

                mcFields.style.display = "none";
                essayFields.style.display = "block";

            } else {

                mcFields.style.display = "block";
                essayFields.style.display = "none";

            }

        }

        typeSelect.addEventListener("change", toggleFields);

        toggleFields();

    });
</script>

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