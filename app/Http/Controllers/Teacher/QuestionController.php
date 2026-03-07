<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    public function create(Quiz $quiz)
    {
        return view('teacher.quiz.questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        // Cek apakah ada file dan ukurannya
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Maksimal 2MB (2048 KB)
            if ($file->getSize() > 2 * 1024 * 1024) {
                return back()->with('error', 'Gagal menyimpan pertanyaan. Ukuran gambar terlalu besar (maks 2MB).');
            }

            // Bisa juga cek validitas file
            if (!$file->isValid()) {
                return back()->with('error', 'Gagal menyimpan pertanyaan. File gambar tidak valid.');
            }
        }

        // Aturan validasi
        $rules = [
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,essay',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'score_correct' => 'required|numeric',
            'score_incorrect' => 'required|numeric',
        ];

        if ($request->question_type == 'multiple_choice') {
            $rules = array_merge($rules, [
                'option_a' => 'required|string',
                'option_b' => 'required|string',
                'option_c' => 'required|string',
                'option_d' => 'required|string',
                'correct_answer' => 'required|in:A,B,C,D',
            ]);
        }

        $validated = $request->validate($rules);

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('question_images', 'public');
        }

        // Atur kolom sesuai tipe soal
        if ($request->question_type == 'essay') {
            $validated['option_a'] = null;
            $validated['option_b'] = null;
            $validated['option_c'] = null;
            $validated['option_d'] = null;
            $validated['correct_answer'] = null;
            $validated['is_essay'] = 1;
        } else {
            $validated['essay_answer'] = null;
            $validated['is_essay'] = 0;
        }

        $validated['quiz_id'] = $quiz->id;

        Question::create($validated);

        return back()->with('success', 'Pertanyaan berhasil ditambahkan!');
    }

    public function edit(Quiz $quiz, Question $question)
    {
        return view('teacher.quiz.questions.edit', compact('quiz', 'question'));
    }

    public function update(Request $request, Quiz $quiz, Question $question)
    {
        $rules = [
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,essay',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'score_correct' => 'required|numeric',
            'score_incorrect' => 'required|numeric',
        ];

        // Jika pilihan ganda
        if ($request->question_type == 'multiple_choice') {
            $rules = array_merge($rules, [
                'option_a' => 'required|string',
                'option_b' => 'required|string',
                'option_c' => 'required|string',
                'option_d' => 'required|string',
                'correct_answer' => 'required|in:A,B,C,D',
            ]);
        }

        $validated = $request->validate($rules);

        // Upload gambar baru
        if ($request->hasFile('image')) {

            if ($question->image) {
                Storage::disk('public')->delete($question->image);
            }

            $validated['image'] = $request->file('image')
                ->store('question_images', 'public');
        }

        // Jika essay
        if ($request->question_type == 'essay') {

            $validated['option_a'] = null;
            $validated['option_b'] = null;
            $validated['option_c'] = null;
            $validated['option_d'] = null;
            $validated['correct_answer'] = null;
        }

        $question->update($validated);

        return redirect()
            ->route('teacher.quiz.show', $quiz->id)
            ->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        if ($question->image) {
            Storage::disk('public')->delete($question->image);
        }

        $question->delete();

        return back()->with('success', 'Pertanyaan berhasil dihapus!');
    }
}
