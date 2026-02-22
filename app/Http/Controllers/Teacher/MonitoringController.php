<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\User;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\QuizSubmission;
use App\Models\Attendance;


class MonitoringController extends Controller
{
    /**
     * Tampilkan semua kelas yang diajar guru
     */
    public function index()
    {
        $classes = auth()->user()
            ->classes()
            ->wherePivot('role', 'teacher')
            ->withCount('students')
            ->get();

        return view('teacher.monitoring.index', compact('classes'));
    }

    /**
     * Tampilkan progres siswa per kelas
     */
    public function show(Classes $class)
    {
        // Load relasi
        $class->load([
            'Students',
            'materials',
            'quizzes',
            'quiz_Submissions',
            'attendances',
        ]);

        $students = $class->users()
            ->wherePivot('role', 'student')
            ->get()
            ->map(function ($student) use ($class) {

                /**
                 * ==========================
                 *        PROGRES MATERI
                 * ==========================
                 */
                $materiCount = $class->materials->count();

                $materiDone = $student->materials()
                    ->where('materials.class_id', $class->id)
                    ->wherePivot('is_completed', 1)
                    ->count();


                /**
                 * ==========================
                 *         PROGRES QUIZ
                 * ==========================
                 */
                $quizCount = $class->quizzes->count();

                $quizDone = optional($class->quiz_Submissions)
                    ->where('user_id', $student->id)
                    ->count() ?? 0;

                /**
                 * ==========================
                 *        PROGRES ABSENSI
                 * ==========================
                 */
                $attendanceCount = $class->attendances->count();

                $attendancePresent = $class->attendances
                    ->where('student_id', $student->id)
                    ->where('status', 'Hadir')
                    ->count();

                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'materi_progress' => $materiCount > 0 ? round($materiDone / $materiCount * 100) : 0,
                    'quiz_progress' => $quizCount > 0 ? round($quizDone / $quizCount * 100) : 0,
                    'attendance_progress' => $attendanceCount > 0 ? round($attendancePresent / $attendanceCount * 100) : 0,
                ];
            });

        return view('teacher.monitoring.show', compact('class', 'students'));
    }
}
