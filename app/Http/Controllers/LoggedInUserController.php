<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\UserCourse;
use App\Models\Quiz;

class LoggedInUserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $courses = Course::all();
            return view('admin.logged_in_user.index', compact('courses'));
        }
        if ($user->role === 'teacher') {
            $studentRole = 'student';
            $courseIds = UserCourse::where('user_id', $user->id)->pluck('course_id');
            $courses = Course::whereIn('id', $courseIds)
            ->whereHas('users', function ($query) use ($studentRole) {
                $query->where('role', $studentRole);
            })
            ->get();
            return view('admin.logged_in_user.index', compact('courses'));
        }
        return redirect()->to('/dashboard');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $quiz = Quiz::findOrFail($id);
        return view('admin.quiz.show', compact('quiz'));
    }

    public function edit($id)
    {
        dd($id);
    }

    public function update($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->status = true; // Assuming 'status' is a boolean field
        $quiz->save();
        return redirect()->back()->with('success', 'Quiz status updated successfully');
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return redirect()->back()->with('error', 'Quiz rejected and deleted successfully');
    }
}
