<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\InstructorDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['store']]);
    }


    public function index()
    {
        $instructors = User::WHERE('type', 'instructor')->paginate(12);
        return view('instructor.index', compact('instructors'));
    }

    public function create()
    {
        $departments = Department::get();

        if (Auth::user()->type != 'admin') return redirect(route('instructor.index'));
        return view('instructor.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|string|min:3',
            'email'         => ['required', 'email', 'regex:/^\w+@\w+\.green\.edu\.bd$/'],
            'username'      => 'required|string|min:3|regex:/^\S*$/u|unique:users,username',
            'department'    => 'required|integer|exists:departments,id',
            'password'      => 'required|min:6',

            'office'        => 'required|string|min:3',
            'mobile'        => 'required|string|min:8'
        ],
        [
            'email.regex' => 'The email must be in the format [employee_id]@[department].green.edu.bd',
        ]);

        if($request->avatar) {
            $tmpName = str_replace(' ', '_', $request->avatar->getClientOriginalName());
            $avatarName = time().'_'.$tmpName;
            $request->avatar->storeAs('public/users-avatar', $avatarName);
        } else {
            $avatarName = "avatar.png";
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'          => ucwords($request->name),
                'email'         => Str::lower($request->email),
                'username'      => Str::lower($request->username),
                'type'          => Str::lower('instructor'),
                'department_id' => $request->department,
                'password'      => bcrypt($request->password),
                'avatar'        => $avatarName,
            ]);

            InstructorDetail::create([
                'instructor_id' => $user->id,
                'office'        => $request->office,
                'mobile'        => $request->mobile,
            ]);

            DB::commit();

            if(Auth::check()) {
                return redirect(route('instructor.index'));
            } else {
                auth()->login($user);
            }
            return redirect()->intended(route('dashboard'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return back();
        }

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
