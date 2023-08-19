<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UserCourse;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LectureController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userId = $user->id;
        if ($user->role === 'admin') {
            $lectures = Lecture::all();
            return view('admin.lecture.index', compact('lectures'));
        }
        else{
            $courseIds = UserCourse::where('user_id', $user->id)->pluck('course_id');
            $lectures = Lecture::whereIn('course_id', $courseIds)->get();
            return view('admin.lecture.index', compact('lectures'));
        }
    }

    public function create()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $courses = Course::all();
            return view('admin.lecture.create', compact('courses'));
        }
        if ($user->role === 'teacher') {
            $courses = $user->courses()->with(['users' => function ($query) {
                $query->where('role', 'student');
            }])->get();            
            return view('admin.lecture.create', compact('courses'));
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
            'video' => 'required|file|mimetypes:video/mp4',
        ]);
        $fileName = $request->video->getClientOriginalName();
        $filePath = 'videos/' . $fileName; 
        $isFileMoved = $request->video->move(public_path('videos'), $fileName);
        if ($isFileMoved) {
            $url = asset('videos/' . $fileName); // Generate URL for the video
            $video = new lecture();
            $video->course_id = $request->course_id;
            $video->video = $url; // Save the URL directly
            $video->detail = $request->detail;
            $video->save();
        }
    }

    public function show(string $id)
    {
        $lecture = Lecture::findOrFail($id);
        return view('admin.lecture.show', compact('lecture'));
    }

    public function edit(string $id)
    {
        $lecture = Lecture::findOrFail($id);
        $user = auth()->user();
        if ($user->role === 'admin') {
            $courses = Course::all();
            return view('admin.lecture.edit', compact('lecture', 'courses'));
        }
        if ($user->role === 'teacher') {
            $courses = $user->courses()->with(['users' => function ($query) {
                $query->where('role', 'student');
            }])->get();            
            return view('admin.lecture.edit', compact('lecture', 'courses'));
        }
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'course_id' => 'required',
            'video' => 'required|file|mimetypes:video/mp4',
        ]);
        $fileName = $request->video->getClientOriginalName();
        $filePath = 'videos/' . $fileName; 
        $isFileMoved = $request->video->move(public_path('videos'), $fileName);
        if ($isFileMoved) {
            $url = asset('videos/' . $fileName); // Generate URL for the video
            $lecture = Lecture::findOrFail($id);
            $lecture->course_id = $request->course_id;
            $lecture->video = $url; // Save the URL directly
            $lecture->detail = $request->detail;
            $lecture->save();
        }
    }

    public function destroy(string $id)
    {
        $lecture = Lecture::findOrFail($id);
        $lecture->delete();

        return redirect()->route('lectures.index')->with('success', 'Lecture deleted successfully.');
    }
}