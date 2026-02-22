<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;

class QuestionController extends Controller
{
    public function create(Quiz $quiz)
    {
        return view('teacher.quiz.questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $rules = [
            'question_text' => 'required|string',
            'is_essay' => 'required|boolean',
            'score_correct' => 'required|numeric',
            'score_incorrect' => 'required|numeric',
        ];

        if ($request->is_essay == 0) {
            // Pilihan Ganda
            $rules = array_merge($rules, [
                'option_a' => 'required|string',
                'option_b' => 'required|string',
                'option_c' => 'required|string',
                'option_d' => 'required|string',
                'correct_answer' => 'required|in:A,B,C,D',
            ]);
        }

        $validated = $request->validate($rules);

        // Jika essay
        if ($request->is_essay == 1) {
            $validated['option_a'] = null;
            $validated['option_b'] = null;
            $validated['option_c'] = null;
            $validated['option_d'] = null;
            $validated['correct_answer'] = null;
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
            'is_essay' => 'required|boolean',
            'score_correct' => 'required|numeric',
            'score_incorrect' => 'required|numeric',
        ];

        if ($request->is_essay == 0) {
            $rules = array_merge($rules, [
                'option_a' => 'required|string',
                'option_b' => 'required|string',
                'option_c' => 'required|string',
                'option_d' => 'required|string',
                'correct_answer' => 'required|in:A,B,C,D',
            ]);
        }

        $validated = $request->validate($rules);

        if ($request->is_essay == 1) {
            $validated['option_a'] = null;
            $validated['option_b'] = null;
            $validated['option_c'] = null;
            $validated['option_d'] = null;
            $validated['correct_answer'] = null;
        }

        $question->update($validated);

        return redirect()->route('teacher.quiz.show', $quiz->id)
            ->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        $question->delete();
        return back()->with('success', 'Pertanyaan berhasil dihapus!');
    }
}
