<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Classes;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    // Tampilkan semua tugas guru
    public function index()
    {
        $teacherId = Auth::id();

        $assignments = Assignment::with(['course', 'class'])
            ->where('teacher_id', $teacherId)
            ->latest()
            ->get();

        return view('teacher.assignments.index', compact('assignments'));
    }

    // Form buat tugas
    public function create()
    {
        $teacherId = Auth::id();

        $courses = Course::where('teacher_id', $teacherId)->get();
        $classes = Classes::where('teacher_id', $teacherId)->get();

        return view('teacher.assignments.create', compact('courses', 'classes'));
    }

    // Simpan tugas baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'class_id' => 'required|exists:classes,id',
            'due_date' => 'nullable|date',
            'attachment' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('assignments', 'public');
        }

        $data['teacher_id'] = Auth::id();
        Assignment::create($data);

        return redirect()->route('teacher.assignments.index')
            ->with('success', 'Tugas berhasil dibuat.');
    }

    // Detail tugas
    public function show(Assignment $assignment)
    {
        $this->authorizeAccess($assignment);

        $assignment->load('submissions.student', 'course');
        return view('teacher.assignments.show', compact('assignment'));
    }

    // Edit tugas
    public function edit(Assignment $assignment)
    {
        $this->authorizeAccess($assignment);

        $teacherId = Auth::id();
        $courses = Course::where('teacher_id', $teacherId)->get();
        $classes = Classes::where('teacher_id', $teacherId)->get();

        return view('teacher.assignments.edit', compact('assignment', 'courses', 'classes'));
    }

    // Update tugas
    public function update(Request $request, Assignment $assignment)
    {
        $this->authorizeAccess($assignment);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'class_id' => 'required|exists:classes,id',
            'due_date' => 'nullable|date',
            'attachment' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('attachment')) {
            // hapus file lama
            if ($assignment->attachment) {
                Storage::disk('public')->delete($assignment->attachment);
            }

            $data['attachment'] = $request->file('attachment')->store('assignments', 'public');
        }

        $assignment->update($data);

        return redirect()->route('teacher.assignments.index')
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    // Hapus tugas
    public function destroy(Assignment $assignment)
    {
        $this->authorizeAccess($assignment);

        if ($assignment->attachment) {
            Storage::disk('public')->delete($assignment->attachment);
        }

        $assignment->delete();

        return redirect()->route('teacher.assignments.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }

    // Validasi hak akses guru terhadap tugas
    protected function authorizeAccess(Assignment $assignment)
    {
        if ($assignment->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }
    }
}
