<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classes;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Classes $class)
    {
        $student = Auth::user();
        $today = now()->toDateString();

        // Ambil course langsung dari kelas
        $course = $class->course;

        $locked = (bool) $class->attendance_locked;

        $attendanceToday = Attendance::where('class_id', $class->id)
            ->where('student_id', $student->id)
            ->where('course_id', $course?->id)
            ->where('date', $today)
            ->first();

        return view('student.attendance.index', [
            'kelas' => $class,
            'class' => $class,
            'course' => $course,
            'locked' => $locked,
            'attendanceToday' => $attendanceToday,
        ]);
    }

    public function store(Request $request, Classes $class)
    {
        $student = Auth::user();
        $today = now()->toDateString();

        // Ambil course dari kelas (bukan dari request)
        $course = $class->course;

        if (!$course) {
            return back()->with('error', 'Mapel belum ditentukan untuk kelas ini.');
        }

        $request->validate([
            'status' => 'required|in:Hadir,Izin,Sakit,Alpha',
        ]);

        if ($class->attendance_locked) {
            return back()->with('error', 'Absensi sudah ditutup.');
        }

        if (Attendance::where('class_id', $class->id)
            ->where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->where('date', $today)
            ->exists()
        ) {
            return back()->with('info', 'Kamu sudah absen hari ini.');
        }

        Attendance::create([
            'class_id' => $class->id,
            'course_id' => $course->id,
            'teacher_id' => $class->teacher_id,
            'student_id' => $student->id,
            'status' => $request->status,
            'date' => $today,
        ]);

        return back()->with('success', "Absensi berhasil ({$request->status})");
    }
}
