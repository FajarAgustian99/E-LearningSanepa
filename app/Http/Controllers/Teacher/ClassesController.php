<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassesController extends Controller
{
    /**
     * Tampilkan semua kelas guru
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $selectedCourse = $request->course_id;

        $courses = Course::where('teacher_id', $userId)->get();

        $joinedClasses = Classes::with('course')
            ->whereIn('id', function ($q) use ($userId) {
                $q->select('class_id')
                    ->from('class_user')
                    ->where('user_id', $userId);
            })
            ->when($selectedCourse, fn($q) => $q->whereHas('course', fn($q2) => $q2->where('id', $selectedCourse)))
            ->get();

        $availableClasses = Classes::with('course')
            ->whereNotIn('id', function ($q) use ($userId) {
                $q->select('class_id')
                    ->from('class_user')
                    ->where('user_id', $userId);
            })
            ->when($selectedCourse, fn($q) => $q->whereHas('course', fn($q2) => $q2->where('id', $selectedCourse)))
            ->get();

        return view('teacher.kelas.index', compact(
            'courses',
            'joinedClasses',
            'availableClasses',
            'selectedCourse'
        ));
    }

    /**
     * Form tambah kelas
     */
    public function create()
    {
        $teacherId = Auth::id();

        // Dropdown nama kelas dari master list
        $availableClasses = Classes::all();

        // Dropdown course milik guru
        $courses = Course::where('teacher_id', $teacherId)->get();

        return view('teacher.kelas.create', compact('availableClasses', 'courses'));
    }

    /**
     * Simpan kelas baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,id',
            'description' => 'nullable|string',
        ]);

        // Buat kelas baru berdasarkan nama yang dipilih
        $kelas = new Classes();
        $kelas->name = $request->name;
        $kelas->description = $request->description;
        $kelas->course_id = $request->courses[0];
        $kelas->teacher_id = Auth::id();
        $kelas->save();

        // Hubungkan kelas dengan course
        if ($request->has('courses')) {
            $kelas->courses()->sync($request->courses);
        }

        return redirect()->route('teacher.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan!');
    }

    /**
     * Detail kelas
     */
    public function show($id)
    {
        $class = Classes::with([
            'students',
            'materials',
            'quizzes',
            'attendances.student',
            'attendances.course',
            'attendances.teacher',
            'course',
            'creator'
        ])->findOrFail($id);

        $this->ensureTeacherEnrolled($id);

        $courses = Course::all();
        $selectedCourse = request('course_id');

        $materials = $class->materials()
            ->when($selectedCourse, fn($q) => $q->whereHas('class.course', fn($q2) => $q2->where('id', $selectedCourse)))
            ->get();

        $quizzes = $class->quizzes;
        $attendances = $class->attendances;

        return view('teacher.kelas.show', compact(
            'class',
            'courses',
            'materials',
            'quizzes',
            'attendances',
            'selectedCourse'
        ));
    }

    /**
     * Guru keluar dari kelas
     */
    public function unjoin($id)
    {
        $userId = Auth::id();

        DB::table('class_user')
            ->where('user_id', $userId)
            ->where('class_id', $id)
            ->delete();

        return back()->with('success', 'Berhasil keluar dari kelas.');
    }

    /**
     * Simpan link Google Meet
     */
    public function saveMeetLink(Request $request, $id)
    {
        $request->validate([
            'meet_link' => 'required|url',
        ]);

        $this->ensureTeacherEnrolled($id);

        $class = Classes::findOrFail($id);
        $class->update(['meet_link' => $request->meet_link]);

        return back()->with('success', 'Link Google Meet disimpan.');
    }

    /**
     * Form pilih kelas untuk bergabung
     */
    public function showEnrollForm()
    {
        $teacherId = Auth::id();

        $classes = Classes::whereNotIn('id', function ($q) use ($teacherId) {
            $q->select('class_id')
                ->from('class_user')
                ->where('user_id', $teacherId);
        })
            ->orderBy('name')
            ->get();

        return view('teacher.kelas.enroll', compact('classes'));
    }

    /**
     * Guru bergabung ke kelas
     */
    public function enroll(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
        ]);

        $teacherId = Auth::id();

        $exists = DB::table('class_user')
            ->where('class_id', $request->class_id)
            ->where('user_id', $teacherId)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah bergabung di kelas ini.');
        }

        // Insert ke pivot
        DB::table('class_user')->insert([
            'class_id'   => $request->class_id,
            'user_id'    => $teacherId,
            'role'       => 'teacher',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update teacher_id di kelas jika kosong
        $class = Classes::find($request->class_id);
        if (!$class->teacher_id) {
            $class->teacher_id = $teacherId;
            $class->save();
        }

        return redirect()
            ->route('teacher.kelas.index')
            ->with('success', 'Berhasil bergabung ke kelas!');
    }


    /**
     * Sembunyikan kelas dari list guru
     */
    public function hide($id)
    {
        $this->ensureTeacherEnrolled($id);

        $class = Classes::findOrFail($id);
        $class->update([
            'teacher_deleted_at' => now(),
        ]);

        return redirect()
            ->route('teacher.kelas.index')
            ->with('success', 'Kelas disembunyikan.');
    }

    /**
     * Helper: pastikan guru sudah terdaftar di kelas
     */
    private function ensureTeacherEnrolled($classId)
    {
        $isEnrolled = DB::table('class_user')
            ->where('class_id', $classId)
            ->where('user_id', Auth::id())
            ->exists();

        if (! $isEnrolled) {
            abort(403, 'Anda belum bergabung di kelas ini.');
        }
    }
}
