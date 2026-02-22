<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GradesExport;
use Barryvdh\DomPDF\Facade\Pdf;


class GradesController extends Controller
{
    public function index(Request $request)
    {
        $teacherId = Auth::id();
        $classId   = $request->class_id;
        $courseId  = $request->course_id;

        // Kelas yang diajar guru
        $classes = Classes::where('teacher_id', $teacherId)
            ->orWhereHas('teachers', fn($q) => $q->where('users.id', $teacherId))
            ->get();

        // Mapel yang diajar guru
        $courses = Course::where('teacher_id', $teacherId)->get();

        $selectedClass = null;
        $students = collect();
        $grades   = collect();

        if ($classId && $courseId) {

            $selectedClass = Classes::findOrFail($classId);

            // Validasi akses guru
            if (
                $selectedClass->teacher_id != $teacherId &&
                !optional($selectedClass->teachers)->pluck('id')->contains($teacherId)
            ) {
                abort(403);
            }

            // Ambil siswa dalam kelas
            $students = $selectedClass->students()->get();

            // Ambil grade BERDASARKAN kelas + mapel
            $grades = Grade::where('class_id', $classId)
                ->where('course_id', $courseId)
                ->get()
                ->keyBy('student_id');
        }

        return view('teacher.grades.index', compact(
            'classes',
            'courses',
            'selectedClass',
            'students',
            'grades'
        ));
    }

    public function store(Request $request)
    {
        $classId  = $request->class_id;
        $courseId = $request->course_id;
        $data     = $request->grades ?? [];

        foreach ($data as $studentId => $values) {

            $nilai = collect([
                $values['rekap_absensi'] ?? null,
                $values['lingkup_materi_1'] ?? null,
                $values['lingkup_materi_2'] ?? null,
                $values['lingkup_materi_3'] ?? null,
                $values['lingkup_materi_4'] ?? null,
                $values['sumatif_akhir_semester'] ?? null,
                $values['uhb'] ?? null,
                $values['psat'] ?? null,
            ])->filter(fn($v) => $v !== null && $v !== '');

            $na = $nilai->count() ? round($nilai->avg(), 2) : null;

            Grade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'class_id'   => $classId,
                    'course_id'  => $courseId,
                ],
                [
                    'rekap_absensi' => $values['rekap_absensi'] ?? null,
                    'lingkup_materi_1' => $values['lingkup_materi_1'] ?? null,
                    'lingkup_materi_2' => $values['lingkup_materi_2'] ?? null,
                    'lingkup_materi_3' => $values['lingkup_materi_3'] ?? null,
                    'lingkup_materi_4' => $values['lingkup_materi_4'] ?? null,
                    'sumatif_akhir_semester' => $values['sumatif_akhir_semester'] ?? null,
                    'uhb' => $values['uhb'] ?? null,
                    'psat' => $values['psat'] ?? null,
                    'na' => $na,
                    'kktp' => $values['kktp'] ?? null,
                ]
            );
        }


        return redirect()->back()->with('success', '✅ Nilai berhasil disimpan');
    }

    /**
     * EXPORT EXCEL
     */
    public function exportExcel(Request $request)
    {
        $classId  = $request->query('class_id');
        $courseId = $request->query('course_id');

        if (!$classId || !$courseId) {
            return back()->with('error', 'Kelas dan Mapel wajib dipilih');
        }

        $class  = Classes::findOrFail($classId);
        $course = Course::findOrFail($courseId);

        return Excel::download(
            new GradesExport($classId, $courseId),
            'Nilai_' . $class->name . '_' . $course->title . '.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $classId  = $request->query('class_id');
        $courseId = $request->query('course_id');

        $class  = Classes::findOrFail($classId);
        $course = Course::findOrFail($courseId);

        $grades = Grade::with('student')
            ->where('class_id', $classId)
            ->where('course_id', $courseId)
            ->get();

        $pdf = Pdf::loadView('teacher.grades.export-pdf', [
            'grades' => $grades,
            'class'  => $class,
            'course' => $course,
        ])->setPaper('A4', 'landscape');

        return $pdf->download(
            'Nilai_' . $class->name . '_' . $course->title . '.pdf'
        );
    }
}
