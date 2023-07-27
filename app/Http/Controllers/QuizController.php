<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Report;
use App\Models\User;
use App\Models\Course;
use App\Models\UserCourse;
use App\Models\Log;
use Illuminate\Http\Request;
use League\Csv\Reader;
use Carbon\Carbon;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $courses = Course::all();
            return view('admin.quiz.index', compact('courses'));
        }
        if ($user->role === 'teacher') {
            $courseIds = UserCourse::where('user_id', $user->id)->pluck('course_id');
            $courses = Course::whereIn('id', $courseIds)->get();
            return view('admin.quiz.index', compact('courses'));
        }
        return redirect()->to('/dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required',
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_option' => 'required',
            'total_marks' => 'required|integer',
        ]);
        $quiz = Quiz::create($validatedData);
        // log against this user's action
        $user = auth()->user();
        $logData = [
            'event' => 'New Quiz Created',
            'user_id' => $user->id,
            'who' => $user->name,
            'when' => Carbon::now(),
            'where' => 'QuizController@store',
            'how' => 'HTTP POST Request',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $log = Log::create($logData);
        return redirect()->route('quizzes.index')->with('success', 'Quiz added successfully!');    
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        $courseId = $quiz->course_id;
        $userIds = UserCourse::where('course_id', $courseId)->pluck('user_id');
        $selected_course_users = User::where('role','student')->whereIn('id', $userIds)->get();
        
        $user = auth()->user();
        if ($user->role === 'admin') {
            $courses = Course::all();
        }
        if ($user->role === 'teacher') {
            $courseIds = UserCourse::where('user_id', $user->id)->pluck('course_id');
            $courses = Course::whereIn('id', $courseIds)->get();
        }
        return view('admin.quiz.edit', compact('quiz', 'selected_course_users', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, quiz $quiz)
    {
        $validatedData = $request->validate([
            'course_id' => 'required',
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_option' => 'required',
            'total_marks' => 'required|integer',
        ]);
        $quiz->update($validatedData);
        // log against this user's action
        $user = auth()->user();
        $logData = [
            'event' => 'Quiz - '.$quiz->id.' Updated',
            'user_id' => $user->id,
            'who' => $user->name,
            'when' => Carbon::now(),
            'where' => 'QuizController@update',
            'how' => 'HTTP POST Request',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $log = Log::create($logData);
        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully!');    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        // log against this user's action
        $user = auth()->user();
        $logData = [
            'event' => 'Quiz - '.$quiz->id.' Deleted',
            'user_id' => $user->id,
            'who' => $user->name,
            'when' => Carbon::now(),
            'where' => 'QuizController@destroy',
            'how' => 'HTTP POST Request',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $log = Log::create($logData);
        return redirect()->route('quizzes.index')->with('error', 'Quiz deleted successfully!');    
    }

    public function startQuiz($id)
    {
        $courseId = Report::where('id',$id)->pluck('course_id');
        $questions = Quiz::inRandomOrder()->where('course_id', $courseId)->take(20)->get();
        return view('student.quiz', compact('questions'));
    }
    public function get_course_users(Request $request){
        $course = Course::findOrFail($request['id']);
        $users = $course->users()->where('role', 'student')->get();
        return response()->json($users);
    }
    public function handleUpload(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'csv_file' => 'required|mimes:csv,txt',
        ]);
        
        $nonExistingUsers = [];
        $courseId = $request['course_id'];
        $user = auth()->user();
        // Getting all existing users of Teacher Specific Course
        $users = User::whereHas('courses', function ($query) use ($courseId) {
            $query->where('course_id', $courseId);
        })
        ->where('role', 'student')
        ->get();
        // Getting all existing users of Teacher Specific Course
        $userIds = $users->pluck('id')->toArray();
        if (empty($userIds)) {
            return redirect()->back()->with('error', "No Users Exist Against this course");
        }
        
        $csv = Reader::createFromPath($request->file('csv_file')->getPathname());
        $csv->setHeaderOffset(0);
        
        foreach ($csv as $row) {
            if (!in_array($row['user_id'], $userIds)) {
                $nonExistingUsers[] = $row['user_id'];
                continue;
            }
            $quiz = new Quiz();
            $quiz->user_id = $row['user_id'];
            $quiz->quiz_date = $row['quiz_date'];
            $quiz->start_time = $row['start_time'];
            $quiz->finish_time = $row['finish_time'];
            $quiz->total_marks = $row['total_marks'];
            $quiz->created_at = now();
            $quiz->updated_at = now();
            $quiz->save();
        }
        if (!empty($nonExistingUsers)) {
            $course = Course::find($courseId);
            return redirect()->back()->with('error', 'These IDs do not exist in ' . $course->name . ' course: ' . implode(', ', $nonExistingUsers));
        }
        return redirect()->back()->with('success', 'CSV file imported successfully.');
    }

    public function clock_in_out(Request $request){
        $currentTime = Carbon::now()->toDateString();
        $loggedInUserId = auth()->user()->id;
        
        if ($request->has('clock_in')) {
            $quiz = Quiz::where('quiz_date', $currentTime)->where('user_id', $loggedInUserId)
                            ->update(['clock_in' => Carbon::now()]);
                            // log against this user's action
                            $user = auth()->user();
                            $logData = [
                                'event' => 'User Clock-In',
                                'user_id' => $loggedInUserId,
                                'who' => $user->name,
                                'when' => Carbon::now(),
                                'where' => 'QuizController@clock_in_out',
                                'how' => 'HTTP POST Request',
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
                            $log = Log::create($logData);
                            return redirect()->back()->with('success', 'Your Quiz is Started');
            
        } elseif ($request->has('clock_out')) {
            $quiz = Quiz::where('quiz_date', $currentTime)->where('user_id', $loggedInUserId)
                            ->whereNotNull('clock_in')->whereNull('clock_out')
                            ->update(['clock_out' => Carbon::now()]);
                            // log against this user's action
                            $user = auth()->user();
                            $logData = [
                                'event' => 'User Clock-Out',
                                'user_id' => $loggedInUserId,
                                'who' => $user->name,
                                'when' => Carbon::now(),
                                'where' => 'QuizController@clock_in_out',
                                'how' => 'HTTP POST Request',
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
                            $log = Log::create($logData);
                            return redirect()->back()->with('success', 'Your Quiz is Ended');

        } elseif ($request->has('start_break')) {
            $quizId = Quiz::where('user_id', $loggedInUserId)
                            ->whereNotNull('clock_in')->whereNull('clock_out')
                            ->value('id');
            $quizBreak = new QuizBreaks();
            $quizBreak->quiz_id = $quizId;
            $quizBreak->start_break = Carbon::now();
            $quizBreak->created_at = now();
            $quizBreak->updated_at = now();
            $quizBreak->save();
            // log against this user's action
            $user = auth()->user();
            $logData = [
                'event' => 'User Start Break',
                'user_id' => $loggedInUserId,
                'who' => $user->name,
                'when' => Carbon::now(),
                'where' => 'QuizController@clock_in_out',
                'how' => 'HTTP POST Request',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $log = Log::create($logData);
            return redirect()->back()->with('success', 'Your Break is Started');

        } elseif ($request->has('end_break')) {
            $quizId = Quiz::where('user_id', $loggedInUserId)
                            ->whereNotNull('clock_in')->whereNull('clock_out')
                            ->value('id');
            $quizBreaks = QuizBreaks::where('quiz_id', $quizId)
                            ->whereNotNull('start_break')->whereNull('end_break')
                            ->update(['end_break' => Carbon::now()]);
                            // log against this user's action
                            $user = auth()->user();
                            $logData = [
                                'event' => 'User End Break',
                                'user_id' => $loggedInUserId,
                                'who' => $user->name,
                                'when' => Carbon::now(),
                                'where' => 'QuizController@clock_in_out',
                                'how' => 'HTTP POST Request',
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
                            $log = Log::create($logData);
                            return redirect()->back()->with('success', 'Your Break is Ended');
        }
        dd("There is no quiz for today.");
    }
}
