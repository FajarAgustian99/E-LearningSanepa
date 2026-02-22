<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model

{
    protected $fillable = [
        'class_id',
        'title',
        'description',
        'duration',
        'due_date'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];



    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function submissions()
    {
        return $this->hasMany(QuizSubmission::class, 'quiz_id');
    }
}
