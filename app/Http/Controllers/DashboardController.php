<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\UserCourse;
use App\Models\Quiz;
use App\Models\Report;
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
        $courseIds = UserCourse::where('user_id', $user->id)->pluck('course_id');
        $courses = Course::whereIn('id', $courseIds)->get();
        return view('student.index',compact('courses'));
    }
}
