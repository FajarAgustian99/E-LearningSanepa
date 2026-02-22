<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Discussion;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        // Ringkasan data
        $total_kelas = Course::where('teacher_id', $teacherId)->count();
        $total_tugas = Assignment::where('teacher_id', $teacherId)->count();
        $total_diskusi = Discussion::where('teacher_id', $teacherId)->count();

        // Ambil 5 pengumuman terbaru
        $announcements = Announcement::orderBy('date', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($a) {
                return [
                    'title' => $a->title,
                    'desc'  => $a->description,
                    'date'  => $a->date ? $a->date->format('d M Y') : '-', // aman jika null
                ];
            });

        return view('teacher.beranda', compact('total_kelas', 'total_tugas', 'total_diskusi', 'announcements'));
    }

    public function kelas()
    {
        $teacherId = Auth::id();

        $classes = \App\Models\Classes::with('courses')
            ->where('teacher_id', $teacherId)
            ->get();

        return view('teacher.kelas', compact('classes'));
    }
}
