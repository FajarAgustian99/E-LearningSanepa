<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        $student = auth()->user();

        // Ambil grade dari kelas yang diikuti siswa (ambil pertama)
        $grade = $student->classes()->value('grade');

        // Filter course berdasarkan grade kelas siswa
        $courses = Course::with('teacher')
            ->when($grade, function ($q) use ($grade) {
                $q->where('grade', $grade);
            })
            ->get();

        $enrolledCourseIds = $student->courses()->pluck('courses.id')->toArray();

        return view('student.course.index', compact('courses', 'enrolledCourseIds'));
    }

    public function requestJoin(Request $request, Course $course)
    {
        $user = auth()->user();

        $request->validate([
            'join_code' => 'required|string',
        ]);

        // sudah join?
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return back()->with('success', 'Kamu sudah terdaftar di mata pelajaran ini.');
        }

        // validasi kode
        if ($request->join_code !== $course->join_code) {
            return back()->withErrors(['join_code' => 'Kode kelas salah.']);
        }

        DB::transaction(function () use ($user, $course) {

            // attach course
            $user->courses()->attach($course->id, [
                'enrolled_at' => now()
            ]);

            // ambil kelas utama siswa
            $classId = $user->class_id;

            if (! $classId) {
                abort(400, 'Siswa belum memiliki kelas utama.');
            }

            // masukkan ke class_user (SATU kelas)
            DB::table('class_user')->updateOrInsert(
                [
                    'class_id' => $classId,
                    'user_id'  => $user->id,
                ],
                [
                    'role'       => 'student',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        });



        return back()->with('success', 'Kamu berhasil bergabung dengan mata pelajaran ini.');
    }

    public function show($id)
    {
        $student = auth()->user();

        $course = Course::with('teacher')->findOrFail($id);

        // ambil class utama siswa
        $class = Classes::where('id', $student->class_id)
            ->where('course_id', $course->id)
            ->with(['materials', 'quizzes'])
            ->first();

        if (! $class) {
            abort(403, 'Kamu belum terdaftar di kelas untuk mata pelajaran ini.');
        }

        return view('student.course.show', compact('course', 'class'));
    }
}
