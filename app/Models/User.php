<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Role;
use App\Models\Classes;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Submission;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Material;
use App\Models\QuizSubmission;
use App\Models\Notification;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'class_id',
        'role_id',
        'username',
        'avatar',
        'nip',
        'nisn',
        'npsn',
        'subject',
        'phone',
        'address',
        'photo',

    ];

    protected $hidden = ['password', 'remember_token'];

    /*
    |--------------------------------------------------------------------------
    | RELASI ROLE
    |--------------------------------------------------------------------------
    */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI KELAS UTAMA (UNTUK SISWA)
    |--------------------------------------------------------------------------
    */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI ENROLLMENTS (TABLE PIVOT)
    |--------------------------------------------------------------------------
    */
    // public function enrollments()
    // {
    //     return $this->hasMany(Enrollment::class);
    // }

    /*
    |--------------------------------------------------------------------------
    | RELASI KELAS YANG DI-ENROLL (SISWA / GURU)
    |--------------------------------------------------------------------------
    */
    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_user', 'user_id', 'class_id')
            ->withPivot('role')
            ->withTimestamps();
    }

    // Alias untuk siswa yang join banyak kelas
    public function joinedClasses()
    {
        return $this->classes()->wherePivot('role', 'student');
    }

    // Alias untuk guru yang mengajar kelas
    public function teachingClasses()
    {
        return $this->classes()->wherePivot('role', 'teacher');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI ABSENSI, NILAI, TUGAS, SUBMISSION
    |--------------------------------------------------------------------------
    */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function grade()
    {
        return $this->hasOne(Grade::class, 'student_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'student_id');
    }

    /*
    |--------------------------------------------------------------------------
    | COURSE YANG DIAJAR GURU
    |--------------------------------------------------------------------------
    */
    public function coursesTaught()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'teacher_id');
    }

    /*
    |--------------------------------------------------------------------------
    | MATERIAL & QUIZ SUBMISSIONS
    |--------------------------------------------------------------------------
    */
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_user', 'user_id', 'material_id')
            ->withTimestamps();
    }

    public function quizSubmissions()
    {
        return $this->hasMany(QuizSubmission::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | NOTIFIKASI
    |--------------------------------------------------------------------------
    */
    public function notifications()
    {
        return $this->hasMany(Notification::class)->latest();
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id')
            ->withPivot('enrolled_at')
            ->withTimestamps();
    }

    public function scopeStudents($query)
    {
        return $query->whereHas('role', function ($q) {
            $q->where('name', 'student');
        });
    }
}
