<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $users = User::all();
            $users = User::where('role', '!=', 'admin')->get();
            return view('admin.user.index', compact('users'));
        }
        if ($user->role === 'teacher') {
            $courses = $user->courses()->with(['users' => function ($query) {
                $query->where('role', 'student');
            }])->get();            
            return view('admin.user.index', compact('courses'));
        }
        return redirect()->to('/dashboard');
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.user.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $email = $request['email'].'@';
        $request['email'] = str_replace("@","@gmail.com",$email);
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = $request->input('role');
        $user->course_ids = json_encode($request->input('course_ids'));
        $user->save();
        $courseIds = $request->input('course_ids');
        $user->courses()->attach($courseIds);
        
        $email = $request->input('email');
        $course = Course::where('id', 1)->get();
        dd($course);
        $folderId = '15vUtgKnFEzNbgw0TIujqcc59RsfSNZll';
        $this->lectureFolderPermission($folderId, $email);
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $courses = Course::all();
        return view('admin.user.edit', compact('user', 'courses'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->role = $request->input('role');
        $user->save();

        $user->courses()->detach();
        
        $courseIds = $request->input('course_ids');
        
        if (isset($courseIds) && $courseIds[0] !== null) {
            $user->courses()->attach($courseIds);
        } else {
            return back()->withErrors('No courses selected.');
        }
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
    private function lectureFolderPermission($folderId, $email){
        $client = new \Google_Client();
        $client->setAuthConfig('../app/client_secret.json');
        $client->refreshToken('1//047Se-3Lsa67CCgYIARAAGAQSNwF-L9IrX1lXz1B2C7tyU4fK2IYKOXidrdAOCFUkbYyiMu854Kd1_JRIFJhbLwSUv8vguHV9ZNE');
        $client->setScopes(\Google_Service_Drive::DRIVE);
        $client->setAccessType('offline');
        $service = new \Google_Service_Drive($client);
        $permission = new \Google_Service_Drive_Permission(array(
            'type' => 'user',
            'role' => 'reader',
            'emailAddress' => $email,
        ));
        $service->permissions->create($folderId, $permission);
    }
}