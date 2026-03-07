<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'quiz_id',
        'question_text',
        'question_type',
        'image',
        'is_essay',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'essay_answer',
        'score_correct',
        'score_incorrect',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class, 'question_id');
    }
}
