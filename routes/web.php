<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\{
    AnnouncementController,
    StudentController,
    UserController as AdminUserController,
    DashboardController as AdminDashboardController,
    ClassesController as AdminClassesController,
    CourseController as AdminCourseController,
    AttendanceController as AdminAttendanceController,
    GradeController as AdminGradeController
};

use App\Http\Controllers\Teacher\{
    DashboardController as TeacherDashboardController,
    HomeController as TeacherHomeController,
    ClassesController,
    AttendanceController,
    MaterialController,
    QuizController,
    QuestionController,
    CommentController,
    GradesController,
    AssignmentController as TeacherAssignmentController,
    StudentController as TeacherStudentController,
    DiscussionController,
    ProfileController,
    MonitoringController,
    TeacherEssayGradingController
};

use App\Http\Controllers\Student\{
    DashboardController as StudentDashboardController,
    AnnouncementController as StudentAnnouncementController,
    KelasController as StudentKelasController,
    CourseController as StudentCourseController,
    StudentMaterialController as StudentMaterialController,
    AttendanceController as StudentAttendanceController,
    ProfileController as StudentProfileController,
    QuizSubmissionController as StudentQuizSubmissionController,
    StudentDiscussionController,
};
use App\Models\Notification;
use App\Models\Announcement;

/*
|--------------------------------------------------------------------------
| DEFAULT ROUTE
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'));


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (HARUS LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dynamic Dashboard Redirect by Role
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $role = strtolower(data_get($user, 'role.name') ?? $user->role ?? 'siswa');

        return match ($role) {
            'admin'              => redirect()->route('admin.dashboard'),
            'guru', 'teacher'    => redirect()->route('teacher.dashboard'),
            'siswa', 'student'   => redirect()->route('student.dashboard'),
            default              => redirect()->route('student.dashboard'),
        };
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | NOTIFICATION ROUTES
    |--------------------------------------------------------------------------
    */
    Route::post('/notifications/{notification}/read', function (Notification $notification) {

        // Keamanan: pastikan notifikasi milik user yang login
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update([
            'is_read' => true
        ]);

        return back();
    })->name('notifications.read');

    /*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
    Route::prefix('admin')
        ->middleware('role:Admin')
        ->name('admin.')
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard');

            // Pengumuman
            Route::resource('announcements', AnnouncementController::class);

            // ================== ATTENDANCE ADMIN ==================

            // Rekap / filter
            Route::get(
                'attendance/rekap',
                [AdminAttendanceController::class, 'index']
            )
                ->name('attendance.index');

            // Tampilkan hasil absensi guru
            Route::get(
                'attendance/show',
                [AdminAttendanceController::class, 'show']
            )
                ->name('attendance.show');

            // Update absensi (ADMIN EDIT ONLY)
            Route::put(
                'attendance/update',
                [AdminAttendanceController::class, 'update']
            )
                ->name('attendance.update');


            // Export Rekap Absensi Admin
            Route::get(
                'attendance/export',
                [AdminAttendanceController::class, 'export']
            )->name('attendance.export');

            // Nilai Admin
            Route::get('/grade', [AdminGradeController::class, 'index'])
                ->name('grade.index');


            // ================== END ATTENDANCE ADMIN ==================


            // Import / Export Siswa
            Route::get('students/template', [StudentController::class, 'downloadTemplate'])
                ->name('students.template');

            Route::post('students/import', [StudentController::class, 'import'])
                ->name('students.import');

            Route::get('students/export', [StudentController::class, 'export'])
                ->name('students.export');

            // Teachers
            Route::get('/teachers', [TeacherController::class, 'index'])
                ->name('teachers.index');

            // Resource CRUD (attendance DIHAPUS!)
            Route::resources([
                'users'       => AdminUserController::class,
                'students'    => StudentController::class,
                'classes'     => AdminClassesController::class,
                'courses'     => AdminCourseController::class,

                'assignments' => TeacherAssignmentController::class,
                'submissions' => SubmissionController::class,
                'grades'      => AdminGradeController::class,
            ]);
        });


    // Export Excel & PDF Admin
    Route::get('grades/export/excel', [GradesController::class, 'exportExcel'])->name('grades.export.excel');
    Route::get('grades/export/pdf', [GradesController::class, 'exportPdf'])->name('grades.export.pdf');


    /*
    |--------------------------------------------------------------------------
    | TEACHER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('teacher')
        ->middleware('role:Guru')
        ->name('teacher.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Dashboard & Beranda
            |--------------------------------------------------------------------------
            */
            Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
            Route::get('/beranda', [TeacherHomeController::class, 'index'])->name('beranda');


            /*
            |--------------------------------------------------------------------------
            | Monitoring
            |--------------------------------------------------------------------------
            */
            Route::prefix('monitoring')->name('monitoring.')->group(function () {
                Route::get('/', [MonitoringController::class, 'index'])->name('index');
                Route::get('/{class}', [MonitoringController::class, 'show'])->name('show');
            });


            /*
            |--------------------------------------------------------------------------
            | Profil Guru
            |--------------------------------------------------------------------------
            */
            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('/', [ProfileController::class, 'index'])->name('index');
                Route::post('/update', [ProfileController::class, 'update'])->name('update');
                Route::post('/update-photo', [ProfileController::class, 'updatePhoto'])->name('update.photo');
                Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('update.password');
            });


            /*
            |--------------------------------------------------------------------------
            | Manajemen Kelas Guru
            |--------------------------------------------------------------------------
            */
            Route::prefix('kelas')->name('kelas.')->group(function () {

                Route::get('/', [ClassesController::class, 'index'])->name('index');
                Route::get('/enroll', [ClassesController::class, 'showEnrollForm'])->name('enroll_form');
                Route::post('/enroll', [ClassesController::class, 'enroll'])->name('enroll');

                Route::get('/{id}', [ClassesController::class, 'show'])->name('show');

                Route::post('/{id}/hide', [ClassesController::class, 'hide'])->name('hide');

                Route::get('/restore', [ClassesController::class, 'restore'])->name('restore');
                Route::put('/restore/{id}', [ClassesController::class, 'restoreClass'])->name('restoreClass');

                Route::get('/{id}/edit-meet', [ClassesController::class, 'editMeetLink'])->name('editMeet');
                Route::put('/{id}/update-meet', [ClassesController::class, 'updateMeetLink'])->name('updateMeet');
                Route::get('/{id}/add-meet', [ClassesController::class, 'addMeetLink'])->name('addMeet');
                Route::post('/{id}/meet', [ClassesController::class, 'saveMeetLink'])->name('meet');

                Route::delete('/{id}/unjoin', [ClassesController::class, 'unjoin'])->name('unjoin');
            });


            /*
            |--------------------------------------------------------------------------
            | Siswa dalam Kelas
            |--------------------------------------------------------------------------
            */
            Route::prefix('kelas/{class_id}/siswa')->name('students.')->group(function () {
                Route::get('/', [TeacherStudentController::class, 'index'])->name('index');
                Route::get('/create', [TeacherStudentController::class, 'create'])->name('create');
                Route::post('/', [TeacherStudentController::class, 'store'])->name('store');
                Route::delete('/{id}', [TeacherStudentController::class, 'destroy'])->name('destroy');
            });


            /*
            |--------------------------------------------------------------------------
            | Kehadiran Guru
            |--------------------------------------------------------------------------
            */
            Route::prefix('attendance')->name('attendance.')->group(function () {
                Route::get('/', [AttendanceController::class, 'index'])->name('index');
                Route::get('/{class_id}', [AttendanceController::class, 'show'])->name('show');
                Route::post('/store', [AttendanceController::class, 'store'])->name('store');
                Route::get('/rekap/{class_id}', [AttendanceController::class, 'rekap'])->name('rekap');
                Route::post('/toggle-lock/{class_id}', [AttendanceController::class, 'toggleLock'])->name('toggleLock');
                Route::get('/{class}/export', [AttendanceController::class, 'export'])->name('export');
                Route::get('/guru/{class}', [AttendanceController::class, 'guru'])->name('guru');
            });

            Route::post('/attendance/guru/{class}', [AttendanceController::class, 'storeGuru'])
                ->name('attendance.guru.store');

            Route::get('/attendance/{class}/pdf', [AttendanceController::class, 'exportPdf'])
                ->name('attendance.pdf');


            /*
            |--------------------------------------------------------------------------
            | Nilai Guru
            |--------------------------------------------------------------------------
            */
            // tampilkan nilai
            Route::get('/grades', [GradesController::class, 'index'])
                ->name('grades.index');

            // simpan nilai (INI YANG KURANG)
            Route::post('/grades', [GradesController::class, 'store'])
                ->name('grades.store');

            // export
            Route::get('/grades/export/excel', [GradesController::class, 'exportExcel'])
                ->name('grades.export.excel');

            Route::get('/grades/export/pdf', [GradesController::class, 'exportPdf'])
                ->name('grades.export.pdf');


            /*
            |--------------------------------------------------------------------------
            | Materi
            |--------------------------------------------------------------------------
            */
            Route::prefix('materi')->name('materi.')->group(function () {
                Route::get('/{class_id}', [MaterialController::class, 'index'])->name('index');
                Route::get('/{class_id}/create', [MaterialController::class, 'create'])->name('create');
                Route::post('/store', [MaterialController::class, 'store'])->name('store');
                Route::get('/edit/{id}', [MaterialController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [MaterialController::class, 'update'])->name('update');
                Route::delete('/delete/{id}', [MaterialController::class, 'destroy'])->name('destroy');
            });


            /*
            |--------------------------------------------------------------------------
            | Quiz
            |--------------------------------------------------------------------------
            */
            Route::prefix('quiz')->name('quiz.')->group(function () {

                // CRUD Quiz
                Route::get('/create/{class}', [QuizController::class, 'create'])->name('create');
                Route::post('/store', [QuizController::class, 'store'])->name('store');
                Route::get('/{quiz}', [QuizController::class, 'show'])->name('show');
                Route::get('/{quiz}/edit', [QuizController::class, 'edit'])->name('edit');
                Route::put('/{quiz}', [QuizController::class, 'update'])->name('update');
                Route::delete('/{quiz}', [QuizController::class, 'destroy'])->name('destroy');
                Route::get('{quiz}/results', [QuizController::class, 'results'])
                    ->name('results');

                Route::get('{quiz}/export-excel', [QuizController::class, 'exportExcel'])
                    ->name('export.excel');

                Route::get('{quiz}/export-pdf', [QuizController::class, 'exportPdf'])
                    ->name('export.pdf');
                Route::post('{quiz}/grade-essay/{submission}', [QuizController::class, 'gradeEssay'])
                    ->name('gradeEssay');


                // Questions
                Route::prefix('{quiz}/questions')->name('questions.')->group(function () {

                    Route::get('/create', [QuestionController::class, 'create'])->name('create');
                    Route::post('/store', [QuestionController::class, 'store'])->name('store');
                    Route::get('/{question}/edit', [QuestionController::class, 'edit'])->name('edit');
                    Route::put('/{question}/update', [QuestionController::class, 'update'])->name('update');
                    Route::delete('/{question}/delete', [QuestionController::class, 'destroy'])->name('delete');
                });
            });


            /*
            |--------------------------------------------------------------------------
            | Diskusi & Komentar
            |--------------------------------------------------------------------------
            */
            Route::prefix('discussions')->name('discussions.')->group(function () {
                Route::get('/', [DiscussionController::class, 'index'])->name('index');
                Route::get('/create', [DiscussionController::class, 'create'])->name('create');
                Route::post('/store', [DiscussionController::class, 'store'])->name('store');
                Route::get('/{discussion}/edit', [DiscussionController::class, 'edit'])->name('edit');
                Route::put('/{discussion}', [DiscussionController::class, 'update'])->name('update');
                Route::get('/{class}/{discussion}', [DiscussionController::class, 'showThread'])->name('showThread');
                Route::delete('/{discussion}', [DiscussionController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('comments')->name('comments.')->group(function () {
                Route::post('/{discussion}', [CommentController::class, 'store'])->name('store');
                Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy');
            });


            /*
            |--------------------------------------------------------------------------
            | Grading Essay
            |--------------------------------------------------------------------------
            */
            Route::prefix('quiz')->group(function () {
                Route::get('/{quiz}/results', [QuizController::class, 'results'])->name('quiz.results');
                Route::post('/{quiz}/grade-essay/{submission}', [QuizController::class, 'gradeEssay'])->name('quiz.gradeEssay');
                Route::get('/{quiz}/allresults', [QuizController::class, 'allResults'])->name('quiz.allResults');
            });

            Route::prefix('quiz/{quiz}/essay')->name('essay.')->group(function () {
                Route::get('/', [TeacherEssayGradingController::class, 'index'])->name('index');
                Route::get('/{submission}', [TeacherEssayGradingController::class, 'show'])->name('show');
                Route::post('/{submission}/grade', [TeacherEssayGradingController::class, 'grade'])->name('grade');
            });
        });



    /*
    |--------------------------------------------------------------------------
    | STUDENT ROUTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('student')
        ->middleware('role:Siswa')
        ->name('student.')
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
            Route::get('/', [StudentDashboardController::class, 'index']);
            Route::get('/home', [StudentDashboardController::class, 'index'])->name('home');
            Route::get('/quiz/history', [StudentDashboardController::class, 'quizHistory'])->name('quiz.history');
            Route::get('/notifications', [StudentDashboardController::class, 'notifications'])->name('notifications');


            /*
            |--------------------------------------------------------------------------
            | Pengumuman
            |--------------------------------------------------------------------------
            */
            Route::resource('announcements', StudentAnnouncementController::class)
                ->only(['index', 'show']);


            /*
            |--------------------------------------------------------------------------
            | Kelas Siswa
            |--------------------------------------------------------------------------
            */
            Route::prefix('kelas')->name('kelas.')->group(function () {
                Route::get('/', [StudentKelasController::class, 'index'])->name('index');
                Route::get('/{kelas}', [StudentKelasController::class, 'show'])->name('show');
                Route::get('/join', [StudentKelasController::class, 'joinForm'])->name('join.form');
                Route::post('/join', [StudentKelasController::class, 'join'])->name('join.submit');
                Route::post('/{kelas}/join', [StudentKelasController::class, 'joinClass'])->name('join');
            });


            /*
            |--------------------------------------------------------------------------
            | Courses
            |--------------------------------------------------------------------------
            */
            Route::get('/student/courses', [StudentCourseController::class, 'index'])
                ->name('student.courses.index');

            Route::get('/courses', [StudentCourseController::class, 'index'])->name('courses.index');
            Route::get('/courses/{course}', [StudentCourseController::class, 'show'])->name('courses.show');
            Route::post('/courses/{course}/join', [StudentCourseController::class, 'requestJoin'])->name('courses.requestJoin');

            Route::get(
                '/materials/{material}/download',
                [StudentMaterialController::class, 'download']
            )->name('materials.download');


            /*
            |--------------------------------------------------------------------------
            | Absensi Siswa
            |--------------------------------------------------------------------------
            */
            Route::get('/kelas/{class}/absensi', [StudentAttendanceController::class, 'index'])->name('absensi.index');
            Route::post('/kelas/{class}/absensi', [StudentAttendanceController::class, 'store'])->name('absensi.store');




            /*
            |--------------------------------------------------------------------------
            | Forum Siswa
            |--------------------------------------------------------------------------
            */
            Route::resource('forum', StudentDiscussionController::class)
                ->only(['index', 'show', 'create', 'store'])
                ->names([
                    'index'  => 'forum.index',
                    'show'   => 'forum.show',
                    'create' => 'forum.create',
                    'store'  => 'forum.store',
                ])
                ->parameters(['forum' => 'discussion']);

            Route::post('forum/{discussion}/reply', [StudentDiscussionController::class, 'storeReply'])
                ->name('forum.reply.store')
                ->where('discussion', '[0-9]+');


            /*
            |--------------------------------------------------------------------------
            | Profil Siswa
            |--------------------------------------------------------------------------
            */
            Route::get('profile', [StudentProfileController::class, 'show'])->name('profile.show');
            Route::post('profile', [StudentProfileController::class, 'update'])->name('profile.update');
            Route::post('profile/photo', [StudentProfileController::class, 'updatePhoto'])->name('profile.update.photo');
            Route::post('profile/password', [StudentProfileController::class, 'updatePassword'])->name('profile.update.password');


            /*
            |--------------------------------------------------------------------------
            | Quiz Siswa
            |--------------------------------------------------------------------------
            */
            Route::prefix('quiz')->group(function () {
                Route::get('{quiz}', [StudentQuizSubmissionController::class, 'show'])->name('quiz.show');
                Route::get('{quiz}/start', [StudentQuizSubmissionController::class, 'start'])->name('quiz.start');
                Route::post('{quiz}/submit', [StudentQuizSubmissionController::class, 'submit'])->name('quiz.submit');
                Route::get('{quiz}/result', [StudentQuizSubmissionController::class, 'result'])->name('quiz.result');
            });

            Route::get('/quiz/history', [StudentQuizSubmissionController::class, 'history'])->name('quiz.history');
        });
});
