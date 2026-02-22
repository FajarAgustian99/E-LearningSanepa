<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Attendance;
use App\Models\Announcement;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Material;
use App\Models\QuizSubmission;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK KEHADIRAN
        |--------------------------------------------------------------------------
        */
        $attendanceStats = Attendance::where('student_id', $user->id)
            ->selectRaw("
                SUM(status = 'Hadir') as hadir,
                SUM(status = 'Izin') as izin,
                SUM(status = 'Sakit') as sakit,
                SUM(status = 'Alpha') as alpha
            ")
            ->first();

        /*
        |--------------------------------------------------------------------------
        | PROGRESS BELAJAR TOTAL
        |--------------------------------------------------------------------------
        */
        $totalMateri = Material::count();

        $materiSelesai = DB::table('material_user')
            ->where('user_id', $user->id)
            ->count();

        $progress = $totalMateri > 0
            ? round(($materiSelesai / $totalMateri) * 100)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | PENGUMUMAN
        |--------------------------------------------------------------------------
        */
        $announcements = Announcement::latest()->take(5)->get();

        /*
        |--------------------------------------------------------------------------
        | KELAS SISWA
        |--------------------------------------------------------------------------
        */
        $kelasList = Classes::whereHas('students', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->get();

        /*
        |--------------------------------------------------------------------------
        | MAPEL AKTIF + MATERIAL
        |--------------------------------------------------------------------------
        */
        $mapelAktif = Course::whereHas('classes', function ($q) use ($kelasList) {
            $q->whereIn('classes.id', $kelasList->pluck('id'));
        })

            ->get();

        /*
|--------------------------------------------------------------------------
| PROGRESS PER MAPEL (via CLASS -> MATERIAL)
|--------------------------------------------------------------------------
*/
        $progressMapel = [];

        foreach ($mapelAktif as $mapel) {

            // class mapel ini yg diikuti siswa
            $classIds = $mapel->classes()
                ->whereIn('classes.id', $kelasList->pluck('id'))
                ->pluck('classes.id');

            // semua materi dari class tersebut
            $materialIds = Material::whereIn('class_id', $classIds)->pluck('id');

            $total = $materialIds->count();

            $selesai = DB::table('material_user')
                ->where('user_id', $user->id)
                ->whereIn('material_id', $materialIds)
                ->count();

            $progressMapel[] = [
                'title' => $mapel->title,
                'percent' => $total > 0 ? round(($selesai / $total) * 100) : 0
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | RIWAYAT ABSENSI
        |--------------------------------------------------------------------------
        */
        $absensi = Attendance::with(['classes', 'course'])
            ->where('student_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | QUIZ HISTORY
        |--------------------------------------------------------------------------
        */
        $quizHistory = QuizSubmission::with('quiz')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | MAPEL AVAILABLE
        |--------------------------------------------------------------------------
        */
        $availableMapel = Course::whereDoesntHave('classes', function ($q) use ($kelasList) {
            $q->whereIn('classes.id', $kelasList->pluck('id'));
        })->get();

        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI
        |--------------------------------------------------------------------------
        */
        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $unreadCount = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return view('student.dashboard', compact(
            'attendanceStats',
            'progress',
            'announcements',
            'kelasList',
            'mapelAktif',
            'progressMapel',
            'absensi',
            'quizHistory',
            'availableMapel',
            'notifications',
            'unreadCount'
        ));
    }
}
