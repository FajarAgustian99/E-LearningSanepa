<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizSubmission;
use Illuminate\Http\Request;
use Carbon\Carbon;

class QuizSubmissionController extends Controller
{
    /**
     * Detail quiz sebelum mulai
     */
    public function show(Quiz $quiz)
    {
        $submission = QuizSubmission::where('quiz_id', $quiz->id)
            ->where('user_id', auth()->id())
            ->first();

        return view('student.quiz.show', compact('quiz', 'submission'));
    }

    /**
     * Mulai mengerjakan quiz
     */
    public function start(Quiz $quiz)
    {
        $submission = QuizSubmission::where('quiz_id', $quiz->id)
            ->where('user_id', auth()->id())
            ->where('is_submitted', true)
            ->first();

        if ($submission) {
            return redirect()
                ->route('student.quiz.result', $quiz->id)
                ->with('info', 'Anda sudah mengerjakan quiz ini.');
        }

        // ❗ HANYA kirim data quiz ke view
        return view('student.quiz.start', [
            'quiz' => $quiz,
            'submission' => null, // tidak ada data DB
        ]);
    }

    /**
     * Submit jawaban quiz
     *  SATU-SATUNYA TEMPAT SIMPAN DATA
     */
    public function submit(Request $request, Quiz $quiz)
    {
        $request->validate([
            'answers' => 'required|array',
        ]);

        $user = auth()->user();

        //  Cegah submit ulang
        $existing = QuizSubmission::where('quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->where('is_submitted', true)
            ->first();

        if ($existing) {
            return redirect()
                ->route('student.quiz.result', $quiz->id)
                ->with('info', 'Quiz sudah disubmit.');
        }

        $answers = $request->answers;

        // ==========================
        // HITUNG NILAI
        // ==========================
        $correct = 0;
        $incorrect = 0;

        foreach ($quiz->questions as $q) {
            if ($q->question_type !== 'multiple_choice') {
                continue;
            }

            $raw = $answers[$q->id] ?? null;
            $normalized = $raw ? strtoupper(substr($raw, -1)) : null;

            if ($normalized === $q->correct_answer) {
                $correct += $q->score_correct;
            } else {
                $incorrect += $q->score_incorrect;
            }
        }

        // ==========================
        //  SIMPAN FINAL KE DB
        // ==========================
        QuizSubmission::create([
            'quiz_id'        => $quiz->id,
            'user_id'        => $user->id,
            'class_id'       => $user->class_id,
            'start_time'     => now()->subMinutes($quiz->duration),
            'end_time'       => now(),
            'answers'        => $answers,
            'score'          => $correct - $incorrect,
            'score_correct'  => $correct,
            'score_incorrect' => $incorrect,
            'is_submitted'   => true,
            'submitted_at'   => now(),
        ]);

        return redirect()
            ->route('student.quiz.result', $quiz->id)
            ->with('success', 'Jawaban berhasil dikumpulkan.');
    }

    /**
     * Hasil quiz
     */
    public function result(Quiz $quiz)
    {
        $submission = QuizSubmission::where('quiz_id', $quiz->id)
            ->where('user_id', auth()->id())
            ->where('is_submitted', true)
            ->firstOrFail();

        $answersArray = $submission->answers ?? [];

        $answers = $quiz->questions->map(function ($q) use ($answersArray) {
            $raw = $answersArray[$q->id] ?? null;
            $normalized = $raw ? strtoupper(substr($raw, -1)) : null;

            return (object)[
                'question' => $q,
                'selected_option' => $normalized,
                'answer_text' => $raw, // TAMBAHKAN INI
                'is_correct' =>
                $q->question_type === 'multiple_choice'
                    ? $normalized === $q->correct_answer
                    : null,
            ];
        });
        return view('student.quiz.result', compact('quiz', 'submission', 'answers'));
    }

    /**
     * Riwayat quiz
     */
    public function history()
    {
        $quizHistory = QuizSubmission::where('user_id', auth()->id())
            ->where('is_submitted', true)
            ->with(['quiz', 'quiz.class'])
            ->latest()
            ->get();

        return view('student.quiz.history', compact('quizHistory'));
    }
}
