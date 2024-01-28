<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        $instructor_id = auth()->user()->type == 'instructor' ? auth()->id() : null;
        $departments = Department::with(['courses' => function ($query) use ($instructor_id) {
            if ($instructor_id) {
                $query->where('instructor_id', $instructor_id);
            }
        }])->paginate(12);
        return view('department.index', compact('departments'));
    }

    public function create()
    {
        if (Auth::user()->type != 'admin') return redirect(route('department.index'));

        return view('department.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->type != 'admin') return redirect(route('department.index'));

        $this->validate($request, [
            'name'  => 'required|string|min:3|max:100',
        ]);

        if($request->thumbnail) {
            $tmpName = str_replace(' ', '_', $request->thumbnail->getClientOriginalName());
            $thumbnailName = time().'_'.$tmpName;
            if(env('APP_ENV') == 'local') {
                $request->thumbnail->move(public_path('images/departments'), $thumbnailName);
            }
            else {
                $request->thumbnail->move('images/departments', $thumbnailName);
            }
        }
        else {
            $thumbnailName = "default.jpg";
        }

        Department::create([
            'name'      => $request->name,
            'thumbnail' => $thumbnailName,
        ]);

        return redirect(route('department.index'));
    }

    public function show(Department $department)
    {
        $instructor_id = auth()->user()->type == 'instructor' ? auth()->id() : null;
        $department = $department->load([
            'students',
            'instructors',
            'courses' => function ($query) use ($instructor_id) {
                if ($instructor_id) {
                    $query->where('instructor_id', $instructor_id);
                }
            }
        ]);
        $courses = $department->courses;
        $students = $department->students;
        $instructors = $department->instructors;

        return view('department.show', compact('department', 'courses', 'students', 'instructors'));
    }

    public function edit(Department $department)
    {
        //
    }

    public function update(Request $request, Department $department)
    {
        //
    }

    public function destroy(Department $department)
    {
        //
    }
}
