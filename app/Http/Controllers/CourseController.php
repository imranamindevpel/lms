<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userId = $user->id;
        if ($user->role === 'admin') {
            $courses = Course::all();
            return view('admin.course.index', compact('courses'));
        }
        if ($user->role === 'teacher') {
            $courseIds = UserCourse::where('user_id', $user->id)->pluck('course_id');
            $courses = Course::whereIn('id', $courseIds)->get();
            return view('admin.course.index', compact('courses'));
        }
        return redirect()->to('/dashboard');
    }

    public function create()
    {
        return view('admin.course.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $course = new Course();
        $course->name = $request->input('name');
        $course->detail = $request->input('detail');
        $course->save();

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function show(string $id)
    {
        $course = Course::findOrFail($id);
        return view('admin.course.show', compact('course'));
    }

    public function edit(string $id)
    {
        $course = Course::findOrFail($id);
        return view('admin.course.edit', compact('course'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $course = Course::findOrFail($id);
        $course->name = $request->input('name');
        $course->detail = $request->input('detail');
        $course->save();

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
