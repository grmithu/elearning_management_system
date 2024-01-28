<?php

namespace App\Http\Controllers;

use App\Models\InstructorDetail;
use App\Models\User;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class AuthController extends Controller
{
    public function index()
    {
        $students = User::WHERE('type', 'student')->paginate(8);
        return view('student.index', compact('students'));
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string|min:3|regex:/^\S*$/u',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function create()
    {
        $departments = Department::get();

        return view('auth.register', compact('departments'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|string|min:3',
            'email'         => 'required|email|regex:/^[0-9]+@green.edu.bd$/|unique:users,email',
            'username'      => 'required|string|regex:/^\S*$/u|unique:users,username',
            'department'    => 'required|integer|exists:departments,id',
            'password'      => 'required|min:6',
        ],
        [
            'email.regex' => 'The email must end with @green.edu.bd (e.g. : [student_id]@green.edu.bd)',
        ]);

        $user = User::create([
            'name'          => ucwords($request->name),
            'email'         => Str::lower($request->email),
            'username'      => Str::lower($request->username),
            'type'          => Str::lower('student'),
            'department_id' => $request->department,
            'password'      => bcrypt($request->password),
        ]);

        auth()->login($user);
        return redirect()->intended(route('dashboard'));
    }

    public function show(User $user)
    {
        if($user->type == 'instructor') {
            $courses = Course::WHERE('instructor_id', $user->id)->get();
        }
        elseif($user->type == 'student') {
            $courses = User::find($user->id)->enrolledCourses;
        }
        else {
            $courses = Course::get();
        }

        $departments = Department::get();
        return view('user.show', compact('user', 'courses', 'departments'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        $user = Auth::user()->load('detail');

        if ($user->type == 'student') {
            $this->validate($request, [
                'email' => 'required|email|regex:/^[a-zA-Z0-9]+@green.edu.bd$/',
            ],
            [
                'email.regex' => 'The email must end with @green.edu.bd (e.g. : [student_id]@green.edu.bd)',
            ]);
        } elseif ($user->type == 'instructor') {
            $this->validate($request, [
                'email' => ['required', 'email', 'regex:/^\w+@\w+\.green\.edu\.bd$/'],
            ],
            [
                'email.regex' => 'The email must be in the format [employee_id]@[department].green.edu.bd',
            ]);
        }


        if($request->avatar) {
            $tmpName = str_replace(' ', '_', $request->avatar->getClientOriginalName());
            $avatarName = time().'_'.$tmpName;
            $request->avatar->storeAs('public/users-avatar', $avatarName);
        } else {
            $avatarName = $user->avatar;
        }

        $user->update([
            'name'          => ucwords($request->name),
            'email'         => Str::lower($request->email),
            'department_id' => $request->department,
            'avatar'        => $avatarName,
        ]);

        if ($user->type == 'instructor') {
            $user->detail->update([
                'office'    => $request->office,
                'mobile'    => $request->mobile,
            ]);
        }

        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if (Hash::check($request->current_password, $user->password)) {
            $user->password = bcrypt($request->new_password);
            $user->save();
        }

        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
