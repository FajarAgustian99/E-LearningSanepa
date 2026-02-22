<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'class_id', 'teacher_id', 'course_id', 'title', 'content'];

    // Relasi ke kelas
    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    // Relasi semua komentar termasuk balasan
    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi ke guru pembuat diskusi
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Relasi ke user pembuat thread (bisa guru atau siswa)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // app/Models/Discussion.php
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
