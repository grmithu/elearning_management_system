<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Department;
use App\Models\Course;
use App\Models\Semester;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index ()
    {
        $user = Auth::user()->load('enrolledCourses.regularUpdates');

        $courses = Course::with('detail.semester')
            ->get();
        if($user->type == 'instructor')
            $courses = $courses->where('instructor_id', $user->id);

        $currentMonth = Carbon::now()->month;
        $running_semester_courses = $courses
            ->where('detail.semester.start_month', '<=', $currentMonth)
            ->where('detail.semester.end_month', '>=', $currentMonth);

        if($user->type == 'student')
            $courses = $running_semester_courses->where('department_id', Auth::user()->department_id);

        $myCourses = $running_semester_courses;

        $enrolledCourses = $user->enrolledCourses;
        $regular_updates = $enrolledCourses->flatMap(function ($enrolledCourses) {
            return $enrolledCourses->regularUpdates;
        })->where('end_time', '>', Carbon::now())
            ->sortByDesc('updated_at');

        $instructors = User::WHERE('type', 'instructor')->get();
        $departments = Department::get();

        return view('dashboard.index', compact('courses', 'instructors', 'departments', 'myCourses', 'enrolledCourses', 'regular_updates'));
    }
}
