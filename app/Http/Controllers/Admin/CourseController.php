<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * List mata pelajaran dengan opsi filter kelas.
     */
    public function index(Request $request)
    {
        $grade = $request->grade;

        $courses = Course::with(['teacher', 'classes'])
            ->when($grade, function ($q) use ($grade) {
                $q->whereHas(
                    'classes',
                    fn($query) =>
                    $query->where('classes.id', $grade)
                );
            })
            ->orderBy('title')
            ->paginate(12);

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Form tambah course.
     */
    public function create()
    {
        $teachers = User::whereHas('role', fn($q) => $q->where('name', 'Guru'))->get();
        $classes  = Classes::orderBy('name')->get();
        $course = new Course();

        return view('admin.courses.create', compact('teachers', 'classes', 'course'));
    }

    /**
     * Proses tambah course.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'grade'       => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'teacher_id'  => 'required|exists:users,id',
            'join_code'   => 'nullable|string|max:20|unique:courses,join_code',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
        ]);

        // Upload file
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        Course::create($data);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    /**
     * Form edit course.
     */
    public function edit(Course $course)
    {
        $teachers = User::whereHas('role', fn($q) => $q->where('name', 'Guru'))->get();
        $classes  = Classes::orderBy('name')->get();

        return view('admin.courses.edit', compact('course', 'teachers', 'classes'));
    }

    /**
     * Proses update course.
     */
    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'grade'       => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'teacher_id'  => 'required|exists:users,id',
            'join_code'   => 'nullable|string|max:20|unique:courses,join_code,' . $course->id,
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
        ]);

        // Upload file baru & hapus lama
        if ($request->hasFile('image')) {

            if ($course->image && Storage::disk('public')->exists($course->image)) {
                Storage::disk('public')->delete($course->image);
            }

            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $course->update($data);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui!');
    }

    /**
     * Hapus course + file gambar.
     */
    public function destroy(Course $course)
    {
        if ($course->image && Storage::disk('public')->exists($course->image)) {
            Storage::disk('public')->delete($course->image);
        }

        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Mata pelajaran berhasil dihapus!');
    }
}
