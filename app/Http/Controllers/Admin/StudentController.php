<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentTemplateExport;


class StudentController extends Controller
{
    // Tampilkan daftar siswa
    public function index(Request $request)
    {
        $query = User::with('class')
            ->whereHas('role', fn($q) => $q->where('name', 'Siswa'));

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        }

        // Filter kelas pakai class_id
        if ($request->filled('kelas')) {
            $query->where('class_id', $request->kelas);
        }

        $students = $query->orderBy('name')->paginate(40)->withQueryString();

        $allClasses = \App\Models\Classes::orderBy('name')->get();

        return view('admin.students.index', compact('students', 'allClasses'));
    }


    // Form tambah siswa
    public function create()
    {
        $classes = Classes::all();
        return view('admin.students.create', compact('classes'));
    }

    // Simpan siswa baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'nisn'    => 'required|numeric|unique:users,nisn',
            'password' => 'required|min:6',
            'class_id' => 'nullable|exists:classes,id',
        ]);

        $student = User::create([
            'name'     => $request->name,
            'nisn'    => $request->nisn,
            'password' => Hash::make($request->password),
            'class_id' => $request->class_id,
            'role_id'  => 3,
        ]);

        if ($request->class_id) {
            $student->classes()->attach($request->class_id, [
                'role' => 'student'
            ]);
        }

        return redirect()->route('admin.students.index')
            ->with('success', 'Siswa berhasil ditambahkan');
    }


    // Detail siswa
    public function show(User $student)
    {
        return view('admin.students.show', compact('student'));
    }

    // Form edit siswa
    public function edit(User $student)
    {
        $classes = Classes::all();
        return view('admin.students.edit', compact('student', 'classes'));
    }

    // Update siswa
    public function update(Request $request, User $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|numeric|unique:users,nisn,' . $student->id,
            'class_id' => 'required|exists:classes,id',
            'password' => 'nullable|min:6',
        ]);

        $student->name = $request->name;
        $student->nisn = $request->nisn;
        $student->classes()->sync([
            $request->class_id => ['role' => 'student']
        ]);

        // Hanya update password kalau diisi
        if ($request->filled('password')) {
            $student->password = bcrypt($request->password);
        }

        $student->save();

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui!');
    }


    // Hapus siswa
    public function destroy(User $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil dihapus');
    }

    public function downloadTemplate()
    {
        $path = public_path('templates/template_siswa.xlsx');

        if (!file_exists($path)) {
            abort(404, 'File template tidak ditemukan.');
        }

        return response()->download($path, 'template_siswa.xlsx');
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        Excel::import(new StudentsImport, $request->file('file'));

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diimpor.');
    }
}
