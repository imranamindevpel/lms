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
        $questions = Quiz::inRandomOrder()->where('course_id', $courseId)->take(env('MCQ_COUNT'))->get();
        return view('student.quiz', compact('id','questions'));
    }
    public function submit_quiz(Request $request)
    {
        $request->validate([
            'report_id' => 'required',
            'answer' => 'required|array',
        ]);
        $reportId = $request->input('report_id');
        $quizData = $request->input('answer');
        $questionIds = array_keys($quizData);
        $correctAnswers = Quiz::whereIn('id', $questionIds)
                               ->pluck('correct_option', 'id')
                               ->toArray();
        $numCorrectAnswers = 0;
        foreach ($quizData as $questionId => $submittedAnswer) {
            if (isset($correctAnswers[$questionId]) && $correctAnswers[$questionId] === $submittedAnswer) {
                $numCorrectAnswers++;
            }
        }
        $halfMCQCount = intval(env('MCQ_COUNT')) / 2;
        $status = ($numCorrectAnswers >= $halfMCQCount) ? 1 : 0;

        $report = Report::find($reportId);
        $report->quiz_date = Carbon::now();
        $report->clock_in = Carbon::now();
        $report->clock_out = Carbon::now();
        $report->obtained_marks = $numCorrectAnswers;
        $report->total_marks = env('MCQ_COUNT');
        $report->status = $status;
        $report->save();

        $now = Carbon::now();
        $nextDate = $now->copy()->addDays(env('QUIZ_AFTER_DAYS'));
        if($status == 0){
            $userQuiz = new Report();
            $userQuiz->user_id = $report->user_id;
            $userQuiz->course_id = $report->course_id;
            $userQuiz->quiz_date = $nextDate;
            $userQuiz->save();
        }
        $message = "You scored $numCorrectAnswers out of " . count($questionIds) . " attempted questions from Total ".env('MCQ_COUNT')." Questions!";
        $request->session()->flash('success', $message);
        return redirect('/dashboard');
    }
    public function get_course_users(Request $request){
        $course = Course::findOrFail($request['id']);
        $users = $course->users()->where('role', 'student')->get();
        return response()->json($users);
    }
}
