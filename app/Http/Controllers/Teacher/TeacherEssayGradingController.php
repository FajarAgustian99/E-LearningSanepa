<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizSubmission;
use App\Models\QuizAnswer;
use Illuminate\Http\Request;

class TeacherEssayGradingController extends Controller
{
    /**
     * Daftar submission quiz untuk dinilai guru
     */
    public function index(Quiz $quiz)
    {
        // Ambil semua submission yang sudah selesai
        $submissions = QuizSubmission::where('quiz_id', $quiz->id)
            ->with('student')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('teacher.quiz.essay.index', compact('quiz', 'submissions'));
    }

    /**
     * Menampilkan detail jawaban essay siswa
     */
    public function show(Quiz $quiz, QuizSubmission $submission)
    {
        // Pastikan submission milik quiz yang sama
        if ($submission->quiz_id != $quiz->id) {
            abort(404);
        }

        // Ambil jawaban hanya untuk essay
        $answers = QuizAnswer::where('submission_id', $submission->id)
            ->whereHas('question', function ($q) {
                $q->where('is_essay', true);
            })
            ->with('question')
            ->get();

        return view('teacher.quiz.essay.show', compact('quiz', 'submission', 'answers'));
    }

    /**
     * Simpan nilai essay
     */
    public function grade(Request $request, Quiz $quiz, QuizSubmission $submission)
    {
        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'numeric|min:0|max:100',
            'teacher_note' => 'nullable|string|max:1000',
        ]);

        // Update nilai tiap jawaban essay
        foreach ($request->grades as $answerId => $grade) {
            QuizAnswer::where('id', $answerId)->update([
                'grade' => $grade
            ]);
        }

        // Update total skor submission
        $totalScore = QuizAnswer::where('submission_id', $submission->id)->sum('grade');

        $submission->update([
            'score' => $totalScore,
            'is_graded' => true,
            'teacher_note' => $request->teacher_note,
        ]);

        return redirect()
            ->route('teacher.quiz.essay.index', $quiz->id)
            ->with('success', 'Penilaian essay berhasil disimpan.');
    }
}
