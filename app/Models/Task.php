<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['class_id', 'title', 'description', 'due_date'];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
