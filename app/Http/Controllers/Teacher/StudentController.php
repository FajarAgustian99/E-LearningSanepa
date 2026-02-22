<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classes;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // 🔹 Menampilkan daftar siswa di kelas tertentu
    public function index($class_id)
    {
        $class = Classes::findOrFail($class_id);

        // Ambil siswa berdasarkan tabel enrollments
        $class->students = User::whereIn('id', function ($query) use ($class_id) {
            $query->select('user_id')
                ->from('enrollments')
                ->where('class_id', $class_id);
        })->get();

        return view('teacher.students.index', compact('class'));
    }

    // 🔹 Form pilih siswa untuk dimasukkan ke kelas
    public function create($class_id)
    {
        $class = Classes::findOrFail($class_id);

        // Ambil hanya siswa dengan role_id=3 (Siswa) yang belum masuk kelas
        $students = User::where('role_id', 3)
            ->whereNotIn('id', function ($query) use ($class_id) {
                $query->select('user_id')
                    ->from('enrollments')
                    ->where('class_id', $class_id);
            })
            ->get();

        return view('teacher.students.create', compact('class', 'students'));
    }

    // 🔹 Simpan siswa ke kelas melalui tabel enrollments
    public function store(Request $request, $class_id)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        // Cek apakah siswa sudah masuk kelas
        $already = Enrollment::where('class_id', $class_id)
            ->where('user_id', $request->student_id)
            ->exists();

        if ($already) {
            return back()->with('error', 'Siswa ini sudah berada di kelas!');
        }

        // Tambahkan siswa ke enrollments
        Enrollment::create([
            'class_id' => $class_id,
            'user_id' => $request->student_id,
            'enrolled_at' => now(),
        ]);

        return redirect()
            ->route('teacher.students.index', $class_id)
            ->with('success', 'Siswa berhasil dimasukkan ke kelas!');
    }

    // 🔹 Hapus siswa dari kelas (hapus dari enrollment saja)
    public function destroy($class_id, $student_id)
    {
        Enrollment::where('class_id', $class_id)
            ->where('user_id', $student_id)
            ->delete();

        return redirect()
            ->route('teacher.students.index', $class_id)
            ->with('success', 'Siswa berhasil dikeluarkan dari kelas.');
    }
}
