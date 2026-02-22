<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Mass Assignment
    |--------------------------------------------------------------------------
    | Kolom yang boleh diisi secara massal (create/update).
    */
    protected $fillable = [
        'title',
        'grade',
        'description',
        'teacher_id',
        'image',
        'join_code',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function classes()
    {
        return $this->hasMany(Classes::class, 'course_id');
    }


    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id')
            ->withTimestamps()
            ->wherePivot('role', 'student');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }


    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
