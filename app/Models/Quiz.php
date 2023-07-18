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
        'user_id','quiz_date','start_time','finish_time','break_allocation','clock_in','clock_out', 'ghost_quiz',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function breaks()
    {
        return $this->hasMany(QuizBreaks::class);
    }
}
