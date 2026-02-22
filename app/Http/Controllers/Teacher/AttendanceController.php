<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;
use App\Models\Notification;
use Barryvdh\DomPDF\Facade\Pdf;



class AttendanceController extends Controller
{
    public function index()
    {
        $classes = Classes::whereHas('teachers', fn($q) => $q->where('users.id', Auth::id()))->get();
        return view('teacher.attendance.index', compact('classes'));
    }

    public function show($class_id)
    {
        $class = Classes::findOrFail($class_id);

        $classes = Classes::whereHas('teachers', fn($q) => $q->where('users.id', Auth::id()))
            ->orderBy('description')
            ->get();

        $students = User::whereHas('role', fn($q) => $q->where('name', 'Siswa'))
            ->whereHas('classes', fn($q) => $q->where('classes.id', $class_id))
            ->orderBy('name')
            ->get();

        $date = now()->toDateString();

        $attendances = Attendance::where('class_id', $class_id)
            ->whereDate('date', $date)
            ->whereNotNull('student_id')
            ->get()
            ->keyBy('student_id');

        $locked = (bool)$class->attendance_locked;

        return view('teacher.attendance.show', compact(
            'class',
            'classes',
            'students',
            'attendances',
            'date',
            'locked'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'status' => 'required|array'
        ]);

        $class = Classes::findOrFail($request->class_id);

        $class_id  = $class->id;
        $course_id = $class->course_id;
        $date = $request->date ?? now()->toDateString();
        $teacher_id = Auth::id();

        foreach ($request->status as $student_id => $status) {

            if (!$status) {
                continue;
            }

            Attendance::updateOrCreate(
                [
                    'class_id' => $class_id,
                    'student_id' => $student_id,
                    'date' => $date,
                ],
                [
                    'teacher_id' => $teacher_id,
                    'status' => $status,
                    'course_id' => $course_id
                ]
            );
        }


        return back()->with('success', 'Absensi siswa berhasil disimpan');
    }

    public function rekap($classId, Request $request)
    {
        $class = Classes::findOrFail($classId);

        $classes = Classes::whereHas('teachers', fn($q) => $q->where('users.id', Auth::id()))
            ->orderBy('description')
            ->get();

        $month = $request->get('month', now()->format('Y-m'));

        $students = User::whereHas('role', fn($q) => $q->where('name', 'Siswa'))
            ->whereHas('classes', fn($q) => $q->where('classes.id', $classId))
            ->orderBy('name')
            ->get();

        $attendances = Attendance::where('class_id', $classId)
            ->whereBetween('date', [
                $month . '-01',
                date('Y-m-t', strtotime($month . '-01'))
            ])->get();

        $rekap = [];

        foreach ($students as $s) {
            $d = $attendances->where('student_id', $s->id);

            $rekap[$s->id] = [
                'Hadir' => $d->where('status', 'Hadir')->count(),
                'Izin' => $d->where('status', 'Izin')->count(),
                'Sakit' => $d->where('status', 'Sakit')->count(),
                'Alpha' => $d->where('status', 'Alpha')->count(),
            ];
        }

        return view('teacher.attendance.rekap', compact(
            'class',
            'classes',
            'students',
            'month',
            'rekap'
        ));
    }

    public function guru($classId, Request $request)
    {
        $class = Classes::findOrFail($classId);
        $date = $request->get('date', now()->toDateString());
        $teacherId = Auth::id();

        $attendance = Attendance::where('class_id', $class->id)
            ->where('teacher_id', $teacherId)
            ->whereDate('date', $date)
            ->first();

        $alreadySubmitted = (bool)$attendance;
        $locked = (bool)$class->attendance_locked;

        return view('teacher.attendance.guru', compact(
            'class',
            'date',
            'attendance',
            'alreadySubmitted',
            'locked'
        ));
    }

    public function toggleLock($classId)
    {
        $class = Classes::findOrFail($classId);
        $class->attendance_locked = !$class->attendance_locked;
        $class->save();

        if (!$class->attendance_locked) {

            $students = User::whereHas('role', fn($q) => $q->where('name', 'Siswa'))
                ->whereHas('classes', fn($q) => $q->where('classes.id', $classId))
                ->get();

            foreach ($students as $s) {
                Notification::create([
                    'user_id' => $s->id,
                    'message' => '🟢 Absensi dibuka untuk kelas ' . $class->description,
                    'is_read' => false
                ]);
            }
        }

        return back()->with('success', 'Status absensi diubah');
    }

    public function export(Request $request, $classId)
    {
        $month = $request->month;
        $courseId = $request->course_id;

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\AttendanceExport($classId, $courseId, $month),
            'rekap-absensi.xlsx'
        );
    }

    public function exportPdf($classId, Request $request)
    {
        $month = $request->month;
        $courseId = $request->course_id;

        $start = $month . '-01';
        $end = date('Y-m-t', strtotime($start));

        $attendances = Attendance::where('class_id', $classId)
            ->whereBetween('date', [$start, $end])
            ->when($courseId, function ($q) {
                $q->where('course_id', $courseId);
            })
            ->get();

        $students = User::whereIn(
            'id',
            $attendances->pluck('student_id')->unique()
        )->orderBy('name')->get();

        $rekap = [];

        foreach ($students as $student) {

            $data = $attendances->where('student_id', $student->id);

            $hadir = $data->where('status', 'Hadir')->count();
            $izin  = $data->where('status', 'Izin')->count();
            $sakit = $data->where('status', 'Sakit')->count();
            $alpha = $data->where('status', 'Alpha')->count();

            $rekap[$student->id] = [
                'Hadir' => $hadir,
                'Izin' => $izin,
                'Sakit' => $sakit,
                'Alpha' => $alpha,
                'Total' => $hadir + $izin + $sakit + $alpha,
            ];
        }

        $kelas = Classes::find($classId);

        $pdf = Pdf::loadView('teacher.attendance.pdf', [
            'kelas' => $kelas,
            'students' => $students,
            'rekap' => $rekap,
            'month' => $month,
        ])->setPaper('A4', 'landscape');

        return $pdf->download('rekap-absensi.pdf');
    }
}
