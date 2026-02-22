<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $table = 'enrollments';

    protected $fillable = [
        'class_id',
        'user_id',
        'role',        // guru / student
        'enrolled_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | KELAS YANG DI-ENROLL
    |--------------------------------------------------------------------------
    */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /*
    |--------------------------------------------------------------------------
    | USER YANG DI-ENROLL (bisa guru atau siswa)
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
