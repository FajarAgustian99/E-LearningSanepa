<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        /*
    |-------------------------------------------------------------------------- 
    | 1. AMBIL TOTAL KELAS LANGSUNG DARI TABEL class_user
    |-------------------------------------------------------------------------- 
    */
        $total_kelas = DB::table('class_user')
            ->where('user_id', $teacherId)
            ->where('role', 'teacher')
            ->count();

        /*
    |-------------------------------------------------------------------------- 
    | 2. AMBIL DATA KELAS YANG DIAMPU GURU
    |-------------------------------------------------------------------------- 
    */
        $classes = Classes::with(['materials'])
            ->whereHas('teachers', function ($q) use ($teacherId) {
                $q->where('user_id', $teacherId);
            })
            ->get();

        /*
    |-------------------------------------------------------------------------- 
    | 3. HITUNG TOTAL TUGAS (DIAMBIL DARI materials)
    |-------------------------------------------------------------------------- 
    */
        $total_tugas = $classes->sum(fn($c) => $c->materials->count());
        $total_diskusi = 0; // jika comment tidak dipakai

        /*
    |-------------------------------------------------------------------------- 
    | 4. MATERIAL TERBARU DARI KELAS YANG DIAMPU
    |-------------------------------------------------------------------------- 
    */
        $latestMaterials = Material::whereIn('class_id', $classes->pluck('id'))
            ->with('class.course') // pastikan relasi 'class' ada di model Materials
            ->latest()
            ->get();

        /*
    |-------------------------------------------------------------------------- 
    | 5. Agar Blade tetap berfungsi: set $assignments = $latestMaterials
    |-------------------------------------------------------------------------- 
    */
        $assignments = $latestMaterials; // backward compatibility

        return view('teacher.dashboard', [
            'title'          => 'Dashboard Guru',
            'total_kelas'    => $total_kelas,
            'total_tugas'    => $total_tugas,
            'total_diskusi'  => $total_diskusi,
            'materials'      => $latestMaterials,
            'assignments'    => $assignments, // <--- kirim juga assignments
        ]);
    }
}
