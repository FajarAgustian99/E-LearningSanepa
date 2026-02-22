<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classes;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminAttendanceExport;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FILTER PAGE
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        return view('admin.attendance.index', [
            'classes' => Classes::all(),
            'courses' => Course::all()
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW REKAP
    |--------------------------------------------------------------------------
    */
    public function show(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'type'      => 'required|in:teacher,student',
            'class_id'  => 'nullable',
            'date'      => 'nullable|date'
        ]);

        $course_id = $request->course_id;
        $class_id  = $request->class_id;
        $type      = $request->type;
        $date      = $request->date ?? now()->toDateString();

        $classes = Classes::all();
        $courses = Course::all();

        /*
        |---------------- GURU ----------------
        */
        if ($type === 'teacher') {

            $users = User::whereHas('role', fn($q) => $q->where('name', 'Guru'))
                ->orderBy('name')
                ->get();

            $attendances = Attendance::where('course_id', $course_id)
                ->whereDate('date', $date)
                ->whereNotNull('teacher_id')
                ->get()
                ->keyBy('teacher_id');
        }

        /*
        |---------------- SISWA ----------------
        */ else {

            $users = User::whereHas('role', fn($q) => $q->where('name', 'Siswa'))
                ->when($class_id, fn($q) => $q->where('class_id', $class_id))
                ->orderBy('name')
                ->get();

            $attendances = Attendance::where('course_id', $course_id)
                ->whereDate('date', $date)
                ->whereNotNull('student_id')
                ->when($class_id, fn($q) => $q->where('class_id', $class_id))
                ->get()
                ->keyBy('student_id');
        }

        return view(
            $type === 'teacher'
                ? 'admin.attendance.show_teacher'
                : 'admin.attendance.show_student',
            compact(
                'users',
                'attendances',
                'classes',
                'courses',
                'course_id',
                'class_id',
                'date',
                'type'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN UPDATE (EDIT + AUTO CREATE)
    |--------------------------------------------------------------------------
    */
    public function update(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|array',
            'status'    => 'required|array',
            'course_id' => 'required',
            'date'      => 'required|date',
            'type'      => 'required|in:teacher,student'
        ]);

        foreach ($request->user_id as $i => $userId) {

            $status = $request->status[$i] ?? null;
            if (!$status) continue;

            $where = [
                'course_id' => $request->course_id,
                'date'      => $request->date,
            ];

            if ($request->type === 'teacher') {

                $where['teacher_id'] = $userId;

                Attendance::updateOrCreate(
                    $where,
                    ['status' => $status]
                );
            } else {

                $where['student_id'] = $userId;
                $where['class_id']   = $request->class_id;

                Attendance::updateOrCreate(
                    $where,
                    ['status' => $status]
                );
            }
        }

        return back()->with('success', 'Rekap absensi berhasil diperbarui');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL ADMIN
    |--------------------------------------------------------------------------
    */
    public function export(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'type'      => 'required|in:teacher,student',
            'date'      => 'required|date',
            'format'    => 'required|in:excel,pdf',
            'class_id'  => 'nullable'
        ]);

        $courseId = $request->course_id;
        $classId  = $request->class_id;
        $type     = $request->type;
        $date     = $request->date;
        $format   = $request->format;

        // ===== Nama kelas + tanggal =====
        $class = $classId ? Classes::find($classId) : null;

        $className = $class
            ? ($class->description ?? $class->name)
            : 'Semua_Kelas';

        $tanggal = \Carbon\Carbon::parse($date)->format('d-m-Y');

        // ================= EXCEL =================
        if ($format === 'excel') {

            return Excel::download(

                new AdminAttendanceExport(
                    $courseId,
                    $date,
                    $type,
                    $classId
                ),
                "Rekap_{$className}_{$tanggal}.xlsx"
            );
        }

        // ================= PDF =================

        if ($format === 'pdf') {

            $attendances = Attendance::where('course_id', $courseId)
                ->whereDate('date', $date)

                ->when(
                    $type === 'teacher',
                    fn($q) => $q->whereNotNull('teacher_id'),
                    fn($q) => $q->whereNotNull('student_id')
                )

                ->when($classId, fn($q) => $q->where('class_id', $classId))

                ->with($type === 'teacher' ? 'teacher' : 'student')

                ->orderBy($type === 'teacher' ? 'teacher_id' : 'student_id')

                ->get();

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
                'admin.attendance.pdf',
                [
                    'attendances' => $attendances,
                    'className'   => $className,
                    'tanggal'     => $tanggal,
                    'type'        => $type,
                ]
            )->setPaper('a4', 'portrait');

            return $pdf->download("Rekap_{$className}_{$tanggal}.pdf");
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DISABLE CREATE MANUAL
    |--------------------------------------------------------------------------
    */
    public function store()
    {
        abort(403);
    }

    public function create()
    {
        abort(403);
    }
}
