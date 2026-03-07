<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Exports\QuizResultExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Notification;
use App\Models\Classes;
use Carbon\Carbon;
use App\Models\QuizSubmission;


class QuizController extends Controller
{
    public function create($class_id)
    {
        $class = \App\Models\Classes::findOrFail($class_id);

        return view('teacher.quiz.create', [
            'class' => $class,
            'class_id' => $class_id,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id'   => 'required|exists:classes,id',
            'title'      => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'   => 'required|integer|min:1',
            'due_date'   => 'nullable|date',
        ]);

        // ===============================
        // SIMPAN QUIZ
        // ===============================
        $quiz = Quiz::create($validated);

        // ===============================
        // 🔔 NOTIFIKASI KE SISWA
        // ===============================
        $class = Classes::find($validated['class_id']);

        $students = User::where('class_id', $class->id)
            ->whereHas('role', fn($q) => $q->where('name', 'Siswa'))
            ->get();

        foreach ($students as $student) {
            Notification::create([
                'user_id' => $student->id,
                'message' => '📝 Quiz baru tersedia: "' . $quiz->title . '" pada kelas ' . $class->description,
                'is_read' => false,
            ]);
        }

        return redirect()
            ->route('teacher.quiz.questions.create', $quiz->id)
            ->with('success', 'Quiz berhasil dibuat! Sekarang tambahkan pertanyaan.');
    }


    public function show(Quiz $quiz)
    {
        // Validasi quiz aktif
        if ($quiz->due_date && Carbon::now()->gt($quiz->due_date)) {
            return redirect()
                ->back()
                ->with('error', 'Quiz sudah berakhir.');
        }

        $quiz->load('questions');

        return view('teacher.quiz.show', [
            'quiz' => $quiz,
            'questions' => $quiz->questions
        ]);
    }


    public function edit(Quiz $quiz)
    {
        return view('teacher.quiz.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'due_date' => 'nullable|date',
        ]);

        $quiz->update($validated);

        return redirect()->route('teacher.quiz.show', $quiz->id)
            ->with('success', 'Quiz berhasil diperbarui!');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return back()->with('success', 'Quiz berhasil dihapus!');
    }

    /**
     * Lihat hasil pengerjaan siswa
     */
    public function results(Quiz $quiz)
    {
        // Load relasi
        $quiz->load([
            'questions',
            'submissions.user',
        ]);

        $submissions = $quiz->submissions;

        foreach ($submissions as $submission) {

            // =============================
            // DECODE JAWABAN (PENTING!)
            // =============================
            $answersJson = is_array($submission->answers)
                ? $submission->answers
                : json_decode($submission->answers, true);

            $answersJson = $answersJson ?? [];

            $multipleChoiceScore = 0;

            foreach ($quiz->questions as $question) {

                // =============================
                // PILIHAN GANDA SAJA
                // =============================
                if ($question->question_type === 'multiple_choice') {

                    $studentRaw = $answersJson[$question->id] ?? null;
                    $studentAnswer = null;

                    if ($studentRaw) {
                        // ambil huruf terakhir (A/B/C/D)
                        $studentAnswer = strtoupper(substr($studentRaw, -1));
                    }

                    if ($studentAnswer === $question->correct_answer) {
                        $multipleChoiceScore += $question->score_correct;
                    } else {
                        $multipleChoiceScore += $question->score_incorrect;
                    }
                }
            }

            // =============================
            // SET NILAI (UNTUK VIEW)
            // =============================
            $submission->score = $multipleChoiceScore; // dipakai di view
            $submission->total_score = $multipleChoiceScore;
            $submission->multiple_choice_score = $multipleChoiceScore;
            $submission->essay_score = null; // essay dinilai manual
        }

        return view('teacher.quiz.results', compact('quiz', 'submissions'));
    }


    public function exportExcel(Quiz $quiz)
    {
        $quiz->load('submissions.user');

        return Excel::download(
            new QuizResultExport($quiz),
            'hasil-quiz-' . $quiz->id . '.xlsx'
        );
    }

    public function exportPdf(Quiz $quiz)
    {
        $quiz->load('submissions.user');

        $pdf = Pdf::loadView('teacher.quiz.pdf', compact('quiz'));

        return $pdf->download('hasil-quiz-' . $quiz->id . '.pdf');
    }

    public function gradeEssay(Request $request, $quizId, $submissionId)
    {
        $submission = QuizSubmission::findOrFail($submissionId);

        // Validasi input
        $data = $request->validate([
            'essay_scores' => 'required|array',
            'essay_scores.*' => 'nullable|numeric|min:0|max:100',
        ]);

        // Simpan nilai essay
        $submission->essay_scores = $data['essay_scores'];

        // Update total score jika ingin menjumlahkan dengan score otomatis
        $submission->score = $submission->score + array_sum($data['essay_scores']);

        $submission->save();

        return back()->with('success', 'Nilai essay berhasil disimpan!');
    }

    public function allResults(Request $request, $class_id)
    {
        $class = Classes::findOrFail($class_id);
        $quizzes = Quiz::where('class_id', $class_id)->get();

        $query = QuizSubmission::with(['user', 'quiz']);

        if ($request->quiz_id) {
            $query->where('quiz_id', $request->quiz_id);
        } else {
            $query->whereIn('quiz_id', $quizzes->pluck('id'));
        }

        $results = $query->get();

        return view('teacher.quiz.all_results', compact('class', 'quizzes', 'results'));
    }
}
