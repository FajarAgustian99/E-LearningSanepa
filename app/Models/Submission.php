<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = ['assignment_id', 'user_id', 'file', 'comment', 'submitted_at'];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function grade()
    {
        return $this->hasOne(Grade::class);
    }
}
