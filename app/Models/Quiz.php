<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'course_id','question','option_a','option_b','option_c','option_d','correct_option', 'total_marks'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function breaks()
    {
        return $this->hasMany(QuizBreaks::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
