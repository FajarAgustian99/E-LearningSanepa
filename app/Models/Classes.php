<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Course;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\QuizSubmission;
use App\Models\Task;
use App\Models\Attendance;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'grade',
        'description',
        'class_code',
        'attendance_locked',
        'meet_link',
        'course_id',
        'created_by',
    ];

    /* ==============================
     | RELASI USER (PIVOT class_user)
     ============================== */
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'class_user',
            'class_id',
            'user_id'
        )->withPivot('role')
            ->withTimestamps();
    }

    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'class_user',
            'class_id',
            'user_id'
        )->wherePivot('role', 'student');
    }

    public function teachers()
    {
        return $this->belongsToMany(
            User::class,
            'class_user',
            'class_id',
            'user_id'
        )->wherePivot('role', 'teacher');
    }

    /* ==============================
     | RELASI CREATOR (OPSIONAL)
     ============================== */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /* ==============================
     | RELASI LAIN
     ============================== */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function courses()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'class_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'class_id');
    }

    public function quiz_Submissions()
    {
        return $this->hasMany(QuizSubmission::class, 'class_id');
    }


    public function tasks()
    {
        return $this->hasMany(Task::class, 'class_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }
}
