<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * List kelas yang siswa sudah diassign oleh admin
     */
    public function index()
    {
        $user = auth()->user();

        $kelas = Classes::with('courses')
            ->where('id', $user->class_id)
            ->first();

        return view('student.kelas.index', compact('kelas'));
    }


    /**
     * Detail kelas
     */
    public function show(Classes $kelas)
    {
        $user = auth()->user();

        if ($kelas->id != $user->class_id) {
            abort(403);
        }

        $kelas->load([
            'teacher',
            'students',
            'materials',
        ]);

        // 🔥 FILTER MAPEL SESUAI TINGKAT KELAS
        $mapelAktif = $kelas->courses()
            ->where('grade', $kelas->tingkat)
            ->get();

        return view('student.kelas.show', compact('kelas', 'mapelAktif'));
    }


    /**
     * Siswa masuk kelas
     * Otomatis assign semua course di kelas ke siswa
     */
    public function joinClass(Classes $kelas)
    {
        $user = auth()->user();

        // Cegah join ulang
        $alreadyJoined = DB::table('class_user')
            ->where('class_id', $kelas->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyJoined) {
            return redirect()->back()->with('message', 'Anda sudah tergabung di kelas ini.');
        }

        DB::transaction(function () use ($user, $kelas) {

            // 1️⃣ Simpan class_id di users (optional kalau masih dipakai)
            $user->update([
                'class_id' => $kelas->id
            ]);

            // 2️⃣ Masukkan ke pivot class_user sebagai student
            DB::table('class_user')->updateOrInsert(
                [
                    'class_id' => $kelas->id,
                    'user_id' => $user->id,
                ],
                [
                    'role' => 'student',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // 3️⃣ Assign semua course kelas ke siswa
            $courses = $kelas->courses;

            if ($courses->count()) {
                $courseIds = $courses->pluck('id')->toArray();
                $user->courses()->syncWithoutDetaching($courseIds);
            }
        });

        return redirect()->route('student.kelas.show', $kelas->id)
            ->with('success', 'Berhasil masuk kelas dan semua mata pelajaran terassign!');
    }
}
