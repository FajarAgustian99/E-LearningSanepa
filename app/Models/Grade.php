<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'course_id',
        'rekap_absensi',
        'lingkup_materi_1',
        'lingkup_materi_2',
        'lingkup_materi_3',
        'lingkup_materi_4',
        'sumatif_akhir_semester',
        'uhb',
        'psat',
        'na',
        'kktp',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
