<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\UserCourse;
use App\Models\Quiz;
use App\Models\QuizBreaks;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count()-1;
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalStudents = User::where('role', 'student')->count();
        $courses = Course::all();

        $user = auth()->user();
        if ($user->role === 'admin') {
            return view('admin.index',compact('totalUsers','totalTeachers','totalStudents','courses'));
        }
        if ($user->role === 'teacher') {
            $courseIds = UserCourse::where('user_id', $user->id)->pluck('course_id');
            $courses = Course::whereIn('id', $courseIds)->get();
            return view('teacher.index',compact('courses'));
        }

        $currentTime = Carbon::now()->toDateString();
        $loggedInUserId = auth()->user()->id;
        $studentStatus = 0;
        
        $userQuiz = Quiz::where('user_id', $loggedInUserId)->where('quiz_date', $currentTime)
                            ->whereNull('clock_out')->get();
        if(count($userQuiz) > 0){
            // userClockedIn
            $quizId = Quiz::where('quiz_date', $currentTime)->where('user_id', $loggedInUserId)
            ->whereNotNull('clock_in')->whereNull('clock_out')->value('id');
            if($quizId){$studentStatus = "userClockedIn";};
            
            // userStartedBreak
            $quizId = Quiz::where('user_id', $loggedInUserId)
            ->whereNotNull('clock_in')->whereNull('clock_out')
            ->value('id');
            // In case of clockIn & no break, its finding null quizzes thatswhy needed to check, if clockIn and quizzes exist.
            $quizBreaksExist = QuizBreaks::where('quiz_id', $quizId)->get();
            if(count($quizBreaksExist) > 0){
                $quizBreaks = QuizBreaks::where('quiz_id', $quizId)
                ->whereNotNull('start_break')->orderBy('id', 'desc')
                ->value('end_break');
                if($quizBreaks === null){$studentStatus = "userStartedBreak";};
            }
            
            // userEndedBreak
            $quizId = Quiz::where('user_id', $loggedInUserId)
            ->whereNotNull('clock_in')->whereNull('clock_out')
            ->value('id');
            $quizBreaks = QuizBreaks::where('quiz_id', $quizId)
            ->whereNotNull('start_break')->orderBy('id', 'desc')
            ->value('end_break');
            if($quizBreaks !== null){$studentStatus = "userEndedBreak";};
            
            // userClockedOut
            $quizId = Quiz::where('user_id', $loggedInUserId)
            ->whereNotNull('clock_in')->whereNotNull('clock_out')
            ->value('id');
            $quizBreaks = QuizBreaks::where('quiz_id', $quizId)
            ->whereNotNull('start_break')->whereNotNull('end_break')
            ->value('id');
            if($quizBreaks){$studentStatus = "userClockedOut";};

        }else{
            $studentStatus = "userNoQuiz"; 
        }
        $courseId = UserCourse::where('user_id', $user->id)->value('course_id');
        $course = Course::find($courseId);
        return view('student.index',compact('studentStatus', 'course'));
    }
}
