<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['class_id', 'title', 'file', 'description', 'meeting_link', 'link_upload'];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'material_user', 'material_id', 'user_id')
            ->withTimestamps();
    }
}
