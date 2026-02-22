<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Classes;
use App\Models\Attendance;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        // ================= TOTAL UTAMA =================
        $totalUsers    = User::count();
        $totalTeachers = User::whereHas('role', fn($q) => $q->where('name', 'Guru'))->count();
        $totalStudents = User::whereHas('role', fn($q) => $q->where('name', 'Siswa'))->count();
        $totalAdmins   = User::whereHas('role', fn($q) => $q->where('name', 'Admin'))->count();
        $totalCourses  = Course::count();
        $totalClasses  = Classes::count();

        // ================= DATA CHART =================
        $classes = Classes::withCount('courses')->get();

        // ================= MINI STAT =================

        // Rata-rata mapel per kelas
        $avgCourses = round($totalCourses / max($totalClasses, 1), 1);

        // Kelas mapel terbanyak
        $maxClass = Classes::withCount('courses')
            ->orderByDesc('courses_count')
            ->first();

        $maxClassName  = $maxClass?->name ?? '-';
        $maxClassCount = $maxClass?->courses_count ?? 0;

        // ================= ABSENSI HARI INI =================
        $todayAttendance = Attendance::whereDate('created_at', today())->count();

        // ================= KELAS TERAKTIF =================
        $activeClass = Attendance::select('class_id')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('class_id')
            ->orderByDesc('total')
            ->with('class')
            ->first();

        $activeClassName = $activeClass?->class->name ?? '-';
        $activeClassTotal = $activeClass?->total ?? 0;

        return view('admin.dashboard', [
            'totalUsers'        => $totalUsers,
            'totalTeachers'     => $totalTeachers,
            'totalStudents'     => $totalStudents,
            'totalAdmins'       => $totalAdmins,
            'totalCourses'      => $totalCourses,
            'totalClasses'      => $totalClasses,

            // Chart
            'classNames'        => $classes->pluck('name'),
            'classCourseCounts' => $classes->pluck('courses_count'),

            // Mini statistik
            'avgCourses'       => $avgCourses,
            'maxClassName'     => $maxClassName,
            'maxClassCount'    => $maxClassCount,

            // Pro statistik
            'todayAttendance'  => $todayAttendance,
            'activeClassName'  => $activeClassName,
            'activeClassTotal' => $activeClassTotal,
        ]);
    }
}
