<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizSubmission;
use App\Models\Question;
use Illuminate\Http\Request;

class QuizEssayController extends Controller
{
    /**
     * Daftar submission quiz untuk guru
     */
    public function index(Quiz $quiz)
    {
        $submissions = QuizSubmission::where('quiz_id', $quiz->id)
            ->with('user')
            ->latest()
            ->get();

        return view('teacher.quiz.essay.index', compact('quiz', 'submissions'));
    }

    /**
     * Lihat jawaban siswa untuk dinilai
     */
    public function show(Quiz $quiz, QuizSubmission $submission)
    {
        $answersJson = json_decode($submission->answers, true) ?? [];

        $answers = collect($quiz->questions)->map(function ($question) use ($answersJson) {
            return (object)[
                'question'   => $question,
                'answer'     => $answersJson[$question->id] ?? null,
                'is_essay'   => $question->question_type == 'essay'
            ];
        });

        return view('teacher.quiz.essay.show', compact('quiz', 'submission', 'answers'));
    }

    /**
     * Proses penilaian essay oleh guru
     */
    public function grade(Request $request, Quiz $quiz, QuizSubmission $submission)
    {
        $request->validate([
            'scores' => 'required|array'
        ]);

        $totalScore = 0;

        // Hitung total score berdasarkan input guru
        foreach ($request->scores as $score) {
            $totalScore += intval($score);
        }

        // Update score final
        $submission->score = $totalScore;
        $submission->save();

        return redirect()
            ->route('teacher.quiz.essay.index', $quiz->id)
            ->with('success', 'Penilaian berhasil disimpan!');
    }

    public function gradeEssay(Request $request, $quizId, $submissionId)
    {
        $submission = QuizSubmission::findOrFail($submissionId);

        $essayScores = $request->essay_scores ?? [];

        $totalEssayScore = array_sum($essayScores);

        $scoreCorrect = $submission->score_correct ?? 0;
        $scoreIncorrect = $submission->score_incorrect ?? 0;

        $finalScore = ($scoreCorrect - $scoreIncorrect) + $totalEssayScore;

        $submission->update([
            'score' => $finalScore
        ]);

        return back()->with('success', 'Nilai essay berhasil disimpan');
    }
}
