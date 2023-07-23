<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_course', 'course_id', 'user_id')
                    ->withTimestamps();
    }
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
