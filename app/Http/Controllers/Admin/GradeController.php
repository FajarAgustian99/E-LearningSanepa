<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Grade;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GradesExport;
use Barryvdh\DomPDF\Facade\Pdf;

class GradeController extends Controller
{
    /**
     * 📘 Halaman daftar nilai + filter
     */
    public function index(Request $request)
    {
        // Data dropdown
        $classes = Classes::orderBy('name')->get();
        $courses = Course::orderBy('title')->get();

        // Default kosong
        $grades = collect();

        // Validasi filter
        if ($request->filled('class_id') && $request->filled('course_id')) {
            $grades = Grade::with(['student', 'class', 'course'])
                ->where('class_id', $request->class_id)
                ->where('course_id', $request->course_id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('admin.grades.index', compact(
            'classes',
            'courses',
            'grades'
        ));
    }

    /**
     * 📥 Export Excel
     */
    public function exportExcel(Request $request)
    {
        $request->validate([
            'class_id'  => 'required|exists:classes,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        return Excel::download(
            new GradesExport($request->class_id, $request->course_id),
            'nilai-kelas.xlsx'
        );
    }

    /**
     * 📄 Export PDF
     */
    public function exportPdf(Request $request)
    {
        $request->validate([
            'class_id'  => 'required|exists:classes,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $grades = Grade::with(['student', 'class', 'course'])
            ->where('class_id', $request->class_id)
            ->where('course_id', $request->course_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.grades.pdf', [
            'grades' => $grades,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('nilai-kelas.pdf');
    }
}
